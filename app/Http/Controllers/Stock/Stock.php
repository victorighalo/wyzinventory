<?php

namespace App\Http\Controllers\Stock;

use App\stockcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class Stock extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:superagent|admin']);
    }

    protected function validator(Request $data)
    {
        return Validator::make($data->all(), [
            'description' => ['required', 'string'],
            'qtyreceived' => ['required'],
            'qtyout' => ['required'],
            'invoiceno' => ['required'],
            'bacthno' => ['required'],
            'mfd_date' => ['required'],
            'exp_date' => ['required'],
            'remark' => ['required'],
            'product_id' => ['required']
        ]);
    }

    public function addStock(Request $request){

        $validator = $this->validator($request);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 400);
        }
        $stock = stockcard::create([
            'description' => $request->description,
            'qtyreceived' => $request->qtyreceived,
            'qtyout' => $request->qtyout,
            'invoiceno' => $request->invoiceno,
            'bacthno' => $request->bacthno,
            'currentbalance' => 0,
            'mfd_date' => $request->mfd_date,
            'exp_date' => $request->exp_date,
            'remark' => $request->remark,
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
        ]);

        $stock->update(['currentbalance' => stockcard::currentBalance(Auth::id(), $request->product_id ) - $request->qtyout,]);

        return response()->json(['data' => $stock], 200);
    }

}
