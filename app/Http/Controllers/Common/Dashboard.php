<?php

namespace App\Http\Controllers\Common;

use App\product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

        if(Auth::user()->hasRole('admin')){
            return redirect('/products');
        }
        if(Auth::user()->hasRole('superagent')){
            $products = product::get();
            return redirect('/storekeeper/products')->with('products');
        }

        if(Auth::user()->hasRole('agent')){
            return redirect('/audit/storekeepers');
        }
//        $products = product::count();
//        $storekeepers = User::role('superagent')->count();
//        return view('common.dashboard.index', compact('products', 'storekeepers'));
    }
}
