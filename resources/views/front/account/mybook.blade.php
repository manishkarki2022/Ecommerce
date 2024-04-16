@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a></li>
                    <li class="breadcrumb-item active">My Book</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-11">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Book</h2>
                        </div>
                        <div class="row pb-3">
                            @if($orders->isNotEmpty())
                                @foreach($orders as $order)
                                    @foreach($order->items as $item )
                                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4 p-2">
                                            <div class="items-center p-4">
                                                <div class="product product-image position-relative" style="height:auto;overflow: hidden;">
                                                    @if($item->product->images !== null && $item->product->images->isNotEmpty() && $item->product->images->first() !== null)
                                                        <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/' . $item->product->images->first()->image) }}" alt="{{ $item->product->title }}">
                                                    @else
                                                        <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/di.jpg') }}" alt="{{ $item->product->title }}">
                                                    @endif
                                                </div>
                                                <div class="card-body p-1">
                                                    {{ strlen($item->product->title) > 20 ? substr($item->product->title, 0, 20) . ' ...' : $item->product->title }}
                                                    @if($item->product->author_id)
                                                        <p class="text-muted text-left mb-0">By: {{ $item->product->author->name }}</p>
                                                    @endif
                                                </div>
                                                <form action="{{ route('account.myBookShow', $item->product->id) }}" method="GET" style="display: none;" id="read-form-{{ $item->product->id }}">
                                                    @csrf
                                                </form>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('read-form-{{ $item->product->id }}').submit();" class="btn btn-success w-100">Read</a>

                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{ $orders->withQueryString()->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
