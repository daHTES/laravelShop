<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket(){

        $order = (new Basket())->getOrder();

        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request) {
        $email = Auth::check() ? Auth::user()->email : $request->email;
        if ((new Basket())->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', 'Ваш заказ принят в обработку!');
        } else {
            session()->flash('warning', 'Случилась ошибка');
        }

        return redirect()->route('index');
    }

    public function basketPlace(){
        $basket = new Basket();
        $order = (new Basket())->getOrder();
        if(!$basket->countAvaliable()){
            session()->flash('warning', 'Товар для заказа не доступен в большем количестве' );
            return redirect()->route('basket');
        }
        return view('order', compact('order'));
    }

    public function basketAdd(Product $product) {

       $result =  (new Basket(true))->addProduct($product);
        if($result){
            session()->flash('success', 'Добавлен товар ' . $product->name);
        }else{
            session()->flash('warning', 'Товар' . $product->name . 'для заказа не доступен в большем количестве' );
        }

        return redirect()->route('basket');

    }

    public function basketRemove(Product $product){

        (new Basket())->removeProduct($product);


        session()->flash('warning', 'Удален товар ' . $product->name);
        return redirect()->route('basket');
    }
}
