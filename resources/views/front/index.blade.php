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

                <!-- Static Card 1 -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image col-3">
                            <img src="{{ asset('images/computer-training.jpeg') }}"
                                alt="Diploma in Functional Arabic" class="img-responsive">
                        </div>
                        <div class="amc-course-content col-7">
                            <h3><a href="">Computer Training Program </a></h3>
                            <p>Computers have become essential in today's world. Computer technology is used across nearly
                                every industry, and computer literacy significantly improves employment opportunities. Our
                                mission is to spread computer education as widely as possible. We offer various computer
                                training programs, including diploma courses in Professional DTP, CCC, Office Automation,
                                Tally, Graphic Design, and others like CorelDraw, Photoshop, Hardware, and MS Office. We
                                train students to face competitive environments and become self-sufficient. Every financial
                                year, we select 30 deserving youth from underprivileged backgrounds to receive three months
                                of software training. The curriculum includes Computer Fundamentals, MS Office, DTP,
                                Internet Concepts, and Soft Skills. </p>
                        </div>

                    </div>
                </div>

                <!-- Static Card 2 -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/graphics.jpeg') }}"
                                alt="Diploma in Urdu Language" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Calligraphy and Graphic Design training </a></h3>
                            <p>AMC runs a Calligraphy and Graphic Design Course financial acceptance by the National Council
                                Promotion for the Urdu Language
                                Calligraphy is the art of beautiful handwriting, created by hand using flat calligraphy
                                pens. It encompasses a wide variety of writing styles that require patience, practice, and
                                perseverance to master. it has been offering comprehensive classes for both male and female
                                students. In addition to regular training sessions, the center also hosts workshops focused
                                on traditional calligraphy techniques applied to materials such as pottery, glass, and more.
                                This course is perfect for anyone passionate about combining artistic expression with
                                cultural heritage through the timeless beauty of calligraphy. </p>
                        </div>

                    </div>
                </div>

                <!-- Static Card 3 -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Diploma in Fashion Designing"
                                class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Urdu and Arabic Diploma Course</a></h3>
                            <p>we offer One year diploma in Urdu language, and Two years “Diploma in Functional Arabic “
                                [financially assisted by National Council for promotion of Urdu Language, Ministry of Human
                                resources Development, government of India. </p>
                        </div>

                    </div>
                </div>

                <!-- Static Card 4 -->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Road Safety Program </a></h3>
                            <p>Transportation is a vital part of life but comes with risks if road safety education is
                                lacking. To promote awareness, AMC conducts workshops to educate the public on traffic rules
                                and the staggering statistics of road accidents.
                                Mr. Mohsin Khan stated, "Let us not become our own enemies on the road but work together to
                                develop our knowledge and attitude as our road infrastructure improves." He added, "It's our
                                duty to reduce road casualties as much as possible." This program attracts hundreds of
                                participants, including young children who also participate in a drawing competition. Prizes
                                are awarded, and a book on traffic rules is distributed.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Hygiene and Sanitation </a></h3>
                            <p>Clean drinking water, hygiene, and sanitation are vital for health. AMC organized camps in
                                the slum areas of Old Lucknow and Malihabad to raise awareness about waterborne diseases
                                like diarrhea caused by contaminated water. The program emphasized health and hygiene
                                education to contribute to social and economic.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Seminar - Urdu Ek Bhuli Si Dastaan </a></h3>
                            <p>In collaboration with Aadaab Arz Lucknow, AMC hosted a tribute to legendary poet Jaun Elia.
                                The event promoted the importance of reviving Urdu in daily use. Syed Shoeb, former chairman
                                of the Waqf Board, said, "Urdu must be used in everyday life to protect it." Dr. Sabra Habib
                                emphasized that Urdu, once a global language, should not be associated with a single
                                community. — also attended the program. A calligraphy exhibition by students added depth to
                                the event. The seminar highlighted Urdu's universal relevance and the need to preserve its
                                cultural heritage.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">International Yoga Day </a></h3>
                            <p>Celebrated enthusiastically by AMC students and staff, the event began with warm-up
                                exercises, followed by sitting and standing asanas. The importance of each posture was
                                explained. Mr. Ashish Shukla encouraged regular yoga for improved physical, mental, and
                                spiritual well-being.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Art and Craft Workshop </a></h3>
                            <p>AMC regularly organizes art exhibitions and competitions to discover and promote student
                                creativity. Both internal and external participants display work in forms such as pictorial,
                                decorative, and performing arts. We run a handicraft training center at our registered
                                office, offering skills like making jute bags, wall hangings, baskets, and chikan
                                embroidery. This training helps artisans earn livelihoods and gain recognition.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Skill Training for Minorities </a></h3>
                            <p>With increasing competition and declining job opportunities, many youth experience
                                frustration. Women, in particular, often lack access to education and work, making them
                                dependent. AMC provides vocational training in stitching, embroidery (including zardozi),
                                and other craft skills. This initiative empowers women with sustainable employmer mproves
                                their economic conditions and enhances their quality of living.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Consumer Awareness Program </a></h3>
                            <p>AMC launched a campaign to raise awareness about consumer rights. With an overwhelming number
                                of products on the market, many consumers fall victim to malpractices. Our campaign
                                emphasized the right to ask questions, compare options, and demand accountability. We
                                encouraged people to speak out against fraud and demand fair value for their money.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Women Entrepreneurship </a></h3>
                            <p>Our Livelihoods & Craft Entrepreneurship Program trains economically weaker women in
                                handicrafts, calligraphy, and art to help them establish small businesses. At the Mahindra
                                Sanatkada Jashn Festival in Lucknow, AMC showcased a Calligraphy Stall featuring handmade
                                crafts and live name inscriptions. This initiative promoted traditional art forms and
                                underscored AMC's commitment to culture and community engagement.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Swachh Bharat Campaign </a></h3>
                            <p>On October 2, AMC organized a Cleanliness Awareness Campaign in Qaiserbagh, Lucknow, under
                                the Swachh Bharat Mission. The campaign, titled "Make My India Clean," involved students and
                                staff working together to clean public spaces. This event paid tribute to Mahatma Gandhi and
                                emphasized the importance of cleanliness.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Cultural Program </a></h3>
                            <p>On December 15, AMC organized "Shame Afsana," an evening of Urdu storytelling in
                                collaboration with Bazm-e-Urdu. The event featured moving stories, a calligraphy
                                competition, and an exploration of Urdu's literary richness. The event reinforced AMC's
                                dedication to preserving cultural heritage.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Republic Day </a></h3>
                            <p>On January 26, AMC celebrated Republic Day with a flag-hoisting ceremony, the singing of the
                                national anthem, speeches, and cultural performances. The Principal emphasized the
                                importance of sports and student involvement. The celebration concluded with the
                                distribution of sweets.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Air Pollution Awareness Program </a></h3>
                            <p>On February 8, AMC held a program to raise awareness about air pollution, including a graphic
                                design competition. Speakers like Mrs. Sumbul Khan and Mr. Vadudul Hasan Usmani emphasized
                                urgent environmental action. Young participants presented compelling artwork on pollution
                                and sustainability. The exhibition served as both education and inspiration.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="amc-course-card">
                        <div class="amc-course-image">
                            <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
                        </div>
                        <div class="amc-course-content">
                            <h3><a href="">Women Empowerment Program </a></h3>
                            <p>On March 21, AMC hosted a session to empower young women to understand their rights,
                                recognize their potential, and strive for independence. The event featured interactive
                                discussions on education, self-belief, and personal growth. Participants shared experiences
                                in a supportive and motivating environment.

                            </p>
                        </div>

                    </div>
                </div>


            </div>


            <div class="amc-view-all text-center" style="margin-top: 40px;">
                <a href="{{ route('program') }}" class="amc-view-all-btn">
                    <strong>View All Courses</strong>
                </a>
            </div>
        </div>
    </div>


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