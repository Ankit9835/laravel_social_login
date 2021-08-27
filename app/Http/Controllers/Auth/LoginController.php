<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
use Auth;

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

   

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        
        $login = User::where('email', '=', $user->email)->first();
        if(!$login){
            $login = new User();
            $login->name = $user->name;
            $login->email = $user->email;
            $login->login_type = 'google';
            $login->provider_id = $user->id;
            $login->avatar = $user->avatar;
            $login->save();
        }
        Auth::login($login);

        return redirect()->route('home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */

    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
       
        $login = User::where('email', '=', $user->email)->first();
        if(!$login){
            $login = new User();
            $login->name = $user->name;
            $login->email = $user->email;
            $login->login_type = 'github';
            $login->provider_id = $user->id;
            $login->avatar = $user->avatar;
            $login->save();
        }
        Auth::login($login);

        return redirect()->route('home');

        //return $user->name;
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
       
        $login = User::where('email', '=', $user->email)->first();
        if(!$login){
            $login = new User();
            $login->name = $user->name;
            $login->email = $user->email;
            $login->login_type = 'facebook';
            $login->provider_id = $user->id;
            $login->avatar = $user->avatar;
            $login->save();
        }
        Auth::login($login);

        return redirect()->route('home');

        //return $user->name;
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    protected function _registerOrLoginUser($data){
        $user = User::where('email', '=', $data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }
        Auth::login($user);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    
}
