@extends('Admin.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card bg-danger-subtle shadow-none w-100">
                        <div class="card-body">
                            <div class="d-flex mb-10 pb-1 justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-6">
                                    <div
                                        class="rounded-circle-shape bg-danger px-3 py-2 rounded-pill d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:gamepad-bold-duotone"
                                            class="fs-7 text-white"></iconify-icon>
                                    </div>
                                    <h6 class="mb-0 fs-4 fw-medium text-muted">
                                        Total Game
                                    </h6>
                                </div>
                            </div>
                            <div class="row align-items-end justify-content-between">
                                <div class="col-5">
                                    <h2 class="mb-6 fs-8">{{ $total_games }}</h2>
                                    <span
                                        class="badge rounded-pill border border-muted fw-bold text-muted fs-2 py-1">games</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card bg-danger-subtle shadow-none w-100">
                        <div class="card-body">
                            <div class="d-flex mb-10 pb-1 justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-6">
                                    <div
                                        class="rounded-circle-shape bg-danger px-3 py-2 rounded-pill d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:users-group-rounded-bold-duotone"
                                            class="fs-7 text-white"></iconify-icon>
                                    </div>
                                    <h6 class="mb-0 fs-4 fw-medium text-muted">
                                        Total Users
                                    </h6>
                                </div>
                            </div>
                            <div class="row align-items-end justify-content-between">
                                <div class="col-5">
                                    <h2 class="mb-6 fs-8">{{ $total_users }}</h2>
                                    <span class="badge rounded-pill border border-muted fw-bold text-muted fs-2 py-1">Total Users</span>
                                </div>
                            
                                <div class="col-5 text-end">
                                    <h2 class="mb-6 fs-8">{{ $total_users_balance }}</h2>
                                    <span class="badge rounded-pill border border-muted fw-bold text-muted fs-2 py-1">Total Balance</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- games section ---->
    <div class="row">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Thumbnail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($games as $game)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $game->name }}</td>
                                    <td class="fw-bold">
                                        <span class="badge bg-danger">
                                            {{ $game->category_id ? $game->category->name : 'No Category' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">
                                        <img src="{{ asset($game->thumbnail) }}" alt="Thumbnail" width="50"
                                            height="50" class="rounded-circle">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
