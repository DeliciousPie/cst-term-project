<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Purpose: Represents the User table from the DB. Allows for simple
 * modifications.
 * 
 * @author Fraiser McBlind
 * 
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    
    use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",'userID', 'name', 'email', 'password', 'confirmed',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function roles() {
         return $this->belongsToMany('App\Role');
    }
    
    public function studentactivities()
    {
        return $this->hasMany('App\StudentActivity');
    }

}
