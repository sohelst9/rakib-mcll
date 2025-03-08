@extends('Admin.app')
@section('content')
    <!-- Page Header -->
    <h4 class="fw-bold">
        <iconify-icon icon="mdi:wallet-outline" class="icon-title me-2"></iconify-icon>
        Deposit Cashback
    </h4>

    <!-- Two-Column Layout -->
    <div class="row g-4">
        <!-- Table Section -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Cashback List</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Deposit Amount</th>
                                    <th>Cashback</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cashbacks as $cashback)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $cashback->amount }}</td>
                                        <td>{{ $cashback->cashback_amount }}</td>
                                        <td>
                                            @if ($cashback->status == 1)
                                                <a href="{{ route('cashback.status', $cashback->id) }}"
                                                    class="badge bg-success">Active</a>
                                            @else
                                                <a href="{{ route('cashback.status', $cashback->id) }}"
                                                    class="badge bg-danger">Inactive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cashback.edit', $cashback->id) }}"
                                                class="btn btn-sm btn-warning me-2">Edit</a>
                                            <form action="{{ route('cashback.destroy', $cashback->id) }}"
                                                method="POST" onsubmit="return confirmDelete(event)"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirmDelete(event)">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add Cashback</h5>
                    <form action="{{ route('cashback.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Deposit Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control">
                            @error('amount')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cashback_amount" class="form-label">Cashback Amount</label>
                            <input type="number" name="cashback_amount" id="cashback_amount" class="form-control">
                            @error('cashback_amount')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event) {
            return confirm("Are you sure you want to delete this game?");
        }
    </script>
@endsection
