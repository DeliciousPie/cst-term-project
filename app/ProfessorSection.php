<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessorSection extends Model
{
      protected $table = 'ProfessorSection'; 
    
    protected $fillable = [ 'userID','sectionID'];
}
