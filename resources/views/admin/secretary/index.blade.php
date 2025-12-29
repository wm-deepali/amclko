@extends('layouts.app')

@section('title', 'Secretary Messages')

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

                    <a href="{{ route('secretaries.create') }}" class="btn btn-primary ms-auto">
                        + Add Secretary Message
                    </a>
                </div>

                <div class="d-flex mb-3">
                    <select id="bulkAction" class="form-control w-25">
                        <option value="">Bulk Action</option>
                        <option value="delete">Delete</option>
                        <option value="active">Activate</option>
                        <option value="block">Block</option>
                    </select>
                    <button id="applyBulk" class="btn btn-secondary ms-2">Apply</button>
                </div>

                <table class="table table-bordered" id="secretaryTable">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>Title</th>
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
        let table = $('#secretaryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('secretaries.index') }}",
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'title' },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']],
            language: {
                processing: "Loading data..."
            }
        });

        $('#statusFilter').change(() => table.ajax.reload());

        $('#checkAll').on('click', function () {
            $('.row_check').prop('checked', this.checked);
        });

        $('#applyBulk').click(function () {
            let ids = $('.row_check:checked').map(function () {
                return $(this).val();
            }).get();

            let action = $('#bulkAction').val();

            if (!ids.length || !action) {
                Swal.fire('Warning', 'Select records & action', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    $.post("{{ route('secretaries.bulk') }}", {
                        _token: "{{ csrf_token() }}",
                        ids: ids,
                        action: action
                    }, () => table.ajax.reload());
                }
            });
        });

        $(document).on('click', '.delete', function () {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Delete this record?',
                icon: 'warning',
                showCancelButton: true
            }).then(res => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/secretaries') }}/" + id,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: () => table.ajax.reload()
                    });
                }
            });
        });
    </script>
@endpush