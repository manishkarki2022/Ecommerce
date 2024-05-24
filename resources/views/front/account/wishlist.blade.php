@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('account.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Wishlist</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>
                        <div class="card-body p-4">
                            @if($wishlists->count() > 0)
                                @foreach($wishlists as $item)
                                    <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                        <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{route('front.product',$item->product->slug)}}" style="width: 10rem;">
                                                @if(($item->product->images!==null))
                                                    <img src="{{asset('products/'.$item->product->images->first()->image)}}" alt="{{$item->product->title}}"></a>
                                            @else
                                                <img src="{{asset('products/di.jpg')}}" alt="{{$item->product->title}}"></a>
                                            @endif
                                            <div class="pt-2">
                                                <h3 class="product-title fs-base mb-2"><a href="{{route('front.product',$item->product->slug)}}">{{$item->product->title}}</a></h3>
                                                <div class="fs-lg text-accent pt-2">Rs{{(number_format($item->product->price,2))}}</div>
                                            </div>
                                        </div>
                                        <form id="removeForm_{{$item->product->id}}" action="{{ route('front.deleteWishlist', $item->product->id) }}" method="post" onsubmit="event.preventDefault(); confirmDeletion({{$item->product->id}});">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="product_id" value="{{$item->product->id}}">
                                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                                    <i class="fas fa-trash-alt me-2"></i>Remove
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">No items found in wishlist</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        function confirmDeletion(productId) {
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
                    document.getElementById('removeForm_' + productId).submit();
                }
            });
        }
    </script>

@endsection
