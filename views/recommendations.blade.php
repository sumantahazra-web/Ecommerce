@extends('layouts.app')

@section('title', 'MyShop - Recommendations')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4 text-center">
        Recommended For You
    </h2>

    @if($products->count() > 0)

        <div class="row">

            @foreach($products as $product)

                <div class="col-md-3 mb-4">

                    <div class="card h-100 shadow-sm">

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

                    <div class="card-body">

                    <h5 class="card-title">
                        {{ $product->name }}
                    </h5>

                    <p class="card-text">
                        {{ $product->description }}
                    </p>

                    <p class="fw-bold text-success">
                         ₹{{ $product->price }}
                    </p>

                    <p>
                        Category:
                        {{ $product->category->name ?? 'N/A' }}
                    </p>

                    <a
                        href="{{ url('/products/' . $product->id) }}"
                        class="btn btn-dark"
                    >
                        View Product
                    </a>

                    </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="alert alert-info text-center">
            No recommendations available yet.
        </div>

    @endif

</div>

@endsection