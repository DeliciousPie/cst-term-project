<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'Course'; 
    
    public $timestamps = false;
    
    protected $fillable = ['courseID', 'courseName', 'description'];
    
    protected $guarded = ['courseID'];


    protected $primaryKey = 'courseID';


    public function sections()
    {
        return $this->hasMany('App\Section');
    }
    
    public function studentactivities()
    {
        return $this->hasManyThrough('App\StudentActivity', 
                'App\Section', 'App\Activity', 'sectionID', 'activityID');
    }
}
