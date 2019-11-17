@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="/shop">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->slug}}</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail">
            </div>
            <div class="col-lg-8">
                <h4>{{ $product->name }}</h4><br>
                <p class="text-muted">{{ $product->details }}</p>
                <p>${{ $product->price }}</p>
                <p>${{ $product->shipping_cost }}</p>
                <p>{{ $product->description }}</p>
                <br>
                <form action="{{ route('cart.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $product->id }}" id="id" name="id">
                    <input type="hidden" value="{{ $product->name }}" id="name" name="name">
                    <input type="hidden" value="{{ $product->price }}" id="price" name="price">
{{--                    <input type="hidden" value="{{ $product->shipping_cost }}" id="shipping_cost" name="shipping_cost">--}}
                    <input type="hidden" value="{{ $product->image_path }}" id="img" name="img">
                    <input type="hidden" value="{{ $product->slug }}" id="slug" name="slug">
                    <div class="row">
                        <input type="number" class="form-control" id="quantity" name="quantity" style="width: 100px; margin-right: 10px;">
                        <button class="btn btn-dark btn-md">Add To Cart</button>
                    </div>

                </form>

            </div>
        </div>
        <hr>
        @if(count($mightLike)>0)
            <br><h5>You Might Also Like...</h5><br>
            <div class="row">
                @foreach($mightLike as $likePro)
                    <div class="col-lg-3">
                        <div class="card" style="margin-bottom: 20px;">
                            <img src="/images/{{ $likePro->image_path }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <a href="/shop/{{ $likePro->slug }}"><h6 class="card-title">{{ $likePro->name }}</h6></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
