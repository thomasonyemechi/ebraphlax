<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Permission;
use App\Models\SalesSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{

    function createStaff(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|min:3',
            'role' => 'required|string',
            'phone' => 'required|string',
            'address' => 'string'
        ])->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'password' => Hash::make($request->phone),
            'address' => $request->address
        ]);

        $this->cper($user);

        return back()->with('success', 'Staff profile has been created');
    }

    function createStaffIndex()
    {
        $staffs = User::orderby('id', 'desc')->paginate(12);

        return view('control.staffs', compact(['staffs']));
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


    function managePermissionIndex()
    {
        $users = User::with(['permission'])->paginate(10,['id','name', 'role']);

        return view('control.manage_permission', compact(['users']));
    }

    function createPermission() {
        $users = User::get(['id', 'role']);
        foreach($users as $user)
        {
            $this->cper($user);
        }
        return back()->with('success', 'All permission has been restored to default');
    }


    function cper($user) {
        if(strtolower($user->role == 'administrator')) {
            $jute_bag = $cost_analysis = $manage_staff = $manage_customer = $manage_expenses = $check_ledger = $manage_stock = $visit_log = $business_detial = 1;
        }elseif(strtolower($user->role == 'store-keeper')) {
            $jute_bag = $manage_stock = $visit_log = 1;
        }elseif(strtolower($user->role == 'accountant')) {
            $cost_analysis = $manage_expenses = $check_ledger = $business_detial = 1;
        }

        Permission::updateOrCreate([
            'user_id' => $user->id
        ], [
            'jute_bag' => $jute_bag ?? 0,
            'cost_analysis' => $cost_analysis ?? 0,
            'manage_staff' => $manage_staff ?? 0,
            'manage_customer' => $manage_customer ?? 0,
            'manage_expenses' => $manage_expenses ?? 0,
            'check_ledger' => $check_ledger ?? 0,
            'manage_stock' => $manage_stock ?? 0,
            'visit_log' => $visit_log ?? 0,
            'business_detial' => $business_detial ?? 0,
        ]);
    }



    function updatePermission(Request $request)
    {

    //  return $request->all_users;
        foreach(json_decode($request->all_users) as $val)
        {
            $user_id = $val;

            Permission::where('user_id', $user_id)->update([
                'jute_bag' => $request['jute_bag'.$user_id] ?? 0,
                'cost_analysis' => $request['cost_analysis'.$user_id] ?? 0,
                'manage_staff' => $request['manage_staff'.$user_id] ?? 0,
                'manage_customer' => $request['manage_customer'.$user_id] ?? 0,
                'manage_expenses' => $request['manage_expenses'.$user_id] ?? 0,
                'check_ledger' => $request['check_ledger'.$user_id] ?? 0,
                'manage_stock' => $request['manage_stock'.$user_id] ?? 0,
                'visit_log' => $request['visit_log'.$user_id] ?? 0,
                'business_detial' => $request['business_detial'.$user_id] ?? 0,
            ]);

        }

        return back()->with('success', 'Permission has been sucessfly updated');
    }

}
