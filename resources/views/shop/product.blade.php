@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="/shop">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->slug}}</li>
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
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail">
                <hr>
                <div class="row">
                    <div class="col-lg-3"><img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail"></div>
                    <div class="col-lg-3"><img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail"></div>
                    <div class="col-lg-3"><img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail"></div>
                    <div class="col-lg-3"><img src="/images/{{ $product->image_path }}" alt="" class="img-thumbnail"></div>
                </div>
            </div>
            <div class="col-lg-8">
                <h4>{{ $product->name }}</h4>
                <p content="text-muted">{{ $product->brand->name }}</p>
                <p class="text-muted">{{ $product->details }}</p>
                <p>${{ $product->price }}</p>
{{--                <p>${{ $product->shipping_cost }}</p>--}}
                <p>{{ $product->description }}</p>
                <br>
                <div class="row">
                    <form action="{{ route('cart.store') }}" method="POST" style="margin-left: 30px;">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $product->id }}" id="id" name="id">
                        <input type="hidden" value="{{ $product->name }}" id="name" name="name">
                        <input type="hidden" value="{{ $product->price }}" id="price" name="price">
                        {{--                    <input type="hidden" value="{{ $product->shipping_cost }}" id="shipping_cost" name="shipping_cost">--}}
                        <input type="hidden" value="{{ $product->image_path }}" id="img" name="img">
                        <input type="hidden" value="{{ $product->slug }}" id="slug" name="slug">
                        <div class="row">
                            <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" style="width: 100px; margin-right: 10px;">
                            <button class="btn btn-dark btn-sm" style="margin-right: 25px;">Add To Cart</button>
                        </div>
                    </form>
                    @if(auth()->check())
                        <form action="{{ route('cart.wishlist') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ auth()->user()->id  }}" id="user_id" name="user_id">
                            <input type="hidden" value="{{ $product->id }}" id="id" name="id">
                            <input type="hidden" value="{{ $product->name }}" id="name" name="name">
                            <input type="hidden" value="{{ $product->price }}" id="price" name="price">
                            <input type="hidden" value="1" id="quantity" name="quantity">
                            <input type="hidden" value="{{ $product->slug }}" id="slug" name="slug">
                            <input type="hidden" value="{{ $product->image_path }}" id="image" name="image">
                            <button class="btn btn-danger btn-sm"><i class="fa fa-heart"></i></button>
                        </form>
                    @else
                        <button class="btn btn-danger btn-sm" style="margin-right: 10px; height: 35px;" data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart"></i></button>
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
        <br>
        <b style="margin-left: 0px;">({{ count($reviews) }}) Customer Reviews</b><br><br><br>
        <div class="row">
            <div class="col-lg-7">
                @if(count($reviews)>0)
                    @foreach($reviews as $review)
                        <div class="row">
                            <div class="col-lg-10">
                                {{ $review->comment }}<br>
                                <small><b>published by: </b>{{ $review->user->name }}</small><br>
                                <small><b>published by: </b>{{ date('d-m-Y H:m:s', strtotime($review->created_at)) }}</small>
                            </div>
                            <div class="col-lg-2">
                                @if(auth()->check())
                                    @if($review->user_id = auth()->user()->id)
                                        <form action="{{ route('review.remove') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $review->id }}" name="review_id">
                                            <input type="hidden" value="{{ $product->id }}" name="prod_id">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                </div>
                        </div>

                        <hr>
                    @endforeach
                @else
                    <b>No Reviews</b>
                @endif
            </div>
            <div class="col-lg-5">
                @if(auth()->check())
                    <b style="margin-left: 0px;">Add Your Review</b><br><br>
                    <form action="{{ route('review') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" id="prod_id" name="prod_id" value="{{ $product->id }}">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label for="rate">Your Rating</label>
                                <select class="form-control form-control-sm" id="rate" name="rate">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select></div>
                            <div class="col-lg-8">
                                <label for="name">Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ auth()->user()->name }}" id="name" name="name" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control form-control-sm" value="{{ auth()->user()->email }}" id="email" name="email" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <label for="comment">Your Review</label>
                            <textarea class="form-control form-control-sm" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button class="btn btn-dark btn-sm">Add Review</button>
                    </form>
                @endif
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
