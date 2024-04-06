@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Reset Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="{{route('front.processResetPassword')}}" method="post">
                    @csrf
                    <h4 class="modal-title">Reset Password</h4>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="New Password"  name="new_password" >
                        @error('new_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password"  name="confirm_password" >
                        @error('confirm_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <input type="text" hidden value="{{$token}}" name="reset_token">

                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">
                </form>
                <div class="text-center small"> <a href="{{route('account.login')}}">Click here to Login</a></div>
            </div>
        </div>
    </section>
@endsection
