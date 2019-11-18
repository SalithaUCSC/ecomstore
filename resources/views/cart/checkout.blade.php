@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">{{ \Cart::getTotalQuantity()}}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach($cartCollection as $item)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{ $item->name }}</h6>
                            <small class="text-muted"><b>quantity: </b>{{ $item->quantity }}</small>
                        </div>
                        <span class="text-muted">${{ \Cart::get($item->id)->getPriceSum() }}</span>
                    </li>
                    @endforeach

{{--                    <li class="list-group-item d-flex justify-content-between bg-light">--}}
{{--                        <div class="text-success">--}}
{{--                            <h6 class="my-0">Promo code</h6>--}}
{{--                            <small>EXAMPLECODE</small>--}}
{{--                        </div>--}}
{{--                        <span class="text-success">-$5</span>--}}
{{--                    </li>--}}
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>${{ \Cart::getTotal()}}</strong>
                    </li>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form>
                <br>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fa fa-check-circle-o"></i> Original Products</li>
                        <li class="list-group-item"><i class="fa fa-home"></i> Home Delivery</li>
                        <li class="list-group-item"><i class="fa fa-arrow-circle-left"></i> 7 Days Return</li>
                    </ul>
                </div>

            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing Details</h4>
                <form class="needs-validation" data-parsley-validate id="checkout-form">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="" value=""
                               data-parsley-required="true" data-parsley-required-message="Your Name is Required">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="salitha@gmail.com"
                               data-parsley-required="true" data-parsley-required-message="Your Email is Required"
                               data-parsley-type="email" data-parsley-type-message="Your Email is Not Valid"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                               data-parsley-required="true" data-parsley-required-message="Your Address is Required">
                    </div>
{{--                    <div class="row">--}}
                        <div class="mb-3">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city"
                                   data-parsley-required="true" data-parsley-required-message="City is Required">
                        </div>
                        <div class="mb-3">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province"
                                   data-parsley-required="true" data-parsley-required-message="Province is Required">
                        </div>
                        <div class="mb-3">
                            <label for="postal-code">Postal Code</label>
                            <input type="text" class="form-control" id="postal-code" name="postal-code"
                                   data-parsley-required="true" data-parsley-required-message="Postal Code is Required">
                        </div>
                        <div class="mb-3">
                            <label for="phone">Phone No</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   data-parsley-required="true" data-parsley-required-message="Phone Number is Required"
                                   data-parsley-length="10" data-parsley-length-message="Phone Number is Not Valid">
                        </div>
{{--                    </div>--}}
{{--                    <hr class="mb-4">--}}
{{--                    <div class="custom-control custom-checkbox">--}}
{{--                        <input type="checkbox" class="custom-control-input" id="same-address">--}}
{{--                        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>--}}
{{--                    </div>--}}
{{--                    <div class="custom-control custom-checkbox">--}}
{{--                        <input type="checkbox" class="custom-control-input" id="save-info">--}}
{{--                        <label class="custom-control-label" for="save-info">Save this information for next time</label>--}}
{{--                    </div>--}}
{{--                    <hr class="mb-4">--}}

{{--                    <h4 class="mb-3">Payment</h4>--}}

{{--                    <div class="d-block my-3">--}}
{{--                        <div class="custom-control custom-radio">--}}
{{--                            <input id="cardpay" name="paymentMethod" type="radio" class="custom-control-input" checked required>--}}
{{--                            <label class="custom-control-label" for="cardpay">Card Payments</label>--}}
{{--                        </div>--}}
{{--                        <div class="custom-control custom-radio">--}}
{{--                            <input id="cod" name="paymentMethod" type="radio" class="custom-control-input" required>--}}
{{--                            <label class="custom-control-label" for="cod">Cash On Delivery</label>--}}
{{--                        </div>--}}
{{--                        <div class="custom-control custom-radio">--}}
{{--                            <input id="stripe" name="paymentMethod" type="radio" class="custom-control-input" required>--}}
{{--                            <label class="custom-control-label" for="stripe">Stripe</label>--}}
{{--                        </div>--}}
{{--                        <div class="custom-control custom-radio">--}}
{{--                            <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>--}}
{{--                            <label class="custom-control-label" for="paypal">Paypal</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6 mb-3">--}}
{{--                            <label for="cc-name">Name on card</label>--}}
{{--                            <input type="text" class="form-control" id="cc-name" placeholder="" required>--}}
{{--                            <small class="text-muted">Full name as displayed on card</small>--}}
{{--                            <div class="invalid-feedback">--}}
{{--                                Name on card is required--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 mb-3">--}}
{{--                            <label for="cc-number">Credit card number</label>--}}
{{--                            <input type="text" class="form-control" id="cc-number" placeholder="" required>--}}
{{--                            <div class="invalid-feedback">--}}
{{--                                Credit card number is required--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-3 mb-3">--}}
{{--                            <label for="cc-expiration">Expiration</label>--}}
{{--                            <input type="text" class="form-control" id="cc-expiration" placeholder="" required>--}}
{{--                            <div class="invalid-feedback">--}}
{{--                                Expiration date required--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3 mb-3">--}}
{{--                            <label for="cc-expiration">CVV</label>--}}
{{--                            <input type="text" class="form-control" id="cc-cvv" placeholder="" required>--}}
{{--                            <div class="invalid-feedback">--}}
{{--                                Security code required--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <hr class="mb-4">
                    <button class="btn btn-dark btn-md" type="submit">Place Order</button>
                </form>

            </div>
        </div>
@endsection
