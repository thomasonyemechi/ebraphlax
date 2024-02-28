<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\SalesSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{


    public function viewAllStaff(Request $request)
    {
        $staffs = User::orderby('id', 'desc')->paginate(10);

        return view('admin.all_staff', compact(['staffs']));
    }


    function createStaff(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|min:3',
            'role' => 'required|string',
            'phone' => 'required|string',
            'address' => 'string'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => Hash::make($request->phone),
        ]);

        return back()->with('success', 'Profile has been created for staff, continue to manage user hours');
    }

    function createStaffIndex()
    {
        return view('admin.add_staff');
    }


    public function updateStaffInfo(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required|exists:users,id',

        ])->validate();
    }



    function modifyHours(Request $request)
    {
        $hours = [
            'monday' => [
                'start' => '09:00',
                'stop' => '17:30'
            ],
            'tuesday' => [
                'start' => '09:00',
                'stop' => '17:30'
            ],
            'wednesday' => [
                'start' => '09:00',
                'stop' => '17:30'
            ],
            'monday' => [
                'start' => '09:00',
                'stop' => '17:30'
            ],
            'friday' => [
                'start' => '09:00',
                'stop' => '17:30'
            ],
            'saturday' => [
                'start' => '09:00',
                'stop' => '16:00'
            ],
            'sunday' => [
                'start' => '12:00',
                'stop' => '12:00'
            ],
        ];


        User::where('id', '>', 0)->update([
            'user_hours' => json_encode($hours)
        ]);


        return json_encode($hours);
    }

}
