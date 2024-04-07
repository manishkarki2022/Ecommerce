@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products Review</h1>
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
                <form action="{{ route('products.ratingSearch') }}" method="get">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ route('products.productRatings') }}'" class="btn btn-default btn-sm">Reset</button>
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
                            <th>Product</th>
                            <th>Reviewer Name</th>
                            <th>Approved</th>
                            <th>Rating</th>
                            <th>Created</th>

                        </tr>
                        </thead>
                        <tbody>
                        @empty($ratings)
                            <tr>
                                <td colspan="7">No products found.</td>
                            </tr>
                        @else
                            @foreach($ratings as $rating)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$rating->product->title}}</td>
                                    <td>{{ $rating->username }}</td>
                                    <td>
                                        @if($rating->status == 1)
                                            <a href="javascript:void(0)" onclick="changeStatus(0,'{{$rating->id}}');">
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" onclick="changeStatus(1,'{{$rating->id}}');">
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{$rating->rating}}</td>
                                    <td>{{ $rating->created_at->format('Y-m-d') }}</td>

                                </tr>
                            @endforeach
                        @endempty


                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$ratings->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        function changeStatus(status,id){
    $.ajax({
                    url: "{{ route('products.changeRatingStatus') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id
                    },
                    success: function(response){
                        if(response.status){
                            toastr.success(response.message);
                            setTimeout(function(){
                                window.location.reload();
                            }, 1000);
                        }else{
                            toastr.error(response.message);
                        }
                    }
                });
        }


    </script>
@endsection

