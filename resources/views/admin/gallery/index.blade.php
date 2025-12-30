@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Gallery</h5>
                <a href="{{ route('manage-galleries.create') }}" class="btn btn-primary">
                    + Add Image
                </a>
            </div>

            {{-- BULK --}}
            <div class="row mb-2">
                <div class="col-md-3">
                    <select id="bulkAction" class="form-control">
                        <option value="">Bulk Action</option>
                        <option value="delete">Delete</option>
                        <option value="active">Activate</option>
                        <option value="block">Block</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary" id="applyBulk">Apply</button>
                </div>
            </div>

            <table class="table table-bordered" id="galleryTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script>
let table = $('#galleryTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('manage-galleries.index') }}",
        type: "GET",
        data: function (d) {
            d.status = $('#filter').val();
        }
    },
    columns: [
        { data: 'checkbox', orderable: false, searchable: false },
        { data: 'image', orderable: false },
        { data: 'category', orderable: false, searchable: false },
        { data: 'status', orderable: false },
        { data: 'action', orderable: false }
    ],
    order: [[1, 'desc']],
    drawCallback: function () {
        $('#checkAll').prop('checked', false);
    }
});

/* CHECK ALL */
$('#checkAll').on('click', function () {
    $('.row_check').prop('checked', this.checked);
});

/* DELETE */
$(document).on('click', '.delete', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete?',
        text: 'This image will be removed',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33'
    }).then(res => {
        if (res.isConfirmed) {
            $.ajax({
                url: "{{ url('manage-galleries') }}/" + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: () => table.ajax.reload(null,false)
            });
        }
    });
});

/* BULK */
$('#applyBulk').on('click', function () {
    let ids = $('.row_check:checked').map(function () {
        return this.value;
    }).get();

    let action = $('#bulkAction').val();
    if (ids.length === 0 || action === '') return;

    $.post("{{ route('manage-galleries.bulk') }}", {
        _token: '{{ csrf_token() }}',
        ids: ids,
        action: action
    }, () => table.ajax.reload(null,false));
});
</script>
@endpush
