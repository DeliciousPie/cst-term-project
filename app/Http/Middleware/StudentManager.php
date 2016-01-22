<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Purpose: Define where users can go based on route groups.
 * 
 * @author Justin Lutzko CST229
 */
class StudentManager
{
    /**
     * Purpose: This is a customized laravel stock function.  It checks to see 
     * if the user is logged in and then checks the users role. Based on the 
     * role determines where the user can go. 
     * 
     * See the kernal class for a list of all the middleware beign used. Or to
     * define it.
     * 
     * @author Justin Lutzko CST229
     * 
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
           
            if($user->hasRole('Student'))
            {
                return $next($request);
                
            }  
            else
            {
                return redirect('home');
            }
        }
    }
}
