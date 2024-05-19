@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{route('front.processCheckout')}}" method="post">
                @csrf
                <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ !empty($user_info->first_name) ? $user_info->first_name : '' }}">
                                        @error('first_name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ !empty($user_info->last_name) ? $user_info->last_name : '' }}" >
                                        @error('last_name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}" readonly>
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="city_id" id="city" class="form-control">
                                            <option value="">Select a City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ $user_info && $city->id == $user_info->city_id ? 'selected' : '' }}>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ !empty($user_info->address) ? $user_info->address : '' }}</textarea>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ !empty($user_info->state) ? $user_info->state : '' }}" >
                                        @error('state')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ !empty($user_info->zip) ? $user_info->zip : '' }}" >
                                        @error('zip')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ !empty($user_info->mobile) ? $user_info->mobile : '' }}" >
                                        @error('mobile')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h3>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach(Cart::content() as $item)
                                <div class="d-flex justify-content-between pb-2">

                                    <div class="h6">{{$item->name}}  {{$item->options->type == 'ebook' ? '' :'X '. $item->qty}}
                                        <span class="badge bg-primary text-danger">{{$item->options->type}}</span>
                                    </div>
                                    <div class="h6">Rs{{$item->options->type == 'ebook' ? $item->price : $item->price * $item->qty}}</div>
                                </div>
                            @endforeach


                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>Rs{{Cart::subtotal()}}</strong></div>
                            </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Discount</strong></div>
                                    <div class="h6"><strong id="discount_amount">Rs{{number_format($discount,2)}}</strong></div>
                                </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="shippingAmount">Rs.{{number_format($totalShippingCharge,2)}}</strong></div>
                            </div>

                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">Rs.{{number_format($grandTotal,2)}}</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
                        <button class="btn btn-success" type="button" id="apply-discount">Apply Coupon</button>
                    </div >
                    <div id="discount-wrapper">
                        @if(\Illuminate\Support\Facades\Session::has('code'))
                            <div class="apply-coupan mt-4" id="discount-row">
                                <strong>{{\Illuminate\Support\Facades\Session::get('code')->code}}</strong>
                                <a  class="btn btn-sm btn-danger ml-2" id="remove-discount"><i class="fa fa-times"></i> </a>
                            </div>
                        @endif
                    </div>


                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Method</h3>
{{--                        <div class="">--}}
{{--                            <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">--}}
{{--                            <label for="payment_method_one" class="form-check-label">Cash on Delivery</label>--}}
{{--                        </div>--}}
                        <div class="">
                            <input type="radio" name="payment_method" value="esewa" id="payment_method_two">
                            <label for="payment_method_two" class="form-check-label">Esewa</label>
                        </div>
                        <div class="pt-4">
{{--                            <a href="#" >Pay Now</a>--}}
                            <button type="submit" class="btn-primary btn btn-block w-100">Pay Now</button>
                        </div>

                    </div>


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </div>
            </form>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        $(document).ready(function () {
            $('#payment_method_two').click(function () {
                $('#card-payment-form').removeClass('d-none');
            });
            $('#payment_method_one').click(function () {
                $('#card-payment-form').addClass('d-none');
            });
        });
        $("#city").change(function () {
            $.ajax({
                url: "{{route('front.getOrderSummary')}}",
                type: "POST",
                data: {
                    city_id: $(this).val(),
                    _token: "{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.status ==true) {
                        $('#shippingAmount').text('Rs'+ response.shippingCharge);
                        $('#grandTotal').text('Rs'+ response.grandTotal);



                    }
                }
            });
        });
        $('#apply-discount').click(function () {
            $.ajax({
                url: "{{route('front.applyDiscount')}}",
                type: "POST",
                data: {
                    code: $('#discount_code').val(),
                    city_id: $('#city').val(),
                    _token: "{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == true){
                        $('#shippingAmount').text('Rs.'+ response.shippingCharge);
                        $('#grandTotal').text('Rs.'+ response.grandTotal);
                        $('#discount_amount').text('Rs.'+ response.discount);
                        $('#discount-wrapper').html(response.discountString);
                    }else{
                        $('#discount-wrapper').html("<span class='text-danger'>"+response.message+"</span>");
                    }

                }
            });
        });
        $('body').on('click',"#remove-discount",function (){
            $.ajax({
                url: "{{route('front.removeDiscount')}}",
                type: "POST",
                data: {
                    city_id: $('#city').val(),
                    _token: "{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == true){
                        $('#shippingAmount').text('Rs.'+ response.shippingCharge);
                        $('#grandTotal').text('Rs.'+ response.grandTotal);
                        $('#discount_amount').text('Rs.'+ response.discount);
                        $('#discount-row').html('');
                        $('#discount_code').val('');

                    }

                }
            });
        });

    </script>
@endsection
