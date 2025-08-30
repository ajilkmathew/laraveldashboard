<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    @include('admin.layouts.partials.navbar')

    <div class="container-fluid mt-3">
        <!-- Main content -->
        @yield('content')
    </div>

    <!-- jQuery (required for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap JS (includes Popper for modals, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Custom JS -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <!-- Page-specific scripts -->
    @yield('scripts')


        <!-- Page-specific scripts -->
    @yield('scripts')

    <script>
    function clearDataTablesState() {
        try {
            // Clear localStorage keys used by DataTables
            for (let i = localStorage.length - 1; i >= 0; i--) {
                const key = localStorage.key(i);
                if (key && key.indexOf('DataTables_') === 0) {
                    localStorage.removeItem(key);
                }
            }
            // Clear sessionStorage keys used by DataTables
            for (let i = sessionStorage.length - 1; i >= 0; i--) {
                const key = sessionStorage.key(i);
                if (key && key.indexOf('DataTables_') === 0) {
                    sessionStorage.removeItem(key);
                }
            }
            console.log('DataTables state cleared on logout.');
        } catch (err) {
            console.warn('Could not clear DataTables state', err);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const adminLogoutForm = document.getElementById('adminLogoutForm');
        if (adminLogoutForm) {
            adminLogoutForm.addEventListener('submit', function () {
                clearDataTablesState();
            });
        }
    });
    </script>
</body>
</html>


</body>
</html>
