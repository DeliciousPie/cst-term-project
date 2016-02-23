<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'Professor';
    
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
