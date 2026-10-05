@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="container">

    <!-- Back Button -->

    <div class="mb-4">

        <a href="/dashboard" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>

    </div>


    <div class="card border-0 shadow">

        <div class="card-body p-4">

            <div class="row">


                <!-- Product Image -->

                <div class="col-md-6">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/products/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="img-fluid rounded"
                            style="width: 100%; height: 450px; object-fit: cover;"
                        >

                    @else

                        <div
                            class="bg-light rounded d-flex align-items-center justify-content-center"
                            style="height: 450px;"
                        >

                            <i class="bi bi-image fs-1 text-secondary"></i>

                        </div>

                    @endif

                </div>


                <!-- Product Information -->

                <div class="col-md-6">

                    <span class="badge bg-secondary mb-3">

                        {{ $product->category->name ?? 'General' }}

                    </span>


                    <h1 class="fw-bold">

                        {{ $product->name }}

                    </h1>


                    <h2 class="text-success fw-bold mt-3">

                        ₹{{ number_format($product->price, 2) }}

                    </h2>


                    <hr>


                    <h5>
                        Description
                    </h5>

                    <p class="text-muted">

                        {{ $product->description }}

                    </p>


                    <!-- Stock -->

                    @if($product->stock > 0)

                        <div class="alert alert-success">

                            <i class="bi bi-check-circle"></i>

                            {{ $product->stock }} products available

                        </div>

                    @else

                        <div class="alert alert-danger">

                            <i class="bi bi-x-circle"></i>

                            Out of Stock

                        </div>

                    @endif


                    <!-- Quantity -->

                    @if($product->stock > 0)

                    <form action="/cart/add/{{ $product->id }}" method="POST">

                    @csrf

                    <div class="mb-3">
                    <label class="form-label fw-bold">
                      Quantity
                    </label>

                    <input
                     type="number"
                     name="quantity"
                     class="form-control"
                     value="1"
                     min="1"
                     max="{{ $product->stock }}"
                     style="width: 120px;"
            >
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus"></i>
                    Add to Cart
                    </button>

                    </form>

                    <!-- ADD TO WISHLIST -->

                    @if($isWishlisted)

                    <button
                    type="button"
                    class="btn btn-danger btn-lg mt-2"
                    disabled
                    >

                    <i class="bi bi-heart-fill"></i>

                       Wishlisted

                    </button>

                    @else

                    <form
                    action="/wishlist/add/{{ $product->id }}"
                    method="POST"
                    class="mt-2"
                    >

                    @csrf

                    <button
                    type="submit"
                    class="btn btn-outline-danger btn-lg"
                    >

                    <i class="bi bi-heart"></i>

                        Add to Wishlist

                    </button>

                    </form>

                    @endif

                    @else

                    <button class="btn btn-secondary btn-lg" disabled>
                    Out of Stock
                    </button>

                    @endif

                </div>

            </div>


    <!-- Recommended Products -->

    @if($recommendations->count() > 0)

        <div class="mt-5">

            <h2 class="fw-bold mb-4">
                Recommended For You
            </h2>

            <div class="row">

                @foreach($recommendations as $recommendedProduct)

                    <div class="col-md-6 col-lg-3 mb-4">

                        <div class="card h-100 border-0 shadow-sm">

                            <!-- Product Image -->

                            @if($recommendedProduct->image)

                                <img
                                    src="{{ asset('storage/products/' . $recommendedProduct->image) }}"
                                    class="card-img-top"
                                    alt="{{ $recommendedProduct->name }}"
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

                                    {{ $recommendedProduct->category->name ?? 'General' }}

                                </span>


                                <h5 class="card-title fw-bold">

                                    {{ $recommendedProduct->name }}

                                </h5>


                                <p class="text-success fw-bold">

                                    ₹{{ number_format($recommendedProduct->price, 2) }}

                                </p>


                                <div class="mt-auto">

                                    <a
                                        href="/products/{{ $recommendedProduct->id }}"
                                        class="btn btn-primary w-100"
                                    >

                                        <i class="bi bi-eye"></i>

                                        View Product

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</div>

@endsection