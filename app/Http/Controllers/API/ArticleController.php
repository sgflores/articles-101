<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Controllers\API\BaseAPIController;

class ArticleController extends BaseAPIController
{
    /**
     * ArticleController constructor
     *
     * @param Article $model The model associated to the controller
     */
    public function __construct(Article $model)
    {
        parent::__construct($model, new ArticleRequest, ArticleCollection::class);
    }

}
