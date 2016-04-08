<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'Section'; 
    
    public $timestamps = false;
    
    protected $fillable = ['sectionID', 'courseID', 'sectionID','date'];

    
    public function courses()
    {
        return $this->belongsTo('App\Course', 'courseID');
    }
    
    public function activities()
    {
        return $this->hasMany('App\Activity', 'courseID', 'sectionID');
    }
    
}
