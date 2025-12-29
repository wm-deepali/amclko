@extends('front.partials.app')

@section('content')

<!---------------------------About Start----------------------------->
<div class="about-banner">
    <img src="{{ asset('images/about-banner.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title">
    <div class="container">
        <h2>&nbsp;</h2>

        @foreach($abouts as $about)
            {!! $about->content !!}
        @endforeach

    </div>
</div>
<!---------------------------About End------------------------------>

@endsection
