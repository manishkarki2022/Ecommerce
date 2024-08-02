@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Blogs</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="py-1">
        <div class="container">
            <div class="row">
                <div class="row pb-4">
                    @if($blogs->isNotEmpty())
                        @foreach($blogs as $blog)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-3">
                                <div class="card h-100 shadow overflow-hidden">
                                    @if($blog->image)
                                        <img src="{{ asset('blogs/' . $blog->image) }}" class="card-img-top p-2 rounded-3 hoverCard" alt="{{ $blog->name }}" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="p-1">
                                        <p class="card-title">{{ $blog->name }}</p>
                                        <p class="text-muted small">Posted on {{ $blog->created_at->format('M d, Y') }}</p>
                                        <p class="text-muted small d-flex justify-content-between">
                                            <i class="fas fa-thumbs-up me-1"> {{ $blog->likes_count }} Likes</i>
                                            <i class="fas fa-comments me-1"> {{ $blog->comments->count() }} Comments</i>
                                        </p>
                                        <a href="{{ route('front.blog.show', $blog->slug) }}" class="btn btn-primary btn-sm w-100">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <p class="text-center">No blogs available.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
