<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;


class LoginController extends Controller
{

    /**
     * Handle login request
     */
public function login(Request $request)
{
    // dd($request->all());
    // Validasi manual untuk Laravel 5.4
    $validator = \Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:4',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Login success
        return redirect()->intended('/dashboard');
    }

    // Login failed
    return redirect()->back()
        ->withInput($request->only('email'))
        ->withErrors([
            'email' => 'Email dan Password Salah.',
        ]);
}
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}