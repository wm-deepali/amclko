@extends('front.partials.app')

@section('content')

<style>
.blog-page {
    padding: 70px 0;
    background: #f9fafc;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.blog-header {
    text-align: center;
    margin-bottom: 50px;
}

.blog-header h2 {
    font-size: 36px;
    font-weight: 700;
    color: #0A1D56;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(320px,1fr));
    gap: 30px;
}

/* BLOG CARD */
.blog-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
    transition: .3s ease;
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(0,0,0,.15);
}

.blog-thumb img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.blog-body {
    padding: 22px;
    flex-grow: 1;
}

.blog-body h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #0A1D56;
}

.blog-body h3 a {
    text-decoration: none;
    color: inherit;
}

.blog-body h3 a:hover {
    color: #FF6B35;
}

.blog-date {
    font-size: 13px;
    color: #888;
    margin-bottom: 12px;
}

.blog-body p {
    font-size: 15px;
    color: #555;
    line-height: 1.6;
}

.blog-footer {
    padding: 0 22px 20px;
}

.blog-footer a {
    font-size: 14px;
    font-weight: 600;
    color: #FF6B35;
    text-decoration: none;
}
</style>

<div class="about-banner mb-4">
    <!-- <img src="{{ asset('images/about-banner.jpg') }}" class="img-responsive"> -->
</div>

<div class="blog-page">
    <div class="container">

        <div class="blog-header">
            <h2>Blogs</h2>
        </div>

        <div class="blog-grid">

            @forelse($blogs as $blog)
                @php
                    $excerpt = \Illuminate\Support\Str::limit(
                        trim(preg_replace('/\s+/', ' ',
                            strip_tags(html_entity_decode($blog->content))
                        )), 130
                    );
                @endphp

                <div class="blog-card">

                    @if($blog->thumbnail)
                        <div class="blog-thumb">
                            <img src="{{ asset('storage/'.$blog->thumbnail) }}"
                                 alt="{{ $blog->title }}">
                        </div>
                    @endif

                    <div class="blog-body">
                        <h3>
                            <a href="{{ route('blog.detail',$blog->slug) }}">
                                {{ $blog->title }}
                            </a>
                        </h3>

                        <div class="blog-date">
                            {{ $blog->created_at->format('d M, Y') }}
                        </div>

                        <p>{{ $excerpt }}</p>
                    </div>

                    <div class="blog-footer">
                        <a href="{{ route('blog.detail',$blog->slug) }}">
                            Read More →
                        </a>
                    </div>

                </div>
            @empty
                <div class="text-center text-muted">
                    No blogs available.
                </div>
            @endforelse

        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $blogs->links() }}
        </div>

    </div>
</div>

@endsection
