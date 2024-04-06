@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">{{$page->name}}</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10 mb-3">
        <div class="container">
            <h1 class="my-3">{{$page->name}}</h1>
            <div class="row">
                <div class="col-md-12 ">
                    {!! $page->contents !!}
                </div>
        </div>
    </section>

@endsection
