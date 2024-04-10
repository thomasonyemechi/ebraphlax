<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function loginIndex()
    {
        if(auth()->user()) {
            return redirect('/control/dashboard');
        }
        return view('login');
    }


    function userLogin(Request $request)
    {
        $val = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:4'
        ])->validate();

        if (!Auth::attempt($val)) {
            return back()->with('error', 'Invalid credentials, please try again');
        }
        return redirect('/control/dashboard')->with('success', 'Welcome back ' . auth()->user()->name);
    }


    function logOut()
    {
        Auth::logout('user');

        return redirect('/login')->with('success', 'Your session has ended, enter you credential to start a new one'); 
    }
}
