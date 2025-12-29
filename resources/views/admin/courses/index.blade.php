@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex mb-3">
                    <select id="statusFilter" class="form-control w-25">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="block">Blocked</option>
                    </select>

                    <a href="{{ route('manage-courses.create') }}" class="btn btn-primary ms-auto">
                        + Add Course
                    </a>
                </div>

                <table class="table table-bordered" id="courseTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

                <button id="bulkDelete" class="btn btn-danger mt-2">
                    Bulk Delete
                </button>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        let table = $('#courseTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('manage-courses.index') }}",
                type: "GET",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'title' },
                { data: 'image', orderable: false, searchable: false },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'desc']],
            drawCallback: function () {
                $('#checkAll').prop('checked', false);
            }

        });

        $('#statusFilter').change(() => table.ajax.reload());

        $('#checkAll').on('click', function () {
            $('.row_check').prop('checked', this.checked);
        });

        $('#bulkDelete').on('click', function () {
            let ids = [];
            $('.row_check:checked').each(function () { ids.push(this.value); });

            if (!ids.length) return alert('Select records');

            $.post("{{ route('manage-courses.bulk') }}", {
                ids: ids,
                action: 'delete',
                _token: "{{ csrf_token() }}"
            }, () => table.ajax.reload());
        });

        $(document).on('click', '.delete', function () {
            if (!confirm('Delete this course?')) return;

            $.ajax({
                url: '/manage-courses/' + $(this).data('id'),
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: () => table.ajax.reload()
            });
        });
    </script>
@endpush