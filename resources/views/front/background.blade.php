@extends('front.partials.app')

@section('content')

<!---------------------------About Start-----------------------------> 
<div class="about-banner">
    <img src="{{ asset('images/background.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title">
    <div class="container">
        <h2>&nbsp;</h2>

       @foreach($backgrounds as $background)
            {!! $background->content !!}
        @endforeach
        <p>&nbsp;</p>
    </div>
</div>
<!---------------------------About End-----------------------------> 

@endsection
