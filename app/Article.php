<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'required_word_count', 'client_id',
        'created_by', 'updated_by'
    ];

    // _eagerLoaded relationship used in select condition for BaseAPIController@index
    public $_eagerLoadedOnIndex = [
        'client',
    ];

    /**
     *  Get the client associated to the article
     * 
     * @return Eloquent Relationship
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }
    
}
