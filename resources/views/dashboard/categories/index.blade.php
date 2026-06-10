@extends('layouts.master')

@section('page_title', 'Dashboard - Multi Vendor Store')

@section('title', 'Home')
@section('sub_title', 'Categories')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">


        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <!--begin::Toolbar-->
            <div class="container-fluid">
                @if (session()->has('success'))
                    <div class="alert alert-primary">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session()->has('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif
            </div>
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor">
                                        </rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" data-kt-ecommerce-category-filter="search"
                                    class="form-control form-control-solid w-250px ps-14" placeholder="Search Category">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">Add
                                Category</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div id="kt_ecommerce_category_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="kt_ecommerce_category_table">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1"
                                                aria-label="



														"
                                                style="width: 29.8906px;">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                        data-kt-check-target="#kt_ecommerce_category_table .form-check-input"
                                                        value="1">
                                                </div>
                                            </th>
                                            <th class="min-w-250px sorting" tabindex="0"
                                                aria-controls="kt_ecommerce_category_table" rowspan="1" colspan="1"
                                                aria-label="Category: activate to sort column ascending"
                                                style="width: 790.188px;">Category</th>
                                            <th class="min-w-250px sorting" tabindex="0"
                                                aria-controls="kt_ecommerce_category_table" rowspan="1" colspan="1"
                                                aria-label="Category: activate to sort column ascending"
                                                style="width: 790.188px;">Parent</th>
                                            <th class="min-w-250px sorting" tabindex="0"
                                                aria-controls="kt_ecommerce_category_table" rowspan="1" colspan="1"
                                                aria-label="Category: activate to sort column ascending"
                                                style="width: 790.188px;">Products #</th>
                                            <th class="min-w-250px sorting" tabindex="0"
                                                aria-controls="kt_ecommerce_category_table" rowspan="1" colspan="1"
                                                aria-label="Category: activate to sort column ascending"
                                                style="width: 790.188px;">States</th>
                                            <th class="min-w-250px sorting" tabindex="0"
                                                aria-controls="kt_ecommerce_category_table" rowspan="1" colspan="1"
                                                aria-label="Category: activate to sort column ascending"
                                                style="width: 790.188px;">Created At</th>
                                            <th class="text-end min-w-70px sorting_disabled" rowspan="1" colspan="1"
                                                aria-label="Actions" style="width: 135.781px;">Actions</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($categories as $category)
                                            <tr class="odd">
                                                <!--begin::Checkbox-->
                                                <td>
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                    </div>
                                                </td>
                                                <!--end::Checkbox-->
                                                <!--begin::Category=-->
                                                <td>
                                                    <div class="d-flex">
                                                        <!--begin::Thumbnail-->
                                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                            class="symbol symbol-50px">
                                                            <span class="symbol-label"
                                                                {{-- style="background-image: url('{{ asset('uploads/' . $category->image) }}');"></span> --}}
                                                                style="background-image: url('{{  $category->imageurl }}');"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                                class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                                data-kt-ecommerce-category-filter="category_name">{{ $category->name }}</a>
                                                            <!--end::Title-->
                                                            <!--begin::Description-->
                                                            <div class="text-muted fs-7 fw-bold">
                                                                {{ $category->description }}</div>
                                                            <!--end::Description-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-info">
                                                        {{ $category->parent->name ?? '—' }}</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <!--end::Category=-->
                                                    <td>
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-dark">{{ $category->products_number }}</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td>
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">{{ $category->status }}</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <!--begin::Type=-->
                                                <td>
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-primary">{{ $category->created_at }}
                                                    </div>
                                                    <!--end::Badges-->
                                                </td>
                                                <!--end::Type=-->
                                                <!--begin::Action=-->
                                                <td class="text-end">
                                                    <a href="#"
                                                        class="btn btn-sm btn-light btn-active-light-primary"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-placement="bottom-end">Actions
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon--></a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                                class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            {{-- <a href="#" class="menu-link px-3"
                                                                data-kt-ecommerce-category-filter="delete_row">Delete</a> --}}
                                                            <!-- زر حذف داخل كل صف -->

                                                            <a href="javascript:void(0);"
                                                                class="menu-link px-3 text-danger"
                                                                onclick="confirmDelete({{ $category->id }})">
                                                                Delete
                                                            </a>


                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                                <!--end::Action=-->
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Delete Confirmation</h2>
                                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-bs-dismiss="modal">
                                                        <span class="svg-icon svg-icon-1">
                                                            <!-- Close icon -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this category?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="assets/js/custom/apps/ecommerce/catalog/categories.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
@endpush
@push('scripts')
    <script>
        function confirmDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = `categories/${id}`; // عدّل حسب Route الحذف عندك
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endpush
