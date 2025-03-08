@extends('Admin.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
                <iconify-icon icon="mdi:controller-classic" class="icon-title me-2"></iconify-icon>
                Tournament Wining Payment Lists
            </h5>
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Tournament</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Trnx Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tournament_payment_lists as $tournament_payment_list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->title }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->user && $tournament_payment_list->user->name ? $tournament_payment_list->user->name : '' }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->tournament && $tournament_payment_list->tournament->name ? $tournament_payment_list->tournament->name : '' }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->payment_type }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->amount }}</td>
                                        <td class="fw-bold">{{ $tournament_payment_list->trnx_date }}</td>
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
    
@endsection
