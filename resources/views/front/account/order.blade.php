@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('account.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Orders</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Order Information</h2>
                        </div>
                        <div class="card-body p-4">
                            @if($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Orders </th>
                                            <th>Date Purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                        <tr>

                                            <td>
                                                <a href="{{route('account.orderDetail',$order->id)}}">OR{{$order->id}}</a>
                                            </td>

                                            <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="badge bg-warning text-black"><i class="fas fa-hourglass-start mr-1"></i> Pending</span>
                                                @elseif($order->status == 'shipped')
                                                    <span class="badge bg-info "><i class="fas fa-truck mr-1"></i> Shipped</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge bg-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>
                                                @elseif(($order->status=='canceled'))
                                                    <span class="badge bg-danger"> <i class="fas fa-times-circle mr-1"></i> Cancelled</span>
                                                @endif
                                            </td>
                                            <td>Rs{{number_format($order->grand_total,2)}}</td>
                                        </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No Orders Found
                                </div>
                            @endif
                                <div class="card-footer clearfix">
                                    {{$orders->links()}}
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
