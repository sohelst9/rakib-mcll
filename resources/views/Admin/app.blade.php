<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Game Vibe Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/admin/images/logos/favicon.png ') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/styles.min.css ') }}" />
    <!-- toster css--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

    @yield('style')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('Admin.inc.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('Admin.inc.navbar')
            <!--  Header End -->
            <div class="body-wrapper-inner">
                <div class="">
                    <!--  Row 1 -->
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>



    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <!--- toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- tinymce editor js --->
    <script src="{{ asset('admin/tinymce/tinymce.min.js') }}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @session('success')
        toastr.success("{{ $value }}");
        @endsession

        @session('info')
        toastr.info("{{ $value }}");
        @endsession

        @session('warning')
        toastr.warning("{{ $value }}");
        @endsession

        @session('error')
        toastr.error("{{ $value }}");
        @endsession


        // Function to update the date and time every second
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-BD', options); // Set locale for Bangladesh
            const formattedTime = now.toLocaleTimeString('en-BD'); // Set time for Bangladesh
            document.getElementById('currentDateTime').innerText = `${formattedDate}, ${formattedTime}`;
        }

        // Initialize and set interval to update every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    @yield('script')

</body>

</html>
