<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                <h3>Game Vibe</h3>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!--- dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!--- setting --->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.setting') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:desktop-classic"></iconify-icon>
                        <span class="hide-menu">Setting</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('category.index') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:desktop-classic"></iconify-icon>
                        <span class="hide-menu">Category</span>
                    </a>
                </li>

                
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('banner.index') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:desktop-classic"></iconify-icon>
                        <span class="hide-menu">Banner</span>
                    </a>
                </li>

                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <!--- dashboard end -->

                <!---Battle games part start -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Battle Games</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.battle.game.create') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:gamepad"></iconify-icon>
                        <span class="hide-menu">Add Game</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.battle.games') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:gamepad-outline"></iconify-icon>
                        <span class="hide-menu">Games</span>
                    </a>
                </li>

                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <!---Battle Games part end -->

                <!---Tournament games part start -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Tournament Games</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.tournament.game.create') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:controller-classic"></iconify-icon>
                        <span class="hide-menu">Add Game</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.tournament.games') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:controller-classic"></iconify-icon>
                        <span class="hide-menu">Games</span>
                    </a>
                </li>

                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <!---Battle Games part end -->



                <!---Accounts part start -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Accounts</span>
                </li>


                <!---- deposit----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.deposits') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:wallet-outline"></iconify-icon>
                        <span class="hide-menu">Deposits</span>
                    </a>
                </li>

                <!---- add deposit----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.add.cash') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:wallet-outline"></iconify-icon>
                        <span class="hide-menu">Add Cash</span>
                    </a>
                </li>


                <!---- return deposit----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.cash.return') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:wallet-outline"></iconify-icon>
                        <span class="hide-menu">Return Deposit</span>
                    </a>
                </li>

                <!---- cashback----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('cashback.index') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:wallet-outline"></iconify-icon>
                        <span class="hide-menu">Cashback Offers</span>
                    </a>
                </li>

                <!---- tournament wining payment----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.tournament.winingpayment_list') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
                        <span class="hide-menu">Tournament Wining</span>
                    </a>
                </li>

                <!---- all trnx----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.withdraws') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
                        <span class="hide-menu">Withdraws</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.withdraws.number') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
                        <span class="hide-menu">Withdraws Number</span>
                    </a>
                </li>

                <!---- all trnx----->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.alltrnx') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
                        <span class="hide-menu">All Trnx</span>
                    </a>
                </li>


                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <!---Accountd Games part end -->


                <!--- auth part start -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">AUTH</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.userlists') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:account-multiple-outline"></iconify-icon>
                        <span class="hide-menu">All Users</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.refer') }}" aria-expanded="false">
                        <iconify-icon icon="mdi:account-multiple-outline"></iconify-icon>
                        <span class="hide-menu">User by Refer</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <iconify-icon icon="mdi:account-multiple-outline"></iconify-icon>
                        <span class="hide-menu">All Admin</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" aria-expanded="false">
                        <iconify-icon icon="solar:user-plus-rounded-line-duotone"></iconify-icon>
                        <span class="hide-menu">Register</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <!--- auth part end -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
