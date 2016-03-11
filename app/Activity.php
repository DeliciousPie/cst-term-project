<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'activityID', 'sectionID', 'activityType', 'assignDate', 
       'dueDate', 'estTime', 'stresstimate',
    ];
    
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
    

    protected $table = 'Activity';

}
