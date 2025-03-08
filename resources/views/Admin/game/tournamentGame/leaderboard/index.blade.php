@extends('Admin.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament LeaderBoard 
            </h5>
            <a href="{{ route('admin.tournament.games') }}" class="btn btn-sm btn-danger">Back</a>
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Player Name</th>
                                    <th>Game Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tournamentScores as $tournamentScore)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">
                                            {{ $tournamentScore->user_name }}</td>
                                        <td>{{ $tournamentScore->tournament_name }}
                                        </td>
                                        <td>{{ $tournamentScore->score }}</td>
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
