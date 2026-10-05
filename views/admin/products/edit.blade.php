@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                <i class="bi bi-pencil-square"></i>
                Edit Product
            </h2>

            <p class="text-muted">
                Update product information
            </p>
        </div>

        <a href="/admin/products" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                action="/admin/products/{{ $product->id }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                {{-- Category --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Category
                    </label>

                    <select
                        name="category_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Product Name --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Product Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ $product->name }}"
                        required
                    >

                </div>


                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Description
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    >{{ $product->description }}</textarea>

                </div>


                {{-- Price --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Price
                    </label>

                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        value="{{ $product->price }}"
                        step="0.01"
                        min="0"
                        required
                    >

                </div>


                {{-- Stock --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Stock
                    </label>

                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        value="{{ $product->stock }}"
                        min="0"
                        required
                    >

                </div>


                {{-- Current Image --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Current Image
                    </label>

                    <br>

                    @if($product->image)

                        <img
                            src="{{ asset('storage/products/' . $product->image) }}"
                            width="150"
                            height="150"
                            class="rounded shadow-sm"
                            style="object-fit: cover;"
                        >

                    @else

                        <p class="text-muted">
                            No image available
                        </p>

                    @endif

                </div>


                {{-- New Image --}}
                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Change Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted">
                        Leave empty if you don't want to change the image.
                    </small>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-circle"></i>
                        Update Product
                    </button>

                    <a
                        href="/admin/products"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection