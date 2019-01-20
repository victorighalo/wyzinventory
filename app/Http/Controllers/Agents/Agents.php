<?php

namespace App\Http\Controllers\Agents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
class Agents extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:superagent|admin']);
    }

    protected function validator(Request $data)
    {
        return Validator::make($data->all(), [
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }
    public function index(){
        $states = DB::table('states')->get();
        $cities = DB::table('cities')->get();
        return view('admin.agents.index', compact( 'states', 'cities'));
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'state' => $request['state'],
            'city' => $request['city'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
        ]);

        $user->assignRole('agent');

        return $user;
    }

    public function getAgents(Request $request)
    {
        $superagents = User::role('agent')->get();
        return Datatables::of($superagents)->editColumn('created_at', function ($data) {
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
