@extends('Admin.app')
@section('content')
    <!-- Page Header -->
    <h4 class="fw-bold">
        <iconify-icon icon="mdi:wallet-outline" class="icon-title me-2"></iconify-icon>
        Return Deposit Edit
    </h4>
    <a href="{{ route('admin.cash.return') }}" class="btn btn-sm btn-danger mt-4">Back</a>

    <!-- Two-Column Layout -->
    <div class="row g-4 mt-5">

        <!-- Form Section -->
        <div class="col-lg-8 m-auto mt-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Add Return Deposit</h5>
                    <form action="{{ route('admin.cash.return.update', $return_deposit->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user" class="form-label">User</label>
                            <select name="user_display" id="user" class="form-control" disabled>
                                <option value="">select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $return_deposit->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                        ({{ $user->totalbalance ? $user->totalbalance->balance . ' TK' : '0.00 TK' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="return_amount" class="form-label">Return Amount</label>
                            <input type="number" name="return_amount" id="return_amount"
                                value="{{ $return_deposit->return_amount }}" class="form-control">
                            @error('return_amount')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
