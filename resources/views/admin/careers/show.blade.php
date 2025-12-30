@extends('layouts.app')
@section('title','Career Application')

@section('content')
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <tr><th>Name</th><td>{{ $career->name }}</td></tr>
            <tr><th>Mobile</th><td>{{ $career->mobile }}</td></tr>
            <tr><th>Email</th><td>{{ $career->email }}</td></tr>
            <tr><th>Post Applied</th><td>{{ $career->post_applied }}</td></tr>
            <tr><th>Qualification</th><td>{{ $career->qualification }}</td></tr>
            <tr><th>Message</th><td>{{ $career->message }}</td></tr>
            <tr>
                <th>Resume</th>
                <td>
                    <a href="{{ asset('storage/'.$career->resume) }}" target="_blank">
                        Download Resume
                    </a>
                </td>
            </tr>
        </table>

        <a href="{{ route('manage-careers.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>
</div>
@endsection
