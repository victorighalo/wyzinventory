<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
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

}