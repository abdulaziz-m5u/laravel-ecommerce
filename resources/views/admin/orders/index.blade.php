@extends('layouts.admin')

@section('content')
   <div class="container">
    <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Orders') }}
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Order ID</th>
                        <th>Grand Total</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th class="text-center" style="width: 30px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                            {{ $order->code }} <br/>
                            {{ $order->order_date }}                                                    
                            </td>
                            <td>{{ $order->grand_total }}</td>
                            <td>
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }} <br/>
                                {{ $order->customer_email }}
                            </td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form onclick="return confirm('are you sure !')" action="{{ route('admin.orders.destroy', $order) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="12">No products found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="float-right">
                                    {!! $orders->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
   </div>
@endsection
