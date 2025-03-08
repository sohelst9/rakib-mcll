@extends('Admin.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament Total Players <span class="text-danger"> ({{ $details->count() }})</span>
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
                                    <th>Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">
                                            {{ $detail->user && $detail->user->name ? $detail->user->name : '' }}</td>
                                        <td>{{ $detail->tournament && $detail->tournament->name ? $detail->tournament->name : '' }}
                                        </td>
                                        <td>{{ $detail->amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total Amount:</td>
                                    <td class="fw-bold">{{ $details->sum('amount') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
