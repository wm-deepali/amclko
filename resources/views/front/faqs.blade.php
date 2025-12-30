@extends('front.partials.app')

@section('content')

<style>
/* PAGE */
.faq-page {
    padding: 70px 0;
    background: #f9fafc;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* HEADER */
.faq-header {
    text-align: center;
    margin-bottom: 50px;
}
.faq-header h2 {
    font-size: 36px;
    font-weight: 700;
    color: #0A1D56;
}

/* FAQ CARD */
.faq-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
    margin-bottom: 18px;
    overflow: hidden;
    transition: .3s ease;
}
.faq-card:hover {
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
}

/* QUESTION */
.faq-question {
    padding: 18px 22px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.faq-question h4 {
    font-size: 16px;
    font-weight: 600;
    color: #0A1D56;
    margin: 0;
}

/* ICON */
.faq-icon {
    font-size: 18px;
    font-weight: bold;
    color: #FF6B35;
    transition: transform .3s ease;
}
.faq-card.active .faq-icon {
    transform: rotate(45deg);
}

/* ANSWER */
.faq-answer {
    display: none;
    padding: 0 22px 20px;
    font-size: 15px;
    color: #555;
    line-height: 1.8;
    border-top: 1px solid #f0f0f0;
}
.faq-card.active .faq-answer {
    display: block;
}
</style>

<div class="faq-page">
    <div class="container">

        {{-- Header --}}
        <div class="faq-header">
            <h2>Frequently Asked Questions</h2>
        </div>

        {{-- FAQ List --}}
        @forelse($faqs as $index => $faq)
            <div class="faq-card {{ $index === 0 ? 'active' : '' }}">
                <div class="faq-question">
                    <h4>{{ $faq->question }}</h4>
                    <span class="faq-icon">+</span>
                </div>

                <div class="faq-answer">
                    {!! $faq->answer !!}
                </div>
            </div>
        @empty
            <div class="text-center text-muted">
                No FAQs available.
            </div>
        @endforelse

    </div>
</div>

{{-- Toggle Script --}}
<script>
document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', function () {
        const card = this.closest('.faq-card');

        // close others
        document.querySelectorAll('.faq-card').forEach(el => {
            if (el !== card) el.classList.remove('active');
        });

        card.classList.toggle('active');
    });
});
</script>

@endsection
