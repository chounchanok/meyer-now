<x-default-layout>

    @section('title')
        {{ __('Review Lists of Evaluated Employees') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-tablet-text-up fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Review Lists of Evaluated Employees') }}
                    </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- <div class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Word</label>
                            <input type="text" class="form-control" id="search_name" placeholder="" onkeyup="search_data();"/>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">วันที่</label>
                            <input type="date" class="form-control" id="search_date" placeholder="" onchange="search_data();"/>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            <button type="button" class="btn btn-primary rounded-pill" onclick="search_data();">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>
                    </div> -->
                    
                    
                    <div class="table-responsive" style="position: relative;">
                        <!--begin::Menu wrapper-->
                        <div class="d-none" style="position: absolute;left: 0;z-index: 100;">
                            <!--begin::Toggle-->
                            <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                Action
                                <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                            </button>
                            <!--end::Toggle-->

                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="editForm.php" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-notepad-edit fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">แก้ไข</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-check-circle fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">Active</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-trash fs-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </span>
                                    <span class="menu-title">ลบ</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Dropdown wrapper-->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped rounded" style="text-wrap:nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:50px">No.</th>
                                        <th>Title</th>
                                        <th>Date created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->


    @push('scripts')
    <script type="text/javascript">
    let table = new DataTable('#example', {
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
    searchDelay: 500,
    processing: true,
    // serverSide: true,
    // scrollY: true,
    // scrollX: true,
    scrollCollapse: true,
    "ajax": {
        "url": "{{ url(Request::segment(1).'/table_alistE_getdata') }}",
        "type": 'POST', 
        "data" : { 
            "_token": "{{ csrf_token() }}"
        },      
    },
    colReorder: true,
    columns: [
        { data: 'order' },
        { data: 'title' },
        { data: 'dateC' },
        { data: 'action' }
    ],
    columnDefs: [ {
        targets: 3,
        orderable: false,
        render: function(data, type, row) {
            return `<a type='button' href='ListEvaluator/${row.year}/' class='btn btn-icon btn-warning text-dark btn-xs me-1'><i class='ki-solid ki-pencil fs-5'></i></a>`;
        }
    } ],
    "language": {
        "lengthMenu": "Show _MENU_",
    },
    "dom":
        "<'row'" +
        "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
        ">" +
        "<'table-responsive'tr>" +
        "<'row'" +
        "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
        ">"
    
    });
        </script>
    @endpush
</x-default-layout>
