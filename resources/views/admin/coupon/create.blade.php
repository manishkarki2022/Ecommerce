@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Coupon Code</h1>
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
            <form action="{{route('coupons.store')}}" method="post"  >
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code" value="{{old('code')}}">
                                    @error('code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text"  name="name" id="name" class="form-control" placeholder="Coupon Code Name"value="{{old('name')}}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Max Uses</label>
                                    <input type="number"  name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses " value="{{old('max_uses')}}">
                                    @error('max_uses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Max Uses User</label>
                                    <input type="text"  name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses User" value="{{old('max_uses_user')}}">
                                    @error('max_uses_user')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percent</option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                    @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Discount Amount</label>
                                    <input type="text"  name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount " value="{{old('discount_amount')}}">
                                    @error('discount_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Min Amount</label>
                                    <input type="text"  name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount " value="{{old('min_amount')}}">
                                    @error('min_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Block</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Starts At</label>
                                    <input type="text"  name="start_at" id="start_at" class="form-control" placeholder="Start At " value="{{old('start_at')}}">
                                    @error('start_at')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Expires At</label>
                                    <input type="text"  name="expire_at" id="expire_at" class="form-control" placeholder="Expire At " value="{{old('expire_at')}}">
                                    @error('expire_at')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{old('description')}}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
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
        {{--$('#name').change(function(){--}}
        {{--    var element = $(this);--}}
        {{--    $("button[type=submit]").prop('disabled', true);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('getSlug') }}",--}}
        {{--        type: "GET",--}}
        {{--        data: { title: element.val() },--}}
        {{--        dataType: "json",--}}
        {{--        success: function(response){--}}
        {{--            $("button[type=submit]").prop('disabled', false);--}}
        {{--            if(response['slug'] !== undefined && response['slug'] !== ''){--}}
        {{--                $('#slug').val(response['slug']);--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
        $(document).ready(function(){
            $('#start_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });
        $(document).ready(function(){
            $('#expire_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });
    </script>

@endsection
