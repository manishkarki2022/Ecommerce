@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text authorname" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active authorname">Shop</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-6">
        <div class="container px-2">
            <div class="row">
                <!-- Sidebar for large screens -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sub-title">
                        <h4 class="main-header">Categories</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if($categories->isNotEmpty())
                                    @foreach($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if($category->subCategories->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed b-secondary" type="button " data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne-{{$key}}">
                                                        {{$category->name}}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{route('front.shop',$category->slug)}}" class="nav-item nav-link b-secondary authorname {{($categorySelected == $category->id) ?'text-primary':''}}">{{$category->name}}</a>
                                            @endif
                                            @if($category->subCategories->isNotEmpty())
                                                <div id="collapseOne-{{$key}}" class="accordion-collapse collapse{{($categorySelected == $category->id) ?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach($category->subCategories as $subCategory)
                                                                <a href="{{route('front.shop', [$category->slug, $subCategory->slug])}}" class="nav-item nav-link b-secondary authorname {{($subCategorySelected == $subCategory->id) ?'text-primary':''}}">{{$subCategory->name}}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-2">
                        <h4 class="main-header">Price</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider text-success authorname" name="my_range" value="" />
                        </div>
                    </div>
                </div>

                <!-- Sidebar for mobile screens -->
                <div class="col-md-9">
                    <div class="d-block d-md-none text-start">
                        <button class="btn btn-primary" id="mobile-filter-toggle">
                            <i class="fas fa-filter"></i> Filters
                        </button>
                    </div>
                    <div id="mobile-filter-sidebar" class="d-none">
                        <div class="sub-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExampleMobile">
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $key => $category)
                                            <div class="accordion-item">
                                                @if($category->subCategories->isNotEmpty())
                                                    <h2 class="accordion-header" id="headingOneMobile">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneMobile-{{$key}}" aria-expanded="false" aria-controls="collapseOneMobile-{{$key}}">
                                                            {{$category->name}}
                                                        </button>
                                                    </h2>
                                                @else
                                                    <a href="{{route('front.shop',$category->slug)}}" class="nav-item nav-link  b-secondary authorname {{($categorySelected == $category->id) ?'text-primary':''}}">{{$category->name}}</a>
                                                @endif
                                                @if($category->subCategories->isNotEmpty())
                                                    <div id="collapseOneMobile-{{$key}}" class="accordion-collapse collapse{{($categorySelected == $category->id) ?'show':''}}" aria-labelledby="headingOneMobile" data-bs-parent="#accordionExampleMobile" style="">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                @foreach($category->subCategories as $subCategory)
                                                                    <a href="{{route('front.shop', [$category->slug, $subCategory->slug])}}" class="nav-item nav-link {{($subCategorySelected == $subCategory->id) ?'text-primary':''}}">{{$subCategory->name}}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-2">
                            <h4 class="main-header">Price</h4>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="js-price-slider text-success authorname" name="my_range" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="row pb-3">
                        @php
                            $filtersApplied = request()->has('price_min') || request()->has('price_max') || request()->has('sort') || request()->segment(2);
                        @endphp

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                @if($filtersApplied)
                                    <a href="{{ route('front.shop') }}" class="btn btn-primary mt-1">
                                        Clear Filter  <i class="fas fa-times-circle"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="d-flex align-items-center">
                                <select name="sort" id="sort" class="form-select">
                                    <option value="latest" {{ ($sortOption == 'latest') ? 'selected' : '' }}>
                                        Latest <i class="fas fa-clock"></i>
                                    </option>
                                    <option value="price_desc" {{ ($sortOption == 'price_desc') ? 'selected' : '' }}>
                                        Price High <i class="fas fa-sort-amount-down"></i>
                                    </option>
                                    <option value="price_asc" {{ ($sortOption == 'price_asc') ? 'selected' : '' }}>
                                        Price Low <i class="fas fa-sort-amount-up"></i>
                                    </option>
                                </select>
                            </div>
                        </div>
                        @if($products->isNotEmpty())
                            @foreach($products as $latestItem)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4">
                                    <div class="card h-100">
                                        <!-- Product Image -->
                                        <div class="position-relative">
                                            <a href="{{ route('front.product', $latestItem->slug) }}" class="d-block">
                                                <img class="card-img-top img-fluid pt-0" src="{{ asset('products/' . $latestItem->images->first()->image) }}" alt="{{ $latestItem->title }}">
                                            </a>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body text-left d-flex flex-column p-1">
                                            <!-- Product Title -->
                                            <a class="h6 text-dark product-title p-0 m-0" href="{{ route('front.product', $latestItem->slug) }}" title="{{ $latestItem->title }}">
                                                <strong class="bookname">{{ $latestItem->title }}</strong>
                                            </a>
                                            <!-- Product Author -->
                                            <span class="text-muted small p-0 m-0">{{ $latestItem->author->name }}</span>

                                            <!-- Product Price and Wishlist Icon -->
                                            <!-- Add to Cart or Out of Stock Button -->
                                            @if($latestItem->book_type_id != null)
                                                @if($latestItem->book_type_id == 1 || $latestItem->book_type_id == 3) <!-- Check if digital or both -->
                                                @if($latestItem->ebook_price != null)
                                                    <p class="text-muted small p-0 m-0">Ebook</p>
                                                    <div class="d-flex justify-content-between align-items-center p-0 m-0">
                                                        <strong>Rs{{ $latestItem->ebook_price }}</strong>
                                                        <div class="ms-2">
                                                            @if (getwishlist($latestItem->id))
                                                                <a href="javascript:void(0);" class="text-success wishlist-btn" data-id="{{ $latestItem->id }}">
                                                                    <i class="fas fa-heart b-secondary"></i>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);" class="text-muted wishlist-btn" data-id="{{ $latestItem->id }}">
                                                                    <i class="far fa-heart b-secondary"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-outline-primary w-100 mb-0" href="javascript:void(0);" onclick="addToCart({{ $latestItem->id }}, 'ebook')">
                                                        <i class="fa fa-shopping-cart me-2"></i>Add To Cart
                                                    </a>
                                                @endif
                                                @endif

                                                @if($latestItem->book_type_id == 2 || $latestItem->book_type_id == 3) <!-- Check if paper or both -->
                                                @if($latestItem->price != null)
                                                    <p class="text-muted small p-0 m-0">Paperback</p>
                                                    <div class="d-flex justify-content-between align-items-center p-0 m-0">
                                                        <strong>Rs{{ $latestItem->price }}</strong>
                                                        <div class="ms-2">
                                                            @if (getwishlist($latestItem->id))
                                                                <a href="javascript:void(0);" class="text-success wishlist-btn" data-id="{{ $latestItem->id }}">
                                                                    <i class="fas fa-heart b-secondary"></i>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);" class="text-muted wishlist-btn" data-id="{{ $latestItem->id }}">
                                                                    <i class="far fa-heart b-secondary"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($latestItem->track_qty == 'Yes')
                                                        @if($latestItem->qty > 0)
                                                            <button class="btn btn-primary w-100 mb-0" onclick="addToCart({{ $latestItem->id }}, 'paperback')">
                                                                <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                                            </button>
                                                        @else
                                                            <span class="btn btn-outline-danger w-100 mb-0 disabled">
                                <i class="fas fa-exclamation-circle me-2"></i>Out Of Stock
                            </span>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-primary w-100 mb-0" onclick="addToCart({{ $latestItem->id }}, 'paperback')">
                                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                                        </button>
                                                    @endif
                                                @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="alert text-center text-danger" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> No products found!
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{$products->withQueryString()->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        // Initialize Ion.RangeSlider
        var rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 2000,
            from: {{request()->price_min ?? 0}},
            step: 5,
            to: {{request()->price_max ?? 2000}},
            skin: "round",
            max_postfix: "+",
            prefix: "Rs",
            onFinish: function (data) {
                apply_filters(data);
            }
        });
        // Initialize Ion.RangeSlider
        var rangeSlider = $(".js-price-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 2000,
            from: {{request()->price_min ?? 0}},
            step: 5,
            to: {{request()->price_max ?? 2000}},
            skin: "round",
            max_postfix: "+",
            prefix: "Rs",
            onFinish: function (data) {
                apply_filters(data);
            }
        })

        // Saving its instance to var
        var slider = $(".js-range-slider").data("ionRangeSlider");
        // Saving its instance to var
        var sliders = $(".js-price-slider").data("ionRangeSlider");

        $('#sort').on('change', function () {
            apply_filters()
        });

        function apply_filters() {
            var url = '{{ url()->current() }}?';
            // Price range filter
            if (slider.result.from !== slider.result.min || slider.result.to !== slider.result.max) {
                url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;
            }
            // Price range filter
            if (sliders.result.from !== sliders.result.min || sliders.result.to !== sliders.result.max) {
                url += '&price_min=' + sliders.result.from + '&price_max=' + sliders.result.to;
            }
            // Sorting filter
            var selectedSortOption = $('#sort').val();
            if (selectedSortOption !== '') {
                url += '&sort=' + selectedSortOption;
            }
            // Redirect to the filtered URL
            window.location.href = url;
        }

        // Show mobile filter sidebar only on mobile devices
        $(document).ready(function() {
            if ($(window).width() < 768) {
                var filtersApplied = {{ $filtersApplied ? 'true' : 'false' }};
                if (filtersApplied) {
                    $('#mobile-filter-sidebar').removeClass('d-none');
                }
            }
        });

        // Mobile filter toggle
        $('#mobile-filter-toggle').on('click', function() {
            $('#mobile-filter-sidebar').toggleClass('d-none');
        });
    </script>
@endsection
