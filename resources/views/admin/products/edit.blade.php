@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
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
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{$product->title}}">
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $product->slug }}">
                                            @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">ShortDescription</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" placeholder="Short Description">{{ $product->short_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Shipping and Return</label>
                                            <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="Description">{{ $product->shipping_return }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div class="form-group">
                                    <label for="images">Product Images</label>
                                    <input type="file" name="images[]" id="images" class="form-control-file" multiple >
                                </div>

                                <!-- Image Previews Container -->
                                <div id="image-preview-container"></div>
                                <div class=""> </div>
                            </div>
                        </div>
                        <div class="row" id="product-gallery">
                          @if($product->images->isNotEmpty())
                                    @foreach($product->images as $image)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <img src="{{ asset('products/'.$image->image) }}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <button class="btn btn-danger btn-sm delete-image" data-image-id="{{ $image->id }}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3"><i class="fa fa-book"></i> Book Information</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="publisher_name">Publisher Name</label>
                                            <input type="text" name="publisher_name" id="publisher_name" class="form-control" placeholder="Enter publisher name" value="{{ $product->publisher_name}}">
                                            @error('publisher_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="published_year">Publication Year</label>
                                            <input type="number" name="published_year" id="published_year" class="form-control" placeholder="Publication Year" value="{{$product->published_year}}" min="1900" max="2099">
                                            @error('published_year')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="isbn">ISBN</label>
                                            <input type="text" name="isbn_number" id="isbn_number" class="form-control" placeholder="Enter ISBN" value="{{ $product->isbn_number }}">
                                            @error('isbn_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="edition">Book Edition</label>
                                            <input type="text" name="edition" id="edition" class="form-control" placeholder="Enter Book edition" value="{{ $product->edition }}">
                                            @error('edition')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="country">Book Origin Country</label>
                                            <input type="text" name="country" id="country" class="form-control" placeholder="Enter Book origin country" value="{{ $product->country }}">
                                            @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="pages">Numbers of Pages</label>
                                            <input type="number" name="pages" id="pages" class="form-control" placeholder="Enter Book numbers of Pages" value="{{ $product->pages }}">
                                            @error('pages')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="language">Book Language</label>
                                            <input type="text" name="language" id="language" class="form-control" placeholder="Enter Book Language" value="{{ $product->language }}">
                                            @error('language')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="paperback_price" style="display: none;">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                            @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{$product->compare_price }}">

                                        </div>
                                    </div>
                                    <p class="text-muted mt-3 text-center">
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
                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ $product->sku }}">
                                            @error('sku')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ $product->barcode }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="trackQty"  style="display: none;">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" {{($product->track_qty =='Yes')? 'checked':''}}>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ $product->qty }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related Products</h2>
                                <div class="mb-3">
                                    <select multiple class="related-product w-100" name="related_products[]" id="related_products">
                                        @if(!empty($relatedProducts))
                                            @foreach($relatedProducts as $relatedProduct)
                                                <option  value="{{ $relatedProduct->id }}" selected>{{ $relatedProduct->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Book Type</h2>
                                <div class="mb-3">
                                    <select name="book_type_id" id="book_type_id" class="form-control">
                                        <option value="">Select Book Type</option>
                                        @foreach($bookTypes as $bookType)
                                            <option value="{{ $bookType->id }}" {{ $product->book_type_id == $bookType->id ? 'selected' : '' }}>
                                                {{ $bookType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option {{$product->status ==1?'selected':''}} value="1">Active</option>
                                        <option {{$product->status ==0?'selected':''}} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3"><i class="fa fa-user"></i> Author </h2>
                                <div class="mb-3">
                                    <label for="author">Author</label>
                                    <select name="author_id" id="author" class="form-control">
                                        <option value="">Select an Author</option>
                                        @if(!$authors->isEmpty())
                                            @foreach($authors as $author)
                                                <option value="{{ $author->id }}" {{ $author->id == $product->author_id ? 'selected' : '' }}>
                                                    {{ $author->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('author_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @foreach($categories as $category)
                                            <option {{($product->category_id==$category->id)?'selected':''}} value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Sub category</label>
                                    <select name="sub_category_id" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category </option>
                                        @if($categories->isNotEmpty())
                                            @foreach($subCategories as $subCategory)
                                                <option {{($product->sub_category_id==$subCategory->id)?'selected':''}} value="{{ $subCategory->id }}" {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured Product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option {{$product->is_featured =="Yes"?'selected':''}} value="Yes">Active</option>
                                        <option {{$product->is_featured =="No"?'selected':''}} value="No">Block</option>
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
                                    @if($product->ebookss)
                                        <div class="ebook-container">
                                            <i class="fas fa-book"></i>
                                            {{$product->title}}
                                            <button class="delete-ebook" data-ebook-id="{{$product->ebookss->id}}"><i class="fas fa-trash text-danger"></i></button>
                                        </div>
                                    @endif
                                    @error('ebook')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ebook_price">E-Book Price</label>
                                    <input type="number" name="ebook_price" id="ebook_price" class="form-control" placeholder="Enter Ebook Price" value="{{ $product->ebook_price ?? '' }}">
                                    @error('ebook_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ebook_compare_price">E-Book Compare at Price</label>
                                    <input type="number" name="ebook_compare_price" id="ebook_compare_price" class="form-control" placeholder="Enter Ebook Compare Price"` value="{{ $product->ebook_compare_price ?? '' }}">
                                    @error('ebook_compare_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Edit</button>
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
        $('.related-product').select2({
            ajax: {
                url: '{{ route('products.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
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
        $(document).ready(function() {
            $('.delete-image').click(function() {
                var imageId = $(this).data('image-id');
                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: '{{ route("delete-image") }}',
                        method: 'DELETE',
                        data: {
                            image_id: imageId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
        // Define a function to handle the visibility of the eBook upload container
        function handleEbookUploadContainer() {
            var bookTypeId = document.getElementById('book_type_id').value;
            var ebookUploadContainer = document.getElementById('ebook_upload_container');
            var paperBackPrice = document.getElementById('paperback_price')
            var trackQty =  document.getElementById('trackQty')

            if (bookTypeId === '1' || bookTypeId === '3') { // Digital or Both
                ebookUploadContainer.style.display = 'block';
            } else {
                ebookUploadContainer.style.display = 'none';
            }
            if(bookTypeId ==='2'  || bookTypeId === '3') {//Paper or Both
                paperBackPrice.style.display = 'block';
                trackQty.style.display = 'block';
            }else{
                paperBackPrice.style.display='none';
                trackQty.style.display='none';
            }
        }

        // Add event listener for the change event of the book_type_id select element
        document.getElementById('book_type_id').addEventListener('change', handleEbookUploadContainer);

        // Call the function to handle the visibility of the eBook upload container when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            handleEbookUploadContainer();
        });
        $(document).ready(function() {
            $('.delete-ebook').click(function() {
                var ebookId = $(this).data('ebook-id');
                if (confirm('Are you sure you want to delete this ebook?')) {
                    $.ajax({
                        url: '{{ route("delete-ebook") }}',
                        method: 'DELETE',
                        data: {
                            ebookId:ebookId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.ebook-container').remove(); // Remove the ebook container if the deletion was successful
                            } else {
                                // Handle the case where the deletion was not successful (optional)
                                console.error('Failed to delete ebook:', response.message);
                            }
                        },
                    });
                }
            });
        });


    </script>
@endsection

