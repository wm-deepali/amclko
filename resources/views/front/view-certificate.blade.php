@extends('front.partials.app')

@section('content')

    <!--------------------------Our Courses Start------------------------------>
    <div class="about-banner">
        <img src="{{ asset('images/view-certificate.jpg') }}" class="img-responsive" />
    </div>

    <div class="about-title"></div>

    <div class="communite-block">
        <div class="container">
            <div class="row MT40 MB10">

                @foreach($certificates as $certificate)
                    <div class="col-lg-3 col-sm-4 col-xs-6">
                        <div class="picture-border">
                            <a class="example-image-link"
                                href="{{ asset('storage/' . $certificate->thumb_image) }}"
                                data-lightbox="example-set" data-title="View certificate">
                                <img class="example-image img-rounded img-responsive" width="270px" height="200px"
                                    src="{{ asset('storage/' . $certificate->thumb_image) }}" alt="" />
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/lightbox-plus-jquery.min.js') }}"></script>

    <!--------------------------Our Courses End------------------------------>

@endsection