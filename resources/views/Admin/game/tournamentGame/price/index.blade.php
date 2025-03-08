@extends('Admin.app')
@section('content')
    <div class="container py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.tournament.games') }}" class="btn btn-secondary">
                <iconify-icon icon="mdi:arrow-left" class="me-2"></iconify-icon>
                Back
            </a>
            <h4 class="fw-bold">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament Prices
            </h4>
        </div>

        <!-- Two-Column Layout -->
        <div class="row g-4">
            <!-- Table Section -->
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Price List</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($prices as $price)
                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ $price->name }}</td>
                                            <td>{{ $price->price }}</td>
                                            <td>{{ $price->position }}</td>
                                            <td>
                                                @if ($price->status == 1)
                                                    <a href="{{ route('admin.tournament.game.price.status', $price->id) }}"
                                                        class="badge bg-success">Active</a>
                                                @else
                                                    <a href="{{ route('admin.tournament.game.price.status', $price->id) }}"
                                                        class="badge bg-danger">Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.tournament.game.price.edit', $price->id) }}"
                                                    class="btn btn-sm btn-warning me-2">Edit</a>
                                                <form action="{{ route('admin.tournament.game.price.delete', $price->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
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
                        <h5 class="card-title">Add Price</h5>
                        <form action="{{ route('admin.tournament.game.price.store', $game->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                                @error('name')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control">
                                @error('price')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input type="number" name="position" id="position" class="form-control">
                                @error('position')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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

@section('script')
    <script>
        function confirmDelete(event) {
            return confirm("Are you sure you want to delete this game?");
        }
    </script>
@endsection
