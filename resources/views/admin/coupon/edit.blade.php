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
            <form action="{{ route('coupons.update', $discount->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code" value="{{ $discount->code }}">
                                    @error('code')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Coupon Code Name" value="{{ $discount->name }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses">Max Uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses" value="{{ $discount->max_uses }}">
                                    @error('max_uses')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses_user">Max Uses User</label>
                                    <input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max Uses User" value="{{ $discount->max_uses_user }}">
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
                                        <option value="percentage" {{ $discount->type == 'percentage' ? 'selected' : '' }}>Percent</option>
                                        <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>
                                    @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount Amount" value="{{ $discount->discount_amount }}">
                                    @error('discount_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_amount">Min Amount</label>
                                    <input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount" value="{{ $discount->min_amount }}">
                                    @error('min_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $discount->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $discount->status == '0' ? 'selected' : '' }}>Block</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_at">Starts At</label>
                                    <input type="text" autocomplete="off" name="start_at" id="start_at" class="form-control" placeholder="Starts At" value="{{ $discount->start_at }}">
                                    @error('start_at')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expire_at">Expires At</label>
                                    <input type="text" autocomplete="off" name="expire_at" id="expire_at" class="form-control" placeholder="Expires At" value="{{ $discount->expire_at }}">
                                    @error('expire_at')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ $discount->description }}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
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
