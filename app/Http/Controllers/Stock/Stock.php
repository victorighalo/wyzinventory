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
        $this->middleware(['auth','role:auditor|admin']);
    }

    protected function validator(Request $data)
    {
        return Validator::make($data->all(), [
            'qtyreceived' => ['required','numeric'],
            'qtyout' => ['required','numeric'],
            'product_code' => ['required']
        ]);
    }

    public function addStock(Request $request){

        $validator = $this->validator($request);
        $newbalance = null;
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 400);
        }

        try {
            $currbal = stockcard::currentBalance(Auth::id(), $request->product_code);
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
            'product_id' => $request->product_code,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['data' => $stock], 200);
    }

    public function update(Request $request){

        $current_qtyreceived = stockcard::currentQtyReceived($request->user_id, $request->product_id)->qtyreceived;
        $current_qtyout = stockcard::currentQtyOut($request->user_id, $request->product_id)->qtyout;

        $qtyreceived_diff = $current_qtyreceived - $request->edit_qtyreceived;
        $qtyout_diff = $current_qtyout - $request->edit_qtyout;

        $stock = stockcard::where('id' ,$request->card_id)->first();
         $stock->update([
            'description' => $request->edit_description,
            'qtyreceived' => $request->edit_qtyreceived,
            'qtyout' => $request->edit_qtyout,
            'invoiceno' => $request->edit_invoiceno,
            'bacthno' => $request->edit_bacthno,
            'mfd_date' => $request->edit_mfd_date,
            'exp_date' => $request->edit_exp_date,
            'remark' => $request->edit_remark
        ]);

         if($current_qtyreceived != $request->edit_qtyreceived) {
             if ($this->isNegative($qtyreceived_diff)) {
                 stockcard::clerkCard($request->user_id)->increment('currentbalance', abs($qtyreceived_diff));
             } else {
                 stockcard::clerkCard($request->user_id)->decrement('currentbalance', abs($qtyreceived_diff));
             }
         }

        if($qtyout_diff != $request->edit_qtyout) {
            if ($this->isNegative($qtyout_diff)) {
                stockcard::clerkCard($request->user_id)->decrement('currentbalance', abs($qtyout_diff));
            } else {
                stockcard::clerkCard($request->user_id)->increment('currentbalance', abs($qtyout_diff));
            }
        }

        return response()->json($stock, 200);
    }

    private function isNegative($a){
        if($a < 0){
            return true;
        }else{
            return false;
        }
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
