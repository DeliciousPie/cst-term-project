<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInCourseSection extends Model
{
      protected $table = 'StudentInCourseSection'; 
    
    
    protected $fillable = [ 'userID','sectionID'];
}
