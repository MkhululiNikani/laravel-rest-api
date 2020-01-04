<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function Login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (!auth()->attempt($credentials)) return abort(401, 'incorrect email or password');


        $user = User::where('email', $request->email)->first();
        $token = auth()->user()->createToken('Personal_Access_Client_01')->accessToken;
        $user->api_token = $token;
        
        UserResource::withoutWrapping();
        return new UserResource($user);
        
        
    }
    public function Logout(Request $request)
    {
        $request->user()->token()->revoke();        
        
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
