@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                <i class="bi bi-people"></i>
                Manage Users
            </h2>

            <p class="text-muted mb-0">
                View and manage registered users
            </p>
        </div>

        <a
            href="/admin"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Admin Management
        </a>

    </div>


    {{-- Success Message --}}
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


    {{-- Error Message --}}
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

        <div class="card-header">

            <h5 class="mb-0">
                <i class="bi bi-person-lines-fill"></i>
                Registered Users
            </h5>

        </div>


        <div class="card-body">

            @if($users->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th width="250">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($users as $user)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $user->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>

                                        @if($user->role === 'admin')

                                            <span class="badge bg-danger">
                                                Admin
                                            </span>

                                        @else

                                            <span class="badge bg-primary">
                                                User
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td>

                                        <a
                                        href="/admin/users/{{ $user->id }}"
                                        class="btn btn-info btn-sm"
                                        >
                                        <i class="bi bi-eye"></i>
                                        View
                                        </a>

                                        <a
                                        href="/admin/users/{{ $user->id }}/edit"
                                        class="btn btn-warning btn-sm"
                                        >
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                        </a>

                                        <form
                                        action="/admin/users/{{ $user->id }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')"
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

                    <i class="bi bi-people fs-1 text-muted"></i>

                    <h5 class="mt-3">
                        No users found
                    </h5>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection