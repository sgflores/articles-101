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
     * Get all articles assigned to client
     *
     * @return Eloquent Relationship
     */
    public function articles()
    {
        return $this->hasMany('App\Article', 'client_id', 'id');
    }
    
}
