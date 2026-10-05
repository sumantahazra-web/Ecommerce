@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-receipt"></i>
            Order Details
        </h2>

        <a href="/my-orders" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to My Orders
        </a>

        @if($order->status == 'Pending')

        <form
        action="/my-orders/{{ $order->id }}/cancel"
        method="POST"
        class="d-inline"
        onsubmit="return confirm('Are you sure you want to cancel this order?');"
    >

        @csrf

        <button
            type="submit"
            class="btn btn-danger"
        >
            <i class="bi bi-x-circle"></i>
            Cancel Order
        </button>

        </form>

        @endif

    </div>


    <!-- ORDER INFORMATION -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Order #{{ $order->id }}
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Status:</strong>

                    @if($order->status == 'Pending')

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                    @elseif($order->status == 'Processing')

                        <span class="badge bg-info">
                            Processing
                        </span>

                    @elseif($order->status == 'Shipped')

                        <span class="badge bg-primary">
                            Shipped
                        </span>

                    @elseif($order->status == 'Delivered')

                        <span class="badge bg-success">
                            Delivered
                        </span>

                    @elseif($order->status == 'Cancelled')

                        <span class="badge bg-danger">
                            Cancelled
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ $order->status }}
                        </span>

                    @endif

                </div>

    <div class="col-md-6 mb-3">

    <strong>
        <i class="bi bi-credit-card"></i>
        Payment Method:
    </strong>

    @if($order->payment_method == 'Cash on Delivery')

        <span class="badge bg-success">
            Cash on Delivery
        </span>

    @elseif($order->payment_method == 'Online Payment')

        <span class="badge bg-primary">
            Online Payment
        </span>

    @else

        <span class="badge bg-secondary">
            {{ $order->payment_method }}
        </span>

    @endif

    </div>


                <div class="col-md-6 mb-3">

                    <strong>Order Date:</strong>

                    {{ $order->created_at->format('d M Y h:i A') }}

                </div>


                <div class="col-md-12 mb-3">

                    <strong>Delivery Address:</strong>

                    <p class="mt-1 mb-0">
                        {{ $order->address }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- PRODUCTS -->

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="bi bi-cart3"></i>

                Ordered Products

            </h5>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>Product</th>

                            <th>Price</th>

                            <th>Quantity</th>

                            <th>Subtotal</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($order->items as $item)

                            <tr>

                                <td>

                                    @if($item->product)

                                        {{ $item->product->name }}

                                    @else

                                        <span class="text-danger">
                                            Product no longer available
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    ₹{{ number_format(
                                        $item->price,
                                        2
                                    ) }}

                                </td>


                                <td>

                                    {{ $item->quantity }}

                                </td>


                                <td>

                                    ₹{{ number_format(
                                        $item->price * $item->quantity,
                                        2
                                    ) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        <div class="card-footer">

            <div class="d-flex justify-content-between">

                <h5>
                    Total Amount
                </h5>

                <h5 class="text-success">

                    ₹{{ number_format(
                        $order->total_amount,
                        2
                    ) }}

                </h5>

            </div>

        </div>

    </div>

</div>

@endsection