<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
        return redirect()->action('StudentController@dashboard');
    }
	
	public function loginin(Request $request)
	{
		if(auth($request->authentication ? $request->authentication : 'web')->user()->user_type =='Admin')
		{
			return redirect()->action('AdminController@index');
		}
		else
		{
			auth()->logout();
			//return redirect()->action('StudentController@dashboard');
			return redirect('/register');
		}
	}
}
