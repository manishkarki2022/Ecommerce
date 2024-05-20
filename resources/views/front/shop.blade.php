@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-6 pt-5">
        <div class="container px-5 ">
            <div class="row">
                <div class="col-md-7 col-sm-8">
                </div>
                <div class="col-md-5 col-sm-4">
                    <div class="text-md-end">
                        <a href="{{ route('front.shop') }}" class="btn btn-primary mt-2">Clear Filter</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h3>Categories</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">

                                @if($categories->isNotEmpty())
                                    @foreach($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if($category->subCategories->isNotEmpty())
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{$key}}" aria-expanded="false" aria-controls="collapseOne-{{$key}}">
                                                    {{$category->name}}
                                                </button>
                                            </h2>
                                            @else
                                                <a href="{{route('front.shop',$category->slug)}}" class="nav-item nav-link {{($categorySelected == $category->id) ?'text-primary':''}}">{{$category->name}}</a>
                                            @endif
                                            @if($category->subCategories->isNotEmpty())
                                            <div id="collapseOne-{{$key}}" class="accordion-collapse collapse{{($categorySelected == $category->id) ?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
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


                    <div class="sub-title mt-5">
                        <h3>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
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
                                <div class="col-lg-4 col-xl-3 mb-4 px-5">
                                    <div class="card items-center hoverCard" style="width: 200px; height:350px">
                                        <div class="product product-image position-relative" style="height:auto; overflow: hidden;">
                                            @if($product->images !== null && $product->images->isNotEmpty() && $product->images->first() !== null)
                                                <a href="{{ route('front.product', $product->slug) }}" class="product-img d-block">
                                                    <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/' . $product->images->first()->image) }}" alt="{{ $product->title }}">
                                                </a>
                                            @else
                                                <a href="{{ route('front.product', $product->slug) }}" class="product-img d-block">
                                                    <img class="card-img-top img-fluid h-100 w-100 object-fit-cover zoom-on-hover" src="{{ asset('products/di.jpg') }}" alt="{{ $product->title }}">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="card-body p-1">
                                            <a class="h6 link mt-0 mb-1" href="{{route('front.product',$product->slug)}}" alt="{{$product->title}}" title="{{$product->title}}">
                                                {{ strlen($product->title) > 20 ? substr($product->title, 0, 20) . ' ...' : $product->title }}
                                            </a>
                                            @if($product->author_id)
                                                <p class="text-muted text-left mb-0">By: {{$product->author->name}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="alert  text-center text-danger" role="alert">
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
                max: 500,
                from: {{request()->price_min ?? 0}},
                step: 5,
                to: {{request()->price_max ?? 500}},
                skin: "round",
                max_postfix: "+",
                prefix: "$",
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

        </script>
    @endsection

