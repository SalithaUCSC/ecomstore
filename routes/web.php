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

Route::get('/', 'PageController@index')->name('index');

Auth::routes(['verify' => true]);

Route::get('/profile', 'HomeController@profile')->name('profile')->middleware('verified');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/shop', 'PageController@shop')->name('shop');

Route::get('/shop/categories/{catId}', 'PageController@category')->name('category');
Route::get('/shop/brands/{brId}', 'PageController@brand')->name('brand');

Route::get('/shop/{proId}', 'PageController@product')->name('product');

Route::get('/search', 'PageController@search')->name('search');
Route::get('/search_results', 'PageController@search_results')->name('search.results');
Route::get('/search_price', 'PageController@search_price')->name('search.price');

Route::get('/cart', 'CartController@index')->name('cart');

Route::post('/clear', 'CartController@clear')->name('cart.clear');

Route::post('/remove', 'CartController@remove')->name('cart.remove');

Route::post('/cart', 'CartController@store')->name('cart.store');

Route::post('/save', 'CartController@save')->name('cart.save');

Route::get('/about', 'PageController@about')->name('about');

Route::get('/blog', 'PageController@blog')->name('blog');
