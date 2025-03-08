@extends('Admin.app')
@section('content')
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                
            </h4>
        </div>

        <!-- Two-Column Layout -->
        <div class="row g-4">
            <!-- Form Section -->
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Edit Cashback</h5>
                        <form action="{{ route('cashback.update', $cashback->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="amount" class="form-label">Deposit Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" value="{{ $cashback->amount }}">
                                @error('amount')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="cashback_amount" class="form-label">Cashback Amount</label>
                                <input type="number" name="cashback_amount" id="cashback_amount" class="form-control" value="{{ $cashback->cashback_amount }}">
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
    </div>
@endsection
