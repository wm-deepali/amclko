@extends('layouts.app')

@section('title', 'About List')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            {{-- TOP ACTION BAR --}}
            <div class="d-flex mb-3 align-items-center">
                <select id="statusFilter" class="form-control w-25">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('abouts.create') }}" class="btn btn-primary ms-auto">
                    + Add About
                </a>
            </div>

            {{-- BULK DELETE --}}
            <div class="mb-3">
                <button id="bulkDelete" class="btn btn-danger">
                    Delete Selected
                </button>
            </div>

            {{-- TABLE --}}
            <table class="table table-bordered table-striped" id="aboutTable">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="checkAll">
                        </th>
                        <th>Image</th>
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
$(function () {

    /* DATATABLE */
    let table = $('#aboutTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('abouts.index') }}",
            data: function (d) {
                d.status = $('#statusFilter').val();
            }
        },
        columns: [
            { data: 'checkbox', orderable:false, searchable:false },
            { data: 'image', orderable:false, searchable:false },
            { data: 'title' },
            { data: 'status', orderable:false },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    /* STATUS FILTER */
    $('#statusFilter').change(function () {
        table.ajax.reload();
    });

    /* CHECK ALL */
    $('#checkAll').on('click', function () {
        $('.row_check').prop('checked', this.checked);
    });

    /* BULK DELETE */
    $('#bulkDelete').on('click', function () {

        let ids = $('.row_check:checked').map(function () {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            Swal.fire('Warning', 'Select at least one record', 'warning');
            return;
        }

        Swal.fire({
            title: 'Delete selected records?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(result => {
            if (result.isConfirmed) {
                $.post("{{ route('abouts.bulk') }}", {
                    _token: "{{ csrf_token() }}",
                    ids: ids,
                    action: 'delete'
                }, function () {
                    table.ajax.reload();
                    $('#checkAll').prop('checked', false);
                });
            }
        });
    });

    /* SINGLE DELETE */
    $(document).on('click', '.delete', function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/abouts') }}/" + id,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        table.ajax.reload();
                    }
                });
            }
        });
    });

});
</script>
@endpush
