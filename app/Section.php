<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
        protected $table = 'Section'; 
    
    
    protected $fillable = [ 'sectionID','sectionType','courseID','date'];
}
