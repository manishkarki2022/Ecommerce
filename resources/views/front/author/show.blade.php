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
    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-3 col-sm-6">
                    <div   >
                        <div class="bg-light">
                                    <div class="">
                                        <img class="card-img-top img-fluid h-100" src="{{ asset('authorImage/' . $author->id . '/' . $author->authorImage->first()->image) }}" alt="{{ $author->name }}" title="{{ $author->name }}">
                                    </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{$author->name}}</h1>

                        {!! $author->description !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 section-8 bg-white">
        <div class="container mb-5">
            <div class="section-title bg-white">
                <h2>Related Products</h2>
            </div>
            <div class="row slider3 d-flex">
                @php
                    $counter = 0;
                @endphp
                @if(!$relatedProducts==null)
                    @foreach($relatedProducts as $relatedProduct)
                        @if($counter < 4)
                            <div class="col-lg-4 col-xl-3 mb-4 px-5">
                                <div class="card items-center" style="width: 230px;">
                                    <div class="product product-image position-relative" style="height:auto; overflow: hidden;">
                                        @if($relatedProduct->images !== null && $relatedProduct->images->isNotEmpty() && $relatedProduct->images->first() !== null)
                                            <a href="{{ route('front.product', $relatedProduct->slug) }}" class="product-img d-block">
                                                <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/' . $relatedProduct->images->first()->image) }}" alt="{{ $relatedProduct->title }}">
                                            </a>
                                        @else
                                            <a href="{{ route('front.product', $relatedProduct->slug) }}" class="product-img d-block">
                                                <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/di.jpg') }}" alt="{{ $relatedProduct->title }}">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="card-body p-1">
                                        <a class="h6 link mt-0 mb-1" href="{{route('front.product',$relatedProduct->slug)}}" alt="{{$relatedProduct->title}}" title="{{$relatedProduct->title}}">
                                            {{ strlen($relatedProduct->title) > 20 ? substr($relatedProduct->title, 0, 20) . ' ...' : $relatedProduct->title }}
                                        </a>
                                        @if($relatedProduct->author_id)
                                            <p class="text-muted text-left mb-0">By: {{$relatedProduct->author->name}}</p>
                                        @endif
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

