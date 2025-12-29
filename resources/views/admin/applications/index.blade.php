@extends('layouts.app')

@section('title', 'Application Forms')

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex mb-3 gap-2">
                    <select id="statusFilter" class="form-control w-25">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="block">Blocked</option>
                    </select>

                    <select id="bulkAction" class="form-control w-25">
                        <option value="">Bulk Actions</option>
                        <option value="delete">Delete</option>
                        <option value="active">Activate</option>
                        <option value="block">Block</option>
                    </select>

                    <button id="applyBulk" class="btn btn-secondary">Apply</button>

                    <a href="{{ route('applications.create') }}" class="btn btn-primary ms-auto">
                        + Add New
                    </a>
                </div>

                <table class="table table-bordered" id="applicationTable">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>Title</th>
                            <th>Image</th>
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
        let table = $('#applicationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('applications.index') }}",
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'title' },
                { data: 'image', orderable: false, searchable: false },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false, searchable: false },
            ]
        });

        $('#statusFilter').change(() => table.ajax.reload());

        $('#checkAll').click(function () {
            $('.row_check').prop('checked', this.checked);
        });

        /* BULK */
        $('#applyBulk').click(function () {
            let ids = $('.row_check:checked').map(function () {
                return $(this).val();
            }).get();

            let action = $('#bulkAction').val();

            if (!ids.length || !action) {
                Swal.fire('Warning', 'Select records and action', 'warning');
                return;
            }

            $.post("{{ route('applications.bulk') }}", {
                _token: "{{ csrf_token() }}",
                ids: ids,
                action: action
            }, () => table.ajax.reload());
        });

        /* DELETE */
        $(document).on('click', '.delete', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Delete record?',
                icon: 'warning',
                showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/applications') }}/" + id,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: () => table.ajax.reload()
                    });
                }
            });
        });
    </script>
@endpush