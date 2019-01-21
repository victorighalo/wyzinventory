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
        return Datatables::of($data)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($data) use($user_id) {
                return '<td>
                    <button  class="btn btn-primary btn-sm" type="button" id="settingcol"><a  class="text-white" href="'.route('get_storekeepers_stock_audittrail',['product_id' => $data->product_id, 'user_id' => $user_id]).'"> Audit trail </a></button>
                        </td>';
            }) ->addColumn('productname', function($data) {
                return product::where('id', $data->product_id)->select('name')->first()->name;
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

    public function getSuperAgentsStockAuditTrail( $user_id, $product_id){
        $data = stockcard::clerkCard($user_id)->ProductCard($product_id)->first();
        $all = $data->audits;
        $data = $all;

        return view('audit.audittrail', compact('data'));
    }
}