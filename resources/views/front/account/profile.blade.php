@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('account.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <form action="{{route('account.updateProfile')}}" method="post">
                            @csrf
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control" value="{{$userinfo->name}}">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{$userinfo->email}}">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control" value="{{$userinfo->phone}}">
                                    @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="card mt-5">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Address Information</h2>
                        </div>
                        <form action="{{route('account.updateAddress')}}" method="post">
                            @csrf
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class=" col-md-6 mb-3">
                                        <label for="name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control" value="{{ $customerInfo ? $customerInfo->first_name : '' }}">
                                        @error('first_name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control" value="{{ $customerInfo ? $customerInfo->last_name : '' }}">
                                        @error('last_name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                        <input readonly hidden type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control" value="{{$userinfo->email}}">
                                    <div class="col-md-6 mb-3">
                                        <label for="Mobile">Mobile</label>
                                        <input type="text" name="mobile" id="mobile" placeholder="Enter Your Mobile" class="form-control" value="{{ $customerInfo ? $customerInfo->mobile : '' }}">
                                        @error('mobile')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city">City</label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{ isset($customerInfo) && $customerInfo->city_id == $city->id ? 'selected' : '' }}>
                                                    {{$city->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="Zip">Zip</label>
                                        <input type="text" name="zip" id="zip" placeholder="Enter Your Zip Code" class="form-control" value="{{ $customerInfo ? $customerInfo->zip : '' }}">
                                        @error('zip')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="State">State</label>
                                        <input type="text" name="state" id="state" placeholder="Enter Your State" class="form-control" value="{{ $customerInfo ? $customerInfo->state : '' }}">
                                        @error('state')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="Address">Address</label>
                                        <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ $customerInfo ? $customerInfo->state : '' }}</textarea>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-dark">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
