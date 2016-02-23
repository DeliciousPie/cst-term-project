<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

/**
 * Purpose: Represents the Role table from the DB. Allows for simple
 * modifications.
 * 
 * @author Justin Lutzko CST229
 */
class Role  extends EntrustRole
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = ['name', 'display_name', 'description'];
}
