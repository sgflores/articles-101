<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'created_by', 'updated_by'
    ];

    /**
     * The related attributes that are eager loaded on index page.
     *
     * @var array
     */
    public $_eagerLoadedOnIndex = [
        'articles',
    ];

    /**
     * The attributes that are valid as filter options.
     *
     * @var array
     */
    public $_validFilters = [
        'id', 'name', 'email', 'created_at'
    ];

    /**
     * Get all articles assigned to client
     *
     * @return Eloquent Relationship
     */
    public function articles()
    {
        return $this->hasMany('App\Article', 'client_id', 'id');
    }
    
}
