@extends('layouts.app')

@section('title', 'Enquiry Management')

@section('content')
<div class="bg-light rounded">
    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Enquiry Management</h5>
                    <small class="text-muted">All website enquiries</small>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enquiries as $enquiry)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $enquiry->full_name }}</strong><br>
                                    <small>{{ $enquiry->email }}</small>
                                </td>

                                <td>
                                    +{{ $enquiry->country_code }} {{ $enquiry->mobile }}
                                </td>

                                <td>{{ $enquiry->location }}</td>

                                <td style="max-width:250px;">
                                    {{ \Illuminate\Support\Str::limit($enquiry->details, 60) }}
                                </td>

                                <td>
                                    {{ $enquiry->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    <form action="{{ route('manage-enquiries.destroy', $enquiry->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this enquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No enquiries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $enquiries->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>
@endsection
