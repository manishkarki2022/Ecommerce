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
                <div class="row pb-4 p-2">
                    @if($blogs->isNotEmpty())
                        @foreach($blogs as $blog)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 hoverCard p-2 shadow">
                                    @if($blog->image)
                                        <img src="{{ asset('blogs/' . $blog->image) }}" class="card-img-top rounded-2" alt="{{ $blog->name }}" style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $blog->name }}</h6>
                                        <p class="card-text text-muted small">Posted on {{ $blog->created_at->format('M d, Y') }}</p>
                                        <p class="card-text text-muted small">
                                            <i class="fas fa-thumbs-up"></i> {{ $blog->likes_count }} Likes
                                            <i class="fas fa-comments"></i> {{ $blog->comments->count() }} Comments
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('front.blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">Read More</a>
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
