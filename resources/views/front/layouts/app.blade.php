<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{{--    <title>{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Home' }}</title>--}}
    {!! SEO::generate() !!}
    <base href="{{route('front.home')}}" />


    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick-theme.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/ion.rangeSlider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/custom.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Fav Icon -->
    <link rel="icon" type="image/png" href="{{ websiteInfo()->isNotEmpty() && websiteInfo()->first()->logo ? asset('logo/' . websiteInfo()->first()->logo) : asset('logo/d_logo.png') }}">
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body data-instant-intensity="mousedown" class="bg-white">

<div class="bg-light top-header">
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="{{ route('front.home') }}" class="text-decoration-none">
                    <img src="{{ websiteInfo()->isNotEmpty() && websiteInfo()->first()->logo ? asset('logo/' . websiteInfo()->first()->logo) : asset('logo/d_logo.png') }}" alt="{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Website Name' }}" class="img-fluid rounded-circle" style="max-width:70px;">
                    <span class="h3 text-uppercase text-primary bg-dark px-2">{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Website Name' }}</span>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                @if(\Illuminate\Support\Facades\Auth::check())
                <a href="{{route('account.profile')}}" class="nav-link text-dark">My Account</a>
                @else
                    <a href="{{route('account.login')}}" class="nav-link text-dark">Login/Register</a>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    .tns-outer {
        position: relative;
    }
    button[data-action="stop"] {
        display: none;
    }
    button[data-action="start"] {
        display: none;
    }

    [data-controls] {
        border: 0;
        padding: 0;
        font-size: 30px;
        position: absolute;
        top: 40%;
        margin-top: -18px;
        z-index: 1;
        background: transparent;
    }
    [data-controls="prev"] {
        left: 1px;
    }
    [data-controls="next"] {
        right: 0px;
    }

</style>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="{{ route('front.home') }}" class="text-decoration-none mobile-logo">
                <img src="{{ websiteInfo()->isNotEmpty() && websiteInfo()->first()->logo ? asset('logo/' . websiteInfo()->first()->logo) : asset('logo/d_logo.png') }}" alt="{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Website Name' }}" class="img-circle  rounded-circle" style="max-width:45px;">
                <span class="h4 text-uppercase text-primary bg-dark">{{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Website Name' }}</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-around" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mr-lg-0" style="margin: 0 !important;" >
                    <li class="nav-item">
                        <a href="{{ route('front.shop') }}" class="nav-link text-primary">All Book</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('front.shop',['ebook'=>true]) }}" class="nav-link text-primary">Ebook</a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ route('front.author') }}" class="nav-link text-primary">Authors</a>
                    </li>
                <!-- Navigation Links -->
                    <!-- Categories -->
                    @if(getCategories()->isNotEmpty())
                        @foreach(getCategories() as $category)
                            <li class="nav-item dropdown">
                                @if($category->subCategories->isNotEmpty())
                                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{$category->name}}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        @foreach($category->subCategories as $sub_category)
                                            <li><a class="dropdown-item nav-link" href="{{route('front.shop',[$category->slug,$sub_category->slug])}}">{{$sub_category->name}}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a class="btn btn-dark" href="{{ route('front.shop', $category->slug) }}">
                                        {{$category->name}}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif

                </ul>
                <!-- Search Form -->
                <form action="{{ route('front.shop') }}" method="get">
                    <div class="input-group">
                        <input type="text" placeholder="Enter keyword Author, title or ISBN" class="form-control" aria-label="Amount (to the nearest dollar)" name="search">
                        <button type="submit" class="input-group-text">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="right-nav py-0 ml-lg-4">
                <a href="{{ route('front.cart') }}" class="nav-link text-white">
            <span class="position-relative">
                <i class="fas fa-shopping-cart text-primary"></i>
                @if(Cart::count() > 0)
                    <span class="badge text-danger position-absolute top-0 start-100 translate-middle">{{ Cart::count() }}</span>
                @endif
            </span>
                </a>
            </div>
        </nav>
    </div>
</header>

<main>
@yield('content')



</main>
<footer class="text-primay mt-5">
    <div class="container pb-5 pt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Get In Touch</h3>
                    <p>
                        {{ websiteInfo()->isNotEmpty() ? websiteInfo()->first()->quote : 'Company Quote' }}
                        <br>
                        <i class="fas fa-map-marker-alt"></i>
                        {{ websiteInfo()->isNotEmpty() ? websiteInfo()->first()->address : 'Company Address' }}
                        <br>
                        <i class="fas fa-envelope"></i>
                        {{ websiteInfo()->isNotEmpty() ? websiteInfo()->first()->email : 'Company Email' }}
                        <br>
                        <i class="fas fa-phone"></i>
                        {{ websiteInfo()->isNotEmpty() ? websiteInfo()->first()->phone : 'Company Phone' }}
                    </p>

                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mt-3">
                        <p class="text-white me-3 d-lg-none">Follow us:</p>
                        <ul class="list-unstyled d-flex mb-0">
                            @foreach(['facebook', 'instagram', 'twitter', 'youtube', 'linkedin'] as $social)
                                @php $socialLink = websiteInfo()->isNotEmpty() ? websiteInfo()->first()->$social : null; @endphp
                                @if(!empty($socialLink))
                                    <li class="me-2">
                                        <a href="https:{{ $socialLink }}" class=" text-decoration-none" target="_blank" aria-label="{{ ucfirst($social) }}" title="Follow us {{$social}}">
                                            <i class="fab fa-{{ $social }} fa-lg"></i>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    @php
                        $pages = getPages();
                    @endphp
                    @if($pages->isNotEmpty())
                        <ul>
                            @foreach($pages as $page)
                                <li><a href="{{ route('front.page', $page->slug) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="{{ route('account.login') }}" title="Sell"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="{{ route('account.register') }}" title="Advertise"><i class="fas fa-user-plus"></i> Register</a></li>
                        <li><a href="{{ route('account.orders') }}" title="Contact Us"><i class="fas fa-shopping-cart"></i> My Orders</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p>© All copyrights are reserved. {{ websiteInfo()->isNotEmpty() ? ucfirst(websiteInfo()->first()->name) : 'Company Name' }} 2024. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
<script src="{{asset('front-assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('front-assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('front-assets/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{asset('front-assets/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{asset('front-assets/js/slick.min.js')}}"></script>
<script src="{{asset('front-assets/js/custom.js')}}"></script>
<script src="{{asset('front-assets/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
    window.onscroll = function() {myFunction()};

    var navbar = document.getElementById("navbar");
    var sticky = navbar.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var slider;

        // Function to initialize the slider with appropriate number of items
        function initSlider() {
            var viewportWidth = window.innerWidth;

            // Adjust the number of items based on viewport width
            var itemsToShow = 5; // Default number of items
            if (viewportWidth < 1200) {
                itemsToShow = 3; // Decrease number of items for smaller screens
            }
            if (viewportWidth < 992) {
                itemsToShow = 2; // Further decrease for even smaller screens
            }
            if (viewportWidth < 768) {
                itemsToShow = 1; // Only 1 item for very small screens
            }

            // Initialize Tiny Slider with updated configuration
            if (slider) {
                slider.destroy(); // Destroy existing slider instance if it exists
            }
            slider = tns({
                container: '.slider',
                slideBy: 'page',
                autoplay: true,
                controlsText: ['<span class="fas fa-chevron-circle-left"></span>', '<span class="fas fa-chevron-circle-right"></span>'],

                loop: true,
                items: itemsToShow, // Use the calculated number of items
                nav: false
            });
        }

        // Initialize slider on page load
        initSlider();

        // Reinitialize slider on window resize to adjust to screen size changes
        window.addEventListener('resize', function () {
            initSlider();
        });
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        var slider;

        // Function to initialize the slider with appropriate number of items
        function initSlider() {
            var viewportWidth = window.innerWidth;

            // Adjust the number of items based on viewport width
            var itemsToShow = 5; // Default number of items
            if (viewportWidth < 1200) {
                itemsToShow = 3; // Decrease number of items for smaller screens
            }
            if (viewportWidth < 992) {
                itemsToShow = 2; // Further decrease for even smaller screens
            }
            if (viewportWidth < 768) {
                itemsToShow = 1; // Only 1 item for very small screens
            }

            // Initialize Tiny Slider with updated configuration
            if (slider) {
                slider.destroy(); // Destroy existing slider instance if it exists
            }
            slider = tns({
                container: '.slider2',
                items: 6,
                slideBy: 'page',
                autoplay: true,
                controlsText: ['<span class="fas fa-chevron-circle-left"></span>', '<span class="fas fa-chevron-circle-right"></span>'],
                loop: true,
                items: itemsToShow, // Use the calculated number of items
                nav: false
            });
        }

        // Initialize slider on page load
        initSlider();

        // Reinitialize slider on window resize to adjust to screen size changes
        window.addEventListener('resize', function () {
            initSlider();
        });
    });
    function addToCart(id,type){
        $.ajax({
            url: "{{ route('front.addToCart') }}",
            type: "post",
            data: {id: id, type: type},
            dataType: "json",
            success: function (response) {
                if(response.status == true){
                  toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                }
            }
        });
    }
    $(document).ready(function() {
        // Check for flashed session message and show Toast notification
        @if(session()->has('success'))
        toastr.success('{{ session('success') }}');
        @elseif(session()->has('error'))
        toastr.error('{{ session('error') }}');
        @endif
    });
    function addToWishList(id){
        $.ajax({
            url: "{{ route('front.addWishlist') }}",
            type: "post",
            data: {id: id},
            dataType: "json",
            success: function (response) {
                if(response.status == true){
                    toastr.success(response.message);
                }else if(response.status == 'error') {
                    toastr.error(response.message);
                }
                else{
                    toastr.error(response.message);
                   window.location.href = "{{route('account.login')}}";
                }
            }
        });
    }



</script>


@yield('customJs')
</body>
</html>

