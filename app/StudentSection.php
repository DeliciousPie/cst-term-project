<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSection extends Model
{
      protected $table = 'StudentSection'; 
    
    
    protected $fillable = [ 'userID','sectionID'];
}
