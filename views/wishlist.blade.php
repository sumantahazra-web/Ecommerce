@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')

<div class="container py-4">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-heart-fill text-danger"></i>
                My Wishlist
            </h2>

            <p class="text-muted mb-0">
                Products you have saved for later
            </p>

        </div>

        <a href="/dashboard" class="btn btn-outline-primary">

            <i class="bi bi-arrow-left"></i>

            Continue Shopping

        </a>

    </div>


    <!-- Success Message -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <!-- Error Message -->

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <!-- Wishlist Products -->

    @forelse($wishlists as $wishlist)

        @if($wishlist->product)

            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body">

                    <div class="row align-items-center">


                        <!-- Product Image -->

                        <div class="col-md-2 text-center">

                            <img
                                src="{{ asset('storage/products/' . $wishlist->product->image) }}"
                                alt="{{ $wishlist->product->name }}"
                                class="img-fluid rounded"
                                style="height: 120px; width: 120px; object-fit: cover;"
                            >

                        </div>


                        <!-- Product Information -->

                        <div class="col-md-5">

                            <h5 class="fw-bold mb-2">

                                {{ $wishlist->product->name }}

                            </h5>

                            @if($wishlist->product->category)

                                <p class="text-muted mb-2">

                                    <i class="bi bi-tag"></i>

                                    {{ $wishlist->product->category->name }}

                                </p>

                            @endif

                            <h5 class="text-primary fw-bold">

                                ₹{{ number_format($wishlist->product->price, 2) }}

                            </h5>

                        </div>


                        <!-- Stock -->

                        <div class="col-md-2">

                            @if($wishlist->product->stock > 0)

                                <span class="badge bg-success">

                                    <i class="bi bi-check-circle"></i>

                                    In Stock

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    <i class="bi bi-x-circle"></i>

                                    Out of Stock

                                </span>

                            @endif

                        </div>


                        <!-- View Product -->

                        <div class="col-md-3 text-md-end mt-3 mt-md-0">

                            <a
                                href="/products/{{ $wishlist->product->id }}"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-eye"></i>

                                View Product

                            </a>


                            @if($wishlist->product->stock > 0)

                            <form
                            action="/cart/add/{{ $wishlist->product->id }}"
                            method="POST"
                            class="d-inline"
                            >

                            @csrf

                            <input
                            type="hidden"
                            name="quantity"
                            value="1"
                            >

                            <button
                            type="submit"
                            class="btn btn-success"
                            >

                            <i class="bi bi-cart-plus"></i>

                              Add to Cart

                            </button>

                            </form>

                            @endif

                            <form
                                 action="/wishlist/remove/{{ $wishlist->id }}"
                                 method="POST"
                                 class="d-inline"
                            >
                                @csrf

                            <button type="submit" class="btn btn-danger">
                                 <i class="bi bi-trash"></i>
                                 Remove
                            </button>
                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    @empty

        <!-- Empty Wishlist -->

        <div class="text-center py-5">

            <i
                class="bi bi-heart"
                style="font-size: 70px; color: #dc3545;"
            ></i>

            <h3 class="mt-3 fw-bold">

                Your Wishlist is Empty

            </h3>

            <p class="text-muted">

                You haven't added any products to your wishlist yet.

            </p>

            <a
                href="/dashboard"
                class="btn btn-primary"
            >

                <i class="bi bi-cart"></i>

                Browse Products

            </a>

        </div>

    @endforelse

</div>

@endsection
