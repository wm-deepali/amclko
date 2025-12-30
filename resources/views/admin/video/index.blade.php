@extends('layouts.app')

@section('title', 'Videos')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-3">
                <select id="filter" class="form-control w-25">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="block">Blocked</option>
                </select>

                <a href="{{ route('manage-videos.create') }}" class="btn btn-primary ms-auto">
                    + Add Video
                </a>
            </div>

            <table class="table table-bordered" id="videoTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Video URL</th>
                        <th>Status</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
            </table>

            <div class="mt-2">
                <button class="btn btn-danger" id="bulkDelete">Delete</button>
            </div>

        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        let table = $('#videoTable').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ route('manage-videos.index') }}",
                data: function (d) {
                    d.status = $('#filter').val();
                }
            },
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'url' },
                { data: 'status', orderable: false },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']],
            language: {
                processing: "Loading data..."
            }
        });

        $('#filter').change(() => table.ajax.reload());

        $('#checkAll').on('click', function () {
            $('.row_check').prop('checked', this.checked);
        });

        function bulkAction(action) {
            let ids = [];
            $('.row_check:checked').each((i, e) => ids.push(e.value));
            if (!ids.length) return alert('Select rows');

            $.post("{{ route('manage-videos.bulk') }}", {
                ids: ids,
                action: action,
                _token: "{{ csrf_token() }}"
            }, () => table.ajax.reload());
        }

        $('#bulkDelete').click(() => bulkAction('delete'));

        $(document).on('click', '.delete', function () {
            if (!confirm('Delete?')) return;
            $.ajax({
                url: '/manage-videos/' + $(this).data('id'),
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: () => table.ajax.reload()
            });
        });
    </script>
@endpush