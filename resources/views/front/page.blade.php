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
@if($page->slug == 'contact-us')
    <section class="section-10">
        <div class="container">
            <div class="section-title mt-5">
                <h3>{{$page->name}}</h3>
            </div>
        </div>
    </section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-3 pe-lg-5">
                    {!! $page->contents !!}
                </div>

                <div class="col-md-6">
                    <form action="{{route('front.sendContactEmail')}}" class="shake" role="form" method="post" id="contactForm" name="contact-form">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-2" for="name">Name</label>
                            <input class="form-control" id="name" type="text" name="name"  data-error="Please enter your name">
                           @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2" for="email">Email</label>
                            <input class="form-control" id="email" type="email" name="email"  data-error="Please enter your Email">
                            @error('email')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Subject</label>
                            <input class="form-control" id="msg_subject" type="text" name="subject" data-error="Please enter your message subject">
                           @error('subject')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="mb-2">Message</label>
                            <textarea class="form-control" rows="3" id="message" name="message"  data-error="Write your message"></textarea>
                          @error('message')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-submit">
                            <button class="btn btn-dark" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@else
    <section class="section-10 mb-3">
        <div class="container">
            <h1 class="my-3">{{$page->name}}</h1>
            <div class="row">
                <div class="col-md-12 ">
                    {!! $page->contents !!}
                </div>
            </div>
        </div>
    </section>
@endif

@endsection

