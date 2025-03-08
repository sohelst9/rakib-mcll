@extends('Admin.app')
@section('content')
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament Price {{ $price->name }}
            </h4>
        </div>

        <!-- Two-Column Layout -->
        <div class="row g-4">
            <!-- Form Section -->
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Edit Price</h5>
                        <form action="{{ route('admin.tournament.game.price.update', $price->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="game_id" value="{{ $gameid }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $price->name }}">
                                @error('name')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control"
                                    value="{{ $price->price }}">
                                @error('price')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="number" name="position" id="position" class="form-control" value="{{ $price->position }}">
                                @error('position')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="1" {{ $price->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $price->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
