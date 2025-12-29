@extends('front.partials.app')

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
</style>
@section('content')

    <div class="annual-report-section">
        <div class="container">
            <h2 class="page-title ">Annual Reports</h2>

            <div class="report-grid">

                <!-- CARD 1 -->
                <a href="{{ asset('reports/2022-23 annual report.pdf') }}" target="_blank" class="report-card">
                    <img src="{{ asset('reports/pdf.png') }}" class="report-icon" alt="PDF Icon">
                    <h3 class="report-title">Annual Report for Year 2022 - 2023</h3>
                </a>

                <!-- CARD 2 -->
                <a href="{{ asset('reports/Annual report 23-24 (1).pdf') }}" target="_blank" class="report-card">
                    <img src="{{ asset('reports/pdf.png') }}" class="report-icon" alt="PDF Icon">
                    <h3 class="report-title">Annual Report for Year 2023 - 2024</h3>
                </a>

                <!-- CARD 3 -->
                <a href="{{ asset('reports/Annual report 2024-25 (1) (1).pdf') }}" target="_blank" class="report-card">
                    <img src="{{ asset('reports/pdf.png') }}" class="report-icon" alt="PDF Icon">
                    <h3 class="report-title">Annual Report for Year 2024 - 2025</h3>
                </a>



            </div>
        </div>
    </div>

@endsection