@extends('customer.layouts.app')

@section('content')
<h2>Welcome, {{ auth('customer')->user()->name }}!</h2>
<p>You are logged in as a customer.</p>
@endsection
