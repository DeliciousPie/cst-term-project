<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
      
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'role_user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'role_id',
    ];

}
