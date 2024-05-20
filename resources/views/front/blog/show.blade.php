@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('blogs.index') }}">Blogs</a></li>
                    <li class="breadcrumb-item active">{{ $blog->name }}</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div>
                        @if($blog->image)
                            <img src="{{ asset('blogs/' . $blog->image) }}" class="img-fluid rounded mb-3" alt="{{ $blog->name }}">
                        @endif
                        <h2>{{ $blog->name }}</h2>
                        <p>{{ $blog->excerpt }}</p>
                        <p class="text-muted">Posted on {{ $blog->created_at->format('M d, Y') }}</p>
                        <div>{!! $blog->content !!}</div>
                        <a href="{{ route('front.blog') }}" class="btn btn-primary btn-sm">Back to Blogs</a>

                        <!-- Like Section -->
                        <div class="mt-4">
                            <h4>Likes: <span id="likes-count">{{ $blog->likes_count }}</span></h4>
                            <form id="like-form" action="{{ route('front.blogs.like', $blog->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="button" class="btn btn-link p-0" style="border: none; background: none;">
                                    <i class="fas fa-thumbs-up fa-2x text-success"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Share Section -->
                        <div class="mt-4">
                            <div class="col-md-12 d-inline-flex">
                                <p class="mr-3 my-auto">Share this post on:</p>
                                <div class="btn-group btn-group-md" role="group" aria-label="Social Media Share Buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('front.blog.show', $blog->slug) }}" target="_blank" class="btn btn-primary" title="Share on Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ route('front.blog.show', $blog->slug) }}" target="_blank" class="btn btn-primary" title="Share on Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('front.blog.show', $blog->slug) }}" target="_blank" class="btn btn-primary" title="Share on LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ route('front.blog.show', $blog->slug) }}" target="_blank" class="btn btn-success" title="Share on WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="mailto:?subject=Check this out&body={{ route('front.blog.show', $blog->slug) }}" target="_blank" class="btn btn-danger" title="Share via Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="mt-4">
                            <h4>Comments</h4>
                            @foreach($blog->comments as $comment)
                                <div class="border p-2 mb-2">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p>{{ $comment->content }}</p>
                                    <small class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            @endforeach

                            @auth
                                <form action="{{ route('front.blogs.comment', $blog->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="form-group">
                                        <label for="content">Leave a comment:</label>
                                        <textarea name="content" id="content" class="form-control mb-2" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post Comment</button>
                                </form>
                            @else
                                <p class="mt-4">You need to <a href="{{ route('login') }}">login</a> to post a comment.</p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            $('#like-form button').click(function(e) {
                e.preventDefault();
                var form = $('#like-form');
                var url = form.attr('action');
                var token = $('input[name="_token"]').val();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#likes-count').text(response.likes_count);
                        }
                    },
                    error: function(response) {
                        console.log('Error:', response);
                    }
                });
            });
        });
    </script>
@endsection
