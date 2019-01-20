<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
class Customers extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.customers.index');
    }

    public function getCustomers(Request $request)
    {
        $customers = User::role('customer')->get();
        return Datatables::of($customers)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($data) {
                return '      <td>
                                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol">
                    
                                                        <a class="dropdown-item activate_btn" href="#" id="'.$data->id.'" onclick="activate('.$data->id.')">Activate</a>
                                                        <a class="dropdown-item deactivate_btn" href="#" id="'.$data->id.'" onclick="deactivate('.$data->id.')">Deactivate</a>
                                                        <a class="dropdown-item del_btn" href="#" id="'.$data->id.'" onclick="delete('.$data->id.')">Delete</a>
                                                </div></td>';
            })  ->addColumn('active', function ($subdata) {
                if($subdata->active){
                    return "Active";
                }else{
                    return "Deactivated";
                }
            })
            ->make(true);
    }
}
