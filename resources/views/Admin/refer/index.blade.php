@extends('Admin.app')
@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
            <a href="{{ route('admin.refer') }}"> <iconify-icon icon="mdi:account-multiple-outline"
                    class="icon-title me-2"></iconify-icon>
                All Users</a>
        </h5>

        <!-- Search Bar -->
        <div class="mb-3">
            <form action="{{ route('admin.refer') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by User Name or Phone"
                    value="{{ $search }}">
                <button type="submit" class="btn btn-primary">
                    <iconify-icon icon="mdi:magnify"></iconify-icon> Search
                </button>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- add button clear refer count to 0 all users -->
                <a href="{{ route('admin.refer.clear') }}" class="btn btn-danger mb-3"
                    onclick="return confirm('Are you sure you want to clear all refer counts?')">
                    Clear All Refer Count
                </a>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>profile</th>
                                <th>Phone</th>
                                <th>Refer Code</th>
                                <th>Total Refer</th>
                                <th>All Time Refer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td class="fw-bold">
                                        @if ($user->profile)
                                            <img src="{{ asset('profile/' . $user->profile) }}"
                                                alt="user_{{ $user->id }}" width="50" height="50"
                                                class="rounded-circle">
                                        @else
                                            <img src="{{ asset('profile/user-3.jpg') }}" alt="user_{{ $user->id }}"
                                                width="50" height="50" class="rounded-circle">
                                        @endif

                                    </td>
                                    <td class="fw-bold">{{ $user->phone }}</td>
                                    <td class="fw-bold">{{ $user->refer_code }}</td>
                                    <td class="fw-bold">{{ $user->refer_count }}</td>
                                    <td class="fw-bold">{{ $user->total_refer_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger fw-bold">No User Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
