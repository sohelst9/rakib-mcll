@extends('Admin.app')
@section('content')
    <!-- Page Header -->
    <h4 class="fw-bold">
        <iconify-icon icon="mdi:wallet-outline" class="icon-title me-2"></iconify-icon>
        Return Deposit
    </h4>

    <!-- Two-Column Layout -->
    <div class="row g-4">

        <!-- Form Section -->
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add Return Deposit</h5>
                    <form action="{{ route('admin.cash.return.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user" class="form-label">User</label>
                            <select name="user" id="user" class="form-control">
                                <option value="">select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->totalbalance ? $user->totalbalance->balance. ' TK' : '0.00 TK' }})</option>
                                @endforeach
                            </select>
                            @error('user')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="return_amount" class="form-label">Return Amount</label>
                            <input type="number" name="return_amount" id="return_amount" class="form-control">
                            @error('return_amount')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Return Deposit List</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Return Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($returndatas as $returndata)
                                    <tr>
                                        <td>{{ ($returndatas->currentPage() - 1) * $returndatas->perPage() + $loop->iteration }} </td>
                                        <td>{{ $returndata->user ? $returndata->user->name : 'NA' }}</td>
                                        <td><span class="badge bg-secondary">{{ $returndata->return_amount }}</span></td>
                                       
                                        <td>
                                            <a href="{{ route('admin.cash.return.edit', $returndata->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                            {{-- <form action="{{ route('cashback.destroy', $cashback->id) }}"
                                                method="POST" onsubmit="return confirmDelete(event)"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirmDelete(event)">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $returndatas->links() }}
                    </div>
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
