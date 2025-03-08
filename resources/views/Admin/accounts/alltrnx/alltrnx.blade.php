@extends('Admin.app')
@section('content')
<div class="card-body">
    <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
       <a href="{{ route('admin.alltrnx') }}"> <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
        All Transactions</a>
    </h5>

    <!-- Search Bar -->
    <div class="mb-3">
        <form action="{{ route('admin.alltrnx') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by User Name, Title, or Trnx. ID" value="{{ request('search') }}">
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
                            <th>Title</th>
                            <th>Trnx. Type</th>
                            <th>Amount</th>
                            <th>Trnx. ID</th>
                            <th>Status</th>
                            <th>Trnx. Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allTrnsactions as $allTrnsaction)
                            <tr>
                                <td>{{ ($allTrnsactions->currentPage() - 1) * $allTrnsactions->perPage() + $loop->iteration }}</td>
                                <td class="fw-bold">{{ $allTrnsaction->user_name }}</td>
                                <td class="fw-bold">{{ $allTrnsaction->title }}</td>
                                <td class="fw-bold">{{ $allTrnsaction->trnx_type }}</td>
                                <td class="fw-bold">{{ $allTrnsaction->amount }} TK</td>
                                <td class="fw-bold">{{ $allTrnsaction->trnx_id }}</td>
                                <td class="fw-bold">
                                    @if ($allTrnsaction->status == 1)
                                        <span class="badge bg-success">COMPLETE</span>
                                    @else
                                        <span class="badge bg-danger">PENDING</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($allTrnsaction->trnx_date)->format('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-danger fw-bold">No Transactions Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $allTrnsactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
