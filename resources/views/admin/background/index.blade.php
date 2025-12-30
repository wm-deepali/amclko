@extends('layouts.app')
@section('title', 'Background')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="filter" class="form-control w-25">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('manage-backgrounds.create') }}" class="btn btn-primary ms-auto">+ Add</a>
            </div>

            <table class="table table-bordered" id="bgTable">
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

            <button id="bulkDelete" class="btn btn-danger mt-2">Bulk Delete</button>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        let table = $('#bgTable').DataTable({
            processing: true,   // ✅ REQUIRED
            serverSide: true,
            ajax: {
                url: "{{ route('manage-backgrounds.index') }}",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false },
                { data: 'title' },
                { data: 'image', orderable: false },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false }
            ],
            order: [[1, 'asc']],
            language: {
                processing: "Loading data..."
            }
        });

        $('#filter').change(() => table.ajax.reload());
        $('#checkAll').click(e => $('.row_check').prop('checked', e.target.checked));

        $('#bulkDelete').click(() => {
            let ids = [];
            $('.row_check:checked').each((i, e) => ids.push(e.value));
            if (!ids.length) return alert('Select rows');

            $.post("{{ route('manage-backgrounds.bulk') }}",
                { ids, action: 'delete', _token: "{{ csrf_token() }}" },
                () => table.ajax.reload()
            );
        });

        // SINGLE DELETE
        $(document).on('click', '.delete', function () {

            if (!confirm('Are you sure you want to delete this background?')) {
                return;
            }

            let id = $(this).data('id');

            $.ajax({
                url: "{{ url('/manage-backgrounds') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    table.ajax.reload(null, false);
                },
                error: function () {
                    alert('Delete failed');
                }
            });
        });

    </script>
@endpush