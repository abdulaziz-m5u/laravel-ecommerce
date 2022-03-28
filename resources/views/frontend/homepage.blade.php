@extends('layouts.frontend')
@section('title', 'Homepage')
@section('content')
     <!-- slides -->
     <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">       
            <div class="carousel-inner">
                @foreach($slides as $key => $slide)
                    <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                        <img src="{{ Storage::url('images/slides/'. $slide->cover) }}" class="d-block w-100" alt="{{ $slide->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-white">{{ $slide->title }}</h5>
                            <p>{!! $slide->body !!}</p>
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
        <div class="container mt-5">
                <div class="section-title-furits text-center">
                    <h2>BROWSE OUR CATEGORIES</h2>
                </div>
                <br>
            <div class="row mt-5">
                @foreach($categories as $category)
                    <div class="col-lg-3 mb-5">
                        <div class="card category-card">
                            <a href="{{ route('shop.index', $category->slug) }}">
                                <img class="img-cover" src="{{ Storage::url('images/categories/'. $category->cover) }}" alt="">
                                <span 
                                class="position-absolute category-name" 
                                style=" position: absolute;left: 50%;top: 50%;transform: translate(-50%,-50%);background-color: white;padding: .8rem 1rem;border: 3px solid #f0f0f0;">
                                    {{ $category->name }}
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- end categories -->

        <!-- services -->
        <div class="services-area wrapper-padding-4 gray-bg pt-120 pb-80">
            <div class="container-fluid">
                <div class="section-title-furits text-center">
                    <h2>Why Choose Us</h2>
                </div>
                <br>
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
                <br>
                <div class="section-title-furits section-title-6 text-center mb-50">
                    <h2>Popular Product</h2>
                </div>
                <br>
                <div class="product-style">
                    <div class="popular-product-active owl-carousel">
                        @foreach ($products as $product)
                            <div class="product-wrapper">
                                <div class="product-img">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        @if($product->firstMedia)
                                        <img src="{{ asset('storage/images/products/' . $product->firstMedia->file_name) }}"
                                         alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="product-action">
                                        <a class="animate-left add-to-fav" title="Wishlist"  product-slug="{{ $product->slug }}" href="">
                                            <i class="pe-7s-like"></i>
                                        </a>
                                        <a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id }}" product-slug="{{ $product->slug }}">
                                            <i class="pe-7s-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="funiture-product-content text-center">
                                    <h4><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h4>
                                    <span>Rp.{{ number_format($product->price) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- end products -->
@endsection