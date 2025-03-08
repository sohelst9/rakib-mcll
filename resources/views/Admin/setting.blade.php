@extends('Admin.app')
@section('content')
    <div class="row">
        <div class="col-lg-5 m-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Setting</h5>
                    <form action="{{ route('admin.setting.update', $setting->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="app_name" class="form-label">App Name</label>
                            <input type="text" name="app_name" id="app_name" class="form-control" value="{{ $setting->app_name }}">
                            @error('app_name')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="withdraw_status" class="form-label">Withdraw Status</label>
                            <select name="withdraw_status" id="withdraw_status" class="form-control">
                                <option value="1" {{ $setting->withdraw_status == 1 ? 'selected' : '' }}>ON</option>
                                <option value="0" {{ $setting->withdraw_status == 0 ? 'selected' : '' }}>OFF</option>
                            </select>
                            @error('withdraw_status')
                                <p class="mt-2 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                       
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
@endsection
