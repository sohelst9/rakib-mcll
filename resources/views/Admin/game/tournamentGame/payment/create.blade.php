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
                Tournament Payment add
            </h4>
        </div>

        <div class="row mb-3">
            <!-- Form Section -->
            <div class="col-lg-8 m-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Send Payment</h5>
                        <form action="{{ route('admin.tournament.tournament_payment_store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Game Join User</label>
                                <input type="hidden" name="tgame_id" value="{{ $tGame->id }}">
                                <select name="name" id="name" class="form-control">
                                    <option value="">-select-</option>
                                    @foreach ($join_users as $detail)
                                        <option value="{{ $detail->user && $detail->user->id ? $detail->user->id : '' }}">{{ $detail->user && $detail->user->name ? $detail->user->name : '' }} ({{ $detail->user && $detail->user->phone ? $detail->user->phone : '' }})</option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            

                            {{-- <div class="mb-3">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" name="number" id="number" class="form-control">
                                @error('number')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control">
                                @error('amount')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center my-4">
            <a href="{{ route('admin.tournament.winingpayment_list') }}" class="btn btn-outline-primary btn-lg">
            <iconify-icon icon="mdi:currency-usd" class="me-2"></iconify-icon>
            View Payment List
            </a>
        </div>

        <!-- Two-Column Layout -->
        <div class="row g-4">
            <!-- Table Section -->
            <div class="col-lg-6">
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
                                                    <a class="badge bg-success">Active</a>
                                                @else
                                                    <a class="badge bg-danger">Inactive</a>
                                                @endif
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

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">LeaderBoard</h5>
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
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event) {
            return confirm("Are you sure you want to delete this game?");
        }

        //--- get user withdraw number---
        $(document).ready(function() {
            $('#name').change(function() {
                let userId = $(this).val();
                if (userId) {
                    $.ajax({
                        url: `/admin/tournament/get_user_withdraw_number/${userId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if(response.number){
                                $('#number').val(response.number)
                            }else{
                                $('#number').val('')
                            }
                           
                        }
                    });
                }
            });
        });
    </script>
@endsection
