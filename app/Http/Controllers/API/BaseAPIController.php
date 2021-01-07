<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseAPIController extends Controller
{
    use Helpers;

    protected $model;
    protected $formRequest;
    protected $resourceCollectionClass;

    /**
     * BaseAPIController constructor
     *
     * @param Model $model The model associated to the controller
     * @param FormRequest $formRequest The request validator associated to the model
     * @param string $resourceCollectionClass The request collection class
     */
    public function __construct(
        Model $model, 
        FormRequest $formRequest, 
        string $resourceCollectionClass
    ) {
        $this->model = $model;
        $this->formRequest = $formRequest;
        $this->resourceCollectionClass = $resourceCollectionClass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = $this->model->query();

        $orderByColumn = $request->orderByColumn ?? 'id';
        $orderByValue = $request->orderByValue ?? 'asc';

        // basic sort
        $validFilters = $this->model->_validFilters ?? [];
        if (in_array($orderByColumn, $validFilters)) {
            $model->orderBy($orderByColumn, $orderByValue);
        }

        // sort on related table
        $relatedSortableColumns = $this->model->_relatedSortableColumns ?? [];
        $relatedColumn = $this->searchMultiDimensionArray('relatedColumn', $orderByColumn, $relatedSortableColumns);
        if ($relatedColumn) {
            // extract related data
            $relatedTable = $relatedColumn['relatedTable']; // clients
            $relatedPrimaryId = $relatedColumn['relatedPrimaryId']; // id
            $baseTable = $relatedColumn['baseTable']; // articles
            $baseForeignId = $relatedColumn['baseForeignId']; // client_id
            // join query and sort by related table
            $model->leftJoin(
                $relatedTable, // clients
                "$baseTable.$baseForeignId", // articles.client_id
                '=',
                "$relatedTable.$relatedPrimaryId" // clients.id
            )->orderBy($orderByColumn, $orderByValue)
            ->select("$baseTable.*");
        }

        $eagerLoadedOnIndex = $this->model->_eagerLoadedOnIndex ?? [];
        $model->with($eagerLoadedOnIndex);
        
        $limit = $request->limit ?? 'all';
        $resource = $this->resolveCollectionResource($this->resourceCollectionClass);
        if ($limit != 'all') { 
            return new $resource($model->paginate($limit));
        }
        return new $resource($model->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->formRequest->rules(), $this->formRequest->messages());
        $request['created_by'] = auth()->user()->id;
        $this->model = $this->model->create($request->all());
        $resource = $this->resolveSingleResource($this->resourceCollectionClass);
        return response()->json(new $resource($this->model), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->model = $this->model::findOrFail($id);
        $resource = $this->resolveSingleResource($this->resourceCollectionClass);
        return response()->json(new $resource($this->model), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->model = $this->model::findOrFail($id);
        request()->merge([
            'id' => $id
        ]);
        $request->validate($this->formRequest->rules(), $this->formRequest->messages());
        $request['updated_by'] = auth()->user()->id;
        $this->model->update($request->all());
        return response()->json('successfully updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model = $this->model::findOrFail($id);
        $this->model->delete();
        return response()->json('successfully deleted', 200);
    }

}