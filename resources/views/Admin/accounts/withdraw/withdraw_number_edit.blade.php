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
                        <h5 class="card-title">Edit Withdraw Number</h5>
                        <a href="{{ route('admin.withdraws.number') }}" class="btn btn-sm btn-danger mb-3">Back</a>
                        <form action="{{ route('admin.withdraws.number.update', $withdraw_number->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 mt-4">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" name="number" id="number" class="form-control" value="{{ $withdraw_number->number }}">
                                @error('number')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
