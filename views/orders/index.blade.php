@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-bag-check"></i>
            My Orders
        </h2>

        <a href="/dashboard" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Shop
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

    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        <i class="bi bi-exclamation-triangle"></i>

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

    @endif


    <!-- Orders -->
    @if($orders->count() > 0)

        <div class="card shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>Order ID</th>

                                <th>Total</th>

                                <th>Address</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($orders as $order)

                                <tr>

                                    <td>
                                        <strong>
                                            #{{ $order->id }}
                                        </strong>
                                    </td>

                                    <td>
                                        ₹{{ number_format(
                                            $order->total_amount,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        {{ $order->address }}
                                    </td>

                                    <td>

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

                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>

                                    <td>

                                        <a
                                            href="/my-orders/{{ $order->id }}"
                                            class="btn btn-info btn-sm"
                                        >
                                            <i class="bi bi-eye"></i>
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @else

        <!-- No Orders -->
        <div class="card shadow-sm">

            <div class="card-body text-center py-5">

                <i
                    class="bi bi-bag-x"
                    style="font-size: 60px;"
                ></i>

                <h4 class="mt-3">
                    No Orders Yet
                </h4>

                <p class="text-muted">
                    You haven't placed any orders yet.
                </p>

                <a
                    href="/dashboard"
                    class="btn btn-primary"
                >
                    <i class="bi bi-shop"></i>
                    Start Shopping
                </a>

            </div>

        </div>

    @endif

</div>

@endsection