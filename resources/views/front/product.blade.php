@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">{{ ucfirst($product->title) }}</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-3 col-sm-6">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if($product->images)
                                @foreach($product->images as $key => $image)
                                    <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                            <img class="card-img-top img-fluid h-100" src="{{ asset('products/' . $image->image) }}" alt="{{ $image->litle }}" title="{{ $product->title }}">
                                    </div>
                                @endforeach
                            @endif
                                <img class="card-img-top img-fluid" src="{{ asset('products/di.jpg') }}" alt="{{ $product->title }}" title="{{ $product->title }}">
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{$product->title}}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        @if($product->compare_price)
                            <h2 class="price "><del>${{$product->compare_price}}</del></h2>
                        @endif
                        <h2 class="price ">${{$product->price}}</h2>

                        {!! $product->short_description !!}
                        <a href="javascript:void(0);" onclick="addToCart({{$product->id}})" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                @if($product->description==!null)
                                    <p>
                                        {!! $product->description !!}
                                    </p>
                                @else<p>No Description</p>
                                @endif


                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                    @if($product->shipping_returns==!null)
                                        <p>
                                            {!! $product->shipping_returns !!}
                                        </p>
                                    @else<p>No Shipping and Returns</p>
                                    @endif
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="row pb-3 slider3 ">
                @if(!$relatedProducts==null)
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-card">
                                <div class="product-image position-relative" style="height: 300px !important; overflow: hidden">
                                    @if($relatedProduct->images !== null && $relatedProduct->images->isNotEmpty() && $relatedProduct->images->first() !== null)
                                        <a href="{{route('front.product',$relatedProduct->slug)}}" class="product-img ">
                                            <img class="card-img-top img-fluid h-100" src="{{ asset('products/' . $relatedProduct->images->first()->image) }}" alt="{{$relatedProduct->litle}}">
                                        </a>
                                    @else
                                        <a href="{{route('front.product',$relatedProduct->slug)}}" class="product-img " alt="{{$relatedProduct->litle}}">
                                            <img class="card-img-top img-fluid" src="{{ asset('products/di.jpg') }}" alt="{{$relatedProduct->litle}}">
                                        </a>
                                    @endif

                                </div>
                                <div class="card-body mt-2 p-1">
                                    <a class="h4 link mt-0" href="{{route('front.product',$relatedProduct->slug)}}" title="{{$relatedProduct->title}}">{{ strlen($relatedProduct->title) > 15 ? substr($relatedProduct->title, 0, 15) . ' ...' : $relatedProduct->title }}</a>
                                    <p class="text-muted text-left">Ram Bahadur</p>
                                    <div class="d-flex justify-content-between px-1">
                                        <div>
                                            <span class="h5 me-2"><strong>${{$relatedProduct->price}}</strong></span>
                                            @if($relatedProduct->compare_price !== '')
                                                <span class="h6 text-underline"><del>${{$relatedProduct->compare_price}}</del></span>
                                            @endif
                                        </div>
                                        <a class="" href="#"><i class="far fa-heart text-primary"></i></a>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-dark w-100" style="background-color: #937dc2 !important; border: none !important" href="javascript:void(0)" onclick="addToCart({{$relatedProduct->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else <p class="error">No Related Product </p>
                @endif

            </div>
        </div>
    </section>
@endsection
@section('customJs')
@endsection

