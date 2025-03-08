@extends('Admin.app')
@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
            <a href="{{ route('admin.deposits') }}"> <iconify-icon icon="mdi:controller-classic"
                    class="icon-title me-2"></iconify-icon>
                All Deposits</a>
        </h5>

        <!-- Search Bar -->
        <div class="mb-3">
            <form action="{{ route('admin.deposits') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Search by User Name, Title, or Trnx. ID" value="{{ request('search') }}">
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
                                <th>Trnx. Type</th>
                                <th>Amount</th>
                                <th>Cashback</th>
                                <th>Total</th>
                                <th>Trnx. ID</th>
                                <th>Status</th>
                                <th>Trnx. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deposits as $deposit)
                                <tr>
                                    <td>{{ ($deposits->currentPage() - 1) * $deposits->perPage() + $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $deposit->user ? $deposit->user->name : 'N/A' }}</td>
                                    <td class="fw-bold">{{ $deposit->trnx_type }}</td>
                                    <td class="fw-bold">{{ $deposit->amount }} TK</td>
                                    <td class="fw-bold">{{ $deposit->cashback_amount }} TK</td>
                                    <td class="fw-bold">
                                        {{ number_format(($deposit->amount ?? 0) + ($deposit->cashback_amount ?? 0), 2) }}
                                        TK</td>
                                    <td class="fw-bold">{{ $deposit->trnx_id }}</td>
                                    <td class="fw-bold">
                                        @if ($deposit->status == 1)
                                            <a>
                                                <span class="badge bg-success">COMPLETE</span>
                                            </a>
                                        @else
                                            {{-- <a href="{{ route('admin.deposit.payment_status', $deposit->id) }}" 
                                           onclick="return confirm('Are you sure you want to mark this deposit as PENDING?');">
                                            <span class="badge bg-danger">PENDING</span>
                                        </a> --}}
                                            <a>
                                                <span class="badge bg-danger">PENDING</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($deposit->trnx_date)->format('d F Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger fw-bold">No Deposit Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Total Amount:</td>
                                <td class="text-center fw-bold text-primary">
                                    {{ number_format(
                                        $deposits->sum(function ($deposit) {
                                            return ($deposit->amount ?? 0) + ($deposit->cashback_amount ?? 0);
                                        }),
                                        2,
                                    ) }}
                                    TK
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>

                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
