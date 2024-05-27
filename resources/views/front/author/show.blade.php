@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.author')}}">Authors</a></li>
                    <li class="breadcrumb-item">{{ ucfirst($author->name) }}</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-7 pt-1 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-3 col-sm-6">
                    <div>
                        <div class="bg-light">
                            <div class="d-flex justify-content-center p-3">
                                <img class="img-fluid" src="{{ asset('authorImage/' . $author->id . '/' . $author->authorImage->first()->image) }}" alt="{{ $author->name }}" title="{{ $author->name }}" style="max-width: 150px; max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 p-3">
                    <div class="bg-light " style="text-justify: newspaper">
                        <h3>{{$author->name}}</h3>

                        {!! $author->description  !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 section-8 bg-white">
        <div class="container mb-5">
            @if(!$author->products==null && $author->products->isNotEmpty())
                <div class="section-title bg-white">
                    <h5>Books my {{$author->name}}</h5>
                </div>
            <div class="row slider3 d-flex">
                @php
                    $counter = 0;
                @endphp

                    @foreach($author->products as $relatedProduct)
                        @if($counter < 4)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                            <div class="h-100 position-relative p-2 shadow-sm rounded-3 d-flex flex-column hover-effect">
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

