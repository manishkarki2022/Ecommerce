@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{$order->id}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('orders.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                        <strong>{{$order->first_name.' '.$order->last_name}}</strong><br>
                                        {{$order->address}}<br>
                                        {{$order->city->name}}, {{$order->zip}}<br>
                                        Phone: {{$order->mobile}}<br>
                                        Email: {{$order->user->email}}
                                    </address>
                                </div>



                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #007612</b><br>
                                    <br>
                                    <b>Order ID:</b> {{$order->id}}<br>
                                    <b>Total:</b> ${{number_format($order->grand_total)}}<br>
                                    <b>Status:</b>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-black"><i class="fas fa-hourglass-start mr-1"></i> Pending</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-info "><i class="fas fa-truck mr-1"></i> Shipped</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>
                                    @elseif(empty($order->status))
                                        <span class="badge bg-danger"> <i class="fas fa-times-circle mr-1"></i> Cancelled</span>
                                    @endif
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderItems as $orderItem)
                                <tr>
                                    <td>{{$orderItem->product->title}}</td>
                                    <td>${{$orderItem->price}}</td>
                                    <td>{{$orderItem->qty}}</td>
                                    <td>${{$orderItem->total}}</td>
                                </tr>
                                @endforeach


                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>${{number_format($order->subtotal,2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>${{number_format($order->discount,2)}}</td>
                                </tr>

                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>${{number_format($order->shipping,2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>${{number_format($order->grand_total,2)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="" {{ $order->status == '' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Customer</option>
                                    <option value="">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
@endsection

