@extends('layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-plus-circle"></i>
            Add Product
        </h2>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back to Products

        </a>

    </div>


    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Product Information
            </h5>

        </div>


        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf


                <!-- Category -->

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select name="category_id"
                            class="form-select"
                            required>

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Product Name -->

                <div class="mb-3">

                    <label class="form-label">
                        Product Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter product name"
                           value="{{ old('name') }}"
                           required>

                </div>


                <!-- Description -->

                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              placeholder="Enter product description">{{ old('description') }}</textarea>

                </div>


                <div class="row">

                    <!-- Price -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Price
                        </label>

                        <input type="number"
                               name="price"
                               class="form-control"
                               placeholder="Enter price"
                               step="0.01"
                               value="{{ old('price') }}"
                               required>

                    </div>


                    <!-- Stock -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Stock
                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               placeholder="Enter stock"
                               value="{{ old('stock') }}"
                               required>

                    </div>

                </div>


                <!-- Image -->

                <div class="mb-4">

                    <label class="form-label">
                        Product Image
                    </label>

                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">

                </div>


                <!-- Submit -->

                <button type="submit"
                        class="btn btn-primary">

                    <i class="bi bi-save"></i>
                    Save Product

                </button>

            </form>

        </div>

    </div>

</div>

@endsection