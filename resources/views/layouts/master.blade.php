<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body id="kt_app_body"
      data-kt-app-layout="light-sidebar"
      data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true"
      data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-footer="true"
      class="app-default">

    <script>
        var defaultThemeMode = "light";
        if (document.documentElement) {
            document.documentElement.setAttribute("data-theme", "light");
        }
    </script>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            @include('layouts.main-header')

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                @include('layouts.main-sidebar')

                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                    {{-- Breadcrumb toolbar --}}
                    <div class="app-toolbar py-3 py-lg-4">
                        <div class="app-container container-fluid d-flex align-items-center">
                            <div class="page-title d-flex flex-column justify-content-center me-3">
                                <h1 class="page-heading d-flex text-gray-900 fw-semibold fs-5 my-0">
                                    @yield('page_title', config('app.name'))
                                </h1>
                            </div>
                        </div>
                    </div>

                    {{-- Page content --}}
                    <div class="app-content flex-column-fluid">
                        <div class="app-container container-fluid">

                            @if (session('success'))
                                <div class="alert alert-success d-flex align-items-center mb-6 p-4">
                                    <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger d-flex align-items-center mb-6 p-4">
                                    <i class="bi bi-exclamation-circle-fill fs-3 text-danger me-3"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            @yield('content')

                        </div>
                    </div>

                    @include('layouts.footer')
                </div>

            </div>
        </div>
    </div>

    @include('layouts.scripts')
</body>
</html>
