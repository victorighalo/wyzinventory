<?php

namespace App\Http\Controllers\Agents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class SuperAgents extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:auditor|admin']);
    }

    protected function validator(Request $data)
    {
        return Validator::make($data->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function index(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return view('admin.superagents.index', compact('superagents' ));
    }

    public function getSuperAgents(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return Datatables::of($superagents)->editColumn('created_at', function ($superagents) {
            return $superagents->created_at ? with(new Carbon($superagents->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($superagents) {
                return '      <td>
                                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol">
                    
                                                        <a class="dropdown-item activate_btn" href="#" id="'.$superagents->id.'" onclick="activate('.$superagents->id.')">Activate</a>
                                                        <a class="dropdown-item deactivate_btn" href="#" id="'.$superagents->id.'" onclick="deactivate('.$superagents->id.')">Deactivate</a>
                                                        <a class="dropdown-item del_btn" href="#" id="'.$superagents->id.'" onclick="destroy('.$superagents->id.')">Delete</a>
                                                </div></td>';
            })  ->addColumn('active', function ($superagents) {
       if($superagents->active){
       return "Active";
       }else{
        return "Deactivated";
        }
            })
            ->make(true);
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $user = User::create([
            'firstname' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'active' => 1,
            'password' => Hash::make($request['password']),
        ]);

        $user->assignRole('superagent');

        return response()->json(['data'=>'User Created', 'status' => '200'], 200);
    }

    public function destroy($id){
        try{
            User::destroy($id);
            response()->json(['data'=>'User deleted', 'status' => '200'], 200);
        }catch (\Exception $e){
            response()->json(['data'=>' Failed to delete User', 'status' => '400'], 400);
        }
    }
}
