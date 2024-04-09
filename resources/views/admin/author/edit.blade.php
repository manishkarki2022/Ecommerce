@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Author</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('authors.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('authors.update',$author->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Author details -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Name -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Name*</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name of Author" value="{{ $author->name }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{ $author->description }}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Image upload -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="image">Author Image</label>
                                            <input type="file" name="image" id="image" class="form-control-file">
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Author status -->
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Author status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $author->status == 'active' ? 'selected' : '' }} value="active">Active</option>
                                        <option {{ $author->status == 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Media -->
                <div class="row" id="product-gallery">
                    @if($author->authorImage->isNotEmpty())
                        <div class="col-md-3">
                            <div class="card">
                                <img src="{{ asset('authorImage/' . $author->id . '/' . $author->authorImage->first()->image) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <button class="btn btn-danger btn-sm delete-image" data-image-id="{{ $author->authorImage->first()->id }}">Delete</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('authors.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            $('.delete-image').click(function() {
                var imageId = $(this).data('image-id');
                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: '{{ route("delete-authorImage") }}',
                        method: 'DELETE',
                        data: {
                            image_id: imageId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                toastr.success(response['message']);
                                $('[data-image-id="' + imageId + '"]').closest('.col-md-3').remove();
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error(response['message']);
                        }
                    });
                }
            });
        });
    </script>
@endsection
