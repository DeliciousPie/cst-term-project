<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfSection extends Model
{
    /*
     * Table associated with model.
     * 
     * @var string
     */
    protected $table = 'ProfSection';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'userID', 'sectionID', 
    ];
}
