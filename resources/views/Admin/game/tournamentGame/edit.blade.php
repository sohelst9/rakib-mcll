@extends('Admin.app')

@section('style')
    <style>
        #imagePreview {
            width: 100%;
            max-width: 100px;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preview {
            /* display: none; */
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        #preview:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        /* Align icon and label properly */
        .icon-title {
            font-size: 24px;
            vertical-align: middle;
            margin-right: 8px;
        }

        /* Align icon and label in form fields */
        .icon-form {
            font-size: 20px;
            vertical-align: middle;
            margin-right: 8px;
        }

        /* Form Label Alignment */
        .form-label {
            display: flex;
            align-items: center;
        }

        /* Adjusting spacing between input and labels */
        .row {
            margin-bottom: 16px;
        }

        .form-control {
            margin-top: 8px;
        }

        /* For the submit button icon */
        button .iconify-icon {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                <iconify-icon icon="mdi:controller-classic" class="icon-title"></iconify-icon> Tournament Game Edit
            </h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tournament.game.update', $game->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Game Name Input Section -->
                        <div class="mb-3 row">
                            <label for="name" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:controller-classic" class="icon-form"></iconify-icon> Game Name
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $game->name }}">
                                @error('name')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Game Category Input Section -->
                        <div class="mb-3 row">
                            <label for="category" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:format-list-bulleted" class="icon-form"></iconify-icon> Game
                                Category
                            </label>
                            <div class="col-sm-9">
                                <select class="form-select" name="category_id" id="category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $game->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Game Start Date Input Section -->
                        <div class="mb-3 row">
                            <label for="start_date" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:calendar-start" class="icon-form"></iconify-icon> Start Date
                            </label>
                            <div class="col-sm-9">
                                <input type="date" name="start_date" class="form-control" id="start_date"
                                    placeholder="Select start date" value="{{ $game->start_date }}">
                                @error('start_date')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Game End Date Input Section -->
                        <div class="mb-3 row">
                            <label for="end_date" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:calendar-end" class="icon-form"></iconify-icon> End Date
                            </label>
                            <div class="col-sm-9">
                                <input type="date" name="end_date" class="form-control" id="end_date"
                                    placeholder="Select end date" value="{{ $game->end_date }}">
                                @error('end_date')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Game Entry Fee Input Section -->
                        <div class="mb-3 row">
                            <label for="entry_fee" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:currency-usd" class="icon-form"></iconify-icon> Entry Fee
                            </label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" name="entry_fee" class="form-control" id="entry_fee"
                                    placeholder="Enter fee amount" value="{{ $game->entry_fee }}">
                                @error('entry_fee')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <!-- Game Thumbnail Input Section -->
                        <div class="mb-3 row">
                            <label for="thumbnail" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:image" class="icon-form"></iconify-icon> Game Thumbnail
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                                    onchange="previewImage(event)" accept="image/*">
                                <div class="mt-2" id="imagePreview">
                                    <!-- Show existing thumbnail or placeholder -->
                                    <img id="preview" src="{{ $game->thumbnail ? asset($game->thumbnail) : '#' }}"
                                        alt="Thumbnail Preview"
                                        style="max-width: 200px; {{ $game->thumbnail ? '' : 'display: none;' }}">
                                </div>
                                @error('thumbnail')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Game File (.zip) Input Section -->
                        <div class="mb-3 row">
                            <label for="file" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:file-upload" class="icon-form"></iconify-icon> Game File (.zip)
                            </label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file" id="file" accept=".zip">
                                @error('file')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Game Description Input Section with TinyMCE -->
                        <div class="mb-3 row">
                            <label for="description" class="form-label col-sm-3">
                                <iconify-icon icon="mdi:clipboard-text" class="icon-form"></iconify-icon> Game Description
                            </label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" cols="30" rows="10">{!! $game->description !!}</textarea>
                                @error('description')
                                    <p class="mt-2 text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <iconify-icon icon="mdi:send" class="me-2" style="font-size: 20px;"></iconify-icon>
                                <span>Update</span>
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
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }


        // Initialize TinyMCE editor
        tinymce.init({
            selector: '#description', // Target the description textarea
            plugins: [
                'anchor', 'autolink', 'image', 'link', 'lists', 'media', 'table', 'wordcount',
                'spellcheckdialog', 'a11ycheck', 'typography', 'inlinecss', 'markdown'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                'See docs to implement AI Assistant'))
        });


        //-- date picker function
        // document.addEventListener("DOMContentLoaded", function() {
        //     flatpickr("#start_date", {
        //         dateFormat: "Y-m-d", // Format as YYYY-MM-DD
        //         altFormat: "F j, Y", // Pretty display (e.g., January 1, 2024)
        //         altInput: true, // Display formatted date in the input
        //         minDate: "today", // Disable past dates
        //     });

        //     flatpickr("#end_date", {
        //         dateFormat: "Y-m-d",
        //         altFormat: "F j, Y",
        //         altInput: true,
        //         minDate: "today", // Optional: Restrict to future dates only
        //     });
        // });
    </script>
@endsection
