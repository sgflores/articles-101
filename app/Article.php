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

    /**
     * The related attributes that are eager loaded on index page.
     *
     * @var array
     */
    public $_eagerLoadedOnIndex = [
        'client',
    ];

    /**
     * The attributes that are valid as filter options.
     *
     * @var array
     */
    public $_validFilters = [
        'id', 'title', 'required_word_count', 'created_at'
    ];

    /**
     * The related sortable attributes.
     *
     * @var array
     */
    public $_relatedSortableColumns = [
        [
            'relatedTable' => 'clients',
            'relatedColumn' => 'clients.email',
            'relatedPrimaryId' => 'id',
            'baseTable' => 'articles',
            'baseForeignId' => 'client_id'
        ],
        [
            'relatedTable' => 'clients',
            'relatedColumn' => 'clients.name',
            'relatedPrimaryId' => 'id',
            'baseTable' => 'articles',
            'baseForeignId' => 'client_id'
        ]
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
