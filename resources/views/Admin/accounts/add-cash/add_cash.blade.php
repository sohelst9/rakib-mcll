@extends('Admin.app')
@section('content')
    <!-- Page Header -->
    <h4 class="fw-bold">
        <iconify-icon icon="mdi:wallet-outline" class="icon-title me-2"></iconify-icon>
        Add Cash
    </h4>

    <!-- Two-Column Layout -->
    <div class="row g-4">

        <!-- Form Section -->
        <div class="col-lg-5 m-auto mt-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add Cash</h5>
                    <form action="{{ route('admin.add.cash.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user" class="form-label">User</label>
                            <select name="user" id="user" class="form-control">
                                <option value="">select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}
                                        ({{ $user->totalbalance ? $user->totalbalance->balance . ' TK' : '0.00 TK' }})
                                        ({{ $user->phone }})</option>
                                @endforeach
                            </select>
                            @error('user')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                            @error('title')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="add_amount" class="form-label">Add Amount</label>
                            <input type="number" name="add_amount" id="add_amount" class="form-control">
                            @error('add_amount')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                            @error('date')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        {{-- <div class="col-lg-7">
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
        </div> --}}


    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event) {
            return confirm("Are you sure you want to delete this game?");
        }

        $(document).ready(function() {
            $('#user').select2({
                width: '100%'
            });
        });
    </script>
@endsection
