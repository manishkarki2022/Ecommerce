<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Books Shop</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />


    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick-theme.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/ion.rangeSlider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/toastr/toastr.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body data-instant-intensity="mousedown" class="bg-white">

<div class="bg-light top-header">
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="{{route('front.home')}}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">INDIGO</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">BOOK</span>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                <a href="account.php" class="nav-link text-dark">My Account</a>
                <form action="">
                    <div class="input-group">
                        <input type="text" placeholder="Search For Products" class="form-control" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text">
							<i class="fa fa-search"></i>
					  	</span>
                    </div>
                </form>
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
        right: 1px;
    }

</style>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="index.php" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                <span class="h2 text-uppercase text-white px-2">SHOP</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                <i class="navbar-toggler-icon fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
                    </li> -->
                    @if(getCategories()->isNotEmpty())
                        @foreach(getCategories() as $category)
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$category->name}}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    @if($category->subCategories->isNotEmpty())
                                        @foreach($category->subCategories as $sub_category)
                                            <li><a class="dropdown-item nav-link" href="{{route('front.shop',[$category->slug,$sub_category->slug])}}">{{$sub_category->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="right-nav py-0">
                <a href="{{route('front.cart')}}" class="ml-3 d-flex pt-2">
                     <span class="position-relative">
                         <i class="fas fa-shopping-cart text-primary"></i>
                         @if(Cart::count() > 0)
                             <span class="badge badge-pill badge-danger position-absolute top-0 start-100 translate-middle">{{ Cart::count() }}</span>
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
                    <p>No dolore ipsum accusam no lorem. <br>
                        123 Street, New York, USA <br>
                        exampl@example.com <br>
                        000 000 0000</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    <ul>
                        <li><a href="about-us.php" title="About">About</a></li>
                        <li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>
                        <li><a href="#" title="Privacy">Privacy</a></li>
                        <li><a href="#" title="Privacy">Terms & Conditions</a></li>
                        <li><a href="#" title="Privacy">Refund Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="#" title="Sell">Login</a></li>
                        <li><a href="#" title="Advertise">Register</a></li>
                        <li><a href="#" title="Contact Us">My Orders</a></li>
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
                        <p>© All copyrights are reserved. INDIGO 2024. </p>
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
    function addToCart(id){
        $.ajax({
            url: "{{ route('front.addToCart') }}",
            type: "post",
            data: {id: id},
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

</script>


@yield('customJs')
</body>
</html>

