@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex mb-3">
                    <select id="statusFilter" class="form-control w-25">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="block">Blocked</option>
                    </select>

                    <a href="{{ route('contacts.create') }}" class="btn btn-primary ms-auto">
                        + Add Contact
                    </a>
                </div>

                <table class="table table-bordered" id="contactTable">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" id="checkAll"></th>
                            <th>Title</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        let table = $('#contactTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('contacts.index') }}",
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'title' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false, searchable: false },
            ]
        });

        $('#statusFilter').change(() => table.ajax.reload());

        $('#checkAll').on('click', function () {
            $('.row_check').prop('checked', this.checked);
        });

        $(document).on('click', '.delete', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Delete record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/contacts') }}/" + id,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: () => table.ajax.reload()
                    });
                }
            });
        });
    </script>
@endpush