@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                <i class="bi bi-tags"></i>
                Manage Categories
            </h2>

            <p class="text-muted">
                Manage your product categories
            </p>
        </div>

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
                data-bs-dismiss="alert">
            </button>

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


    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Categories
            </h5>

            <a href="/admin/categories/create"
               class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Add Category

            </a>

        </div>


        <div class="card-body">

            @if($categories->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Created</th>
                                <th width="220">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($categories as $category)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $category->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $category->created_at->format('d M Y') }}
                                    </td>

                                    <td>

                                        <a
                                            href="/admin/categories/{{ $category->id }}/edit"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="/admin/categories/{{ $category->id }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
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

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <i class="bi bi-tags fs-1 text-muted"></i>

                    <h5 class="mt-3">
                        No categories found
                    </h5>

                    <p class="text-muted">
                        Create your first product category.
                    </p>

                    <a
                        href="/admin/categories/create"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Add Category
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection