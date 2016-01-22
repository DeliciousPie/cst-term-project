<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Purpose: Represents the Student table from the DB. Allows for simple
 * modifications.
 * 
 * @author Justin Lutzko CST229
 */
class Student extends Model
{
    
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'Student';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'userID', 'age', 'areaOfStudy', 'fName', 'lName',
        'educationalInstitution', 'email',
    ];

}
