@extends('Admin.app')

@section('style')
   
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                <iconify-icon icon="mdi:controller-classic" class="icon-title"></iconify-icon> Banner
            </h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label for="title" class="form-label col-sm-3">
                                Title
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="title" class="form-control" id="title"
                                    value="{{ $banner->title }}">
                                @error('title')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="link" class="form-label col-sm-3">
                                Link
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="link" class="form-control" id="link"
                                    value="{{ $banner->link }}">
                                @error('link')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- image Input Section -->
                        <div class="mb-3 row">
                            <label for="image" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:image" class="icon-form"></iconify-icon> Image
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                @if ($banner->image)
                                    <img src="{{ asset($banner->image) }}" style="max-width: 200px;" class="mt-2">
                                @endif
                                @error('image')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="link" class="form-label col-sm-3">
                                Status
                            </label>
                            <div class="col-sm-9">
                                <select name="status" id="status" class="form-control">
                                    <option value="">-select-</option>
                                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <iconify-icon icon="mdi:send" class="me-2" style="font-size: 20px;"></iconify-icon>
                                <span>Submit</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>



    </div>
@endsection

@section('script')
    <script>
        //-- image preview function
       
    </script>
@endsection
