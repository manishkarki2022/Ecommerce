@extends('front.layouts.app')
@section('content')
    <section class="container">
            <div class="col-md-12 text-center py-5">
                <h1>Thank you for your order</h1>
                <p>Your order has been successfully placed. We will contact you soon.</p>
                <p>Your order id is <strong class="h3"> {{$orderId}}</strong></p>
                <a href="{{route('front.shop')}}">Shop more</a>
            </div>
    </section>
@endsection
