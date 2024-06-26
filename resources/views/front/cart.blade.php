@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                @if($cartItems->isEmpty())
                    <div class="col-md-12 mb-2">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-middle ">

                                    <h2>Your Cart is Empty!!</h2>

                            </div>
                        </div>
                    </div>
                @else
                <div class="col-md-8">
                    <div class="table-responsive">

                        <table class="table" id="cart">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($cartItems))
                                @foreach($cartItems as $cartItem)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($cartItem->options->images !==null)
                                                    <img src="{{ asset('products/' . $cartItem->options->images->image) }}" width="" height="">
                                                @else
                                                    <img src="{{ asset('products/di.jpg') }}" width="" height="">
                                                @endif
                                                <h2>{{$cartItem->name}}</h2>
                                            </div>
                                        </td>
                                        <td>{{$cartItem->options->type == 'ebook' ? 'eBook' : 'paperback'}}</td>
                                        <td>Rs.{{$cartItem->price}}</td>
                                        <td>
                                            @if($cartItem->options->type == 'ebook')
                                                Not Available
                                            @else
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{$cartItem->rowId}}">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm border-0 text-center" value="{{$cartItem->qty}}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{$cartItem->rowId}}">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($cartItem->options->type == 'ebook')
                                                Rs.{{$cartItem->price}}
                                            @else
                                            Rs.{{$cartItem->price * $cartItem->qty}}
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="deleteItem('{{ $cartItem->rowId }}');"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>



                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="card-body">
                            <div class="sub-title">
                                <h3 class="bg-white">Cart Summery</h3>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>Rs.{{Cart::subtotal()}}</div>
                            </div>
                            <div class="pt-2">
                                <a href="{{route('front.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
{{--                    <div class="input-group apply-coupan mt-4">--}}
{{--                        <input type="text" placeholder="Coupon Code" class="form-control">--}}
{{--                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>--}}
{{--                    </div>--}}
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        $('.add').click(function(){
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);
                var rowId = $(this).data('id');
                var newQty=qtyElement.val();
                updateCart(rowId, newQty);
            }
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);
                var rowId = $(this).data('id');
                var newQty=qtyElement.val();
                updateCart(rowId, newQty);
            }
        });
        function updateCart(rowId, qty){
            $.ajax({
                url:'{{route("front.updateCart")}}',
                type:'POST',
                data:{
                    rowId:rowId,
                    qty:qty
                },
                dataType:'json',
                success:function(response){
                  if(response.status==true){
                     window.location.href = "{{route('front.cart')}}";
                  }
                    if(response.status==false){
                        window.location.href = "{{route('front.cart')}}";
                    }
                }

            })

        }
        function deleteItem(rowId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("front.deleteItemCart") }}',
                        type: 'DELETE',
                        data: {
                            rowId: rowId,
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'Your item has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.href = "{{ route('front.cart') }}";
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting your item.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
