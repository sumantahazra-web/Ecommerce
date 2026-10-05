@extends('layouts.app')

@section('title', 'MyShop - Home')

@section('content')

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow rounded mb-4">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="/dashboard">
            <i class="bi bi-shop"></i>
            MyShop
        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                Welcome, {{ Auth::user()->name }}
            </span>

            <a href="/cart" class="btn btn-outline-light me-2">
                <i class="bi bi-cart"></i>
                Cart
            </a>

            <a href="/my-orders" class="btn btn-outline-primary">
                <i class="bi bi-bag-check"></i>
                My Orders
            </a>

            <a
            href="/wishlist"
            class="nav-link text-white ms-3 me-4"
            style="display: inline-block !important; visibility: visible !important;"
            >
            <i class="bi bi-heart"></i>

            <span>
               Wishlist

            @if(auth()->check())

            @php
                $wishlistCount = \App\Models\Wishlist::where(
                    'user_id',
                    auth()->id()
                )->count();
            @endphp

                @if($wishlistCount > 0)

                <span class="badge bg-danger">
                    {{ $wishlistCount }}
                </span>

                @endif

            @endif

            </span>
            </a>

            <a href="/ai" class="btn btn-outline-info me-2">
                <i class="bi bi-robot"></i>
                AI Assistant
            </a>

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


<!-- Welcome Banner -->

<div class="bg-primary text-white rounded-4 shadow mb-5">

    <div class="container p-5">

        <h1 class="display-5 fw-bold">
            Welcome to MyShop
        </h1>

        <p class="lead">
            Find the best products at the best prices.
        </p>

        <button class="btn btn-light btn-lg">
            <i class="bi bi-cart"></i>
            Start Shopping
        </button>

    </div>

</div>


<!-- Products Section -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Our Products
        </h2>

        <p class="text-muted">
            Explore our latest products
        </p>

    </div>

</div>

<!-- Search & Product Filter Section -->

<div class="container mb-5">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5 class="fw-bold mb-3">

                <i class="bi bi-funnel"></i>

                Find Products

            </h5>


            <form action="/dashboard" method="GET">

                <div class="row g-3">


                    <!-- Search -->

                    <div class="col-lg-4 col-md-6">

                        <label class="form-label fw-semibold">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search products or categories..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    <!-- Category -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">

                            Category

                        </label>

                        <select
                            name="category"
                            class="form-select"
                        >

                            <option value="">

                                All Categories

                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}
                                >

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- Minimum Price -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">

                            Min Price

                        </label>

                        <input
                            type="number"
                            name="min_price"
                            class="form-control"
                            placeholder="₹ Min"
                            min="0"
                            value="{{ request('min_price') }}"
                        >

                    </div>


                    <!-- Maximum Price -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">

                            Max Price

                        </label>

                        <input
                            type="number"
                            name="max_price"
                            class="form-control"
                            placeholder="₹ Max"
                            min="0"
                            value="{{ request('max_price') }}"
                        >

                    </div>


                    <!-- Apply Button -->

                    <div class="col-lg-1 col-md-6 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            title="Apply Filters"
                        >

                            <i class="bi bi-search"></i>

                        </button>

                    </div>

                </div>


                <!-- Clear Filters -->

                <div class="mt-3">

                    <a
                        href="/dashboard"
                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-arrow-clockwise"></i>

                        Clear All Filters

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<div class="row">

    @forelse($products as $product)

        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">

            <div class="card h-100 border-0 shadow-sm">


                <!-- Product Image -->

                @if($product->image)

                    <img
                        src="{{ asset('storage/products/' . $product->image) }}"
                        class="card-img-top"
                        alt="{{ $product->name }}"
                        style="height: 220px; object-fit: cover;"
                    >

                @else

                    <div
                        class="bg-light d-flex align-items-center justify-content-center"
                        style="height: 220px;"
                    >

                        <i class="bi bi-image fs-1 text-secondary"></i>

                    </div>

                @endif


                <!-- Product Information -->

                <div class="card-body d-flex flex-column">

                    <span class="badge bg-secondary align-self-start mb-2">

                        {{ $product->category->name ?? 'General' }}

                    </span>


                    <h5 class="card-title fw-bold">

                        {{ $product->name }}

                    </h5>


                    <p class="card-text text-muted">

                        {{ Str::limit($product->description, 80) }}

                    </p>


                    <h4 class="text-success fw-bold">

                        ₹{{ number_format($product->price, 2) }}

                    </h4>


                    @if($product->stock > 0)

                        <p class="text-success">

                            <i class="bi bi-check-circle"></i>

                            {{ $product->stock }} available

                        </p>

                    @else

                        <p class="text-danger">

                            <i class="bi bi-x-circle"></i>

                            Out of Stock

                        </p>

                    @endif


                    <div class="mt-auto">

                        <a href="/products/{{ $product->id }}"
                         class="btn btn-primary w-100">

                        <i class="bi bi-eye"></i>

                         View Product

                        </a>

                    </div>

                </div>

            </div>

        </div>

    @empty

    <div class="col-12">

        <div class="alert alert-warning text-center shadow-sm">

            <i class="bi bi-search fs-1"></i>

            <h5 class="mt-2">
                No Products Found
            </h5>

            <p>
                Sorry, we couldn't find any product matching
                "<strong>{{ request('search') }}</strong>".
            </p>

            <a href="/dashboard" class="btn btn-primary">

                <i class="bi bi-arrow-clockwise"></i>

                Clear Search

            </a>

        </div>

    </div>

     @endforelse

</div>

@endsection