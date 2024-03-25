@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Management</h1>
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
            <form action="{{route('shipping.store')}}" method="post" id="categoryForm" name="categoryForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="city" id="city" class="form-control">
                                        <option value="">Select a City</option>
                                        @if(!empty($cities))
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                            <option value="rest_of_city">Rest of City*</option>
                                        @endif
                                    </select>
                                    @error('city')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter Amount" value="{{old('amount')}}">
                                    @error('amount')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                                @if(!empty($shippingCharges))
                                    @foreach($shippingCharges as $shippingCharge)
                                        <tr>
                                            <td>{{$shippingCharge->id}}</td>
                                            <td>{{($shippingCharge->city_id=='rest_of_city')?'Rest of City':$shippingCharge->name}}</td>


                                            <td>{{$shippingCharge->amount}}</td>
                                            <td>
                                                <a href="{{ route('shipping.edit', $shippingCharge->id) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('shipping.destroy', $shippingCharge->id) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>


                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')

@endsection

