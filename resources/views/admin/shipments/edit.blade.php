@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Order Shipment #{{ $shipment->order->code }}</h2>
				</div>
				<div class="card-body">
                    <form action="{{ url('admin/shipments', $shipment->id) }}" method="post">
                        @csrf 
                        @method('put')
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name"  value="{{ $shipment->first_name }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name"  value="{{ $shipment->last_name }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address1">Address 1</label>
                            <input type="text" name="address1"  value="{{ $shipment->address1 }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" name="address2" value="{{ $shipment->address2 }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                        <label>Province<span class="required">*</span></label>
                            <select name="province_id" class="form-control" disabled>
                                    <option value="">- Please Select -</option>
                                @foreach($provinces as $province => $pro)
                                    <option {{ $shipment->province_id == $province ? 'selected' : null }} value="{{ $province }}">{{ $pro }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>City<span class="required">*</span></label>
                                <select name="city_id" class="form-control" disabled>
                                    @foreach($cities as $city => $ty)
                                        <option {{ $shipment->city_id == $city ? 'selected' : null }} value="{{ $city }}">{{ $ty }}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="col-md-6">
                                <label for="postcode">Postcode</label>
                                <input type="text" name="postcode" value="{{ $shipment->postcode }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" value="{{ $shipment->phone }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ $shipment->email }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="qty">Total Qty</label>
                                <input type="number" name="qty" value="{{ $shipment->total_qty }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="total_weight">Total Weight</label>
                                <input type="text" name="total_weight" value="{{ $shipment->total_weight }}" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="track_number">Track Number</label>
                            <input type="text" name="track_number" value="{{ $shipment->track_number }}" class="form-control" >
                        </div>
                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn btn-secondary btn-default">Back</a>
                        </div>
                    </form>
				</div>
			</div>  
		</div>
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Detail Order</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
							<address>
								{{ $shipment->order->customer_company }} {{ $shipment->order->customer_last_name }}
								<br> {{ $shipment->order->customer_address1 }}
								<br> {{ $shipment->order->customer_address2 }}
								<br> Email: {{ $shipment->order->customer_email }}
								<br> Phone: {{ $shipment->order->customer_phone }}
								<br> Postcode: {{ $shipment->order->customer_postcode }}
							</address>
						</div>
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
							<address>
								ID: <span class="text-dark">#{{ $shipment->order->code }}</span>
								<br> {{ $shipment->order->order_date }}
								<br> Status: {{ $shipment->order->status }}
								<br> Payment Status: {{ $shipment->order->payment_status }}
								<br> Shipped by: {{ $shipment->order->shipping_service_name }}
							</address>
						</div>
					</div>
					<table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Item</th>
								<th>Qty</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($shipment->order->orderItems as $item)
								<tr>
									<td>{{ $item->sku }}</td>
									<td>{{ $item->name }}</td>
									<td>{{ $item->qty }}</td>
									<td>{{ $item->sub_total }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="6">Order item not found!</td>
								</tr>
							@endforelse
						</tbody>
					</table>
					<div class="row  justify-content-center">
						<div class="col-lg-8 col-xl-8 col-xl-8">
							<ul class="list-unstyled mt-4">
								<li class="mid pb-3 text-dark">Subtotal
									<span class="d-inline-block float-right text-default">{{ $shipment->order->base_total_price }}</span>
								</li>
								<li class="mid pb-3 text-dark">Tax(10%)
									<span class="d-inline-block float-right text-default">{{ $shipment->order->tax_amount }}</span>
								</li>
								<li class="mid pb-3 text-dark">Shipping Cost
									<span class="d-inline-block float-right text-default">{{ $shipment->order->shipping_cost }}</span>
								</li>
								<li class="pb-3 text-dark">Total
									<span class="d-inline-block float-right">{{ $shipment->order->grand_total }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection