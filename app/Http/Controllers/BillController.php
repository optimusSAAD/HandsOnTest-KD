<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $data['bills'] = Bill::with('user')->orderBy('id')->paginate(5);

        return view('bill/index',$data);
    }
    public function user_id(Request $request)
    {
        $users = DB::table('users')->select('id', 'name')->where('isadmin','0')->get();
        return response()->json([
            'user_id' => $users
        ]);
    }
    public function store(Request $request)
    {
        $bill   =   Bill::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'user_id' => $request->userid,
                'month' => $request->month,
                'year' => $request->year,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);

        return response()->json(['success' => true]);
    }

    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $bill  = Bill::with('user')->where($where)->first();

        return response()->json($bill);
    }
    public function destroy(Request $request)
    {
        $bill = Bill::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
