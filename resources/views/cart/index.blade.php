@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/shop">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
        @if(session()->has('success_msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session()->has('alert_msg'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('alert_msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(count($errors) > 0)
            @foreach($errors0>all() as $error)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <br>
                    @if(\Cart::getTotalQuantity()>0)
                        <h4>{{ \Cart::getTotalQuantity()}} Product(s) In Your Cart</h4><br>
                    @else
                        <h4>No Product(s) In Your Cart</h4><br>
                        <a href="/shop" class="btn btn-dark">Continue Shopping</a>
                    @endif

                @foreach($cartCollection as $item)
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="/images/{{ $item->attributes->image }}" class="img-thumbnail" width="200" height="200">
                        </div>
                        <div class="col-lg-5">
                            <p>
                                <b><a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}</a></b><br>
                                <b>Price: </b>${{ $item->price }}<br>
                                <b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}<br>
{{--                                <b>With Discount: </b>${{ \Cart::get($item->id)->getPriceSumWithConditions() }}--}}
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <form action="{{ route('cart.update') }}" method="POST">{{ csrf_field() }}
                                    <div class="form-group row">
                                        <input type="hidden" value="{{ $item->id}}" id="id" name="id">
                                        <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}"
                                               id="quantity" name="quantity" style="width: 70px; margin-right: 10px;">
                                        <button class="btn btn-secondary btn-sm" style="margin-right: 25px;"><i class="fa fa-edit"></i></button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="btn btn-dark btn-sm" style="margin-right: 10px;"><i class="fa fa-trash"></i></button>
                                </form>
                                @if(auth()->check())
                                    <form action="{{ route('cart.wishlist') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ auth()->user()->id  }}" id="user_id" name="user_id">
                                        <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                        <input type="hidden" value="{{ $item->name }}" id="name" name="name">
                                        <input type="hidden" value="{{ $item->price }}" id="price" name="price">
                                        <input type="hidden" value="{{ $item->quantity }}" id="quantity" name="quantity">
                                        <input type="hidden" value="{{ $item->attributes->slug }}" id="slug" name="slug">
                                        <input type="hidden" value="{{ $item->attributes->image }}" id="image" name="image">
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-heart"></i></button>
                                    </form>
                                @else
                                    <button class="btn btn-success btn-sm" style="margin-right: 10px; height: 35px;" data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart"></i></button>
                                    <div class="modal fade" id="loginModal" style="margin-top: 100px;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <b>You must login to save items for later</b>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="/login" class="btn btn-primary btn-sm">LOGIN</a>
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                @if(count($cartCollection)>0)
                    <form action="{{ route('cart.clear') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-secondary btn-md">Clear Cart</button>
                    </form>
                @endif
            </div>
            @if(count($cartCollection)>0)
                <div class="col-lg-5">
                    <div class="card">
                        <ul class="list-group list-group-flush">
{{--                            <li class="list-group-item"><b>Sub Total: </b>${{ \Cart::getSubTotal() }}</li>--}}
                            <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>
                        </ul>
                    </div>
                    <br><a href="/shop" class="btn btn-dark">Continue Shopping</a>
                    <a href="/checkout" class="btn btn-success">Proceed To Checkout</a>
                </div>
            @endif
        </div>
        <br><br>
        <hr>
        @if(auth()->check())
            <h4>{{ count($wishesList) > 0 ? count($wishesList): 'No'}} Record(s) Saved For Later</h4><br>
            <div class="row">
                @if(count($wishesList)>0)
                    @foreach($wishesList as $wish)
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <img src="/images/{{ $wish->prod_image }}" class="img-thumbnail" width="200" height="200">
                                </div>
                                <div class="col-lg-7">
                                    <p>
                                    <h5><a href="/shop/{{ $wish->prod_slug }}">{{ $wish->prod_name }}</a></h5>
                                    <b>Price: </b>${{ $wish->prod_price }}<br>
                                    </p>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <form action="{{ route('wishlist.move') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $wish->id }}" id="id" name="id">
                                            <input type="hidden" value="{{ $wish->prod_name }}" id="name" name="name">
                                            <input type="hidden" value="{{ $wish->prod_price }}" id="price" name="price">
                                            <input type="hidden" value="{{ $wish->prod_quantity }}" id="quantity" name="quantity">
                                            <input type="hidden" value="{{ $wish->prod_image }}" id="image" name="image">
                                            <input type="hidden" value="{{ $wish->prod_slug }}" id="slug" name="slug">
                                            <button class="btn btn-warning btn-sm" style="margin-right: 10px;"><i class="fa fa-shopping-cart"></i></button>
                                        </form>
                                        <form action="{{ route('wishlist.remove') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $wish->id }}" id="id" name="id">
                                            <button class="btn btn-dark btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

    </div>
@endsection
