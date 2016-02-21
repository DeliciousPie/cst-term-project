<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'Section';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'sectionID', 'sectionType', 'courseID', 'date',
    ];
}
