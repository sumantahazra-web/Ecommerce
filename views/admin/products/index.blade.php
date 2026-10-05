@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-box-seam"></i>
            Manage Products
        </h2>

        <a href="{{ route('admin.products.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Add Product

        </a>

        <a href="/admin" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Admin Management
        </a>

    </div>


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


    <div class="card shadow">

    <div class="card-body">

     <div class="table-responsive">

    <table class="table table-bordered table-hover align-middle">

    <thead class="table-dark">

        <tr>

            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>

        </tr>

    </thead>


        <tbody>

        @forelse($products as $product)

            <tr>

            <td>
                {{ $product->id }}
            </td>


            <td>

                @if($product->image)

                <img src="{{ asset('products/' . $product->image) }}"
                width="70"
                height="70"
                style="object-fit: cover;"
                class="rounded">

                @else

                <i class="bi bi-image fs-2 text-secondary"></i>

                @endif

                </td>


                <td>
                {{ $product->name }}
                 </td>


                <td>

                {{ $product->category->name ?? 'N/A' }}

                </td>


                <td>

                ₹{{ number_format($product->price, 2) }}

                </td>


                <td>

                @if($product->stock > 0)

                <span class="badge bg-success">

                {{ $product->stock }}

                </span>

                @else

                <span class="badge bg-danger">

                Out of Stock

                </span>

                @endif

                </td>


                <td>

                <a
                href="/admin/products/{{ $product->id }}/edit"
                class="btn btn-warning btn-sm"
                >
                <i class="bi bi-pencil-square"></i>
                Edit
                </a>

                <form
                action="/admin/products/{{ $product->id }}"
                method="POST"
                class="d-inline"
                onsubmit="return confirm('Are you sure you want to delete this product?')"
                >

                @csrf

                @method('DELETE')

                <button
                type="submit"
                class="btn btn-danger btn-sm"
                >
                <i class="bi bi-trash"></i>
                Delete
                </button>

                </form>

                </td>

                </tr>

                @empty

                <tr>

                <td colspan="7"
                class="text-center">

                No products found.

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