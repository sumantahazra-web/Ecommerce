@extends('layouts.app')

@section('title', 'My Cart')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                <i class="bi bi-cart"></i>
                My Cart
            </h2>

            <p class="text-muted">
                Products added to your cart
            </p>
        </div>

        <a href="/dashboard" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Continue Shopping
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Cart will be displayed here --}}

    @if($cartItems->count() > 0)

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($cartItems as $item)

                            <tr>

                                <td>

                                    <div class="d-flex align-items-center">

                                        @if($item->product->image)

                                            <img
                                                src="{{ asset('storage/products/' . $item->product->image) }}"
                                                width="70"
                                                height="70"
                                                class="rounded me-3"
                                                style="object-fit: cover;"
                                            >

                                        @else

                                            <div
                                                class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                style="width:70px;height:70px;"
                                            >
                                                <i class="bi bi-image"></i>
                                            </div>

                                        @endif

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                {{ $item->product->name }}
                                            </h6>

                                            <small class="text-muted">
                                                {{ $item->product->category->name ?? 'General' }}
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    ₹{{ number_format($item->product->price, 2) }}
                                </td>

                                <td>

                                <form action="/cart/update/{{ $item->id }}" method="POST">

                                 @csrf

                                <div class="input-group" style="width: 140px;">

                                <input
                                type="number"
                                name="quantity"
                                value="{{ $item->quantity }}"
                                min="1"
                                max="{{ $item->product->stock }}"
                                class="form-control"
                                >

                                <button
                                type="submit"
                                class="btn btn-primary"
                                title="Update Quantity"
                                >
                                <i class="bi bi-arrow-repeat"></i>
                                </button>

                                </div>

                                </form>

                                </td>

                                <td class="fw-bold text-success">

                                    ₹{{ number_format(
                                        $item->product->price * $item->quantity,
                                        2
                                    ) }}

                                </td>

                                <td>

                                <form
                                action="/cart/remove/{{ $item->id }}"
                                method="POST"
                                >

                                @csrf

                                <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to remove this product?')"
                                >
                                <i class="bi bi-trash"></i>
                                Remove
                                </button>

                                </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <hr>
            
            <div class="d-flex justify-content-between align-items-center">

            <form
            action="/cart/clear"
            method="POST"
            onsubmit="return confirm('Are you sure you want to clear your cart?')"
            >

            @csrf

            <button type="submit" class="btn btn-outline-danger">

            <i class="bi bi-trash"></i>

            Clear Cart

            </button>

            </form>

            </div>

            <hr>

            <div class="d-flex justify-content-end">

                <div class="text-end">

                    <h5 class="text-muted">
                        Total Amount
                    </h5>

                    <h2 class="fw-bold text-success">
                        ₹{{ number_format($total, 2) }}
                    </h2>

                    <a href="/checkout" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-credit-card"></i>
                    Proceed to Checkout
                    </a>

                </div>

            </div>

        </div>

    </div>

@else

    <div class="card border-0 shadow-sm">

        <div class="card-body text-center p-5">

            <i class="bi bi-cart-x display-1 text-secondary"></i>

            <h3 class="mt-3">
                Your Cart is Empty
            </h3>

            <p class="text-muted">
                You haven't added any products yet.
            </p>

            <a href="/dashboard" class="btn btn-primary">
                <i class="bi bi-shop"></i>
                Start Shopping
            </a>

        </div>

    </div>

@endif

</div>

@endsection