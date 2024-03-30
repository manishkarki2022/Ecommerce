@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Discount Coupon Code</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('coupons.create')}}" class="btn btn-primary">New Coupon Code</a>
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
                <form action="{{ route('coupons.search') }}" method="get">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button onclick="window.location.href='{{ route('coupons.index') }}'" class="btn btn-default btn-sm">Reset</button>
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
                            <th width="60">ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($discounts->isEmpty())
                            <tr>
                                <td colspan="5">No Data found.</td>
                            </tr>
                        @else
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{$discount->id}}</td>
                                    <td>{{$discount->code}}</td>
                                    <td>{{$discount->name}}</td>
                                    <td>
                                        @if($discount->type == 'percentage')
                                            {{$discount->discount_amount}} %
                                        @else
                                            ${{$discount->discount_amount}}
                                        @endif
                                    </td>
                                    <td>
                                        {{!empty($discount->start_at)? \Carbon\Carbon::parse($discount->start_at)->format('Y-m-d') : ''}}
                                    </td>
                                    <td>
                                    {{!empty($discount->expire_at)? \Carbon\Carbon::parse($discount->expire_at)->format('Y-m-d') : ''}}
                                    <td>
                                        @if($discount->status == 1)
                                            <!-- Right icon -->
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <!-- Cross icon -->
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('coupons.edit',$discount->id)}}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="text-danger w-4 h-4 mr-1" onclick="return confirm('Are you sure you want to delete the data?') ? document.getElementById('delete-form-{{ $discount->id }}').submit() : false;">
                                            <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                        <!-- Form to handle the delete action -->
                                        <form id="delete-form-{{ $discount->id }}" action="{{ route('coupons.destroy', $discount->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$discounts->links()}}
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
    <script>

    </script>
@endsection

