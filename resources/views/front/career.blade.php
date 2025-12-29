@extends('front.partials.app')

@section('content')

    <div class="about-banner">
        <img src="{{ asset('images/careerBanner.jpg') }}" class="img-responsive" />
    </div>

    <div class="communite-block">
        <div class="container">
            <div class="row">

                <!-- ================= LEFT FORM ================= -->
                <div class="col-lg-6 col-xs-12">

                    <div class="list-group">
                        <div class="list-group-item active table-title">
                            Apply for the Job
                        </div>
                    </div>

                    <div class="careerForm">
                        <h4>Fill the Required Field</h4>

                        {{-- SESSION ERRORS --}}
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- SESSION SUCCESS --}}
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- VALIDATION ERRORS --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('career.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <p style="font-size:24px;  padding:5px 0; color: #36B3E2;  " align="center"><strong></strong>
                            </p>
                            <div class="form-group">
                                <input class="form-control" name="name" required placeholder="Your Name"
                                    value="{{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="mobile" required placeholder="Your Mobile No"
                                    value="{{ old('mobile') }}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="email" placeholder="Email Id" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="post" required placeholder="Post Applied For"
                                    value="{{ old('post') }}">
                            </div>

                            <div class="form-group">
                                <input class="form-control" name="qualification" required placeholder="Total Experience"
                                    value="{{ old('qualification') }}">
                            </div>

                            <div class="form-group">
                                <input type="file" name="file" required accept=".doc,.docx,.pdf">
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="address"
                                    placeholder="Message">{{ old('address') }}</textarea>
                            </div>

                            <div class="form-group">
                                Resolve the simple captcha below:
                                <br><br>
                                <strong>3 + 11 =</strong>

                                <input name="captchaResult" class="form-control" style="width:30%">

                                <input type="hidden" name="firstNumber" value="3">
                                <input type="hidden" name="secondNumber" value="11">
                            </div>

                            <button type="submit" class="btn btn-success">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ================= RIGHT IMAGE ================= -->
                <div class="col-lg-6 form">
                    <img src="{{ asset('images/careerimg.jpg') }}" class="img-responsive">
                </div>

            </div>
        </div>
    </div>

@endsection