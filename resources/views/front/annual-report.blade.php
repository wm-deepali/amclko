@extends('front.partials.app')

@section('content')

<style>
    .annual-report-section {
        height: 100vh !important;
        padding: 60px 0;
        background: #f7f9fc;
    }

    .page-title {
        text-align: center;
        font-size: 32px;
        margin-bottom: 50px !important;
        font-weight: 700;
        color: #1a1a1a;
    }

    .report-grid {

        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 25px;
    }

    .report-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px 20px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #eaeaea;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .report-icon {
        width: 60px;
        height: auto;
        margin-bottom: 15px;
    }

    .report-title {
        font-size: 18px;
        color: #2c3e50;
        font-weight: 600;
        margin-top: 10px;
    }

    .report-card:hover .report-title {
        color: #e63946;
    }

    .empty-report {
        text-align: center;
        color: #777;
        grid-column: 1 / -1;
        font-size: 16px;
    }
</style>

<div class="annual-report-section">
    <div class="container">

        <h2 class="page-title">Annual Reports</h2>

        <div class="report-grid">

            @forelse($reports as $report)
                <a href="{{ asset('storage/'.$report->pdf) }}"
                   target="_blank"
                   class="report-card">

                    <img src="{{ asset('images/pdf.png') }}"
                         class="report-icon"
                         alt="PDF">

                    <h3 class="report-title">
                        {{ $report->title }}
                    </h3>
                </a>
            @empty
                <div class="empty-report">
                    No annual reports available.
                </div>
            @endforelse

        </div>
    </div>
</div>

@endsection
