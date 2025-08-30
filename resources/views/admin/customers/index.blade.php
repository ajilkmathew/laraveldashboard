@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Customers</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#customerModal" id="addCustomerBtn">Add Customer</button>

    <table class="table table-bordered" id="customersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- AJAX load -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div id="pagination" class="text-center mt-3"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="customerForm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModalLabel">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="customer_id">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(function () {

    // ---- helpers ----
    const KEY = 'customers_last_page';

    function getSavedPage() {
        return parseInt(localStorage.getItem(KEY) || '1', 10);
    }

    function savePage(p) {
        localStorage.setItem(KEY, String(p));
    }

    function renderRows(items) {
        let rows = '';
        items.forEach(c => {
            rows += `
                <tr>
                    <td>${c.id}</td>
                    <td>${c.name}</td>
                    <td>${c.email}</td>
                    <td>
                        <button class="btn btn-sm btn-primary editBtn" data-id="${c.id}">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${c.id}">Delete</button>
                    </td>
                </tr>`;
        });
        $('#customersTable tbody').html(rows);
    }

    function renderPagination(current, last) {
        if (last <= 1) {
            $('#pagination').empty();
            return;
        }
        let html = '';
        for (let i = 1; i <= last; i++) {
            const active = i === current
                ? 'btn-primary'
                : 'btn-outline-primary';
            html += `<button type="button" class="btn btn-sm ${active} mx-1 pageBtn" data-page="${i}">${i}</button>`;
        }
        $('#pagination').html(html);
    }

    // ---- core loader ----
    function loadCustomers(page = 1) {
        $.get(`{{ route('admin.customers.index') }}?page=${page}`, function (res) {

            // If current page is empty (e.g., you deleted the last row), go back one page.
            if (res.data.length === 0 && page > 1) {
                const prev = page - 1;
                savePage(prev);
                return loadCustomers(prev);
            }

            renderRows(res.data);
            renderPagination(res.pagination.current_page, res.pagination.last_page);

            // persist & reflect in URL
            savePage(res.pagination.current_page);
            window.history.replaceState(null, '', `?page=${res.pagination.current_page}`);
        });
    }

    // ---- initial load (use saved page or 1) ----
    loadCustomers(getSavedPage());

    // ---- pagination click ----
    $(document).on('click', '.pageBtn', function () {
        const page = parseInt($(this).data('page'), 10);
        loadCustomers(page);
    });

    // ---- Add modal ----
    $('#addCustomerBtn').on('click', function () {
        $('#customerForm')[0].reset();
        $('#customer_id').val('');
        $('#customerModalLabel').text('Add Customer');
        $('#password').attr('required', true);
    });

    // ---- Save (Add / Edit) ----
    $('#customerForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#customer_id').val();
        const url = id ? `/admin/customers/${id}` : `{{ route('admin.customers.store') }}`;
        const type = id ? 'PUT' : 'POST';

        $.ajax({
            url,
            type,
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $('#customerModal').modal('hide');
                loadCustomers(getSavedPage()); // reload same page
                alert(response.message);
            },
            error: function (err) {
                alert('Error! Check console.');
                console.log(err.responseJSON );
            }
        });
    });

    // ---- Edit ----
    $(document).on('click', '.editBtn', function () {
        const id = $(this).data('id');
        $.get(`/admin/customers/${id}/edit`, function (c) {
            $('#customer_id').val(c.id);
            $('#name').val(c.name);
            $('#email').val(c.email);
            $('#password').val('').removeAttr('required');
            $('#customerModalLabel').text('Edit Customer');
            $('#customerModal').modal('show');
        });
    });

    // ---- Delete ----
    $(document).on('click', '.deleteBtn', function () {
        if (!confirm('Are you sure?')) return;
        const id = $(this).data('id');

        $.ajax({
            url: `/admin/customers/${id}`,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function () {
                // if last item on the page was removed, loadCustomers() will step back
                loadCustomers(getSavedPage());
            }
        });
    });

    // ---- Clear saved page when admin logs out ----
    // Add id="adminLogoutForm" to your logout form in the admin navbar.
    $(document).on('submit', '#adminLogoutForm', function () {
        localStorage.removeItem(KEY);
    });
});
</script>
@endsection
