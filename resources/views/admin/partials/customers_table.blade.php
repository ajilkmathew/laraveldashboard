<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th width="150">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->created_at->format('d M Y') }}</td>
                <td>
                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $customer->id }}">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $customer->id }}">
                        Delete
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No customers found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {!! $customers->links() !!}
</div>
