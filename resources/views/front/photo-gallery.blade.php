@extends('front.partials.app')

@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner">
	<img src="{{ asset('images/photo-gallery.jpg') }}" class="img-responsive"/>
</div>

<div class="about-title"></div>

<div class="communite-block mt-5">
    <div class="container">
        <div class="row MT40 MB10 justify-content-center" id="galleryContainer">
            <!-- Images will load here by JS -->
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/lightbox-plus-jquery.min.js') }}"></script>

<script>
const images = [
  "1.jpeg","2.jpeg","3.jpeg","4.jpeg","5.jpeg","6.jpeg","7.jpeg","8.jpeg","9.jpeg","10.jpeg",
  "11.jpeg","12.jpeg","13.jpeg","14.jpeg","15.jpeg","16.jpeg","17.jpeg","18.jpeg","19.jpeg","20.jpeg",
  "21.jpeg","22.jpeg","23.jpeg","24.jpeg","25.jpeg","26.jpeg","27.jpeg","28.jpeg","29.jpeg","30.jpeg",
  "31.jpeg","32.jpeg","33.jpeg","34.jpeg","35.jpeg","36.jpeg","37.jpeg","38.jpeg","39.jpeg","40.jpeg",
  "41.jpeg","42.jpeg","43.jpeg","44.jpeg","45.jpeg","46.jpeg","47.jpeg"
];

const container = document.getElementById("galleryContainer");

images.forEach(img => {
    container.innerHTML += `
        <div class="col-lg-3 col-md-6 col-sm-12 text-center">
            <div class="picture-border">
                <a class="example-image-link"
                   href="{{ asset('gallery') }}/${img}"
                   data-lightbox="example-set"
                   data-title="Academy of Mass Communication">

                    <img class="example-image img-rounded img-responsive"
                         width="270px" height="200px"
                         src="{{ asset('gallery') }}/${img}"
                         alt=""/>
                </a>
            </div>
        </div>
    `;
});
</script>

<!--------------------------Our Courses End------------------------------>

@endsection
