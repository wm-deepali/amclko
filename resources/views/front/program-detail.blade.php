@extends('front.partials.app')

@section('content')

    <style>
        .program-detail-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ================= LEFT CONTENT ================= */
        .program-main {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
            overflow: hidden;
        }

        .program-banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .program-content {
            padding: 30px;
        }

        .program-content h2 {
            font-size: 30px;
            font-weight: 700;
            color: #0A1D56;
            margin-bottom: 12px;
        }

        .program-short {
            font-size: 16px;
            color: #555;
            font-weight: 500;
            margin-bottom: 30px;
            padding: 10px 0 15px;
            border-bottom: 1px solid #eee;
        }

        .program-detail {
            font-size: 15px;
            color: #444;
            line-height: 1.8;
        }

        .program-detail p {
            margin-bottom: 15px;
        }

        /* ================= RIGHT SIDEBAR ================= */
        .program-sidebar {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
            padding: 20px;
            position: sticky;
            top: 90px;
        }

        .program-sidebar h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px !important;
            color: #0A1D56;
        }

        .program-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .program-sidebar li {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .program-sidebar img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .program-sidebar .prog-info a {
            text-decoration: none;
            font-weight: 600;
            color: #333;
            display: block;
            font-size: 14px;
            line-height: 1.3;
        }

        .program-sidebar .prog-info a:hover,
        .program-sidebar li.active a {
            color: #FF6B35;
        }

        .program-sidebar .prog-info p {
            font-size: 12px;
            color: #666;
            margin: 3px 0 0;
            line-height: 1.4;
        }

        .gallery-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .gallery-filter-btn {
            padding: 8px 20px;
            border-radius: 30px;
            border: 1px solid #ddd;
            background: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .gallery-filter-btn.active,
        .gallery-filter-btn:hover {
            background: #FF6B35;
            color: #fff;
            border-color: #FF6B35;
        }

        .gallery-item {
            display: none;
        }

        .gallery-item.show {
            display: block;
        }
    </style>

    <div class="program-detail-section">
        <div class="container">
            <div class="row">

                {{-- LEFT : PROGRAM DETAIL --}}
                <div class="col-lg-9 col-md-8 mb-4">
                    <div class="program-main">

                        {{-- Banner --}}
                        @if($program->banner)
                            <div class="program-banner">
                                <img src="{{ asset('storage/' . $program->banner) }}" alt="{{ $program->title }}">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="program-content">
                            <h2>{{ $program->title }}</h2>

                            <p class="program-short">
                                {{ $program->short_description }}
                            </p>

                            <div class="program-detail">
                                {!! $program->detail_content !!}
                            </div>
                            {{-- ================= PROGRAM GALLERY ================= --}}
                            @if(isset($galleryCategories) && $galleryCategories->count())

                                <hr class="my-5">

                                <h3 style="color:#0A1D56;font-weight:700;margin-bottom:20px !important;">
                                    Program Gallery
                                </h3>

                                {{-- FILTER BUTTONS --}}
                                @if($galleryCategories->count() > 1)
                                    <div class="gallery-filters mb-4">
                                        <button class="gallery-filter-btn active" data-filter="all">
                                            All
                                        </button>

                                        @foreach($galleryCategories as $cat)
                                            <button class="gallery-filter-btn" data-filter="cat{{ $cat->id }}">
                                                {{ $cat->title }}
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- GALLERY GRID --}}
                                <div class="row">

                                    @foreach($galleryCategories as $cat)
                                        @foreach($cat->galleries as $img)
                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 gallery-item cat{{ $cat->id }} show">
                                                <div class="picture-border text-center">
                                                    <a href="{{ asset('storage/' . $img->image) }}" data-lightbox="program-gallery"
                                                        data-title="{{ $cat->title }}">

                                                        <img class="img-responsive img-rounded"
                                                            src="{{ asset('storage/' . $img->thumb_image) }}" alt="{{ $cat->title }}">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach

                                </div>
                            @endif

                        </div>

                    </div>
                </div>

                {{-- RIGHT : OTHER PROGRAMS --}}
                <div class="col-lg-3 col-md-4">
                    <div class="program-sidebar">
                        <h4>Other Programmes</h4>

                        <ul>
                            @forelse($otherPrograms as $item)
                                <li class="{{ $item->id == $program->id ? 'active' : '' }}">

                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}">

                                    <div class="prog-info">
                                        <a href="{{ route('program.detail', $item->id) }}">
                                            {{ $item->title }}
                                        </a>
                                        <p>
                                            {{ \Illuminate\Support\Str::limit($item->short_description, 60) }}
                                        </p>
                                    </div>

                                </li>
                            @empty
                                <li class="text-muted">No other programs</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {

                document.querySelectorAll('.gallery-filter-btn')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                const filter = btn.dataset.filter;

                document.querySelectorAll('.gallery-item').forEach(item => {
                    item.classList.remove('show');

                    if (filter === 'all' || item.classList.contains(filter)) {
                        setTimeout(() => item.classList.add('show'), 50);
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('assets/js/lightbox-plus-jquery.min.js') }}"></script>

@endsection