@extends('front.partials.app')

<style>
  .amc-course-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .amc-course-title {
    text-align: center;
    margin-bottom: 50px;
  }

  .amc-course-title h2 {
    font-size: 38px;
    font-weight: 700;
    color: #0A1D56;
    margin: 0 0 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .amc-divider {
    width: 80px;
    height: 4px;
    background: #FF6B35;
    margin: 0 auto;
    border: none;
    border-radius: 2px;
  }

  /* Course Card */
  .amc-course-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
    transition: all 0.4s ease;
    margin-bottom: 30px;
    height: auto;
    display: grid;
    grid-template-columns: 2fr 10fr;
  }

  .amc-course-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(10, 29, 86, 0.18);
  }

  .amc-course-image {
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }

  .amc-course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .amc-course-card:hover .amc-course-image img {
    transform: scale(1.1);
  }

  .amc-course-content {
    padding: 25px;
    flex-grow: 1;
  }

  .amc-course-content h3 {
    margin: 0 0 15px;
    font-size: 20px;
    font-weight: 600;
    color: #0A1D56;
    line-height: 1.4;
  }

  .amc-course-content h3 a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s;
  }

  .amc-course-content h3 a:hover {
    color: #FF6B35;
  }

  .amc-course-content p {
    color: #555;
    font-size: 15px;
    line-height: 1.6;
    margin: 0;
  }

  .amc-course-footer {
    padding: 0 25px 25px;
  }

  .amc-read-more-btn {
    display: inline-block;
    background: #FF6B35;
    color: white;
    padding: 12px 28px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    font-size: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
  }

  .amc-read-more-btn:hover {
    background: #e55a30;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
    color: white;
  }

  .amc-read-more-btn i {
    margin-left: 8px;
    font-size: 14px;
  }
</style>
@section('content')

  <!--------------------------Our Courses Start------------------------------>
  <div class="about-banner mb-5">
    <!--<img src="images/our-courses.jpg" class="img-responsive"/>-->
  </div>
  <div class="about-title">

  </div>
  <div class="amc-course-section">
    <div class="amc-course-title " style="margin-top:50px;">
      <h2>Programmes</h2>
      <hr class="amc-divider">
    </div>


    <div class="container ">
      <div class="row">

        @foreach($programs as $program)
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="amc-course-card">

              <div class="amc-course-image col-3">
                <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->title }}" class="img-responsive">
              </div>

              <div class="amc-course-content col-7">
                <h3>
                 <a href="{{ route('program.detail', $program->id) }}">
                    {{ $program->title }}
                  </a>
                </h3>

                <p>
                  {{ $program->short_description }}
                </p>
              </div>

            </div>
          </div>
        @endforeach

        @if($programs->isEmpty())
          <div class="text-center text-muted">
            No programs available right now.
          </div>
        @endif

      </div>
    </div>
  </div>

  <!--------------------------Our Courses End------------------------------>

@endsection