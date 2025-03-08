<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Vibe | Admin Login</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/admin/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/styles.min.css') }}" />
       <!-- toster css--->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <h2 class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    Game Vibe
                                </h2>
                                <p class="text-center">Login</p>
                                <form action="{{ route('admin.login.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            id="exampleInputEmail1" aria-describedby="emailHelp">
                                        @error('email')
                                            <p class="mt-2 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1">
                                        @error('password')
                                            <p class="mt-2 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value=""
                                                id="showPasswordCheckbox">
                                            <label class="form-check-label text-dark" for="showPasswordCheckbox">
                                                Show password
                                            </label>
                                        </div>
                                        {{-- <a class="text-primary fw-bold" href="#">Forgot Password ?</a> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <!--- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <script type="text/javascript">
        @session('success')
        toastr.success("{{ $value }}");
        @endsession

        @session('error')
        toastr.error("{{ $value }}");
        @endsession
    </script>

    <script>
        // Show/Hide Password Script
        document.getElementById('showPasswordCheckbox').addEventListener('change', function() {
            const passwordInput = document.getElementById('exampleInputPassword1');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>


    <script>
        // Execute the script after the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the error message div by its ID
            let errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                // Remove the message after 5 seconds
                setTimeout(() => {
                    // Add a fade-out effect by gradually changing opacity
                    errorMessage.style.transition = 'opacity 0.5s ease';
                    errorMessage.style.opacity = '0';
                    // After the fade-out is complete, remove the element from the DOM
                    setTimeout(() => errorMessage.remove(), 500);
                }, 5000); // Wait for 5 seconds before starting the fade-out
            }
        });
    </script>


</body>

</html>
