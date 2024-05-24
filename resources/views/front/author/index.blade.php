@extends('front.layouts.app')
    @section('content')
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Authors</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="py-1">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center  mb-5">Authors</h2>
                    </div>
                </div>
                <div class="row gx-3 ">
                    @foreach($authors as $author)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card h-100 hoverCard p-2 shadow">
                                <a href="{{route('front.author.show',$author->slug)}}" ><img src="{{ asset('authorImage/' . $author->id . '/' . $author->authorImage->first()->image) }}" class="card-img-top rounded-2" alt="{{$author->name}}" title="{{$author->names}}"  style="height: auto; object-fit: cover;" ></a>
                                <div class="card-body">
                                    <a href="{{route('front.author.show',$author->slug)}}" class="text-primary"><h5 class="card-title text-center" title="{{$author->name}}">{{ $author->name }}</h5></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endsection

