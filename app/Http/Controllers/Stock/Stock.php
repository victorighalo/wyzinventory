<?php

namespace App\Http\Controllers\Stock;

use App\stockcard;
use App\User;
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
            'qtyreceived' => ['required','numeric'],
            'qtyout' => ['required','numeric'],
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
        $newbalance = null;
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 400);
        }

        try {
            $currbal = stockcard::currentBalance(Auth::id(), $request->product_id);
            $newbalance = ($currbal->currentbalance + $request->qtyreceived) - $request->qtyout;
        }catch (\Exception $e){
            $newbalance = $request->qtyreceived;
        }

        $stock = stockcard::create([
            'description' => $request->description,
            'qtyreceived' => $request->qtyreceived,
            'qtyout' => $request->qtyout,
            'invoiceno' => $request->invoiceno,
            'bacthno' => $request->bacthno,
            'currentbalance' => $newbalance,
            'mfd_date' => $request->mfd_date,
            'exp_date' => $request->exp_date,
            'remark' => $request->remark,
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['data' => $stock], 200);
    }

    public function getSuperAgents(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return Datatables::of($superagents)->editColumn('created_at', function ($superagents) {
            return $superagents->created_at ? with(new Carbon($superagents->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($superagents) {
                return '      <td>
                                  <button class="btn btn-primary btn-sm" type="button" ><a href="'.route('get_storekeepers_stock',['user_id' => $superagents->id]).'" class="text-white"> View records</a> </button>
                                                    </td>';
            })  ->addColumn('active', function ($superagents) {
                if($superagents->active){
                    return "Active";
                }else{
                    return "Deactivated";
                }
            })
            ->make(true);
    }

}
