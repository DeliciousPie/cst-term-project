<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CD extends Model
{
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'CD';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'userID', 'fName', 'lName',
        'educationalInstitution','areaOfStudy', 'email',
    ];
}
