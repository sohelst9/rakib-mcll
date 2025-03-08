<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

            <li class="nav-item d-none d-lg-block">
                <a class="nav-link" href="javascript:void(0)">
                    <iconify-icon icon="solar:clock-line-duotone" class="fs-6 me-1"></iconify-icon>
                    <span id="currentDateTime" class="fs-6"></span>
                </a>
            </li>

        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a href="{{ route('admin.logout') }}" class="btn btn-primary">Logout</a>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if (auth()->guard('admin')->user()->profile)
                            <img src="{{ asset('admin/user/' . auth()->guard('admin')->user()->profile) }}"
                                alt="" width="35" height="35" class="rounded-circle">
                        @else
                            <img src="{{ asset('assets/admin/images/profile/user-1.jpg ') }}" alt=""
                                width="35" height="35" class="rounded-circle">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="{{ route('admin.profile') }}"
                                class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                            <a href="{{ route('admin.logout') }}"
                                class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
