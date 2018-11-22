<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $redirectTo = '/loginin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }
	
	 public function authenticated(Request $request, $user)
	{		
	if (!$user->isverified) {
		$data['username']=$user->username;
	auth()->logout();
	Session::put('userdetail', $data);
	//$verifuurl=URL::to('/jhhjdh');
	return back()->with('otpmessage', 'You need to confirm your account. We have sent you an activation code, please check your mobile and click <a href="'.url('/user/verify').'">Here</a>.');
	}
	return redirect()->intended($this->redirectPath());
	}


	 public function logout(Request $request){
        auth()->logout();
        return redirect('/login');
    }	

	}
