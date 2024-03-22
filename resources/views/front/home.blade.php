@extends('front.layouts.app')
@section('content')
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('cp.png') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('cp.png') }}" />
                        <div class="cover-image">
                            <img src="{{ asset('cp.jpg') }}" alt="" />
                        </div>
                    </picture>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-2 my-3">
                            <h1 class="display-4 text-white mb-2">Discover Captivating Reads at Our Bookstore</h1>
                            <p class="mx-md-5 px-3 fs-md-4 fs-lg-3"><strong>Welcome to our bookstore, where every page holds a new adventure.</strong></p>
                            <a class="btn btn-outline-light py-1 px-3 mt-2" href="{{route('front.shop')}}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('cp2.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('cp2.jpg')}}" />
                        <img src="{{asset('cp2.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-1 my-3">
                            <h1 class="display-4 text-white mb-2">Unveil Worlds of Wonder</h1>
                            <p class="mx-md-5 px-3 fs-md-4 fs-lg-3"><strong>Step into a realm where imagination knows no bounds. Our bookstore is a sanctuary for bibliophiles.</strong></p>
                            <a class="btn btn-outline-light py-1 px-3 mt-2" href="{{route('front.shop')}}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('cp3.png')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('cp3.png')}}" />
                        <img src="{{asset('cp3.png')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-2 my-3">
                            <h1 class="display-4 text-white mb-2">Journey Through Time and Space</h1>
                            <p class="mx-md-5 px-3 fs-md-4 fs-lg-3"><strong>Embark on an odyssey through the ages and beyond as you traverse the pages of our bookstore.</strong></p>
                            <a class="btn btn-outline-light py-1 px-3 mt-1" href="{{route('front.shop')}}">Shop Now</a>
                        </div>
                    </div>
                </div>
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
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container p-5">
            <div class="section-title">
                <h2>Book Categories</h2>
            </div>
            <div class="row pb-3">
                @if(getCategories()->isNotEmpty())
                    @foreach(getCategories() as $category)
                        <div class="col-lg-3">
                            <div class="cat-card">
                                <div class="left">
                                    @if($category->image =!'')
                                        <img src="{{asset('dBook.png')}}" alt="" class="img-fluid">
                                    @endif

                                </div>
                                <div class="right">
                                    <div class="cat-data">
                                        <h2>{{$category->name}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="section-4 pt-5">
        <div class="container p-5">
            <div class="section-title">
                <h2>Featured Products</h2>
            </div>
            <div class="row pb-3 slider ">
                @if($getFeatured->isNotEmpty())
                    @foreach($getFeatured as $featuredItem)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-card">
                                <div class="product-image position-relative" style="height: 300px !important; overflow: hidden">
                                    @if($featuredItem->images !== null && $featuredItem->images->isNotEmpty() && $featuredItem->images->first() !== null)
                                        <a href="{{route('front.product',$featuredItem->slug)}}" class="product-img ">
                                            <img class="card-img-top img-fluid h-100" src="{{ asset('products/' . $featuredItem->images->first()->image) }}" alt="{{$featuredItem->litle}}">
                                        </a>
                                    @else
                                        <a href="{{route('front.product',$featuredItem->slug)}}" class="product-img " alt="{{$featuredItem->litle}}">
                                                    <img class="card-img-top img-fluid" src="{{ asset('products/di.jpg') }}" alt="{{$featuredItem->litle}}">
                                        </a>
                                    @endif

                                </div>
                                <div class="card-body mt-2 p-1">
                                    <a class="h4 link mt-0" href="product.php" title="{{$featuredItem->title}}">{{ strlen($featuredItem->title) > 15 ? substr($featuredItem->title, 0, 15) . ' ...' : $featuredItem->title }}</a>
                                    <p class="text-muted text-left">Ram Bahadur</p>
                                    <div class="d-flex justify-content-between px-1">
                                        <div>
                                            <span class="h5 me-2"><strong>${{$featuredItem->price}}</strong></span>
                                            @if($featuredItem->compare_price !== '')
                                                <span class="h6 text-underline"><del>${{$featuredItem->compare_price}}</del></span>
                                            @endif
                                        </div>
                                        <a class="" href="#"><i class="far fa-heart text-primary"></i></a>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-dark w-100" style="background-color: #937dc2 !important; border: none !important" href="javascript:void(0);" onclick="addToCart({{$featuredItem->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="section-4 pt-5">
        <div class="container p-5">
            <div class="section-title">
                <h2>Latest Product</h2>
            </div>
            <div class="row pb-3 slider2">
                @if($latest->isNotEmpty())
                    @foreach($latest as $latestItem)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-card">
                                <div class="product-image position-relative" style="height: 300px !important; overflow: hidden">
                                    @if($latestItem->images !== null && $latestItem->images->isNotEmpty() && $latestItem->images->first() !== null)
                                        <a href="{{route('front.product',$latestItem->slug)}}" class="product-img " title="{{$latestItem->title}}">
                                            <img class="card-img-top img-fluid h-100" src="{{ asset('products/' . $latestItem->images->first()->image) }}" alt="">
                                        </a>
                                            @else
                                                <a href="{{route('front.product',$latestItem->slug)}}" class="product-img " title="{{$latestItem->title}}">
                                                    <img class="card-img-top img-fluid" src="{{ asset('products/di.jpg') }}" alt="">
                                                </a>
                                    @endif

                                </div>
                                <div class="card-body mt-2 p-1">
                                    <a class="h4 link mt-0" href="product.php" title="{{$latestItem->title}}">{{ strlen($latestItem->title) > 15 ? substr($latestItem->title, 0, 15) . ' ...' : $latestItem->title }}</a>
                                    <p class="text-muted text-left">Ram Bahadur</p>
                                    <div class="d-flex justify-content-between px-1">
                                        <div>
                                            <span class="h5 me-2"><strong>${{$latestItem->price}}</strong></span>
                                            @if($latestItem->compare_price !== '')
                                                <span class="h6 text-underline"><del>${{$latestItem->compare_price}}</del></span>
                                            @endif
                                        </div>
                                        <a class="" href="#"><i class="far fa-heart text-primary"></i></a>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-dark w-100" style="background-color: #937dc2 !important; border: none !important" href="javascript:void(0);" onclick="addToCart({{$latestItem->id}})">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="bg-white section-4 pt-5">
        <div class="bg-white container ">
            <div class="row pb-4 p-5">
                <div class="col-md-6 ">
                    <div class=" h-100 ">
                        <!-- Added h-100 to make the card full height -->
                        <div class="card-body text-left mt-3">
                            <h3 class="mb-3">Did you know us?</h3>
                            <p >We are about books and our purpose is to show you the book who can chage your life or distract you from the real world în a better one. BWorld works with the must popular publishs just for your delight.
                                If you are about books, you must to subscribe to our newsletter. </p>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-sm-12 ">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.2544190099397!2d85.32404911098125!3d27.709429925300263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19091da0e19b%3A0xc4598923d9d99381!2sCity%20Centre!5e0!3m2!1sen!2snp!4v1710850120485!5m2!1sen!2snp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

            </div>
        </div>
    </section>

@endsection
