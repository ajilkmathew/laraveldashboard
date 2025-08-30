<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('customer.dashboard') }}">Customer Dashboard</a>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <form action="{{ route('customer.logout') }}" method="POST">
          @csrf
          <button class="btn btn-danger btn-sm">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
<div class="container mt-4">@yield('content')</div>
</body>
</html>
