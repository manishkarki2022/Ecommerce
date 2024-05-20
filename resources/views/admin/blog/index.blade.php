@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blogs</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="text-success" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Blogs</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <a type="button"  href="{{route('blogs.create')}}" class="btn btn-primary btn-md mb-1">Add Post</a>
            <div class="card">
                <form action="{{ route('blogs.search') }}" method="get">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ route('blogs.index') }}'" class="btn btn-default btn-sm">Reset</button>
                            </div>
                            <div class="card-tools">
                                <div class="input-group" style="width: 200px;">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search by Name">
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
                            <th >ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($blogs->isEmpty())
                            <tr>
                                <td colspan="7" class="text-danger">No Blogs found!!!</td>
                            </tr>
                        @else

                            @foreach($blogs as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($post->image!=null )
                                            <img src="{{ asset('blogs/' . $post->image) }}" class="img-thumbnail" width="70">
                                        @else
                                            <!-- Default placeholder image or any other default image you want to show -->
{{--                                            <img src="{{ asset('authorImage/noimage.jpg') }}" class="img-thumbnail" width="50">--}}
                                        @endif
                                    </td>
                                    <td><a href="{{route('blogs.edit',$post->slug)}}">{{ $post->name }}</a></td>

                                    <td>
                                        @if($post->status == 'active')
                                            <!-- Right icon -->
                                            <svg class="text-success-500 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" width="25" height="25">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <!-- Cross icon -->
                                            <svg class="text-danger " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" width="25" height="25">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $post->created_by }}</td>
                                    <td class="project-actions">
                                        <a class="btn btn-info btn-sm" href="{{route('blogs.edit',$post->slug)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#"  onclick="confirmDelete({{ $post->id }})">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                        <form id="delete-form-{{ $post->id }}" action="{{ route('blogs.destroy', $post->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        @endif
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{$blogs->links()}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('customJs')
@endsection
