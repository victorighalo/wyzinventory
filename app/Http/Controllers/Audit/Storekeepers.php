<?php

namespace App\Http\Controllers\Audit;

use App\product;
use App\stockcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class Storekeepers extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','role:auditor|admin']);
    }

    public function index(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return view('audit.storekeepers');
    }

    public function getSuperAgentsStock($user_id) {
        $data = User::where('id', $user_id)->first();
        return view('audit.stock', compact('data'));
    }

    public function getSuperAgentsStockData($user_id){
        $data = stockcard::clerkCard($user_id)->get();
        $fil = [];
        foreach ($data as $item){
            if( $pass = product::where('id', $item->product_id)->first() ){
                $fil[] = $item;
            }
        }


        return Datatables::of($fil)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
//            ->addColumn('action', function ($data) use($user_id) {
//                return '<td>
//<a  class="text-white" href="'.route('get_storekeepers_stock_audittrail',['product_id' => $data->product_id, 'user_id' => $user_id]).'">
//                    <button  class="btn btn-primary btn-sm" type="button" id="settingcol">Audit trail </button>
//                    </a>
//                        </td>';
//            })
            ->addColumn('action', function ($data) {
                return '<td>
                    <button  class="btn btn-primary btn-sm editcard" id="'.$data->id.'" data-product_id="'.$data->product_id.'" data-user_id="'.$data->user_id.'" type="button"> Edit Card </button>
            
                        </td>';
            })
            ->addColumn('productname', function($data) {
                return product::where('id', $data->product_id)->select('name')->first()->name;
            })
            ->editColumn('mfd_date', function($product) {
                return Carbon::parse($product->mfd_date)->format('Y-m-d');
            }) ->editColumn('exp_date', function($product) {
                return Carbon::parse($product->exp_date)->format('Y-m-d');
            })
            ->make(true);
    }

    public function getSuperAgents(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return Datatables::of($superagents)->editColumn('created_at', function ($superagents) {
            return $superagents->created_at ? with(new Carbon($superagents->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($superagents) {
                return '      <td>
      <a href="'.route('get_storekeepers_stock',['user_id' => $superagents->id]).'" class="text-white">
                                  <button class="btn btn-primary btn-sm" type="button" > View records </button>
                                                   </a> </td>';
            })  ->addColumn('active', function ($superagents) {
                if($superagents->active){
                    return "Active";
                }else{
                    return "Deactivated";
                }
            })
            ->make(true);
    }

    public function getSuperAgentsStockAuditTrail( $user_id, $product_id){
        $user = User::where('id', $user_id)->select('firstname')->first();
        $product = product::where('id', $product_id)->select('name')->first();
        $data = stockcard::ProductCard($product_id)->first();
        $all = $data->audits;
        $data = $all;

        return view('audit.audittrail', compact('data', 'user', 'product'));
    }
}