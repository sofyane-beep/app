<?php

namespace App\Http\Controllers;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id,$request->title,$request->price);

         

      $duplicata  =  Cart::search(function ($cartItem,$rowId) use ($request) {
              return $cartItem->id == $request->product_id;
          });
                  
          if( $duplicata->isNotEmpty()){
              return redirect()->route('products.index')->with('success','le produit a deje ete ajoute');
          }

          $product = Product::find($request->product_id);

        Cart::add($product->id,$product->title,1,$product->price)
        ->associate('App\Product');
        return redirect()->route('products.index')->with('success','le produit a bien ete ajoute');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        Cart::update($rowId,$data['qty']);
        Session::flash('success','laquantite du produit est oassee a ' .$data['qty'].'.');
        return response()->json(['success' => 'carte quantity has been updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return backk();
    }
}
