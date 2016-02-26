<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfSection extends Model
{
      protected $table = 'ProfSection'; 
    
    protected $fillable = [ 'userID','sectionID'];
}
