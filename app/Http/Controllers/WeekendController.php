<?php

namespace App\Http\Controllers;

use App\Ex_category;
use App\WeekendSale;
use backend\ExtremepcProduct;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
const TARGETCATEGORY=423;
class WeekendController extends Controller
{
    public function index(){
        $products = [];
        if (Input::has('a') && Input::get('a')=='import'){
            $products = $this->all();
        }
        $weekendsale = WeekendSale::all();
        $editing_model = false;
        return view('weeksale.index',compact('products','weekendsale','editing_model'));
    }

    public function get($id){
        $product = ExtremepcProduct::find($id);
        dd($product->info());
    }

    public function all(){
        $products = [];
        foreach (Ex_category::find(TARGETCATEGORY)->products()->where('status',1)->pluck('oc_ex_product.product_id')->all() as $id){
            $products[$id] = $this->findProductData($id);
        }
        return $products;
    }

    private function findProductData($id){
        $product = ExtremepcProduct::find($id);
        $item = [];
        $item['model'] = $product->product->model;
        $item['name'] = $product->product->description->name;
        $item['price_current'] = round($product->product->price*1.15,2);
        $item['special_current'] = round($product->getSpecial()*1.15,2);
        $tem = $product->info();
        $item['cost'] = round($tem['averagecost']*1.15,2);
        $item['stock'] = $tem['stock'];
        $item['lock_status'] = $product->product->price_lock;
        $item['sale_base'] = round($product->product->price*1.15,2);
        $item['sale_special'] = ceil($tem['averagecost']*1.05*1.15);
        return $item;
    }
    public function create(Request $request){
        $this->validate($request, [
            'base'=>'required',
            'special'=>'required',
        ]);
        $products = [];
        foreach ($request->base as $id=>$price){
            $products[$id] = [$price,$request->special[$id]];
        }
        $sale = new WeekendSale();
        $sale->products = \GuzzleHttp\json_encode($products);
        $sale->save();
        return redirect('weekendsale');
    }

    public function show($id){
        $sale = WeekendSale::find($id);
        $products = [];
        foreach (json_decode($sale->products,true) as $id=>$prices){
            $product = $this->findProductData($id);
            $product['sale_base'] = $prices[0];
            $product['sale_special'] = $prices[1];
            $products[$id] = $product;
        }
        $weekendsale = WeekendSale::all();
        $editing_model = true;
        $sale_id = $id;
        return view('weeksale.index',compact('products','weekendsale','editing_model','sale_id'));
    }

    public function update(Request $request){
        $this->validate($request, [
            'sale_id'=>'required',
            'base'=>'required',
            'special'=>'required',
        ]);
        $products = [];
        foreach ($request->base as $id=>$price){
            $products[$id] = [$price,$request->special[$id]];
        }
        $sale = WeekendSale::find($request->sale_id);
        $sale->products = \GuzzleHttp\json_encode($products);
        $sale->save();
        return redirect('weekendsale');
    }

    public function del($id){
        WeekendSale::find($id)->delete();
        return redirect()->back();
    }


}
