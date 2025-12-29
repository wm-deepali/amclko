@extends('front.partials.app')

@section('content')

<!---------------------------About Start----------------------------->
<div class="about-banner">
    <img src="{{ asset('images/message-chairman.jpg') }}" class="img-responsive"/>
</div>

@foreach($chairmen as $chairman)
    {!! $chairman->content !!}
@endforeach

<!---------------------------About End------------------------------>

@endsection
