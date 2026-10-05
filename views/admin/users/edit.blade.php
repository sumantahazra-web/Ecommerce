@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h2 class="fw-bold">
                        <i class="bi bi-pencil-square"></i>
                        Edit User
                    </h2>

                    <p class="text-muted mb-0">
                        Update user information
                    </p>
                </div>

                <a
                    href="/admin/users"
                    class="btn btn-secondary"
                >
                    <i class="bi bi-arrow-left"></i>
                    Back to Users
                </a>

            </div>


            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="/admin/users/{{ $user->id }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Name --}}

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label fw-bold"
                            >
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Email --}}

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label fw-bold"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Role --}}

                        <div class="mb-4">

                            <label
                                for="role"
                                class="form-label fw-bold"
                            >
                                Role
                            </label>

                            <select
                                name="role"
                                id="role"
                                class="form-select @error('role') is-invalid @enderror"
                            >

                                <option
                                    value="user"
                                    {{ old('role', $user->role) === 'user' ? 'selected' : '' }}
                                >
                                    User
                                </option>

                                <option
                                    value="admin"
                                    {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                                >
                                    Admin
                                </option>

                            </select>

                            @error('role')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Password Notice --}}

                        <div class="alert alert-info">

                            <i class="bi bi-shield-lock"></i>

                            <strong>Password is not changed here.</strong>

                            <br>

                            The user's existing password will remain unchanged.

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-check-circle"></i>
                                Update User
                            </button>

                            <a
                                href="/admin/users"
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