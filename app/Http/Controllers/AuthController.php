<?php

namespace App\Http\Controllers;

use App\Models\ResetOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


    function resetIndex()
    {
        return view('reset-order');
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

        if(auth()->user()->warehouse_id == 2) {
            return redirect('/control/stock')->with('success', 'Welcome back ' . auth()->user()->name);

        }
        return redirect('/control/dashboard')->with('success', 'Welcome back ' . auth()->user()->name);
    }


    function logOut()
    {
        Auth::logout('user');

        return redirect('/login')->with('success', 'Your session has ended, enter you credential to start a new one'); 
    }


    function doResetP(Request $request)
    {
        $user = User::where(['phone' => $request->phone])->first(); 
        if(!$user) {
            return back()->with('error', 'Phone number does not exist');
        }




        $order = rand(111111,999999);   
        ResetOrder::create([
            'user_id' => $user->id,
            'phone' => $user->phone,
            'order' => $order,
        ]);

        $body = 'Your reset code is '.$order.' Code will expire in 30 mins';
        $this->sendSms($body, $user->phone);

        return redirect('/reset-order?reset_stage=3')->with('success', 'Account reset code has been sent to your phone number');

    }




    function resetPassword(Request $request)
    {
        Validator::make($request->all(), [
            'reset_code' => 'exists:reset_orders,order',
            'password' => 'confirmed|min:6|required'
        ])->validate();

        $order = ResetOrder::where(['order' => $request->reset_code])->first();
        if($order->status == 'used') {
            return back()->with('error', 'Invalid reset code has been entered');
        }

        User::where(['id' => $order->user_id])->update([
            'password' => Hash::make($request->password)
        ]);

        $order->update([
            'status' => 'used'
        ]);

        return back()->with('success', 'Password has been sucessfuly updated, proceed to login!');
    }
}
