@extends('layouts.app')

@section('title','Change Password')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5>Update Administrator Password</h5>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                <div class="mb-3">
                    <label>Old Password</label>
                    <input type="password" name="old_password"
                           class="form-control @error('old_password') is-invalid @enderror">
                    @error('old_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="form-control">
                </div>

                <div class="text-end">
                    <button class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
