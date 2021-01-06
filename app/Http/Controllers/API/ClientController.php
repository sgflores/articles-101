<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Services\HelperService;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Controllers\API\BaseAPIController;

class ClientController extends BaseAPIController
{
    /**
     * ClientController constructor
     *
     * @param Client $model The model associated to the controller
     * @param HelperService $helperService The base request service
     */
    public function __construct(Client $model, HelperService $helperService)
    {
        parent::__construct($model, new ClientRequest, ClientCollection::class, $helperService);
    }
    
}
