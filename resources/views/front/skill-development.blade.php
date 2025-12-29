@extends('front.partials.app')

@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner">
	<img src="{{ asset('images/skill-dev.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title"></div>

<div class="communite-block">
	<div class="container">

        {{-- FIRST BLOCK (ID = 1) --}}
        @if($skillOne)
            <div class="row">
                <div class="about-block">
                    <div class="col-lg-8 col-xs-12 col-sm-6">
                        <div class="content-block">
                            <h1>{{ $skillOne->title }}</h1>
                            {!! $skillOne->content !!}
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 col-sm-6">
                        <div class="about-image">
                            <img src="{{ asset('storage/'.$skillOne->thumb_image) }}"
                                 alt="about1"
                                 class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- SECOND BLOCK (ID = 2) --}}
        @if($skillTwo)
            <div class="row">
                <div class="col-lg-4 col-xs-12 col-sm-6">
                    <div class="work-image">
                        <img src="{{ asset('storage/'.$skillTwo->thumb_image) }}"
                             alt="about2"
                             class="img-responsive">
                    </div>
                </div>

                <div class="col-lg-8 col-xs-12 col-sm-6">
                    <div class="our-work">
                        <h1>{{ $skillTwo->title }}</h1>
                        {!! $skillTwo->content !!}
                    </div>
                </div>
            </div>
        @endif

	</div>
</div>

<!--------------------------Our Courses End------------------------------>

@endsection
