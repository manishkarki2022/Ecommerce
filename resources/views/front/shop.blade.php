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
                            <h4>Price</h4>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="js-range-slider text-success authorname" name="my_range" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="row pb-3">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="text-start">
                                    <a href="{{ route('front.shop') }}" class="btn btn-primary mt-1">
                                        Clear Filter  <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-end">
                                    <label for="sort"></label>
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ ($sortOption == 'latest') ? 'selected' : '' }}>Latest</option>
                                        <option value="price_desc" {{ ($sortOption == 'price_desc') ? 'selected' : '' }}>Price High</option>
                                        <option value="price_asc" {{ ($sortOption == 'price_asc') ? 'selected' : '' }}>Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-4">
                                    <div class="h-100 position-relative p-1 shadow-sm rounded-3 d-flex flex-column hover-effect">
                                        <!-- Product Image -->
                                        <div class="product-images flex-grow-1 d-flex align-items-center justify-content-center overflow-hidden rounded">
                                            <a href="{{ route('front.product', $product->slug) }}" class="w-100 h-100 d-block hoverCardphp">
                                                <img class="card-img-top img-fluid h-100 w-100 hoverCard" src="{{ asset('products/' . $product->images->first()->image) }}" alt="{{ $product->title }}" style="object-fit: cover;">
                                            </a>
                                        </div>
                                        <!-- Wishlist Icon -->
                                        <div class="wishlist-icon position-absolute top-0  p-2">
                                            @if (getwishlist($product->id))
                                                <a href="javascript:void(0);" class="text-primary"> <i class="fas fa-heart b-secondary"></i></a>
                                            @else
                                                <a href="javascript:void(0);" onclick="addToWishList({{ $product->id }})" class="text-muted"><i class="far fa-heart b-secondary authorname"></i></a>
                                            @endif
                                        </div>


                                        <!-- Card Body -->
                                        <div class="card-body  p-1 d-flex flex-column text-center">
                                            <!-- Product Title -->
                                            <a class="h6 link mt-0 product-title text-dark text-decoration-none" href="{{ route('front.product', $product->slug) }}" title="{{ $product->title }}">
                                                <strong class="d-block text-truncate bookname">{{ $product->title }}</strong>
                                            </a>
                                            <!-- Product Author -->
                                            <p class="card-text text-muted small authorname">{{ $product->author->name }}</p>
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

        // Saving its instance to var
        var slider = $(".js-range-slider").data("ionRangeSlider");

        $('#sort').on('change', function () {
            apply_filters()
        });

        function apply_filters() {
            var url = '{{ url()->current() }}?';
            // Price range filter
            if (slider.result.from !== slider.result.min || slider.result.to !== slider.result.max) {
                url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;
            }
            // Sorting filter
            var selectedSortOption = $('#sort').val();
            if (selectedSortOption !== '') {
                url += '&sort=' + selectedSortOption;
            }
            // Redirect to the filtered URL
            window.location.href = url;
        }

        // Mobile filter toggle
        $('#mobile-filter-toggle').on('click', function() {
            $('#mobile-filter-sidebar').toggleClass('d-none');
        });
    </script>
@endsection
