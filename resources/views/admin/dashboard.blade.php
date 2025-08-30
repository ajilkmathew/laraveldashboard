@extends('admin.layouts.app')
@section('content')
<h2>Welcome, Admin!</h2>
<a class="btn btn-primary mt-3" href="{{ route('admin.customers.index') }}">Manage Customers</a>
@endsection
