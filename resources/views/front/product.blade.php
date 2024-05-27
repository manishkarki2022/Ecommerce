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
                <style>
                    /* Set a fixed height for the carousel container */
                    #product-carousel {
                        max-height: 300px; /* Adjust this value to the desired height */
                        overflow: hidden; /* Ensure any overflow is hidden */
                    }

                    /* Ensure the images fit within the carousel container */
                    #product-carousel .carousel-item img {
                        max-height: 300px; /* Match this value with the carousel height */
                        object-fit: contain; /* Ensure images are scaled appropriately */
                    }
                </style>

                <div class="col-md-3 col-sm-4">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if($product->images)
                                @foreach($product->images as $key => $image)
                                    <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                        <img class="card-img-top img-fluid h-100" src="{{ asset('products/' . $image->image) }}" alt="{{ $image->litle }}" title="{{ $product->title }}">
                                    </div>
                                @endforeach
                                @else
                                <img class="card-img-top img-fluid" src="{{ asset('products/di.jpg') }}" alt="{{ $product->title }}" title="{{ $product->title }}">
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-9 col-sm-6">
                    <h3>{{$product->title}}</h3>
                        <div class="d-flex mb-3">
                            <div class="star-rating product mt-2" title="">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>

                                    <div class="front-stars" style="width: {{$avgRatingPer}}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <small class="pt-1">({{$product->ratings_count}} Reviews)</small>
                        </div>
                        By <a href="{{route('front.author.show',$product->author->slug)}}" class="text-primary">{{$product->author->name}}</a>
                        <div>
                            @if($product->isbn_number != null)
                                <p>ISBN Number: {{$product->isbn_number}}</p>
                            @endif
                            @if($product->publisher_name != null)
                                <p>Published By {{$product->publisher_name}} In {{$product->published_year}}</p>
                            @endif

                        </div>

                        {!! $product->short_description !!}

                    <div class="container py-2">
                        <div class="row g-4">
                            @if($product->book_type_id != null)
                                @if($product->book_type_id == 1 || $product->book_type_id == 3) <!-- Check if digital or both -->
                                @if($product->ebook_price != null)
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-primary">Ebook</h5>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="h5 me-2 fw-bold">Rs{{$product->ebook_price}}</span>
                                                    @if($product->ebook_compare_price !== '')
                                                        <span class="h6 text-muted text-decoration-line-through">Rs{{$product->ebook_compare_price}}</span>
                                                    @endif
                                                </div>
                                                <a class="btn btn-outline-primary mt-auto" href="javascript:void(0);" onclick="addToCart({{$product->id}}, 'ebook')">
                                                    <i class="fa fa-shopping-cart me-2"></i>Add To Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endif
                                @if($product->book_type_id == 2 || $product->book_type_id == 3) <!-- Check if paper or both -->
                                @if($product->price != null)
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-primary">Paperback</h5>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="h5 me-2 fw-bold">Rs{{$product->price}}</span>
                                                    @if($product->compare_price !== '')
                                                        <span class="h6 text-muted text-decoration-line-through">Rs{{$product->compare_price}}</span>
                                                    @endif
                                                </div>
                                                @if($product->track_qty == 'Yes')
                                                    @if($product->qty > 0)
                                                        <a class="btn btn-outline-primary mt-auto" href="javascript:void(0);" onclick="addToCart({{$product->id}}, 'paperback')">
                                                            <i class="fa fa-shopping-cart me-2"></i>Add To Cart
                                                        </a>
                                                    @else
                                                        <span class="btn btn-outline-danger mt-auto disabled">
                                            <i class="fas fa-exclamation-circle me-2"></i>Out Of Stock
                                        </span>
                                                    @endif
                                                @else
                                                    <a class="btn btn-outline-primary mt-auto" href="javascript:void(0);" onclick="addToCart({{$product->id}})">
                                                        <i class="fa fa-shopping-cart me-2"></i>Add To Cart
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endif
                            @endif
                        </div>
                    </div>



                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
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
                                <div class="col-md-8">
                                    <div class="row">
                                        <form action="{{route('front.productRating')}}" method="post">
                                            @csrf
                                            <input type="text" hidden name="product_id" value="{{$product->id}}">
                                            <h3 class="h4 pb-3">Write a Review</h3>
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{old('name')}}">
                                                @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{old('email')}}">
                                                @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="rating">Rating</label>
                                                <br>
                                                <div class="rating" style="width: 10rem">
                                                    <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                                </div>
                                                @error('rating')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="">How was your overall experience?</label>
                                                <textarea name="comment"  id="comment" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?">{{old('comment')}}</textarea>
                                                @error('comment')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <button class="btn btn-dark" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <div class="overall-rating mb-3">
                                        <div class="d-flex">
                                            <h1 class="h3 pe-3">{{$avgRating}}</h1>
                                            <div class="star-rating mt-2" title="">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <div class="front-stars" style="width: {{$avgRatingPer}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-2 ps-2">({{$product->ratings_count}} Reviews)</div>
                                        </div>

                                    </div>
                                    @if($product->ratings->isNotEmpty())
                                        @foreach($product->ratings as $rating)
                                            @php
                                                $ratingPer = ($rating->rating*100) / 5;
                                            @endphp
                                            <div class="rating-group mb-4">
                                                <span> <strong>{{$rating->username}} </strong></span>
                                                <div class="star-rating mt-2" title="">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{$ratingPer}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="my-3">
                                                    <p>{{$rating->comment}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No Review</p>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-3 section-8 ">
        <div class="container mb-5">
            <div class="section-title">
                <h3>Related Products</h3>
            </div>
            <div class="row slider3 d-flex">
                @php
                    $counter = 0;
                @endphp
                @if(!$relatedProducts==null)
                    @foreach($relatedProducts as $relatedProduct)
                        @if($counter < 4)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                                <div class="h-100 position-relative p-2 shadow-sm rounded-3 d-flex flex-column hover-effect">
                                    <!-- Wishlist Icon -->
                                    <div class="wishlist-icon position-absolute top-0 end-0 p-2">
                                        @if (getwishlist($product->id))
                                            <a href="javascript:void(0);" class="text-primary"><i class="fas fa-heart"></i></a>
                                        @else
                                            <a href="javascript:void(0);" onclick="addToWishList({{ $relatedProduct->id }})" class="text-muted"><i class="far fa-heart"></i></a>
                                        @endif
                                    </div>

                                    <!-- Product Image -->
                                    <div class="product-image flex-grow-1 d-flex align-items-center justify-content-center overflow-hidden rounded">
                                        <a href="{{ route('front.product', $relatedProduct->slug) }}" class="w-100 h-100 d-block hoverCard">
                                            <img class="card-img-top img-fluid h-100 w-100" src="{{ asset('products/' . $relatedProduct->images->first()->image) }}" alt="{{ $relatedProduct->title }}" style="object-fit: cover;">
                                        </a>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body mt-3 p-2 d-flex flex-column">
                                        <!-- Product Title -->
                                        <a class="h6 link mt-0 product-title text-dark text-decoration-none" href="{{ route('front.product', $relatedProduct->slug) }}" title="{{ $relatedProduct->title }}">
                                            <strong class="d-block text-truncate">{{ $relatedProduct->title }}</strong>
                                        </a>
                                        <!-- Product Author -->
                                        <p class="text-muted text-left mt-auto mb-0">By: {{ $relatedProduct->author->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                @else
                    <p class="error">No Related Product</p>
                @endif
            </div>

        </div>
    </section>
@endsection
@section('customJs')
@endsection

