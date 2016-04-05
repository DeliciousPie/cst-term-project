<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'Course'; 
    
    public $timestamps = false;
    
    protected $fillable = ['courseID','areaOfStudy', 'courseName', 'description'];
}
