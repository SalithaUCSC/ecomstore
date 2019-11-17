<?php

namespace App\Http\Controllers;

use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartCollection = \Cart::getContent();
//        dd($cartCollection);
        return view('cart.index')->withTitle('E-COMMERCE STORE | CART')
            ->with(['cartCollection' => $cartCollection]);
    }

    public function store(Request $request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));
        return redirect()->route('cart')->with('success_msg', 'Item is Added to Cart!');
    }

    public function clear(){
        \Cart::clear();
        return redirect()->route('cart')->with('success_msg', 'Car is cleared!');
    }

    public function remove(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cart')->with('success_msg', 'Item is removed!');
    }
}
