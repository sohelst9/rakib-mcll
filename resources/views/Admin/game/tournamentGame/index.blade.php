@extends('Admin.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament Games
            </h5>
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Total Players</th>
                                    <th>LeaderBoard</th>
                                    <th>Payment</th>
                                    <th>Category</th>
                                    <th>Thumbnail</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Fee</th>
                                    <th>Price</th>
                                    <th>Play Game</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($games as $game)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $game->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.tournament.game.players', $game->slug) }}" class="btn btn-sm btn-success">View</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tournament.game.leaderboard', $game->slug) }}" class="btn btn-sm btn-secondary">View</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tournament.payment', $game->slug) }}" class="btn btn-sm btn-primary">Add</a>
                                        </td>
                                        <td class="fw-bold">
                                            <span class="badge bg-danger">
                                                {{ $game->category_id ? $game->category->name : 'No Category' }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">
                                            <img src="{{ asset($game->thumbnail) }}" alt="Thumbnail" width="50"
                                                height="50" class="rounded-circle">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($game->start_date)->format('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($game->end_date)->format('d F Y') }}</td>
                                        <td>&#2547;{{ $game->entry_fee }}</td>
                                        <td>
                                            <a href="{{ route('admin.tournament.game.price', $game->slug) }}" class="btn btn-success btn-sm">
                                                Add
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ asset($game->file) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                Play
                                            </a>
                                        </td>

                                        <td>
                                            @if ($game->status == 1)
                                                <a href="{{ route('admin.tournament.game.status', $game->slug) }}"><span class="badge bg-success">Active</span></a>
                                            @else
                                                <a href="{{ route('admin.tournament.game.status', $game->slug) }}"><span class="badge bg-danger">Inactive</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.tournament.game.edit', $game->slug) }}"
                                                class="text-primary me-3" title="Edit">
                                                <iconify-icon icon="mdi:pencil" class="fs-5"></iconify-icon>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.tournament.game.delete', ['slug' => $game->slug]) }}"
                                                method="POST" onsubmit="return confirmDelete(event)"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger bg-transparent border-0"
                                                    title="Delete">
                                                    <iconify-icon icon="mdi:delete" class="fs-5"></iconify-icon>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event) {
            if (confirm("Are you sure you want to delete this game?")) {
                return true;
            }
            return false;
        }
    </script>
@endsection
