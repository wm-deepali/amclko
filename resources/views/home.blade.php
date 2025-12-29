@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">Home</a>
</li>
<li class="breadcrumb-item active">
    <span>Dashboard</span>
</li>
@endsection

@section('content')

<div class="container-fluid">

    {{-- ================= DASHBOARD HEADER ================= --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-semibold">Dashboard</h4>
            <p class="text-muted mb-0">Control panel</p>
        </div>
    </div>

    {{-- ================= ADMIN INFO BOX ================= --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card text-bg-info">
                <div class="card-body">
                    <h5 class="card-title mb-0">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MAIN ROW ================= --}}
    <div class="row">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-7">

            {{-- QUICK EMAIL --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fa fa-envelope me-2"></i> Quick Email
                    </span>
                </div>

                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email to">
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Message"></textarea>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-secondary">
                        Send <i class="fa fa-arrow-circle-right ms-1"></i>
                    </button>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-5">

            {{-- CALENDAR --}}
            <div class="card bg-success text-white">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fa fa-calendar me-2"></i> Calendar
                    </span>

                    <div class="btn-group">
                        <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Add new event</a></li>
                            <li><a class="dropdown-item" href="#">Clear events</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">View calendar</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body bg-white text-dark p-0">
                    <div id="calendar" style="width:100%; min-height:300px;"></div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('after-scripts')
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
@endpush
