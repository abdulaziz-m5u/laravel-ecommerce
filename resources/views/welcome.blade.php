<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/favicon.png') }}">
		
		<!-- all css here -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/pe-icon-7-stroke.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/icofont.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/easyzoom.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
        <script src="{{ asset('frontend/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

        <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>

        <!-- header start -->
            <header>
                <div class="header-top-furniture wrapper-padding-2 res-header-sm">
                    <div class="container-fluid">
                        <div class="header-bottom-wrapper">
                            <div class="logo-2 furniture-logo ptb-30">
                                <a href="/">
                                    <img src="{{ asset('frontend/assets/img/logo/2.png') }}" alt="">
                                </a>
                            </div>
                            <div class="menu-style-2 furniture-menu menu-hover">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="/">home</a>
                                        </li>
                                        <li>
                                            <a href="#">shop</a>
                                        </li>
                                        <li><a href="#">Categories</a>
                                            <ul class="single-dropdown">
                                                <li><a href="blog.html">blog 3 colunm</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">contact</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="header-cart">
                                <a class="icon-cart-furniture" href="">
                                    <i class="ti-shopping-cart"></i>
                                    <span class="shop-count-furniture green">50</span>
                                </a>
                                    <ul class="cart-dropdown">
                                            <li class="single-product-cart">
                                                <div class="cart-img">
                                                    <a href=""><img src="" alt="" style="width:100px"></a>
                                                </div>
                                                <div class="cart-title">
                                                    <h5>
                                                        <a href="">name</a>
                                                    </h5>
                                                    <span>1000 x qty</span>
                                                </div>
                                                <div class="cart-delete">
                                                    <a href="" class="delete"><i class="ti-trash"></i></a>
                                                </div>
                                            </li>
                                        <li class="cart-space">
                                            <div class="cart-sub">
                                                <h4>Subtotal</h4>
                                            </div>
                                            <div class="cart-price">
                                                <h4>Total</h4>
                                            </div>
                                        </li>
                                        <li class="cart-btn-wrapper">
                                            <a class="cart-btn btn-hover" href="">view cart</a>
                                            <a class="cart-btn btn-hover" href="">checkout</a>
                                        </li>
                                    </ul>
                                    
                            </div>
                        </div>
                        <div class="row">
                            <div class="mobile-menu-area d-md-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
                                <div class="mobile-menu">
                                    <nav id="mobile-menu-active">
                                        <ul class="menu-overflow">
                                            <li>
                                                <a href="#">HOME</a>
                                            </li>
                                            <li>
                                                <a href="#">shop</a>
                                            </li>
                                            <li><a href="#">BLOG</a>
                                                <ul>
                                                    <li><a href="#">blog 3 colunm</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#"> Contact  </a></li>
                                        </ul>
                                    </nav>							
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom-furniture wrapper-padding-2 border-top-3" style="border-bottom: 1px solid #e0e0e0;">
                    <div class="container-fluid">
                        <div class="furniture-bottom-wrapper">
                            <div class="furniture-login">
                                <ul>
                                    @guest
                                        <li>Get Access: <a href="{{ route('login') }}">Login</a></li>
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @else
                                        <li>Hello: <a href="">username</a></li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endguest
                                </ul>
                            </div>
                            <div class="furniture-search">
                                <form action="" method="GET">
                                    <input placeholder="I am Searching for . . ." type="text" name="q" value="{{ isset($q) ? $q : null }}">
                                    <button disabled>
                                        <i class="ti-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="furniture-wishlist">
                                <ul>
                                    <li>
                                        <a href=""><i class="ti-heart"></i> Favorites</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <!-- header end -->

        <!-- slides -->
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
          
            <div class="carousel-inner">
                @foreach(\App\Models\Slide::get() as $key => $slide)
                    <div style="height: 120vh;" class="carousel-item {{$key == 0 ? 'active' : '' }}">
                        <img style="width: 100%;height: auto;object-fit:cover;" src="{{ Storage::url('images/slides/'. $slide->cover) }}" class="d-block" alt="{{ $slide->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $slide->title }}</h5>
                            <p>{{ $slide->body }}</p>
                            <a class="furniture-slider-btn btn-hover animated text-white" style="border: 1px solid #fff;" href="{{ $slide->url }}">Go</a>
                        </div>
                    </div>    
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- end slides -->

        <!-- categories -->
        <div class="container">
            <div class="row mt-5">
                @foreach(\App\Models\Category::get()->take(4) as $category)
                    <div class="col-lg-6 mb-5">
                        <div class="card category-card">
                            <img class="img-cover" src="{{ Storage::url('images/categories/'. $category->cover) }}" alt="">
                            <span 
                            class="position-absolute category-name" 
                            style=" position: absolute;left: 50%;top: 50%;transform: translate(-50%,-50%);background-color: white;padding: .8rem 1rem;border: 3px solid #f0f0f0;">
                                {{ $category->name }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- end categories -->

        <!-- services -->
        <div class="services-area wrapper-padding-4 gray-bg pt-120 pb-80">
            <div class="container-fluid">
                <div class="section-title-6 text-center mb-50">
                    <h2>Why Choose Us</h2>
                </div>
                <div class="services-wrapper mt-40">
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{ asset('frontend/assets/img/icon-img/26.png') }}" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Free Shippig</h4>
                            <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{ asset('frontend/assets/img/icon-img/27.png') }}" alt="">
                        </div>
                        <div class="services-content">
                            <h4>24/7 Support</h4>
                            <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                        </div>
                    </div>
                    <div class="single-services mb-40">
                        <div class="services-img">
                            <img src="{{ asset('frontend/assets/img/icon-img/28.png') }}" alt="">
                        </div>
                        <div class="services-content">
                            <h4>Secure Payments</h4>
                            <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end services -->

        <!-- products -->
        <div class="popular-product-area wrapper-padding-3 pt-115 pb-115">
            <div class="container-fluid">
                <div class="section-title-6 text-center mb-50">
                    <h2>Popular Product</h2>
                </div>
                <div class="product-style">
                    <div class="popular-product-active owl-carousel">
                        @foreach (\App\Models\Product::get() as $product)
                            <div class="product-wrapper">
                                <div class="product-img">
                                    <a href="#">
                                        @if($product->firstMedia)
                                        <img src="{{ asset('storage/images/products/' . $product->firstMedia->file_name) }}"
                                            width="60" height="60" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="product-action">
                                        <a class="animate-left add-to-fav" title="Wishlist"  product-slug="{{ $product->slug }}" href="">
                                            <i class="pe-7s-like"></i>
                                        </a>
                                        <a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id }}" product-type="{{ $product->slug }}" product-slug="{{ $product->slug }}">
                                            <i class="pe-7s-cart"></i>
                                        </a>
                                        <a class="animate-right quick-view" title="Quick View" product-slug="{{ $product->slug }}" href="">
                                            <i class="pe-7s-look"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="funiture-product-content text-center">
                                    <h4><a href="">{{ $product->name }}</a></h4>
                                    <span>${{ $product->price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- end products -->

        <!-- footer -->
        <footer class="footer-area">
            <div class="footer-top-area pt-70 pb-35 wrapper-padding-5">
                <div class="container-fluid">
                    <div class="widget-wrapper">
                        <div class="footer-widget mb-30">
                            <a href="#"><img src="{{ asset('frontend/assets/img/logo/2.png') }}" alt=""></a>
                            <div class="footer-about-2">
                                <p>There are many variations of passages of Lorem Ipsum <br>the majority have suffered alteration in some form, by <br> injected humour</p>
                            </div>
                        </div>
                        <div class="footer-widget mb-30">
                            <h3 class="footer-widget-title-5">Contact Info</h3>
                            <div class="footer-info-wrapper-3">
                                <div class="footer-address-furniture">
                                    <div class="footer-info-icon3">
                                        <span>Address: </span>
                                    </div>
                                    <div class="footer-info-content3">
                                        <p>66 Sipu road Rampura Banasree <br>USA- 10800</p>
                                    </div>
                                </div>
                                <div class="footer-address-furniture">
                                    <div class="footer-info-icon3">
                                        <span>Phone: </span>
                                    </div>
                                    <div class="footer-info-content3">
                                        <p>+8801 (33) 515609735 <br>+8801 (66) 223352333</p>
                                    </div>
                                </div>
                                <div class="footer-address-furniture">
                                    <div class="footer-info-icon3">
                                        <span>E-mail: </span>
                                    </div>
                                    <div class="footer-info-content3">
                                        <p><a href="#"> email@domain.com</a> <br><a href="#"> domain@mail.info</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer-widget mb-30">
                            <h3 class="footer-widget-title-5">Newsletter</h3>
                            <div class="footer-newsletter-2">
                                <p>Send us your mail or next updates</p>
                                <div id="mc_embed_signup" class="subscribe-form-5">
                                    <form action="http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                        <div id="mc_embed_signup_scroll" class="mc-form">
                                            <input type="email" value="" name="EMAIL" class="email" placeholder="Enter mail address" required>
                                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                            <div class="mc-news" aria-hidden="true"><input type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1" value=""></div>
                                            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom ptb-20 gray-bg-8">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="copyright-furniture">
                                <p>Copyright © <a href="https://hastech.company/">HasTech</a> 2018 . All Right Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


     
       
		
		<!-- all js here -->
        <script src="{{ asset('frontend/assets/js/vendor/jquery-1.12.0.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/popper.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/waypoints.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/ajax-mail.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/plugins.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>
