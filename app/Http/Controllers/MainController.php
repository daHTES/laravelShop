<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
    public function index(ProductFilterRequest $request){
        $productsQuery = Product::query();
    if($request->filled('price_from')){
        $productsQuery->where('price', '>=', $request->price_from);
    }

    if($request->filled('price_to')){
        $productsQuery->where('price', '<=', $request->price_to);
    }

    foreach (['hit', 'new', 'recommend'] as $field){
        if($request->has($field)){
            $productsQuery->$field();
        }
    }


    $products = $productsQuery->paginate(15)->withPath("?" . $request->getQueryString());

    return view('index', compact('products'));
    }



    public function categories(){
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function category($code){
        $category = Category::where('code', $code)->first();
        return view('category', compact('category' ));
    }

    public function product($category, $productCode){
        $products = Product::withTrashed()->byCode($productCode)->first();
        return view('product', compact('products'));
    }
    //
}
