<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\HelperService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseAPIController extends Controller
{
    protected $model;
    protected $formRequest;
    protected $resourceCollectionClass;
    protected $helperService;

    /**
     * BaseAPIController constructor
     *
     * @param Model $model The model associated to the controller
     * @param FormRequest $formRequest The request validator associated to the model
     * @param string $resourceCollectionClass The request collection class
     * @param HelperService $helperService The helper service instance
     */
    public function __construct(
        Model $model, 
        FormRequest $formRequest, 
        string $resourceCollectionClass,
        HelperService $helperService
    ) {
        $this->model = $model;
        $this->formRequest = $formRequest;
        $this->resourceCollectionClass = $resourceCollectionClass;
        $this->helperService = $helperService;
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
        $limit = $request->limit ?? 20;
        if ($orderByColumn) {
            $model->orderBy($orderByColumn, $orderByValue);
        }
        $resource = $this->helperService->resolveCollectionResource($this->resourceCollectionClass);
        return new $resource($model->paginate($limit));
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
        $resource = $this->helperService->resolveSingleResource($this->resourceCollectionClass);
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
        $resource = $this->helperService->resolveSingleResource($this->resourceCollectionClass);
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