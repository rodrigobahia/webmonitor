<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'port', 'user_id'
    ];

}
