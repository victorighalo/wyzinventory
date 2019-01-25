<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        if(is_numeric($request->get('email'))){
            $credentials = ['phone'=> $request->get('email'),'password'=> $request->get('password'), 'active' => 1];
        }else{
            $credentials = ['email'=> $request->get('email'),'password'=> $request->get('password'), 'active' => 1];
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
        return response()->view('errors.401', [], 401);
    }
}