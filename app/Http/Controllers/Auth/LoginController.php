<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use function redirect;

class LoginController extends Controller {
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * 
     * @Override
     * @param \App\Http\Controllers\Auth\Request $request
     * @return int
     */
    protected function credentials(Request $request) {
        $crendentials              = $request->only($this->username(), 'password');
        $crendentials['is_active'] = 1;
        return $crendentials;
    }

    /**
     * Get the failed login response instance.
     *
     * @Override     
     * @param Request  $request
     * @return Response
     */
    protected function sendFailedLoginResponse(Request $request) {
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([
                            $this->username() => "Invalid email and/or password, or your account is inactive. Please contact the administrator / registrar staff.",
        ]);
    }

}
