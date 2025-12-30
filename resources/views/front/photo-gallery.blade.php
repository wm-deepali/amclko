@extends('front.partials.app')

@section('content')

<style>
    .gallery-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .gallery-filter-btn {
        padding: 10px 22px;
        border-radius: 30px;
        border: 1px solid #ddd;
        background: #fff;
        color: #333;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .gallery-filter-btn.active,
    .gallery-filter-btn:hover {
        background: #e63946;
        color: #fff;
        border-color: #e63946;
    }

    .gallery-item {
        display: none;
        animation: fadeIn 0.4s ease-in-out;
    }

    .gallery-item.show {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<!-------------------------- PHOTO GALLERY START ------------------------------>
<div class="about-banner">
    <img src="{{ asset('images/photo-gallery.jpg') }}" class="img-responsive"/>
</div>

<div class="communite-block mt-5">
    <div class="container">

        {{-- ================= FILTER BUTTONS ================= --}}
        <div class="gallery-filters">
            <button class="gallery-filter-btn active" data-filter="all">
                All
            </button>

            @foreach($categories as $category)
                <button class="gallery-filter-btn"
                        data-filter="cat{{ $category->id }}">
                    {{ $category->title }}
                </button>
            @endforeach
        </div>

        {{-- ================= GALLERY GRID ================= --}}
        <div class="row justify-content-center">

            @foreach($categories as $category)
                @foreach($category->galleries as $gallery)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 gallery-item cat{{ $category->id }} show">
                        <div class="picture-border text-center">
                            <a href="{{ asset('storage/'.$gallery->image) }}"
                               data-lightbox="gallery"
                               data-title="{{ $category->title }}">

                                <img class="img-responsive img-rounded"
                                     src="{{ asset('storage/'.str_replace(
                                        'gallery/',
                                        'gallery/thumb/',
                                        $gallery->image
                                     )) }}"
                                     alt="{{ $category->title }}">
                            </a>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>

    </div>
</div>

<script src="{{ asset('assets/js/lightbox-plus-jquery.min.js') }}"></script>

<script>
    const buttons = document.querySelectorAll('.gallery-filter-btn');
    const items   = document.querySelectorAll('.gallery-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {

            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            items.forEach(item => {
                item.classList.remove('show');

                if (filter === 'all' || item.classList.contains(filter)) {
                    setTimeout(() => item.classList.add('show'), 50);
                }
            });
        });
    });
</script>
<!-------------------------- PHOTO GALLERY END ------------------------------>

@endsection
