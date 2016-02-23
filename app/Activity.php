<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['activityType', 'assignDate', 'dueDate', 'estTime',
        'proffEstimate', 'cdAlocatedTime', 'comments'];
    protected $guarded = ['sectionID', 'activityID']; 
    
    /*
     * Table associated with model.
     * 
     * @var string
     */
    
    protected $table = 'Activity';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
}
