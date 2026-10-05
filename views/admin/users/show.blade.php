@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h2 class="fw-bold">
                        <i class="bi bi-person-circle"></i>
                        User Details
                    </h2>

                    <p class="text-muted mb-0">
                        View registered user information
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

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        <i class="bi bi-person"></i>
                        {{ $user->name }}
                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="row mb-3">

                        <div class="col-md-4 fw-bold">
                            User ID
                        </div>

                        <div class="col-md-8">
                            {{ $user->id }}
                        </div>

                    </div>


                    <hr>


                    <div class="row mb-3">

                        <div class="col-md-4 fw-bold">
                            Name
                        </div>

                        <div class="col-md-8">
                            {{ $user->name }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-md-4 fw-bold">
                            Email
                        </div>

                        <div class="col-md-8">
                            {{ $user->email }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-md-4 fw-bold">
                            Role
                        </div>

                        <div class="col-md-8">

                            @if($user->role === 'admin')

                                <span class="badge bg-danger">
                                    Admin
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    User
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-md-4 fw-bold">
                            Registered On
                        </div>

                        <div class="col-md-8">
                            {{ $user->created_at->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4 fw-bold">
                            Last Updated
                        </div>

                        <div class="col-md-8">
                            {{ $user->updated_at->format('d M Y, h:i A') }}
                        </div>

                    </div>

                </div>


                <div class="card-footer">

                    <a
                        href="/admin/users"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-arrow-left"></i>
                        Back to Users
                    </a>

                    <a
                        href="/admin/users/{{ $user->id }}/edit"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-pencil-square"></i>
                        Edit User
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection