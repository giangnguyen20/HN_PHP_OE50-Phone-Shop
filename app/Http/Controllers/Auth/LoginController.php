<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Exception;
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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (Auth()->user()->role_id == config('auth.roles.admin')) {
            return route('admin.');
        }

        return route('home');
    }

    public function login(LoginRequest $request)
    {
        $compare = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($compare) {
            if (Auth::user()->role_id == config('auth.roles.admin')
                && Auth::user()->status == config('auth.status.active')) {
                return redirect()->route('admin.');
            } else {
                if (Auth::user()->status == config('auth.status.active')) {
                    return redirect()->route('home');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('messages', 'user_lock');
                }
            }
        } else {
            return redirect()->route('login')->with('messages', 'login_fail');
        }
    }
}
