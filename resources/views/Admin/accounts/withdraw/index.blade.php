@extends('Admin.app')
@section('content')
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
            <a href="{{ route('admin.withdraws') }}"> <iconify-icon icon="mdi:controller-classic"
                    class="icon-title me-2"></iconify-icon>
                All Withdraws</a>
        </h5>

        <!-- Search Bar -->
        <div class="mb-3">
            <form action="{{ route('admin.withdraws') }}" method="GET" class="d-flex">
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
                                <th>Withdraw Number</th>
                                <th>Trnx. Type</th>
                                <th>Amount</th>
                                <th>Trnx. ID</th>
                                <td>Update Trnx ID</td>
                                <th>Status</th>
                                <th>Trnx. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdraws as $withdraw)
                                <tr>
                                    <td>{{ ($withdraws->currentPage() - 1) * $withdraws->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="fw-bold">{{ $withdraw->user ? $withdraw->user->name : 'N/A' }}</td>
                                    <td>{{ $withdraw->withdraw_number ? $withdraw->withdraw_number->number : 'N/A' }}</td>

                                    <td class="fw-bold">{{ $withdraw->trnx_type }}</td>
                                    <td class="fw-bold">{{ $withdraw->amount }} TK</td>
                                    <td class="fw-bold">{{ $withdraw->trnx_id }}</td>
                                    <td>
                                        <form class="update-trnx-form" data-id="{{ $withdraw->id }}"
                                            style="display: flex; gap: 5px; align-items: center;">
                                            @csrf
                                            <input type="text" name="trnx_id" class="trnx-input"
                                                value="{{ $withdraw->trnx_id }}"
                                                style="padding: 5px; border: 1px solid #ddd; border-radius: 5px; width: 120px;">
                                            <button type="submit" class="update-btn"
                                                style="padding: 5px 10px; border: none; background-color: #28a745; color: white; border-radius: 5px; cursor: pointer;">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">
                                        @if ($withdraw->status == 1)
                                            <a>
                                                <span class="badge bg-success">COMPLETE</span>
                                            </a>
                                        @else
                                            {{-- <a href="{{ route('admin.deposit.payment_status', $deposit->id) }}" 
                                           onclick="return confirm('Are you sure you want to mark this deposit as PENDING?');">
                                            <span class="badge bg-danger">PENDING</span>
                                        </a> --}}
                                            <a href="{{ route('admin.withdraw.status', $withdraw->id) }}"
                                                onclick="return confirm('Are you sure you want to mark this withdrawal as COMPLETE?');">
                                                <span class="badge bg-danger">PENDING</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ \Carbon\Carbon::parse($withdraw->trnx_date)->format('d F Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger fw-bold">No withdraw Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total Amount:</td>
                                <td class="text-start fw-bold text-primary">
                                    {{ number_format(
                                        $withdraws->sum(function ($withdraw) {
                                            return $withdraw->amount ?? 0;
                                        }),
                                        2,
                                    ) }}
                                    TK
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>

                    {{ $withdraws->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".update-trnx-form").submit(function(e) {
                e.preventDefault(); 

                var form = $(this);
                var withdrawId = form.data("id");
                var trnxId = form.find(".trnx-input").val();
                var submitButton = form.find(".update-btn");

                submitButton.text("Updating...").prop("disabled", true); 

                $.ajax({
                    url: "/admin/withdraw/update/" + withdrawId,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        trnx_id: trnxId
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                    },
                    complete: function() {
                        submitButton.text("Update").prop("disabled", false);
                    }
                });
            });
        });
    </script>
@endsection
