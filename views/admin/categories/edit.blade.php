@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h2 class="fw-bold">
                        <i class="bi bi-pencil-square"></i>
                        Edit Category
                    </h2>

                    <p class="text-muted mb-0">
                        Update category information
                    </p>
                </div>

                <a
                    href="/admin/categories"
                    class="btn btn-secondary"
                >
                    <i class="bi bi-arrow-left"></i>
                    Back to Categories
                </a>

            </div>


            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="/admin/categories/{{ $category->id }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        <div class="mb-4">

                            <label
                                for="name"
                                class="form-label fw-bold"
                            >
                                Category Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}"
                                placeholder="Enter category name"
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-check-circle"></i>
                                Update Category
                            </button>

                            <a
                                href="/admin/categories"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection