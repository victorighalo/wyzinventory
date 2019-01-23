<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Yajra\Datatables\Datatables;
class Settings extends Controller
{

    public function loadCities($id)
    {
        return DB::table('cities')->where('state_id', $id)->get();
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response()->json(['message' => 'Account deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Account'], 400);
        }
    }

    public function deactivate($id)
    {
        try {
            $user = User::find($id);
            $user->active = 0;
            $user->save();
            return response()->json(['message' => 'Account Deactivated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Deactivate Account'], 400);
        }
    }

    public function activate($id)
    {
        try {
            $user = User::find($id);
            $user->active = 1;
            $user->save();
            return response()->json(['message' => 'Account Activated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Activate Account'], 400);
        }
    }

    public function permissions(){
        return view('common/permission.index');
    }

    public function permissionsRevoke($user_id){
        try {
            $user = User::where('id', $user_id)->first();
            $user->removeRole('editor');
            return response()->json(['message' => $user->hasRole('editor')], 200);
       }catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to Revoke Permission'], 400);
        }
    }

    public function permissionsGrant($user_id){
        try {
            $user = User::where('id', $user_id)->first();
            $user->assignRole('editor');
            return response()->json(['message' => $user->hasRole('editor')], 200);
        }catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to Grant Permission'], 400);
        }
    }

    public function getSuperAgentsAndPermission(Request $request)
    {
        $superagents = User::role('superagent')->get();
        return Datatables::of($superagents)
            ->addColumn('action', function ($superagents) {
                        if( $superagents->can("edit cards") ){
                                return '<td><button class="btn btn-danger btn-sm" onclick="revoke('.$superagents->id.')" type="button"> 
                                Revoke
                                </button></td>';
                                }else{
                                 return '<td><button class="btn btn-primary btn-sm" onclick="grant('.$superagents->id.')" type="button"> 
                                Grant
                                </button></td>';
                                }
                             ;
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