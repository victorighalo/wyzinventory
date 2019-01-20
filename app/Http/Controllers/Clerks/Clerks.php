<?php

namespace App\Http\Controllers\Clerks;

use App\stockcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class Clerks extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:superagent|admin']);
    }

    public function index(Request $request)
    {
        $products = product::get();
        return view('clerks.products.index', compact('products' ));
    }

    public function stockCard($product_id){

        $product = product::where('id',$product_id)->select('name', 'id')->first();
        return view('clerks.stockcard.index', compact('product'));
    }

    public function stockCardData($product_id){
        $data = stockcard::clerkCard(Auth::id())->productCard($product_id)->get();

        return Datatables::of($data)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($data) {
                return '<td>
                    <button  class="btn btn-primary btn-sm" type="button" id="settingcol"><a  class="text-white" href="'.route('product_stock_link',['product_id' => $data->id]).'"> Open Card </a></button>
                        </td>';
            }) ->editColumn('active', function($product) {
                return $product->active ? 'Available' : 'Out of stock';
            })
            ->make(true);
    }

}
