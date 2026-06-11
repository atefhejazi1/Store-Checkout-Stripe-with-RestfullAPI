<div id="kt_app_sidebar" class="app-sidebar flex-column"
     data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="225px"
     data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    {{-- Logo --}}
    <div class="app-sidebar-logo px-6 border-bottom border-gray-200" id="kt_app_sidebar_logo">
        <a href="{{ url('/') }}" class="d-flex align-items-center">
            <span class="fw-bold text-dark fs-4 py-5">{{ config('app.name') }}</span>
        </a>
    </div>

    {{-- Menu --}}
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper"
             class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
             data-kt-scroll="true"
             data-kt-scroll-activate="true"
             data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-wrappers="#kt_app_sidebar_menu"
             data-kt-scroll-offset="5px">

            <div class="menu menu-column menu-rounded menu-sub-indention px-3"
                 id="kt_app_sidebar_menu"
                 data-kt-menu="true">

                @auth
                    @if (auth()->user()->isAdmin())

                        {{-- ── ADMIN NAV ─────────────────────────────── --}}
                        <div class="menu-item">
                            <div class="menu-content pb-2">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Platform</span>
                            </div>
                        </div>

                        <x-sidebar-item
                            :href="route('admin.dashboard')"
                            icon="bi-speedometer2"
                            label="Dashboard" />

                        <x-sidebar-item
                            :href="route('admin.vendors.index')"
                            icon="bi-shop"
                            label="Vendors" />

                        <div class="menu-item">
                            <div class="menu-content pb-2 pt-4">
                                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Catalogue</span>
                            </div>
                        </div>

                        <x-sidebar-item
                            :href="route('admin.categories.index')"
                            icon="bi-tags"
                            label="Categories" />

                        <x-sidebar-item
                            :href="route('admin.products.index')"
                            icon="bi-box-seam"
                            label="All Products" />

                    @elseif (auth()->user()->isVendor())

                        {{-- ── VENDOR NAV ────────────────────────────── --}}
                        @if (auth()->user()->isApprovedVendor())

                            <div class="menu-item">
                                <div class="menu-content pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">My Store</span>
                                </div>
                            </div>

                            <x-sidebar-item
                                :href="route('vendor.dashboard')"
                                icon="bi-speedometer2"
                                label="Dashboard" />

                            <x-sidebar-item
                                :href="route('vendor.products.index')"
                                icon="bi-box-seam"
                                label="My Products" />

                            <x-sidebar-item
                                :href="route('vendor.orders.index')"
                                icon="bi-receipt"
                                label="My Orders" />

                            <div class="menu-item">
                                <div class="menu-content pb-2 pt-4">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Settings</span>
                                </div>
                            </div>

                            <x-sidebar-item
                                :href="route('vendor.store.edit')"
                                icon="bi-gear"
                                label="Store Settings" />

                        @else

                            <div class="menu-item px-3 py-2">
                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-4 mt-3">
                                    <i class="bi bi-clock-history fs-3 text-warning me-3"></i>
                                    <div>
                                        <div class="fw-semibold text-gray-800 fs-7">Pending Approval</div>
                                        <div class="text-muted fs-8 mt-1">Your store is under review by our team.</div>
                                    </div>
                                </div>
                            </div>

                        @endif

                    @endif
                @endauth

            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-light w-100 fw-semibold">
                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
            </button>
        </form>
    </div>

</div>
