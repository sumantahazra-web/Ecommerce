@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-credit-card"></i>
            Checkout
        </h2>

        <a href="/cart" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Cart
        </a>
    </div>

    <div class="row">

        <!-- Checkout Form -->
        <div class="col-md-7">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-geo-alt"></i>
                        Delivery Information
                    </h5>
                </div>

                <div class="card-body">

                    <form action="/checkout" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Delivery Address
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                rows="5"
                                placeholder="Enter your complete delivery address"
                                required
                            ></textarea>

                            @error('address')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">

                        <label class="form-label fw-bold">
                        <i class="bi bi-credit-card"></i>
                          Payment Method
                        </label>

                        <div class="form-check border rounded p-3 mb-2">

                        <input
                         class="form-check-input"
                         type="radio"
                         name="payment_method"
                         id="cod"
                         value="Cash on Delivery"
                         checked
                        >

                        <label class="form-check-label" for="cod">

                        <strong>Cash on Delivery</strong>

                        <br>

                        <small class="text-muted">
                         Pay when your order is delivered.
                        </small>

                        </label>

                        </div>


                        <div class="form-check border rounded p-3">

                        <input
                         class="form-check-input"
                         type="radio"
                         name="payment_method"
                         id="online"
                         value="Online Payment"
                        >

                        <label class="form-check-label" for="online">

                        <strong>Online Payment</strong>

                        <br>

                        <small class="text-muted">
                         Pay online using a payment gateway.
                        </small>

                        </label>

                        </div>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-success btn-lg w-100"
                        >
                            <i class="bi bi-check-circle"></i>
                            Place Order
                        </button>

                    </form>

                </div>

            </div>

        </div>


        <!-- Order Summary -->
        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-cart3"></i>
                        Order Summary
                    </h5>
                </div>

                <div class="card-body">

                    @foreach($cartItems as $item)

                        <div class="d-flex justify-content-between mb-3">

                            <div>
                                <strong>
                                    {{ $item->product->name }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    ₹{{ number_format($item->product->price, 2) }}
                                    ×
                                    {{ $item->quantity }}
                                </small>
                            </div>

                            <div class="fw-bold">
                                ₹{{ number_format(
                                    $item->product->price * $item->quantity,
                                    2
                                ) }}
                            </div>

                        </div>

                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between">

                        <h5>Total</h5>

                        <h5 class="text-success">
                            ₹{{ number_format($total, 2) }}
                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection