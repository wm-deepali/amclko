@extends('front.partials.app')

@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner">
    <img src="{{ asset('images/our-courses.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title"></div>

<div class="communite-block">
    <div class="container">
        <div class="row">

            <h2>&nbsp;</h2>

            @foreach($courses as $course)
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="featureDisplay">
                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                        <a href="{{ $course->url }}">
                            {{ $course->title }}
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<!--------------------------Our Courses End------------------------------>

@endsection
