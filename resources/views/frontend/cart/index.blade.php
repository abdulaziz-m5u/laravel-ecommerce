@extends('layouts.frontend')
@section('title', 'Cart')
@section('content')
	<!-- shopping-cart-area start -->
	<div class="cart-main-area pt-95 pb-100">
		<div class="container">
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if(session()->has('message'))
                        <div class="alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">
                            {{ session()->get('message') }}
                            <button type="button" style="cursor: pointer;" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

					<h1 class="cart-heading text-center">Cart Page</h1>
						<div class="table-content table-responsive">
							<table>
								<thead>
									<tr>
										<th>remove</th>
										<th>images</th>
										<th>Product</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($carts as $cart)
										@php
											$product = $cart->associatedModel;
											$image = !empty($product->firstMedia) ? asset('storage/images/products/'. $product->firstMedia->file_name) : asset('frontend/assets/img/cart/3.jpg')
										@endphp
										<form id="delete-cart" action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-none">
											@csrf
											@method('delete')
										</form>
										<form action="{{ route('cart.update', $cart->id) }}" method="post">
										@csrf
										@method('put')
										<tr>
											<td class="product-remove">
												<a href="" onclick="event.preventDefault();document.getElementById('delete-cart').submit();" class="delete"><i class="pe-7s-close"></i></a>
											</td>
											<td class="product-thumbnail">
												<a href="{{ route('product.show', $product->slug) }}"><img src="{{ $image }}" alt="{{ $product->name }}" style="width:100px"></a>
											</td>
											<td class="product-name"><a href="{{ route('product.show', $product->slug) }}">{{ $cart->name }}</a></td>
											<td class="product-price-cart"><span class="amount">{{ number_format($cart->price) }}</span></td>
											<td class="product-quantity">
												<input type="number" name="items[{{ $cart->id }}][quantity]" min="1" required value="{{ $cart->quantity }}">
											</td>
											<td class="product-subtotal">{{ number_format($cart->price * $cart->quantity)}}</td>
										</tr>
									@empty
										<tr>
											<td colspan="6">The cart is empty!</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="coupon-all">
									<div class="coupon2">
                                        <input class="button" name="update_cart" value="Update cart" type="submit">
									</div>
								</div>
							</div>
						</div>
						</form>
						<div class="row">
							<div class="col-md-5 ml-auto">
								<div class="cart-page-total">
									<h2>Cart totals</h2>
									<ul>
										<li>Total<span>{{ number_format(\Cart::getTotal()) }}</span></li>
									</ul>
									<a href="{{ route('checkout.process') }}">Proceed to checkout</a>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- shopping-cart-area end -->
@endsection