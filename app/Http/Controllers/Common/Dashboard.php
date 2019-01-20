<?php

namespace App\Http\Controllers\Common;

use App\product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $products = product::count();
        $storekeepers = User::role('superagent')->count();
        return view('common.dashboard.index', compact('products', 'storekeepers'));
    }
}
