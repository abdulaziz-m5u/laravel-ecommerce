@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Cancel Order #{{ $order->code }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.cancelUpdate', $order->id) }}" method="post">
                        @csrf 
                        @method('put')
                    <div class="form-group">
                        <label for="cancellation note">Cancellation Note</label>
                        <textarea name="cancellation_note" class="form-control" cols="30" rows="10"></textarea>
                        @error('cancellation_note')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-footer pt-5 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Cancel the Order</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-default">Back</a>
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
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                                <br> {{ $order->customer_address1 }}
                                <br> {{ $order->customer_address2 }}
                                <br> Email: {{ $order->customer_email }}
                                <br> Phone: {{ $order->customer_phone }}
                                <br> Postcode: {{ $order->customer_postcode }}
                            </address>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
                            <address>
                                    ID: <span class="text-dark">#{{ $order->code }}</span>
                                <br> DATE: <span>{{ $order->order_date }}</span>
                                <br>
                                NOTE: <span>{{ $order->note }}</span>
                                <br> Status: {{ $order->status }} {{ $order->cancelled_at }}
                                    <br> Cancellation Note : {{ $order->cancellation_note}}
                                <br> Payment Status: {{ $order->payment_status }}
                                <br> Shipped by: {{ $order->shipping_service_name }}
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
                            @forelse ($order->orderItems as $item)
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
                    <div class="row justify-content-end">
                        <div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
                            <ul class="list-unstyled mt-4">
                                <li class="mid pb-3 text-dark">Subtotal
                                    <span class="d-inline-block float-right text-default">{{ $order->base_total_price }}</span>
                                </li>
                                <li class="mid pb-3 text-dark">Tax(10%)
                                    <span class="d-inline-block float-right text-default">{{ $order->tax_amount }}</span>
                                </li>
                                <li class="mid pb-3 text-dark">Shipping Cost
                                    <span class="d-inline-block float-right text-default">{{ $order->shipping_cost }}</span>
                                </li>
                                <li class="pb-3 text-dark">Total
                                    <span class="d-inline-block float-right">{{ $order->grand_total }}</span>
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