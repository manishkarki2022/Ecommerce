@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('products.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Book Name" value="{{ old('title') }}">
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('slug') }}">
                                            @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">ShortDescription</label>
                                            <textarea name="short_description" id="short_description" cols="15" rows="5" class="summernote" placeholder="Short Description" value="{{ old('short_description') }}"></textarea>
                                            @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description" value="{{ old('description') }}"></textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3"><i class="fa fa-book"></i> Book Information</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="publisher_name">Publisher Name</label>
                                                        <input type="text" name="publisher_name" id="publisher_name" class="form-control" placeholder="Enter publisher name" value="{{ old('publisher_name') }}">
                                                        @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="published_year">Publication Year</label>
                                                        <input type="number" name="published_year" id="published_year" class="form-control" placeholder="Publication Year" value="{{ old('published_year') }}" min="1900" max="2099">
                                                        @error('published_year')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="isbn">ISBN</label>
                                                        <input type="text" name="isbn_number" id="isbn_number" class="form-control" placeholder="Enter ISBN" value="{{ old('isbn_number') }}">
                                                        @error('isbn_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="edition">Book Edition</label>
                                                        <input type="text" name="edition" id="edition" class="form-control" placeholder="Enter Book edition" value="{{ old('edition') }}">
                                                        @error('edition')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="country">Book Origin Country</label>
                                                        <input type="text" name="country" id="country" class="form-control" placeholder="Enter Book origin country" value="{{ old('country') }}">
                                                        @error('country')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="pages">Numbers of Pages</label>
                                                        <input type="number" name="pages" id="pages" class="form-control" placeholder="Enter Book numbers of Pages" value="{{ old('pages') }}">
                                                        @error('pages')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="language">Book Language</label>
                                                        <input type="text" name="language" id="language" class="form-control" placeholder="Enter Book Language" value="{{ old('language') }}">
                                                        @error('language')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Photo</h2>
                                <div class="form-group">
                                    <label for="images">Book Images</label>
                                    <input type="file" name="images[]" id="images" class="form-control-file" multiple required>
                                    @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image Previews Container -->
                                <div id="image-preview-container"></div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Paper Book Price" value="{{ old('price') }}">
                                            @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Paper Book Compare Price" value="{{ old('compare_price') }}">
                                            @error('compare_price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <p class="text-muted mt-3">
                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ old('sku') }}">
                                            @error('sku')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ old('barcode') }}">
                                            @error('barcode')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                @error('track_qty')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ old('qty') }}">
                                            @error('qty')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Book status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4  mb-3"><i class="fa fa-user"></i> Author </h2>
                                <div class="mb-3">
                                    <label for="author">Author </label>
                                    <select name="author_id" id="author" class="form-control">
                                        <option value="">Select an Author</option>
                                        @if(!$authors->isEmpty())
                                            @foreach($authors as $author)
                                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                                                @error('author')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('author')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Book category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if(!$categories->isEmpty())
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            @endforeach
                                        @endif


                                    </select>
                                    @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Book Sub category</label>
                                    <select name="sub_category_id" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category </option>
                                        @error('sub_category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured Books</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                        @error('is_featured')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Book Type</h2>
                                <div class="mb-3">
                                    <select name="book_type_id" id="book_type_id" class="form-control">
                                        <option value="">Select Book Type</option>
                                        @foreach ($bookTypes as $bookType)
                                            <option value="{{ $bookType->id }}">{{ $bookType->name }}</option>
                                            @error('book_type_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3" id="ebook_upload_container" style="display: none;">
                            <div class="card-body">
                                <h2 class="h4 mb-3">
                                    <i class="fas fa-book"></i> Ebook Upload
                                </h2>
                                <div class="mb-3">
                                    <input type="file" name="ebook" id="ebook" class="form-control-file">
                                    @error('ebook')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ebook_price">E-Book Price</label>
                                    <input type="number" name="ebook_price" id="ebook_price" class="form-control-file" placeholder="Enter E-Book Price">
                                    @error('ebook_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ebook_compare_price">E-Book Compare at Price</label>
                                    <input type="number" name="ebook_compare_price" id="ebook_compare_price" class="form-control-file" placeholder="Enter E-Book Compare Price">
                                    @error('ebook_compare_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
        </form>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('customJs')

    <script>
        $('#title').change(function(){
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: "{{ route('getSlug') }}",
                type: "GET",
                data: { title: element.val() },
                dataType: "json",
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                    if(response['slug'] !== undefined && response['slug'] !== ''){
                        $('#slug').val(response['slug']);
                    }
                }
            });
        });
        $("#category").change(function(){
            var category_id = $(this).val();
            $.ajax({
                url: "{{ route('get-sub-categories') }}",
                type: "GET",
                data: { category_id: category_id },
                dataType: "json",
                success: function(response){
                    $('#sub_category').find('option').not(":first").remove();
                    $.each(response['subCategories'], function(key, item){
                        $('#sub_category').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                },
                error:function(){
                    console.log("Something went wrong")
                }
            });
        });
        document.getElementById('book_type_id').addEventListener('change', function() {
            var bookTypeId = this.value;
            var ebookUploadContainer = document.getElementById('ebook_upload_container');

            if (bookTypeId === '1' || bookTypeId === '3') { // Digital or Both
                ebookUploadContainer.style.display = 'block';
            } else {
                ebookUploadContainer.style.display = 'none';
            }
        });
    </script>
@endsection
