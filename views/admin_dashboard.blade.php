@extends('layouts.app')

@section('title', 'MyShop - Admin Dashboard')

@section('content')

<div class="container py-4">

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow rounded mb-4">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="/admin">
            <i class="bi bi-shop"></i>
            MyShop Admin
        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                Welcome, {{ Auth::user()->name }}
            </span>


            <form action="/logout" method="POST">
                @csrf

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </button>
            </form>

        </div>

    </div>

</nav>


<!-- Admin Welcome -->
<div class="card border-0 shadow mb-4">

    <div class="card-body p-4">

        <h2 class="fw-bold mb-3">
            <i class="bi bi-person-badge"></i>
            Admin Dashboard
        </h2>

        <p class="mb-2">
            <strong>Name:</strong>
            {{ Auth::user()->name }}
        </p>

        <p class="mb-2">
            <strong>Email:</strong>
            {{ Auth::user()->email }}
        </p>

        <p class="mb-0">
            <strong>Role:</strong>
            <span class="badge bg-danger">
                {{ Auth::user()->role }}
            </span>
        </p>

    </div>

</div>


<!-- Admin Panel -->
<div class="card border-0 shadow">

    <div class="card-body p-4">

        <h3 class="fw-bold mb-3">
            <i class="bi bi-gear"></i>
            Admin Panel
        </h3>

        <p class="text-muted">
            This area is only for administrators.
        </p>

        <a href="/admin" class="btn btn-primary">
            <i class="bi bi-speedometer2"></i>
            Open Admin Panel
        </a>

    </div>

</div>

</div>

@endsection
