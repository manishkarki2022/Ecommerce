@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('admin.updatePassword')}}" method="post" >
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Old Password</label>
                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password">
                                    @error('old_password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">New Password</label>
                                    <input type="password"  name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                    @error('new_password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                                    @error('confirm_password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                        </div>
                    </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Change</button>
                            <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')

@endsection

