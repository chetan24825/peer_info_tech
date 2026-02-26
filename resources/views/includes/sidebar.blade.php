<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            {{-- <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
            <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
            <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
            <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo"> --}}

            <img src="{{ asset('assets/logo/peer-infotech-log.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/logo/peer-infotech-log.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/logo/peer-infotech-log.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/logo/peer-infotech-log.png') }}" alt="logo" class="toggle-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Dashboards</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="{{ route('dashboard') }}" class="side-menu__item">
                        {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <path
                                d="M104,216V152h48v64h64V120a8,8,0,0,0-2.34-5.66l-80-80a8,8,0,0,0-11.32,0l-80,80A8,8,0,0,0,40,120v96Z"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <span class="side-menu__label">Dashboards</span>
                    </a>
                    <ul class="slide-menu child1">

                    </ul>
                </li>

                @php
                    $today = date('Y-m-d');
                    $oneMonthLater = date('Y-m-d', strtotime('+1 month'));

                    $client_route = request()->routeIs(['clients.index', 'clients.create']);

                @endphp


                {{-- <li class="slide__category"><span class="category-name">Web Apps</span></li> --}}
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub {{ $client_route ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <rect x="48" y="48" width="64" height="64" rx="8" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <rect x="144" y="48" width="64" height="64" rx="8" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <rect x="48" y="144" width="64" height="64" rx="8" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <rect x="144" y="144" width="64" height="64" rx="8" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <span class="side-menu__label">Client</span>
                        <i class="ri-arrow-right-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="{{ route('clients.index') }}?service_type=&start_date=&end_date={{ $today }}"
                                class="side-menu__item">List</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('clients.create') }}" class="side-menu__item">Create</a>
                        </li>
                        {{-- <li class="slide">
              <a href="{{ route('clients.expiring.list') }}?service_type=&start_date={{ $today }}&end_date={{ $oneMonthLater }}"
                class="side-menu__item">
                Expiring Plan
              </a>
            </li> --}}
                </li>
            </ul>
            </li>


            <li class="slide has-sub">
                <a href="{{ route('plan.index') }}" class="side-menu__item">
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />

                        <!-- File outline -->
                        <path d="M48 32h112l48 48v144a8 8 0 0 1-8 8H48a8 8 0 0 1-8-8V40a8 8 0 0 1 8-8z" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />

                        <!-- Folded corner -->
                        <polyline points="160 32 160 80 208 80" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />

                        <!-- Checklist item 1 -->
                        <polyline points="80 120 96 136 128 104" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="144" y1="120" x2="192" y2="120" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />

                        <!-- Checklist item 2 -->
                        <polyline points="80 168 96 184 128 152" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="144" y1="168" x2="192" y2="168" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                    </svg>

                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                    <span class="side-menu__label">Plan</span>
                </a>
                <ul class="slide-menu child1">
                </ul>
            </li>



            {{-- <li class="slide__category"><span class="category-name">Dashboards</span></li> --}}
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="{{ route('import.excel.client.view') }}" class="side-menu__item">
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <!-- File outline -->
                        <path d="M48 32h112l48 48v144a8 8 0 0 1-8 8H48a8 8 0 0 1-8-8V40a8 8 0 0 1 8-8z" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <!-- Folded corner -->
                        <polyline points="160 32 160 80 208 80" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <!-- Excel X -->
                        <line x1="80" y1="120" x2="176" y2="200" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                        <line x1="176" y1="120" x2="80" y2="200" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                    </svg>
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                    <span class="side-menu__label">Import Excel</span>
                </a>
                <ul class="slide-menu child1">
                </ul>
            </li>


            <li class="slide has-sub">
                <a href="{{ route('country') }}" class="side-menu__item">
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <!-- Globe outline -->
                        <circle cx="128" cy="128" r="96" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <!-- Latitude lines -->
                        <line x1="32" y1="128" x2="224" y2="128" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                        <path d="M128 32c26.5 0 48 42 48 96s-21.5 96-48 96-48-42-48-96 21.5-96 48-96z" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <!-- Longitude lines -->
                        <line x1="128" y1="32" x2="128" y2="224" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                    </svg>
                    <span class="side-menu__label">Country</span>
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}

                    {{-- <span class="side-menu__label">Country</span> --}}

                </a>
                <ul class="slide-menu child1">

                </ul>
            </li>




            <li class="slide has-sub">
                <a href="{{ route('platform.index') }}" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <!-- Vertical line of P -->
                        <line x1="64" y1="48" x2="64" y2="208" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <!-- Rounded part of P -->
                        <path d="M64 48h64a32 32 0 0 1 0 64h-64" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="side-menu__label">Platform</span>
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}
                </a>
                <ul class="slide-menu child1">

                </ul>
            </li>


            <li class="slide has-sub">
                <a href="{{ route('website.index') }}" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <!-- Browser window outline -->
                        <rect x="32" y="48" width="192" height="160" rx="16" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <!-- Browser top bar -->
                        <line x1="32" y1="80" x2="224" y2="80" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                        <!-- Globe inside -->
                        <circle cx="128" cy="144" r="32" fill="none" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="128" y1="112" x2="128" y2="176" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                        <line x1="96" y1="144" x2="160" y2="144" stroke="currentColor"
                            stroke-width="16" stroke-linecap="round" />
                    </svg>
                    <span class="side-menu__label">Website Type</span>
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}






                </a>
                <ul class="slide-menu child1">

                </ul>
            </li>



            <li class="slide has-sub">
                <a href="{{ route('category.index') }}" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <!-- Top row of blocks -->
                        <rect x="40" y="40" width="64" height="64" rx="8" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="152" y="40" width="64" height="64" rx="8" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <!-- Bottom row of blocks -->
                        <rect x="40" y="152" width="64" height="64" rx="8" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <rect x="152" y="152" width="64" height="64" rx="8" fill="none"
                            stroke="currentColor" stroke-width="16" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="side-menu__label">Category</span>
                    {{-- <i class="ri-arrow-right-s-line side-menu__angle"></i> --}}


                </a>
                <ul class="slide-menu child1">

                </ul>
            </li>





            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
