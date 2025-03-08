@extends('Admin.app')
@section('style')
<style>
    
</style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 d-flex align-items-center">
                <iconify-icon icon="mdi:apps-box" class="icon-title me-2"></iconify-icon>
                Categories
            </h5>
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $category->name }}</td>
                                    <td>
                                        <a href="" class="text-primary me-2" title="Edit">
                                            <iconify-icon icon="mdi:pencil" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="" class="text-danger" title="Delete">
                                            <iconify-icon icon="mdi:delete" class="fs-5"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
