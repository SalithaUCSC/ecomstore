@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="/shop">Shop</a></li>
                <li class="breadcrumb-item" aria-current="page">Brand</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $brand->name }}</li>
            </ol>
        </nav>
        <h4>Products By Category: {{ $brand->name }}</h4>
        <hr>
        <div class="row" style="margin-left: -10px;">
            @foreach($products as $pro)
                <div class="col-lg-4">
                    <div class="card" style="margin-bottom: 20px;">
                        <img src="/images/{{ $pro->image_path }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="/shop/{{ $pro->slug }}"><h5 class="card-title">{{ $pro->name }}</h5></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
