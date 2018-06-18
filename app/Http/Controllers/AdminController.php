<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	
	    if ( !Auth::check() ) {
		    return redirect('/login');
	    }
	
	    return view('layouts.admin', [ 'title' => 'Панель управления' ]);
    }
}
