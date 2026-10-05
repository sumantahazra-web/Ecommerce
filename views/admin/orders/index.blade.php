@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-box-seam"></i>
            Manage Orders
        </h2>

        <a href="/admin" class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back to Admin Management

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


    <!-- ORDERS TABLE -->

    <div class="card shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>Order ID</th>

                            <th>Customer</th>

                            <th>Total</th>

                            <th>Payment Method</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($orders as $order)

                            <tr>

                                <!-- ORDER ID -->

                                <td>

                                    <strong>
                                        #{{ $order->id }}
                                    </strong>

                                </td>


                                <!-- CUSTOMER -->

                                <td>

                                    {{ $order->user->name }}

                                    <br>

                                    <small class="text-muted">
                                        {{ $order->user->email }}
                                    </small>

                                </td>


                                <!-- TOTAL -->

                                <td>

                                    ₹{{ number_format(
                                        $order->total_amount,
                                        2
                                    ) }}

                                </td>


                                <!-- PAYMENT -->

                                <td>

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

                                </td>


                                <!-- STATUS -->

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


                                <!-- DATE -->

                                <td>

                                    {{ $order->created_at->format('d M Y') }}

                                </td>


                                <!-- ACTION -->

                                <td>

                                    <a
                                        href="/admin/orders/{{ $order->id }}"
                                        class="btn btn-info btn-sm"
                                    >

                                        <i class="bi bi-eye"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="bi bi-box-seam"
                                        style="font-size: 50px;"
                                    ></i>

                                    <h5 class="mt-3">
                                        No Orders Found
                                    </h5>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection