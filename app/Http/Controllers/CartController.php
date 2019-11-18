<?php

namespace App\Http\Controllers;

use App\Product;
use App\WishList;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Darryldecode\Cart\Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartCollection = \Cart::getContent();

        if(Auth::check()) {
            $wishes = WishList::where('user_id', auth()->user()->id)->get();
            return view('cart.index')->withTitle('E-COMMERCE STORE | CART')
                ->with([
                    'cartCollection' => $cartCollection,
                    'wishesList' => $wishes
                ]);
        }
        else {
            return view('cart.index')->withTitle('E-COMMERCE STORE | CART')
                ->with(['cartCollection' => $cartCollection]);
        }


    }

    public function store(Request $request)
    {
        $cond = new CartCondition(array(
            'name' => 'Item Gift Pack 25.00',
            'type' => 'promo',
            'value' => '-25',
        ));

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

    public function update_cart(Request $request){
//        dd($request);
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        return redirect()->route('cart')->with('success_msg', 'Cart is Updated!');
    }

    public function wishlist(Request $request){
        $products = WishList::where('prod_id', $request->id)->where('user_id', auth()->user()->id)->get();
        if (count($products) > 0) {
            \Cart::remove($request->id);
            return redirect()->route('cart')->with('alert_msg', 'Item is Already Saved..Check WishList!');
        } else {
            WishList::create([
                'user_id' => $request->user_id,
                'prod_id' => $request->id,
                'prod_name' => $request->name,
                'prod_price' => $request->price,
                'prod_quantity' => $request->quantity,
                'prod_slug' => $request->slug,
                'prod_image' => $request->image
            ]);
            \Cart::remove($request->id);
            return redirect()->route('cart')->with('success_msg', 'Item is Saved For Later!');
        }
    }

    public function remove_wish(Request $request){
        $wish = WishList::where('id', $request->id)->get()->first();;
        $wish->delete();
        return redirect()->route('cart')->with('success_msg', 'Item is Removed From WishList!');
    }

    public function move_to_cart(Request $request){
        $wish = WishList::where('id', $request->id)->get()->first();;

        $wish->delete();
        \Cart::add(array(
            'id' => $wish->prod_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
                'slug' => $request->slug
            )
        ));
        return redirect()->route('cart')->with('success_msg', 'Item is Removed From WishList!');
    }

    public function checkout(){
        $cartCollection = \Cart::getContent();
        return view('cart.checkout')
            ->with([
                'cartCollection' => $cartCollection
            ])->withTitle('E-COMMERCE STORE | CHECKOUT');
    }

}
