<?php

namespace App\Http\Controllers\Products;

use App\category;
use App\stockcard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
class Products extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $categories = category::get();
        return view('admin.products.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }



        $product = product::create([
            'name' => $request['name'],
            'category_id' => $request['category']
        ]);

        return response()->json(['data' => $product, 'status' => '200'], 201);
    }

    public function delete($id){
        try{
            product::destroy($id);
            response()->json(['data'=>'Product deleted', 'status' => '200'], 200);
        }catch (\Exception $e){
            response()->json(['data'=>' Failed to delete product', 'status' => '400'], 400);
        }
    }

    public function getProducts(Request $request)
    {
        $data = product::get();
        return Datatables::of($data)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($data) {
                return '      <td>
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol">
                    
                                                        <a class="dropdown-item activate_btn" href="#" id="'.$data->id.'" onclick="activate('.$data->id.')">Activate</a>
                                                        <a class="dropdown-item deactivate_btn" href="#" id="'.$data->id.'" onclick="deactivate('.$data->id.')">Deactivate</a>
                                                        <a class="dropdown-item del_btn" href="#" id="'.$data->id.'" onclick="remove('.$data->id.')">Delete</a>
                                                </div></td>';
            })  ->addColumn('active', function ($subdata) {
                if($subdata->active){
                    return "Active";
                }else{
                    return "Deactivated";
                }
            })
            ->editColumn('category_id', function($product) {
                return category::where('id', $product->category_id)->select('name')->first()->name;
            })
            ->make(true);
    }


   public function getProductsClerks(Request $request)
    {
        $data = product::get();
        return Datatables::of($data)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('action', function ($data) {
                return '<td>
                    <button  class="btn btn-primary btn-sm" type="button" id="settingcol"><a  class="text-white" href="'.route('product_stock_link',['product_id' => $data->id]).'"> Open Card </a></button>
                        </td>';
            }) ->editColumn('active', function(product $product) {
                return $product->active ? 'Available' : 'Out of stock';
            })
            ->make(true);
    }

    public function deactivate($id)
    {
        try {
            $user = product::find($id);
            $user->active = 0;
            $user->save();
            return response()->json(['message' => 'Product Deactivated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Deactivate Product'], 400);
        }
    }

    public function activate($id)
    {
        try {
            $user = product::find($id);
            $user->active = 1;
            $user->save();
            return response()->json(['message' => 'Product Activated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Activate Product'], 400);
        }
    }
}
