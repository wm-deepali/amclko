@extends('front.partials.app')

<style>
    /* ===== AMC COURSES SECTION - FULLY CUSTOM & OVERRIDE-PROOF ===== */
    .amc-course-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .amc-course-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .amc-course-title h2 {
        font-size: 38px;
        font-weight: 700;
        color: #0A1D56;
        margin: 0 0 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .amc-divider {
        width: 80px;
        height: 4px;
        background: #FF6B35;
        margin: 0 auto;
        border: none;
        border-radius: 2px;
    }

    /* Course Card */
    .amc-course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
        transition: all 0.4s ease;
        margin-bottom: 30px;
        height: auto;
        display: grid;
        grid-template-columns: 2fr 10fr;
    }

    .amc-course-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(10, 29, 86, 0.18);
    }

    .amc-course-image {
        width: 100%;
        height: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .amc-course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .amc-course-card:hover .amc-course-image img {
        transform: scale(1.1);
    }

    .amc-course-content {
        padding: 25px;
        flex-grow: 1;
    }

    .amc-course-content h3 {
        margin: 0 0 15px;
        font-size: 20px;
        font-weight: 600;
        color: #0A1D56;
        line-height: 1.4;
    }

    .amc-course-content h3 a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s;
    }

    .amc-course-content h3 a:hover {
        color: #FF6B35;
    }

    .amc-course-content p {
        color: #555;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }

    .amc-course-footer {
        padding: 0 25px 25px;
    }

    .amc-read-more-btn {
        display: inline-block;
        background: #FF6B35;
        color: white;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    .amc-read-more-btn:hover {
        background: #e55a30;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
        color: white;
    }

    .amc-read-more-btn i {
        margin-left: 8px;
        font-size: 14px;
    }

    /* View All Button */
    .amc-view-all-btn {
        display: inline-block;
        background: #0A1D56;
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 17px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.4s;
        box-shadow: 0 8px 20px rgba(10, 29, 86, 0.3);
    }

    .amc-view-all-btn:hover {
        background: #FF6B35;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .amc-course-title h2 {
            font-size: 32px;
        }

        .amc-course-card {
            margin-bottom: 25px;
        }
    }

    /* ===== AMC INTRODUCTION SECTION - PREMIUM & FIXED ===== */
    .amc-intro-section {
        padding: 100px 0;
        background: #ffffff;
        overflow: hidden;
    }

    .amc-intro-row {
        margin: 0;
    }

    .amc-intro-content {
        padding-right: 40px;
    }

    .amc-intro-title {
        font-size: 38px;
        font-weight: 700;
        color: #0A1D56;
        margin: 0 0 20px;
        line-height: 1.3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .amc-divider {
        width: 80px;
        height: 5px;
        background: #FF6B35;
        border: none;
        margin: 25px 0 30px;
        border-radius: 3px;
    }

    .amc-intro-text {
        font-size: 17px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 35px;
        text-align: justify;
    }

    /* Read More Button */
    .amc-readmore-btn {
        display: inline-block;
        background: #FF6B35;
        color: white;
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.35);
    }

    .amc-readmore-btn:hover {
        background: #e55a30;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 107, 53, 0.5);
        color: white;
    }

    .amc-readmore-btn i {
        margin-left: 10px;
        font-size: 14px;
    }

    /* Image with Hover Effect */
    .amc-intro-image-wrapper {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        /*box-shadow: 0 15px 40px rgba(10, 29, 86, 0.2);*/
        transition: all 0.5s ease;
    }

    .amc-intro-img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.6s ease;
    }

    .amc-intro-image-wrapper:hover .amc-intro-img {
        transform: scale(1.08);
    }

    .amc-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(10, 29, 86, 0.1), rgba(255, 107, 53, 0.2));
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .amc-intro-image-wrapper:hover .amc-image-overlay {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .amc-intro-content {
            padding-right: 0;
            margin-bottom: 40px;
            text-align: center;
        }

        .amc-divider {
            margin: 25px auto;
        }

        .amc-readmore-wrapper {
            text-align: center;
        }

        .amc-intro-image-wrapper {
            max-width: 400px;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .amc-intro-title {
            font-size: 30px;
        }

        .amc-intro-text {
            font-size: 16px;
        }
    }

    /* ===== AMC ABOUT US SECTION - PREMIUM DESIGN ===== */
    .amc-about-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .amc-about-row {
        margin: 0;
    }

    .amc-about-content {
        padding-left: 30px;
    }

    .amc-about-title {
        font-size: 38px;
        font-weight: 700;
        color: #0A1D56;
        margin: 0 0 20px;
        line-height: 1.3;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .amc-divider {
        width: 90px;
        height: 5px;
        background: #FF6B35;
        border: none;
        margin: 25px 0 35px;
        border-radius: 3px;
    }

    .amc-about-text {
        font-size: 17px;
        line-height: 1.8;
        color: #444;
        margin-bottom: 40px;
        text-align: justify;
    }

    /* View More Button (Right Aligned) */
    .amc-about-readmore {
        text-align: right;
    }

    .amc-readmore-btn {
        display: inline-block;
        background: #0A1D56;
        color: white;
        padding: 14px 38px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(10, 29, 86, 0.3);
    }

    .amc-readmore-btn:hover {
        background: #FF6B35;
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 107, 53, 0.4);
        color: white;
    }

    .amc-readmore-btn i {
        margin-left: 10px;
        font-size: 14px;
    }

    /* Image with Hover Effect */
    .amc-about-image-wrapper {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(10, 29, 86, 0.22);
        transition: all 0.5s ease;
    }

    .amc-about-img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.6s ease;
    }

    .amc-about-image-wrapper:hover .amc-about-img {
        transform: scale(1.1);
    }

    .amc-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(10, 29, 86, 0.15), rgba(255, 107, 53, 0.25));
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .amc-about-image-wrapper:hover .amc-image-overlay {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .amc-about-content {
            padding-left: 0;
            text-align: center;
            margin-top: 40px;
        }

        .amc-about-readmore {
            text-align: center;
        }

        .amc-divider {
            margin: 25px auto;
        }
    }

    @media (max-width: 768px) {
        .amc-about-title {
            font-size: 30px;
        }

        .amc-about-text {
            font-size: 16px;
        }
    }

    /* ===== AMC GALLERY SECTION - PREMIUM DESIGN ===== */
    .amc-gallery-section {
        padding: 100px 0;
        background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
    }

    .amc-gallery-title {
        text-align: center;
        margin-bottom: 60px;
    }

    .amc-gallery-title h2 {
        font-size: 42px;
        font-weight: 700;
        color: #0A1D56;
        margin: 0 0 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .amc-gallery-title p {
        font-size: 18px;
        color: #666;
        margin: 0;
    }

    /* Divider */
    .amc-divider {
        width: 100px;
        height: 5px;
        background: #FF6B35;
        margin: 20px auto;
        border-radius: 3px;
    }

    /* Gallery Item */
    .amc-gallery-item {
        padding: 15px;
    }

    .amc-gallery-image-wrapper {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(10, 29, 86, 0.15);
        transition: all 0.5s ease;
        cursor: pointer;
    }

    .amc-gallery-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .amc-gallery-image-wrapper:hover .amc-gallery-img {
        transform: scale(1.15);
    }

    .amc-gallery-image-wrapper:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(10, 29, 86, 0.25);
    }

    /* Overlay Effect */
    .amc-gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(10, 29, 86, 0.7), rgba(255, 107, 53, 0.6));
        opacity: 0;
        transition: opacity 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .amc-gallery-image-wrapper:hover .amc-gallery-overlay {
        opacity: 1;
    }

    .amc-gallery-icon {
        color: white;
        font-size: 36px;
        background: rgba(255, 255, 255, 0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s;
    }

    .amc-gallery-image-wrapper:hover .amc-gallery-icon {
        transform: scale(1.2);
    }

    /* Owl Carousel Custom Navigation */
    .amc-gallery-carousel .owl-nav {
        margin-top: 30px;
        text-align: center;
    }

    .amc-gallery-carousel .owl-prev,
    .amc-gallery-carousel .owl-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #0A1D56 !important;
        color: white !important;
        width: 55px;
        height: 55px;
        border-radius: 50% !important;
        font-size: 24px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(10, 29, 86, 0.4) !important;
        transition: all 0.4s !important;
    }

    .amc-gallery-carousel .owl-prev {
        left: -80px;
    }

    .amc-gallery-carousel .owl-next {
        right: -80px;
    }

    .amc-gallery-carousel .owl-prev:hover,
    .amc-gallery-carousel .owl-next:hover {
        background: #FF6B35 !important;
        transform: translateY(-50%) scale(1.1);
    }

    /* Dots */
    .amc-gallery-carousel .owl-dots {
        margin-top: 20px;
        text-align: center;
    }

    .amc-gallery-carousel .owl-dot span {
        background: #ccc !important;
        width: 12px !important;
        height: 12px !important;
        margin: 0 6px !important;
        border-radius: 50% !important;
    }

    .amc-gallery-carousel .owl-dot.active span {
        background: #FF6B35 !important;
        width: 14px !important;
        height: 14px !important;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .amc-gallery-carousel .owl-prev {
            left: -50px;
        }

        .amc-gallery-carousel .owl-next {
            right: -50px;
        }
    }

    @media (max-width: 992px) {

        .amc-gallery-carousel .owl-prev,
        .amc-gallery-carousel .owl-next {
            width: 45px;
            height: 45px;
            font-size: 20px;
        }

        .amc-gallery-carousel .owl-prev {
            left: 10px;
        }

        .amc-gallery-carousel .owl-next {
            right: 10px;
        }
    }

    .amc-course-content h3 a:hover {
        color: #000 !important;
    }
</style>
@section('content')

    <!----------------------------Slider Start--------------------------->
    <div class="slider">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($sliders as $key => $slider)
                    <li data-target="#myCarousel" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}">
                    </li>
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">

                @foreach($sliders as $key => $slider)
                    <div class="item {{ $key === 0 ? 'active' : '' }}">
                        <div class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">
                            <img src="{{ asset('storage/' . $slider->thumb_image) }}" alt="Chania">
                        </div>

                        {{--
                        <div class="carousel-caption">
                            <h3>Chania</h3>
                            <p>The atmosphere in Chania has a touch of Florence and Venice.</p>
                        </div>
                        --}}
                    </div>
                @endforeach

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>


    {{-- ================= MARQUEE ================= --}}
    <div class="content">
        <div class="container">
            <div class="simple-marquee-container">
                <div class="marquee-sibling">
                    <div class="latest">Latest News</div>
                </div>
                <div class="news">
                    <div class="marquee">
                        <ul class="marquee-content-items">
                            <li>Welcome to the Academy of Mass Communication</li>
                            <li>Admission Open for 2025 - 2026 Batch</li>
                            <li>Stay tuned for Upcoming programmes in 2026</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!----------------------------Introduction Start--------------------------->

<div class="amc-intro-section">

    @foreach($backgrounds as $background)

        <div class="container">
            <div class="row align-items-center amc-intro-row">

                <!-- Text Content -->
                <div class="col-lg-8 col-md-7">
                    <div class="amc-intro-content">
                        <h2 class="amc-intro-title">
                            {{ $background->title }}
                        </h2>

                        <hr class="amc-divider">

                        <div class="amc-intro-text">
                            {{ \Illuminate\Support\Str::limit(strip_tags($background->content), 590, '...') }}
                        </div>

                        <div class="amc-readmore-wrapper">
                            <a href="{{ url('background') }}" class="amc-readmore-btn">
                                Read More <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="col-lg-4 col-md-5 text-center">
                    <div class="amc-intro-image-wrapper">
                        <img
                            src="{{ asset('storage/'.$background->image) }}"
                            alt="{{ $background->title }}"
                            class="amc-intro-img">

                        <div class="amc-image-overlay"></div>
                    </div>
                </div>

            </div>
        </div>

    @endforeach

</div>

<!----------------------------Introduction End--------------------------->


    <!----------------------------Our Feature Start--------------------------->
<div class="amc-course-section">
    <div class="amc-course-title">
        <h2>Programmes</h2>
        <hr class="amc-divider">
    </div>

    <div class="container">
        <div class="row">

            @forelse($programs as $program)
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">

                        <div class="amc-course-image col-3">
                            <img src="{{ asset('storage/'.$program->thumbnail) }}"
                                 alt="{{ $program->title }}"
                                 class="img-responsive">
                        </div>

                        <div class="amc-course-content col-7">
                            <h3>
                                <a href="{{ route('program.detail', $program->id) }}">
                                    {{ $program->title }}
                                </a>
                            </h3>

                            <p>
                                {{ \Illuminate\Support\Str::limit($program->short_description, 750) }}
                            </p>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    No programs available.
                </div>
            @endforelse

        </div>

        {{-- VIEW ALL --}}
        <div class="amc-view-all text-center" style="margin-top: 40px;">
            <a href="{{ route('program') }}" class="amc-view-all-btn">
                <strong>View All Programmes</strong>
            </a>
        </div>
    </div>
</div>
<!----------------------------Our Feature End----------------------------->


    <!----------------------------About Us Start--------------------------->

    <div class="amc-about-section">

        @foreach($abouts as $about)
            <div class="container">
                <div class="row align-items-center amc-about-row">

                    <!-- Text Content (Left Side) -->
                    <div class="col-lg-7 col-md-7 order-lg-1 order-2">
                        <div class="amc-about-content">
                            <h2 class="amc-about-title">
                                {{ $about->title }}
                            </h2>

                            <hr class="amc-divider">

                            <div class="amc-about-text">
                                {{ \Illuminate\Support\Str::limit(strip_tags($about->content), 520, '...') }}
                            </div>

                            <div class="amc-about-readmore text-end">
                                <a href="{{ url('about-us') }}" class="amc-readmore-btn">
                                    View More <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Image (Right Side) -->
                    <div class="col-lg-5 col-md-5 order-lg-2 order-1 text-center mb-lg-0 mb-4">
                        <div class="amc-about-image-wrapper">
                            <img src="{{ asset('storage/' . $about->thumb_image) }}" alt="{{ $about->title }}" class="amc-about-img">

                            <div class="amc-image-overlay"></div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>


    <!----------------------------Our Gallery Start--------------------------->
    <div class="amc-gallery-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="amc-gallery-title">
                        <h2>Gallery</h2>
                        <hr class="amc-divider">
                        <p>Explore our campus, events, and student activities</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Owl Carousel Gallery -->
        <div class="amc-gallery-carousel owl-carousel owl-theme" id="amcGalleryCarousel">

            @foreach($galleries as $gallery)
                <div class="amc-gallery-item">
                    <div class="amc-gallery-image-wrapper">
                        <img src="{{ asset('storage/' . $gallery->thumb_image) }}" alt="AMC Gallery" class="amc-gallery-img">

                        <!-- Overlay with Zoom Icon -->
                        <div class="amc-gallery-overlay">
                            <div class="amc-gallery-icon">
                                <i class="fa fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#amcGalleryCarousel").owlCarousel({
                items: 4,
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 3 },
                    1200: { items: 4 }
                }
            });
        });
    </script>


@endsection