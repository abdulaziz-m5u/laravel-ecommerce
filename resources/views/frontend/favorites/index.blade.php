@extends('layouts.frontend')
@section('title', 'Favorite Items')
@section('content')
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('frontend/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container-fluid">
			<div class="breadcrumb-content text-center">
				<h2>My Favorites</h2>
				<ul>
					<li><a href="{{ url('/') }}">home</a></li>
					<li>my favorites</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="shop-page-wrapper shop-page-padding ptb-100">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
                <h3 class="sidebar-title">User Menu</h3>
                    <div class="sidebar-categories">
                        <ul>
                            <li><a href="{{ route('profile.index') }}">Profile</a></li>
                            <li><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li><a href="{{ route('favorite.index') }}">Favorites</a></li>
                        </ul>
                    </div>
				</div>
				<div class="col-lg-9">
					<div class="shop-product-wrapper res-xl">
						<div class="table-content table-responsive">
                        <table>
								<thead>
									<tr>
										<th>remove</th>
										<th>Image</th>
										<th>Product</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($favorites as $favorite)
										@php
											$product = $favorite->product;
										@endphp
										<tr>
											<td class="product-remove">
                                                <form id="delete-fav" action="{{ route('favorite.destroy', $favorite->id)}}" method="POST" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                                <a href="" onclick="event.preventDefault();document.getElementById('delete-fav').submit();" class="delete"><i class="pe-7s-close"></i></a>
											</td>
											<td class="product-thumbnail">
												<a href="{{ route('product.show', $product->slug) }}">
                                                    @if($product->firstMedia)
                                                    <img src="{{ asset('storage/images/products/' . $product->firstMedia->file_name) }}"
                                                        width="60" height="60" alt="{{ $product->name }}">
                                                    @else
                                                        <span class="badge badge-danger">no image</span>
                                                    @endif
                                                </a>
											</td>
											<td class="product-name"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></td>
											<td class="product-price-cart"><span class="amount">{{ number_format($product->price) }}</span></td>
										</tr>
									@empty
										<tr>
											<td colspan="4">You have no favorite product</td>
										</tr>
									@endforelse
                                </tbody>
							</table>
							{{ $favorites->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection