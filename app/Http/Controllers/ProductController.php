<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;

class ProductController extends Controller
{
   public function index(){
         // dd(Cart::content());
       
      $products = Product::inRandomOrder()->take(6)->get();
    //   dd($products);

       return view('products.index')->with('products',$products);

   }

   public function show($slug){
      $product = Product::where('slug',$slug)->firstOrFail();
      return view('products.show')->with('product',$product);
   }
}
