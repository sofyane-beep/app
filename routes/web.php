<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*PRODUCTS ROUTES*/
Route::get('/boutique','ProductController@index')->name('products.index');
Route::get('/boutique/{slug}','ProductController@show')->name('products.show');

/*CART ROUTE D'AJOUTE*/
Route::get('/panier','CartController@index')->name('cart.index');
Route::post('/panier/ajouter','CartController@store')->name('cart.store');
Route::patch('/panier/{rowId}','CartController@update')->name('cart.update');
 Route::get('/panier/{{id}}','CartController@destroy')->name('cart.destroy');



Route::get('/videpanier',function(){
    Cart::destroy();
});

/* checkout route*/

Route::get('/paiment','CheckoutController@index')->name('checkout.index');
Route::post('/paiment','CheckoutController@store')->name('checkout.store');
Route::get('/merci','CheckoutController@thankYou')->name('checkout.thankYou');
