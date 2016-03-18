<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionType extends Model
{
          protected $table = 'SectionType'; 
    
    protected $fillable = [ 'sectionID','description'];
}
