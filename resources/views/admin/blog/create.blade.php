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
                        <li class="breadcrumb-item"><a class="text-success" href="{{ route('blogs.index') }}">Blogs</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">

    <div class="row p-1">
            <div class="col-md-8">
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-default">
                        <div class="card-header bg-success">
                            <h3 class="card-title">Blogs</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Blog Name" name="name" value="{{old('name')}}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Short Description</label>
                                            <textarea class="form-control" placeholder="Enter Short Description" name="excerpt">{{old('excerpt')}}</textarea>
                                            @error('excerpt')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="content" cols="30" rows="20" class="summernote" placeholder="Content">{{old('long_description')}}</textarea>
                                            @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="pb-5 pt-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <a href="{{ route('blogs.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                                </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
            <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title text-white">Blog Detail</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control select2-blue">
                            <option value="active" @if(old('status') == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status') == 'inactive') selected @endif>Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
                <div class="card" id="service_price_section" style="display: none;">
                    <div class="card-header bg-danger">
                        <h3 class="card-title text-white"> Price</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Add your service price input fields here -->
                    <div class="card-body">
                        <div class="form-group">
                            <label> Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Enter Price">
                        </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Blog Image</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Upload Image</label>
                        <input type="file" class="form-control" name="image" id="image" onchange="previewImage(event)">
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="image-preview" ></div>
                </div>
            </div>
        </div>

    </div>
    </form>


@endsection

@section('customJs')
    <script>
        function previewImage(event) {
            console.log('he');
            var input = event.target;
            var preview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = ''; // Clear previous preview
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px'; // Adjust as needed
                    img.style.maxHeight = '100px'; // Adjust as needed
                    preview.appendChild(img);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
