@extends('Admin.app')
@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
            <a href="{{ route('admin.userlists') }}"> <iconify-icon icon="mdi:account-multiple-outline"
                    class="icon-title me-2"></iconify-icon>
                All Users</a>
        </h5>

        <!-- Search Bar -->
        <div class="mb-3">
            <form action="{{ route('admin.userlists') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by User Name"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <iconify-icon icon="mdi:magnify"></iconify-icon> Search
                </button>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>profile</th>
                                <th>Phone</th>
                                <th>Total Balance</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Block</th>
                                <th>Action</th>
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
                                    <td class="fw-bold">
                                        <span
                                            class="badge bg-primary">{{ $user->totalbalance ? $user->totalbalance->balance . ' TK' : '0 TK' }}</span>
                                    </td>
                                    <td class="fw-bold">
                                        @if ($user->is_otp_verified == 1)
                                            <span class="badge bg-success">Verify</span>
                                        @else
                                            <span class="badge bg-danger">Not Verify</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}
                                    </td>
                                    <td>
                                        @if ($user->is_block == 1)
                                            <a onclick="return confirm('Are you sure you want to block this user?')"
                                                href="{{ route('admin.user.block', $user->id) }}">
                                                <span class="badge bg-primary">No</span>
                                            </a>
                                        @else
                                            <a onclick="return confirm('Are you sure you want to unblock this user?')"
                                                href="{{ route('admin.user.block', $user->id) }}">
                                                <span class="badge bg-danger">Yes</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST"
                                            onsubmit="return confirmDelete(event)" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger bg-transparent border-0"
                                                title="Delete">
                                                <iconify-icon icon="mdi:delete" class="fs-5"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>


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
    <script>
        function confirmDelete(event) {
            if (confirm("Are you sure you want to delete this user?")) {
                return true;
            }
            return false;
        }
    </script>
@endsection
