@extends('front.partials.app')

@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner">
    <img src="{{ asset('images/contact-us-banner.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title"></div>

<div class="communite-block">
    <div class="container">
        <div class="row">

            @foreach($contacts as $contact)

            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="contactbox">
                    <h4>
                        <img src="{{ asset('images/bullet_arrow.png') }}">
                        {{ $contact->title }}
                    </h4>

                    <table width="100%" cellspacing="0" cellpadding="4" border="0">
                        <tbody>
                        <tr>
                            <td class="text-danger" width="11%" align="center">
                                <i class="fa fa-map-marker"></i>
                            </td>
                            <td width="89%">
                                {!! $contact->address !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-danger" align="center">
                                <i class="fa fa-phone"></i>
                            </td>
                            <td>{{ $contact->phone }}</td>
                        </tr>

                        <tr>
                            <td class="text-danger" align="center">
                                <i class="fa fa-mobile"></i>
                            </td>
                            <td>{{ $contact->mobile }}</td>
                        </tr>

                        <tr>
                            <td class="text-danger" align="center">
                                <i class="fa fa-envelope-o"></i>
                            </td>
                            <td>
                                <p>
                                    <a href="mailto:{{ $contact->email }}">
                                        {{ $contact->email }}
                                    </a>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <p>
                                    <strong>Website :</strong>
                                    <a href="{{ $contact->website }}" target="_blank">
                                        {{ $contact->website }}
                                    </a>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <img src="{{ asset('images/contactbox-border.png') }}" width="100%">
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.6355435046717!2d80.92741981450082!3d26.851541969186126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfdbb71a5fd05%3A0x457a8111427469ff!2sAcademy+Of+Mass+Communication!5e0!3m2!1sen!2sin!4v1495690276728"
                    width="500"
                    height="270"
                    frameborder="0"
                    style="border:0"
                    allowfullscreen>
                </iframe>
            </div>

            <div class="clearfix"></div>

            @endforeach

        </div>
    </div>
</div>

<!--------------------------Our Courses End------------------------------>

@endsection
