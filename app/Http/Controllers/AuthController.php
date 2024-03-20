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

        if (!Auth::attempt($val, 1)) {
            return back()->with('error', 'Invalid credentials, please try again');
        }
        return redirect('/control/dashboard')->with('success', 'Welcome back ' . auth()->user()->name);
    }
}
