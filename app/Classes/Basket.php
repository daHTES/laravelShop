<?php


namespace App\Classes;


use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Services\CurrencyConversion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class Basket
 * @package App\Classes
 */
class Basket
{
    /**
     * @var Order|\Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected $order;

    /**
     * Basket constructor.
     * @param false $createOrder
     */
    public function __construct($createOrder = false){

        $order = session('order');

      //  $order->currency_id = CurrencyConversion::getCurrentCurrencyFromSession()->id;
      //  session(['order' => $order]);

        if(is_null($order) && $createOrder){
            $data = [];
            if(Auth::check()){
                $data['user_id'] = Auth::id();
            }

            $data['currency_id'] = CurrencyConversion::getCurrentCurrencyFromSession()->id;

            $this->order = new Order($data);
            session(['order' => $this->order]);
        }else{
            $this->order = $order;
        }
    }

    /**
     * @return Order|\Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public function getOrder(){
        return $this->order;
    }

    /**
     * @param false $updateCount
     * @return bool
     */
    public function countAvaliable($updateCount = false){

        $products = collect([]);

        foreach ($this->order->products as $orderProduct){

            $product = Product::find($orderProduct->id);

            if($orderProduct->countInOrder > $product->count){
                return false;
            }

            if($updateCount){
                $orderProduct->count -= $orderProduct->countInOrder;
                $products->push($product);
            }
        }

        if($updateCount){
            $products->map->save();
        }
        return true;
    }

    /**
     * @param $name
     * @param $phone
     * @param $email
     * @return bool
     */
    public function saveOrder($name, $phone, $email){
        if(!$this->countAvaliable(true)){
            return false;
        }
        $this->order->saveOrder($name, $phone);
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));
        return true;
    }


    /**
     * @param Product $product
     */
    public function removeProduct(Product $product){

        if($this->order->products->contains($product)){
            $pivotRow = $this->order->products->where('id', $product->id)->first();
            if($pivotRow->countInOrder < 2){
                $this->order->products->pop($product);
            }else {
                $pivotRow->countInOrder--;
            }
        }
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function addProduct(Product $product){

        if($this->order->products->contains($product)){
            $pivotRow = $this->order->products->where('id', $product->id)->first();
            if( $pivotRow->countInOrder >= $product->count){
                    return false;
            }
            $pivotRow->countInOrder++;
        }else{
            if($product->count == 0){
                return false;
            }
            $product->countInOrder = 1;
            $this->order->products->push($product);
        }

        return true;
    }

}
