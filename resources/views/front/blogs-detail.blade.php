@extends('front.partials.app')

@section('content')

<style>
.blog-detail-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ================= MAIN ================= */
.blog-main {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
    overflow: hidden;
}

.blog-banner img {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
}

.blog-content {
    padding: 30px;
}

.blog-content h1 {
    font-size: 30px;
    font-weight: 700;
    color: #0A1D56;
    margin-bottom: 8px;
}

.blog-date {
    font-size: 14px;
    color: #888;
    margin-bottom: 25px;
}

/* ================= HTML CONTENT ================= */
.blog-body {
    font-size: 15px;
    color: #444;
    line-height: 1.8;
}

.blog-body p {
    margin-bottom: 16px;
}

.blog-body h2,
.blog-body h3,
.blog-body h4 {
    margin: 25px 0 12px;
    color: #0A1D56;
    font-weight: 600;
}

.blog-body ul,
.blog-body ol {
    padding-left: 22px;
    margin-bottom: 16px;
}

.blog-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 15px 0;
}

/* ================= SIDEBAR ================= */
.blog-sidebar {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
    padding: 20px;
    position: sticky;
    top: 90px;
}

.blog-sidebar h4 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 18px;
    color: #0A1D56;
}

.blog-sidebar li {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    align-items: flex-start;
}

.blog-sidebar img {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
}

.blog-sidebar a {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    line-height: 1.4;
}

.blog-sidebar a:hover {
    color: #FF6B35;
}
</style>

<div class="blog-detail-section">
    <div class="container">
        <div class="row">

            {{-- LEFT : BLOG DETAIL --}}
            <div class="col-lg-9 col-md-8 mb-4">
                <div class="blog-main">

                    @if($blog->banner)
                        <div class="blog-banner">
                            <img src="{{ asset('storage/'.$blog->banner) }}"
                                 alt="{{ $blog->title }}">
                        </div>
                    @endif

                    <div class="blog-content">
                        <h1>{{ $blog->title }}</h1>

                        <div class="blog-date">
                            {{ $blog->created_at->format('d M, Y') }}
                        </div>

                        <div class="blog-body">
                            {!! $blog->content !!}
                        </div>
                    </div>

                </div>
            </div>

            {{-- RIGHT : LATEST BLOGS --}}
            <div class="col-lg-3 col-md-4">
                <div class="blog-sidebar">
                    <h4>Latest Blogs</h4>

                    <ul class="list-unstyled mb-0">
                        @foreach($latestBlogs as $item)
                            @if($item->id !== $blog->id)
                                <li>
                                    @if($item->thumbnail)
                                        <img src="{{ asset('storage/'.$item->thumbnail) }}"
                                             alt="{{ $item->title }}">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="">
                                    @endif

                                    <div>
                                        <a href="{{ route('blog.detail',$item->slug) }}">
                                            {{ \Illuminate\Support\Str::limit($item->title, 55) }}
                                        </a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
