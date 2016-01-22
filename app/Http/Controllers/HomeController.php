<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Laravel stock controller. Controls homepage.
 * 
 * @author Laravel
 */
class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }
}
