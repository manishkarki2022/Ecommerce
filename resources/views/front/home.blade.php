@extends('front.layouts.app')
<style>

</style>
@section('content')
{{--    Highlight Section--}}
    @if($highlights->isNotEmpty())
    <section class="section-1 p-lg-5 p-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner rounded">
                @foreach($highlights as $index => $highlight)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <picture>
                            <source media="(max-width: 800px)" srcset="{{ asset('highlightImage/'.$highlight->image) }}" />
                            <source media="(min-width: 800px)" srcset="{{ asset('highlightImage/'.$highlight->image) }}" />
                            <img src="{{ asset($highlight->image) }}" alt="{{$highlight->name}}" />
                        </picture>
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-1">
                                <h4  class="display-5 text-white posterName "> {{ $highlight->name }}</h4>
                                <div style="padding-bottom: 0.5rem !important;" class="posterDescription">
                                    {!! $highlight->description !!}
                                </div>

                                <a class="btn btn-primary" href="{{ route('front.shop', $highlight->category->slug) }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    @endif
{{--    Category Section--}}
    @if(getCategories()->isNotEmpty())
    <section class="bg-white section-3  p-5 pt-3">
        <div class="container ">
            <div class="section-title">
                <h4>Book Categories</h4>
            </div>
            <div class="row pb-3">
                @if(getCategories()->isNotEmpty())
                    @foreach(getCategories() as $category)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                            <div class="cat-card">
                                <div class="left">
                                    @if($category->image =!'')
                                        <img src="{{asset('dBook.png')}}" alt="{{$category->name}}" class="hoverCard " style="max-width: 80px;padding: 0.3rem">
                                    @endif
                                </div>
                                <div class="right ">
                                    <div class="">
                                        <h5  ><a class="text-primary" href={{route('front.shop',$category->slug)}}  >{{$category->name}}</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    @endif
{{--    Featured Section--}}
    @if($getFeatured->isNotEmpty())
        <section class="bg-white section-3  p-5 pt-3">
            <div class="container">
                <div class="section-title">
                <h4>Featured Products</h4>
            </div>
            <div class="row pb-3 p-4 slider ">
                @foreach($getFeatured as $latestItem)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="card h-100 position-relative  p-3 shadow">
                            <!-- Wishlist Icon -->
                            <div class="wishlist-icon position-absolute top-0 end-0 border-red">
                                @if (getwishlist($latestItem->id))
                                    <a href="javascript:void(0);" class="text-success"><i class="fas fa-heart"></i></a>
                                @else
                                    <a href="javascript:void(0);" onclick="addToWishList({{ $latestItem->id }})" class="text-muted"><i class="far fa-heart"></i></a>
                                @endif
                            </div>

                            <!-- Product Image -->
                            <div class="product-image" style="height: 300px !important; overflow: hidden">
                                <a href="{{ route('front.product', $latestItem->slug) }}" class="product-img" title="{{ $latestItem->title }}">
                                    <img class="card-img-top img-fluid h-100 hoverCard" src="{{ asset('products/' . $latestItem->images->first()->image) }}" alt="{{ $latestItem->title }}">
                                </a>
                            </div>

                            <div class="card-body mt-2 p-1">
                                <!-- Product Title -->
                                <a class="h6 link mt-0" href="{{ route('front.product', $latestItem->slug) }}" title="{{ $latestItem->title }}">
                                    <strong>{{ strlen($latestItem->title) > 15 ? substr($latestItem->title, 0, 15) . ' ...' : $latestItem->title }}</strong>
                                </a>
                                <!-- Product Author -->
                                <p class="text-muted text-left">By: {{ $latestItem->author->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
{{--    Latest Section--}}
    @if($latest->isNotEmpty())
        <section class="bg-white section-3  p-5 pt-3">
        <div class="container">
            <div class="section-title">
                <h4>Latest Product</h4>
            </div>
            <div class="row pb-2 p-5 slider2">
                    @foreach($latest as $latestItem)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="card h-100 position-relative  p-3 shadow">
                                <!-- Wishlist Icon -->
                                <div class="wishlist-icon position-absolute top-0 end-0">
                                    @if (getwishlist($latestItem->id))
                                        <a href="javascript:void(0);" class="text-primary"><i class="fas fa-heart"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="addToWishList({{ $latestItem->id }})" class="text-muted"><i class="far fa-heart"></i></a>
                                    @endif
                                </div>

                                <!-- Product Image -->
                                <div class="product-image" style="height: 300px !important; overflow: hidden">
                                    <a href="{{ route('front.product', $latestItem->slug) }}" class="product-img" title="{{ $latestItem->title }}">
                                        <img class="card-img-top img-fluid h-100 hoverCard" src="{{ asset('products/' . $latestItem->images->first()->image) }}" alt="{{ $latestItem->title }}">
                                    </a>
                                </div>

                                <div class="card-body mt-2 p-1">
                                    <!-- Product Title -->
                                    <a class="h6 link mt-0" href="{{ route('front.product', $latestItem->slug) }}" title="{{ $latestItem->title }}">
                                        <strong>{{ strlen($latestItem->title) > 15 ? substr($latestItem->title, 0, 15) . ' ...' : $latestItem->title }}</strong>
                                    </a>
                                    <!-- Product Author -->
                                    <p class="text-muted text-left">By: {{ $latestItem->author->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </section>
    @endif
{{--List of Book as per there Cateogry--}}

@php
    $categories = getCategories();
    $hasProducts = $categories->pluck('products')->flatten()->isNotEmpty();
@endphp

@if($categories->isNotEmpty() && $hasProducts)
    <section class="bg-white section-3  p-5 pt-3">
        <div class="container">
            @foreach($categories as $category)
                @if($category->products->isNotEmpty())
                    <div class="section-title d-flex justify-content-between align-items-center">
                        <h4>{{ $category->name }}s</h4>
                        <a href="{{ route('front.shop', $category->slug) }}" class="text-primary">More &raquo;</a>
                    </div>
                    <div class="row pb-2 mb-5">
                        @foreach($category->products as $product)
                            @if($loop->iteration <= 4)
                                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3 ">
                                    <div class="card h-100 position-relative p-3 shadow">
                                        <!-- Wishlist Icon -->
                                        <div class="wishlist-icon position-absolute top-0 end-0">
                                            @if (getwishlist($product->id))
                                                <a href="javascript:void(0);" class="text-primary"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a href="javascript:void(0);" onclick="addToWishList({{ $product->id }})" class="text-muted"><i class="far fa-heart"></i></a>
                                            @endif
                                        </div>
                                        <!-- Product Image -->
                                        <div class="product-image hover " style="height: 300px !important; overflow: hidden">
                                            <a href="{{ route('front.product', $product->slug) }}" class="product-img" title="{{ $product->title }}">
                                                <img class="card-img-top img-fluid h-100 hoverCard" src="{{ asset('products/' . $product->images->first()->image) }}" alt="{{ $product->title }}">
                                            </a>
                                        </div>
                                        <div class="card-body mt-2 p-1">
                                            <!-- Product Title -->
                                            <a class="h6 link mt-0 mb-3" href="{{ route('front.product', $product->slug) }}" title="{{ $product->title }}">
                                                <strong>{{ strlen($product->title) > 25 ? substr($product->title, 0, 25) . ' ...' : $product->title }}</strong>
                                            </a>
                                            <!-- Product Author -->
                                            <p class="text-muted text-left mt-2">By: {{ $product->author->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @break
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endif






<section class=" section-3 pt-5 border-bottom">
    <div class="container">
        <div class="section-title d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Our Recent Blogs</h4>
            <a href="{{route('front.blog')}}" class="text-primary">View More &raquo;</a>
        </div>
        <div class="row pb-4 p-2">
            @if($blogs->isNotEmpty())
                @foreach($blogs as $blog)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-3">
                        <div class="card h-100 hoverCard p-2 shadow">
                            @if($blog->image)
                                <img src="{{ asset('blogs/' . $blog->image) }}" class="card-img-top rounded-2" alt="{{ $blog->name }}" style="height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $blog->name }}</h6>
                                <p class="card-text text-muted small">Posted on {{ $blog->created_at->format('M d, Y') }}</p>
                                <p class="card-text text-muted small">
                                    <i class="fas fa-thumbs-up"></i> {{ $blog->likes_count }} Likes
                                    <i class="fas fa-comments"></i> {{ $blog->comments->count() }} Comments
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('front.blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No blogs available.</p>
            @endif
        </div>
    </div>
</section>


{{--    Newsletter Section--}}
{{--    <section class="bg-white section-3 pt-5">--}}
{{--        <div class="bg-white container ">--}}
{{--            <div class="row pb-4 p-2">--}}
{{--                <div class="col-md-6 ">--}}
{{--                    <div class=" h-100 ">--}}
{{--                        <!-- Added h-100 to make the card full height -->--}}
{{--                        <div class="card-body text-left mt-3">--}}
{{--                            <h3 class="mb-3">Did you know us?</h3>--}}
{{--                            <p >We are about books and our purpose is to show you the book who can chage your life or distract you from the real world în a better one. BWorld works with the must popular publishs just for your delight.--}}
{{--                                If you are about books, you must to subscribe to our newsletter. </p>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6 col-sm-12 ">--}}
{{--                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.2544190099397!2d85.32404911098125!3d27.709429925300263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19091da0e19b%3A0xc4598923d9d99381!2sCity%20Centre!5e0!3m2!1sen!2snp!4v1710850120485!5m2!1sen!2snp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

@endsection
