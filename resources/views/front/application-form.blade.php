@extends('front.partials.app')

@section('content')

<!---------------------------About Start----------------------------->
<div class="about-banner">
    <img src="{{ asset('images/application-form.jpg') }}" class="img-responsive"/>
</div>

<div class="container">
    <div class="row">
        <h2>&nbsp;</h2>

        @foreach($applications as $application)
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="featureDisplay">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                    <a target="_blank"
                       href="{{ asset('storage/'.$application->thumb_image) }}">
                        {{ $application->title }}
                    </a>
                </div>
            </div>
        @endforeach

    </div>
</div>
<!---------------------------About End------------------------------>

@endsection
