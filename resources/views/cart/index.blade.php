@extends('layouts.app')

@section('content')
    <div class="container">
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
            <div class="col-lg-6">
                <br>
                    @if(count($cartCollection)>0)
                        <h4>{{ count($cartCollection) }} Product(s) In Your Cart</h4><br>
                    @else
                        <h4>No Product(s) In Your Cart</h4><br>
                        <a href="/shop" class="btn btn-dark">Continue Shopping</a>
                    @endif
                <hr>
                @foreach($cartCollection as $item)
                    <div class="row">
                        <div class="col-lg-3">
                            <img src="/images/{{ $item->attributes->image }}" class="img-thumbnail" width="200" height="200">
                        </div>
{{--                        <div class="col-lg-1"></div>--}}
                        <div class="col-lg-6">
                            <p>
                                <h5><a href="/shop/{{ $item->attributes->slug }}">{{ $item->name }}</a></h5>
                                <b>Price: </b>${{ $item->price }}<br>
{{--                                <b>Shipping: </b>${{ $item->shipping_cost }}<br>--}}
                                <b>Sub Total: </b>${{ \Cart::get($item->id)->getPriceSum() }}
                            </p>
                        </div>
                        <div class="col-lg-3">
                            <div class="row">
                                <input type="number" class="form-control form-control-sm" value="{{ $item->quantity }}"
                                       id="quantity" name="quantity" style="width: 70px;"><br>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                                <form action="{{ route('cart.save') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                    <button class="btn btn-success btn-sm"><i class="fa fa-heart"></i></button>
                                </form>
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
                <div class="col-lg-6">
{{--                    <div class="card">--}}
{{--                        <ul class="list-group list-group-flush">--}}
{{--                            <li class="list-group-item"><b>Sub Total: </b>${{ \Cart::getSubTotal() }}</li>--}}
{{--                            <li class="list-group-item"><b>Shipping Cost :</b></li>--}}
{{--                            <li class="list-group-item"><b>Total: </b>${{ \Cart::getSubTotal() }}</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <br>--}}
                    <div class="card">
                        <ul class="list-group list-group-flush">
{{--                            <li class="list-group-item"><b>Sub Total: </b>${{ \Cart::getSubTotal() }}</li>--}}
{{--                            <li class="list-group-item"><b>Total: </b>${{ \Cart::getTotal() }}</li>--}}
                        </ul>
                    </div>
                    <br><a href="/shop" class="btn btn-dark">Continue Shopping</a>
                    <a href="/checkout" class="btn btn-success">Proceed To Checkout</a>
                </div>
            @endif
        </div>
    </div>
@endsection
