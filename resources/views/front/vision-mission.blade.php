@extends('front.partials.app')

@section('content')

<!---------------------------About Start----------------------------->
<div class="about-banner">
    <img src="{{ asset('images/vision-mission.jpg') }}" class="img-responsive"/>
</div>

@foreach($missions as $mission)
    {!! $mission->content !!}
@endforeach

<!---------------------------About End------------------------------>

@endsection
