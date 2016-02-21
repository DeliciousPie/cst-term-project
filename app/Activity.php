<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'Activity';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'activityID', 'sectionID', 'activityType', 'assignDate', 
       'dueDate', 'estTime', 'stresstimate',
    ];
}
