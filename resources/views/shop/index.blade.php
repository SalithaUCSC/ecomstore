@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>


        <br>
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">By Category</h5>
                        @foreach($categories as $cat)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="margin-left: -20px;">
                                    <a href="/shop/categories/{{ $cat->id }}" class="card-link">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">By Brand</h5>
                        @foreach($brands as $brand)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="margin-left: -20px;">
                                    <a href="/shop/brands/{{ $brand->id }}" class="card-link">
                                        {{ $brand->name }}
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">By Price</h5><hr>
                        <ul class="list-group list-group-flush">
                            <form action="{{ route('search.price') }}" method="GET">
                                <div class="form-group row">
                                    <label for="min" class="col-sm-4 col-form-label">Min : </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="min" class="form-control form-control-sm" id="min">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="max" class="col-sm-4 col-form-label">Max : </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="max" class="form-control form-control-sm" id="max">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm" id="apply_price">Apply Filter</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-7">
                        <h4>Products In Our Store</h4>
                    </div>
{{--                    <div class="col-lg-5">--}}
{{--                        <b>Price: </b>--}}
{{--                        <a href="{{ route('product', ['sort' => 'low_high']) }}">Low to High</a>--}}
{{--                        |--}}
{{--                        <a href="{{ route('product', ['sort' => 'high_low']) }}">High to Low</a>--}}
{{--                    </div>--}}
                </div>

                <hr>
                <form action="{{ route('search.results') }}" method="GET" class="form-inline my-20">
                    <input class="form-control form-control-sm mr-sm-2" type="search" id="search" name="search"
                           placeholder="Search Product" aria-label="Search" style="width: 740px;">
                    <button class="btn btn-outline-dark btn-sm my-2 my-sm-0" type="submit" id="search_btn">Search</button>
                </form>
                <div id="products_list"></div>
                <hr>
                <div class="row">
                    @foreach($products as $pro)
                        <div class="col-lg-4">
                            <div class="card" style="margin-bottom: 20px; height: auto;">
                                <img src="/images/{{ $pro->image_path }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <a href="/shop/{{ $pro->slug }}"><h6 class="card-title">{{ $pro->name }}</h6></a>
                                    <p>${{ $pro->price }}</p>
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $pro->id }}" id="id" name="id">
                                        <input type="hidden" value="{{ $pro->name }}" id="name" name="name">
                                        <input type="hidden" value="{{ $pro->price }}" id="price" name="price">
                                        <input type="hidden" value="{{ $pro->image_path }}" id="img" name="img">
                                        <input type="hidden" value="{{ $pro->slug }}" id="slug" name="slug">
                                        <input type="hidden" value="1" id="quantity" name="quantity">
                                        <div class="row">
{{--                                            <button class="btn btn-primary btn-sm" style="margin-right: 10px;"><i class="fa fa-shopping-cart"></i></button>--}}
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
