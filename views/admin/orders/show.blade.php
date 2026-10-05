@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-receipt"></i>
            Admin Order Details
        </h2>

        <a href="/admin/orders" class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back to Manage Orders

        </a>

    </div>


    <!-- SUCCESS MESSAGE -->

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


    <!-- ERROR MESSAGE -->

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


    <!-- ORDER INFORMATION -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="bi bi-info-circle"></i>

                Order Information

            </h5>

        </div>


        <div class="card-body">

            <div class="row">

                <!-- ORDER ID -->

                <div class="col-md-6 mb-3">

                    <strong>
                        Order ID:
                    </strong>

                    #{{ $order->id }}

                </div>


                <!-- CUSTOMER -->

                <div class="col-md-6 mb-3">

                    <strong>
                        Customer:
                    </strong>

                    {{ $order->user->name }}

                </div>


                <!-- EMAIL -->

                <div class="col-md-6 mb-3">

                    <strong>
                        Email:
                    </strong>

                    {{ $order->user->email }}

                </div>


                <!-- DATE -->

                <div class="col-md-6 mb-3">

                    <strong>
                        Order Date:
                    </strong>

                    {{ $order->created_at->format('d M Y h:i A') }}

                </div>


                <!-- PAYMENT -->

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


                <!-- STATUS -->

                <div class="col-md-6 mb-3">

                    <strong>
                        Current Status:
                    </strong>


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


                <!-- ADDRESS -->

                <div class="col-md-12">

                    <strong>

                        <i class="bi bi-geo-alt"></i>

                        Delivery Address:

                    </strong>

                    <p class="mt-2 mb-0">

                        {{ $order->address }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- ORDERED PRODUCTS -->

    <div class="card shadow-sm mb-4">

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


        <!-- TOTAL -->

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


    <!-- UPDATE STATUS -->

    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">

                <i class="bi bi-arrow-repeat"></i>

                Update Order Status

            </h5>

        </div>


        <div class="card-body">

            <form
                action="/admin/orders/{{ $order->id }}/status"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="row align-items-end">

                    <div class="col-md-8">

                        <label class="form-label fw-bold">

                            Order Status

                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >

                            <option
                                value="Pending"
                                {{ $order->status == 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="Processing"
                                {{ $order->status == 'Processing' ? 'selected' : '' }}
                            >
                                Processing
                            </option>

                            <option
                                value="Shipped"
                                {{ $order->status == 'Shipped' ? 'selected' : '' }}
                            >
                                Shipped
                            </option>

                            <option
                                value="Delivered"
                                {{ $order->status == 'Delivered' ? 'selected' : '' }}
                            >
                                Delivered
                            </option>

                            <option
                                value="Cancelled"
                                {{ $order->status == 'Cancelled' ? 'selected' : '' }}
                            >
                                Cancelled
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            <i class="bi bi-check-circle"></i>

                            Update Status

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection