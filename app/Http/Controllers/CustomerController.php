<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $data['customers'] = User::orderBy('id','desc')->where('isadmin', '0')->paginate(5);

        return view('customer/index',$data);
    }
    public function store(Request $request)
    {
        $customer   =   User::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'password' =>  Hash::make($request->password),
            ]);

        return response()->json(['success' => true]);
    }
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $customer  = User::where($where)->first();

        return response()->json($customer);
    }
    public function destroy(Request $request)
    {
        $customer = User::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
