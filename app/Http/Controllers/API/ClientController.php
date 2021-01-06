<?php

namespace App\Http\Controllers\API;

use App\Client;
use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Controllers\API\BaseAPIController;

class ClientController extends BaseAPIController
{
    /**
     * ClientController constructor
     *
     * @param Client $model The model associated to the controller
     */
    public function __construct(Client $model)
    {
        parent::__construct($model, new ClientRequest, ClientCollection::class);
    }
    
}
