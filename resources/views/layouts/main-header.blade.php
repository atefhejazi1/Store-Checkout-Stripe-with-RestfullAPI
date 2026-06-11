<div id="kt_app_header" class="app-header">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
         id="kt_app_header_container">

        {{-- Mobile sidebar toggle --}}
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                 id="kt_app_sidebar_mobile_toggle">
                <i class="bi bi-list fs-2"></i>
            </div>
        </div>

        {{-- Mobile logo --}}
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ url('/') }}" class="d-lg-none fw-bold text-dark fs-5">
                {{ config('app.name') }}
            </a>
        </div>

        {{-- Right: user actions --}}
        <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1"
             id="kt_app_header_wrapper">
            <div class="app-navbar flex-shrink-0">

                <div class="app-navbar-item ms-2 ms-md-4">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-light fw-semibold">
                        <i class="bi bi-shop me-1"></i> Storefront
                    </a>
                </div>

                {{-- User dropdown --}}
                <div class="app-navbar-item ms-2 ms-md-4"
                     id="kt_header_user_menu_toggle">
                    <div class="cursor-pointer symbol symbol-35px"
                         data-kt-menu-trigger="click"
                         data-kt-menu-attach="parent"
                         data-kt-menu-placement="bottom-end">
                        <div class="symbol-label bg-light-primary fw-bold text-primary fs-7">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                         data-kt-menu="true">

                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label bg-light-primary fw-bold text-primary fs-4">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <span class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ auth()->user()->email }}
                                    </span>
                                    <span class="badge badge-light-primary mt-1">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="separator my-2"></div>

                        @if (auth()->user()->isAdmin())
                            <div class="menu-item px-5">
                                <a href="{{ route('admin.profile.edit') }}" class="menu-link px-5">
                                    <i class="bi bi-person me-2"></i> My Profile
                                </a>
                            </div>
                        @elseif (auth()->user()->isVendor() && auth()->user()->isApprovedVendor())
                            <div class="menu-item px-5">
                                <a href="{{ route('vendor.profile.edit') }}" class="menu-link px-5">
                                    <i class="bi bi-person me-2"></i> My Profile
                                </a>
                            </div>
                        @endif

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="menu-link px-5 border-0 bg-transparent w-100 text-start text-danger">
                                    <i class="bi bi-box-arrow-right me-2 text-danger"></i> Sign Out
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
