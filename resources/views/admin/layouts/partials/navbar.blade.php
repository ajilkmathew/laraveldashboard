<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <form id="adminLogoutForm" action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
