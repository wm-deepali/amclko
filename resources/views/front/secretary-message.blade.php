@extends('front.partials.app')

@section('content')

<!---------------------------About Start----------------------------->
<div class="about-banner">
    <img src="{{ asset('images/secratery-msg.jpg') }}" class="img-responsive"/>
</div>

@foreach($secratries as $secratry)
    {!! $secratry->content !!}
@endforeach

<!---------------------------About End------------------------------>

@endsection
