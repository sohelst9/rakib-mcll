@extends('Admin.app')
@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
            <a href="{{ route('admin.withdraws.number') }}"> <iconify-icon icon="mdi:controller-classic"
                    class="icon-title me-2"></iconify-icon>
                All Withdraws Number</a>
        </h5>

        <!-- Search Bar -->
        <div class="mb-3">
            <form action="{{ route('admin.withdraws.number') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by User Name, or Number"
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
                                <th>Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdraw_numbers as $withdraw_number)
                                <tr>
                                    <td>{{ ($withdraw_numbers->currentPage() - 1) * $withdraw_numbers->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="fw-bold">{{ $withdraw_number->user ? $withdraw_number->user->name : 'N/A' }}
                                    </td>
                                    <td class="fw-bold">{{ $withdraw_number->number }}</td>
                                    <td>
                                        <a href="{{ route('admin.withdraws.number.edit', $withdraw_number->id) }}" class="text-primary me-2" title="Edit">
                                            <iconify-icon icon="mdi:pencil" class="fs-5"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.withdraws.number.delete', $withdraw_number->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this withdraw number?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-danger bg-transparent border-0" title="Delete">
                                                <iconify-icon icon="mdi:delete" class="fs-5"></iconify-icon>
                                            </button>
                                        </form> 
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger fw-bold">No withdraw Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                    </table>

                    {{ $withdraw_numbers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
