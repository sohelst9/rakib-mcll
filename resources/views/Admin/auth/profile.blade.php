@extends('Admin.app')
@section('style')
    <!-- Custom Styles -->
    <style>
        .profile-image-container {
            display: inline-block;
            position: relative;
        }

        .upload-icon {
            cursor: pointer;
            transform: translate(25%, -25%);
        }

        .upload-icon .btn {
            padding: 5px;
        }

        .status-indicator {
            font-size: 14px;
            color: green;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-indicator i {
            margin-right: 5px;
        }


        /* current time css */
        #currentTime {
            font-family: 'Arial', sans-serif;
            font-size: 1.4rem;
            /* Smaller text size */
            font-weight: bold;
            color: #333;
            background-color: #fff;
            padding: 8px 16px;
            /* Smaller button padding */
            border: 2px solid #ddd;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            opacity: 0;
            /* Initially hidden for fade-in animation */
            animation: fadeIn 3s ease-out forwards, pulse 4s infinite;
            /* Slow fade-in and pulse animation */
        }

        /* Slow fade-in effect with very smooth animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
                /* Start from below */
            }

            50% {
                opacity: 0.5;
                transform: translateY(10px);
                /* Mid-way point */
            }

            100% {
                opacity: 1;
                transform: translateY(0);
                /* Final position */
            }
        }

        /* Pulse animation to add dynamic movement to the button */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
        }

        #currentTime:hover {
            border-color: #007bff;
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
            transform: scale(1.05);
            /* Slight increase in size on hover */
        }

        #currentTime::before {
            content: "⏰ ";
            font-size: 1.2rem;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            #currentTime {
                font-size: 1.2rem;
                /* Smaller text on mobile */
            }
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Greeting -->
                <h5 class="card-title fw-semibold mb-3">
                    👋 Hello, {{ $user->name }}! <span id="greetingMessage"></span>
                </h5>

                <!-- Profile Image Centered -->
                <div class="text-center mb-4">
                    <div class="profile-image-container position-relative">
                        @if ($user->profile)
                            <img id="profileImage" src="{{ asset('admin/user/' . $user->profile) }}" alt="Profile Image"
                                class="rounded-circle img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                                onclick="document.getElementById('profileUpload').click();">
                        @else
                            <img id="profileImage" src="{{ asset('assets/admin/images/profile/user-1.jpg') }}"
                                alt="Profile Image" class="rounded-circle img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                                onclick="document.getElementById('profileUpload').click();">
                        @endif
                        <label for="profileUpload" class="upload-icon position-absolute bottom-0 end-0">
                            <span class="btn btn-sm btn-primary rounded-circle">
                                <i class="bi bi-camera"></i>
                            </span>
                        </label>
                        <input type="file" id="profileUpload" name="profile" class="d-none" accept="image/*"
                            onchange="updateProfileImage(this)">
                    </div>

                    <!-- Online Status -->
                    <div class="status-indicator mt-2">
                        <i class="bi bi-circle-fill"></i> Online
                    </div>

                    <!--- error message---->
                    @error('profile')
                        <p class="text-danger mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Card with Form -->
                <div class="card">
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ $user->name }}">
                            @error('name')
                                <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                value="{{ $user->email }}" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Change -->
    <h5 class="card-title fw-semibold mb-4">Password Change</h5>
    <div class="card mb-0">
        <div class="card-body">
            <form action="{{ route('admin.password.update') }}" method="POST">
                @csrf
                <!-- Old Password -->
                {{-- <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" name="old_password" class="form-control" id="old_password">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="showOldPassword"
                            onchange="toggleCheckboxPassword('old_password', this)">
                        <label class="form-check-label" for="showOldPassword">Show password</label>
                    </div>
                </div> --}}

                <!-- New Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="showPassword"
                            onchange="toggleCheckboxPassword('password', this)">
                        <label class="form-check-label" for="showPassword">Show password</label>
                    </div>
                    @error('password')
                        <p class="text-danger mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="showConfirmPassword"
                            onchange="toggleCheckboxPassword('confirm_password', this)">
                        <label class="form-check-label" for="showConfirmPassword">Show password</label>
                    </div>
                    @error('confirm_password')
                        <p class="text-danger mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- JavaScript -->
    <script>
        //- profile image upload
        function updateProfileImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        //-- Show Password Function
        function toggleCheckboxPassword(fieldId, checkbox) {
            const inputField = document.getElementById(fieldId);
            inputField.type = checkbox.checked ? 'text' : 'password';
        }

        // Set the dynamic greeting message

        window.onload = function() {
            const greetingElement = document.getElementById('greetingMessage');

            // Get current hour
            const currentHour = new Date().getHours();

            // Determine greeting based on the time of day
            let greetingMessage;
            if (currentHour >= 0 && currentHour < 12) {
                greetingMessage = "Good Morning, hope you have a productive day ahead!";
            } else if (currentHour >= 12 && currentHour < 17) {
                greetingMessage = "Good Afternoon, keep up the great work!";
            } else {
                greetingMessage = "Good Evening, relax and enjoy your time!";
            }

            // Set the dynamic greeting message
            greetingElement.textContent = greetingMessage;
        };
    </script>
@endsection
