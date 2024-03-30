@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="#" class="btn btn-primary">New Category</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form action="{{ route('orders.search') }}" method="get">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ route('orders.index') }}'" class="btn btn-default btn-sm">Reset</button>
                            </div>
                            <div class="card-tools">
                                <div class="input-group" style="width: 250px;">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>
                                <a href="{{ route('orders.index', ['sort' => 'id', 'dir' => $sortField == 'id' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Orders #
                                    @if($sortField == 'id')
                                        @if($sortDirection == 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="text-primary">
                                Customer
                            </th>
                            <th class="text-primary">
                                Email
                            </th>
                            <th class="text-primary">
                                Phone
                            </th>



                            <th>
                                <a href="{{ route('orders.index', ['sort' => 'status', 'dir' => $sortField == 'status' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Status
                                    @if($sortField == 'status')
                                        @if($sortDirection == 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', ['sort' => 'grand_total', 'dir' => $sortField == 'grand_total' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Total
                                    @if($sortField == 'grand_total')
                                        @if($sortDirection == 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('orders.index', ['sort' => 'created_at', 'dir' => $sortField == 'created_at' && $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                    Date Purchased
                                    @if($sortField == 'created_at')
                                        @if($sortDirection == 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{ route('orders.show', $order->id) }}">{{ $order->id }}</a></td>
                                    <td>{{ $order->first_name}}{{$order->last_name}}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->mobile }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning text-black"><i class="fas fa-hourglass-start mr-1"></i> Pending</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info "><i class="fas fa-truck mr-1"></i> Shipped</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-success"><i class="fas fa-check-circle mr-1"></i> Delivered</span>
                                        @elseif(empty($order->status))
                                            <span class="badge bg-danger"> <i class="fas fa-times-circle mr-1"></i> Cancelled</span>
                                        @endif
                                    </td>
                                    <td>${{ $order->grand_total }}</td>
                                    <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Orders Found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$orders->links()}}
                    {{--                    <ul class="pagination pagination m-0 float-right">--}}
                    {{--                        <li class="page-item"><a class="page-link" href="#">«</a></li>--}}
                    {{--                        <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
                    {{--                        <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                    {{--                        <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                    {{--                        <li class="page-item"><a class="page-link" href="#">»</a></li>--}}
                    {{--                    </ul>--}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
@endsection

