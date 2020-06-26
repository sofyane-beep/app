<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Illuminate\Support\Facades\Session;
use App\Order;
use dateTime;
use Stripe\PaymentIntent; 
use Illuminate\Support\Arr;

class CheckoutController extends Controller
{
    public function index(){
         
         if(Cart::count() <= 0   ){
            return redirect()->route('products.index');
         }

       Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
       $intent = PaymentIntent::create([
        'amount' => round(Cart::total()),
        'currency' => 'usd',

        
      ]);


      $clientSecret  = Arr::get($intent,'client_secret');
         return view('checkout.index',[
             'clientSecret' => $clientSecret
         ]);
    }



    public function store(Request $request){
         
        $data = $request->json()->all();
        $order = new Order();
        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];
       
         $order->payment_created_at = (new DateTime())
         ->setTimestamp($data['paymentIntent']['created'])
         ->format('Y-m-d H:i:s');

         $products = [];
         $i = 0 ;

         foreach(Cart::content() as $product){
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
         }
         $order->products = serialize($products);
         $order->user_id = 15;
         $order->save();

         if($data['paymentIntent']['status'] == 'succeeded'){
             Cart::destroy();
             Session::flash('success',' votre commande e ete traitee avec succes .' );
             return response()->json(['success' => 'payment intent succeeded']);
         }else{
            return response()->json(['error' => 'payment intent not succeeded']);
         }

         // return $data['paymentIntent'];
                    //    Cart:destroy();


    }

    public function thankyou(){
         return Session::has('success') ? view('checkout.thankyou') : redirect()->route('products.index');
     }


}
