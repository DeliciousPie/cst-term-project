<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'Section'; 
    
    public $timestamps = false;
    
    protected $fillable = ['courseID', 'sectionID','date'];
}
