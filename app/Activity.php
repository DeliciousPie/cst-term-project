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
    
    protected $primaryKey = 'activityID';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    public function studentactivities()
    {
        $this->hasMany('App\StudentActivity', 'sectionID', 'activityID' );
    }
    
    public function activities()
    {
        return $this->belongsTo('App\Section', 'sectionID');
    }
    

}
