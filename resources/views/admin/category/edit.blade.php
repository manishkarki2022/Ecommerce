@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="categoryForm" name="categoryForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$category->name}}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$category->slug}}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{$category->status ==1?'selected':''}} value="1">Active</option>
                                        <option {{$category->status ==0?'selected':''}} value="0">Block</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="showHome">Show on Home</label>
                                        <select name="showHome" id="showHome" class="form-control">
                                            <option {{$category->showHome == 'Yes' ? 'selected' : ''}} value="Yes">Yes</option>
                                            <option {{$category->showHome == 'No' ? 'selected' : ''}} value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('#categoryForm').submit(function(event){
            event.preventDefault();
            var form = $(this);
            $("btton[type=submit]").prop('disabled', true);
            $.ajax({
                url: "{{route('categories.update',$category->id)}}",
                type: "PUT",
                data: form.serializeArray(),
                dataType: "json",
                success: function(response){
                    if(response['status'] == true){
                        $("button[type=submit]").prop('disabled', false);
                        window.location.href = "{{route('categories.index')}}";
                        $('#name').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors['name']);
                        $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');

                    }else{
                        var errors = response['error'];
                        if(errors['name']){
                            $('#name').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['name']);
                        }else{
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }
                        if(errors['slug']){
                            $('#slug').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['slug']);
                        }else{
                            $('#slug').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                        }

                    }

                },error:function(jqXHR,execption){
                    console.log("Something went wrong. Please try again later.");
                }
            });
        });
        $('#name').change(function(){
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
    </script>
@endsection

