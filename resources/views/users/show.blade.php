@extends('layouts.app')

@section('title')
Show User
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Show user</h5>

            <div class="container mt-4">
                <div>
                    Name: {{ $user->name }}
                </div>
                <div>
                    Email: {{ $user->email }}
                </div>
                <div>
                    Phone: {{ $user->phone }}
                </div>

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-default">Back</a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection