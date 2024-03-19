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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown" class="bg-white">

<div class="bg-light top-header">
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="index.php" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
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
                                            <li><a class="dropdown-item nav-link" href="#">{{$sub_category->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="right-nav py-0">
                <a href="cart.php" class="ml-3 d-flex pt-2">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </a>
            </div>
        </nav>
    </div>
</header>
<main>
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-1-m.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                        <img src="{{asset('front-assets/images/carousel-1.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-2-m.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-2.jpg')}}" />
                        <img src="images/carousel-2.jpg" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-2.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-3.jpg')}}" />
                        <img src="{{asset('front-assets/images/carousel-2.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
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
                        <div class="col-md-2">
                            <div class="card product-card h-100">
                                <div class="product-image position-relative">
                                    <img class="card-img-top img-fluid" src="{{ asset('products/' . $featuredItem->images->first()->image) }}" alt="">
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{$featuredItem->title}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>${{$featuredItem->price}}</strong></span>
                                        @if($featuredItem !='')
                                            <span class="h6 text-underline"><del>${{$featuredItem->compare_price}}</del></span>
                                        @endif
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
                <h2>Latest Product</h2>
            </div>
            <div class="row pb-3 slider2">
                @if($latest->isNotEmpty())
                    @foreach($latest as $latestItem)
                        <div class="col-md-2 mb-5">
                            <div class="card product-card h-100"> <!-- Added h-100 to make the card full height -->
                                <div class="product-image position-relative">
                                    <img class="card-img-top img-fluid" src="{{ asset('products/' . $latestItem->images->first()->image) }}" alt=""> <!-- Added img-fluid to make the image responsive -->
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                    <div class="product-action">
                                        <a class="btn btn-dark" href="#">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{$latestItem->title}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>${{$latestItem->price}}</strong></span>
                                        @if($latestItem !='')
                                            <span class="h6 text-underline"><del>${{$latestItem->compare_price}}</del></span>
                                        @endif
                                    </div>
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
                <div class="col-md-6 ">
                    <div class="card  h-100"> <!-- Added h-100 to make the card full height -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.2544190099397!2d85.32404911098125!3d27.709429925300263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19091da0e19b%3A0xc4598923d9d99381!2sCity%20Centre!5e0!3m2!1sen!2snp!4v1710850120485!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>



</main>
<footer class="bg-dark mt-5">
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
                        <p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
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
            var itemsToShow = 4; // Default number of items
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
    document.addEventListener('DOMContentLoaded', function () {
        var slider;

        // Function to initialize the slider with appropriate number of items
        function initSlider() {
            var viewportWidth = window.innerWidth;

            // Adjust the number of items based on viewport width
            var itemsToShow = 4; // Default number of items
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
</script>
</body>
</html>

