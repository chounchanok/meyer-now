<x-default-layout>

    @section('title')
    {{ __('Review Lists of Evaluated Employees') }}
    @endsection

    <link rel="stylesheet" href="../assets/plugins/custom/datatables/dataTables.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedHeader.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedColumns.dataTables.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedHeader.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedHeader.dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedColumns.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedColumns.dataTables.js"></script>

    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <!-- <div class="card-header">
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-tablet-text-up fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Review Lists of Evaluated Employees') }}
                    </span>
                    </h3>
                </div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    <div class=" d-md-block">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Year')}}</label>
                                <select class="form-select" data-control="select2" id="search_year" data-placeholder="-Choose-" onchange="destroy_table()">
                                   <@foreach ($year as $key => $val)
                                        @php
                                            $substr = substr($val->rec_year,0,4);
                                        @endphp
                                        <option value="{{ $substr }}">{{ $substr }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Position</label>
                                <select class="form-select" data-control="select2" id="search_position" data-placeholder="-Choose-" onchange="destroy_table()">
                                   <option value="0">All</option>
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                <select class="form-select" data-control="select2" id="search_division" data-placeholder="-Choose-" onchange="get_department()">
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                <select class="form-select" data-control="select2" id="search_department" data-placeholder="-Choose-" onchange="get_section()">
                                     
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                <select class="form-select" data-control="select2" id="search_section" data-placeholder="-Choose-" onchange="destroy_table()">
                                   
                                </select>
                            </div>

                            <div class="col-8 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Status')}}</label>
                                <select class="form-select" data-control="select2" id="search_status" data-placeholder="-Choose-" onchange="destroy_table()">
                                    <option value="0">All</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Transferred">Transferred</option>
                                    <option value="Resigned">Resigned</option>
                                </select>
                            </div>
                            <!-- <div class="col-4 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                                <button type="button" class="btn btn-primary rounded-pill" onclick="destroy_table()">
                                    <i class="ki-outline ki-magnifier"></i>
                                    Search
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <div class="d-black d-md-none" style="display:none;">
                        <div>
                            <div class="collapse" id="collapseSearchMobile">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Position</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>

                                    <div class="col-8 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            <option></option>
                                            <option>Transferred</option>
                                            <option>Resigned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ki-outline ki-magnifier"></i>
                                Search
                            </button>
                        </div>
                    </div>
                    <hr class="border-gray-400">
                    
                    <!-- tableDesktop -->
                    <div class=" position-relative">
                        <!--begin::Toggle-->
                        
                        <!-- style="position:absolute;top:0;left:0;z-index:99;" -->
                        <div style="position:absolute;top:0;left:0;z-index:99;">
                            <div class="d-inline-flex">
                                @can('edit review evaluate employees')
                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#approveModal'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">{{__('Passed')}}</span>
                                        </a>
                                    </div>
                                </div>
                                @endcan
                                <!--end::Menu-->
                            </div>
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-primary rotate mb-3 p-2" onclick="export_excel_list_Employees();">
                                    Export Excel
                                    <i class="bi-file-earmark-excel fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                            </div>
                            <div class="d-inline-flex">
                                <p style="margin-left:1em;">หมายเหตุ: 
                                    <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                                    Passed / 
                                    <span class="badge badge-square badge-warning"><i class="ki-solid ki-arrows-loop text-white"></i></span>
                                    Transferred /
                                    <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                                    Resigned /
                                    <span class="badge badge-square badge-danger">NE</span>
                                    Not Evaluate
                                </p>
                                <!--end::Menu-->
                            </div>
                        </div>
                        
                        
                        <!--end::Dropdown wrapper-->

                        
                        
                        <div class="table-responsive">
                            <table id="example" class="table table-striped rounded" style="text-wrap:nowrap">
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th style="width:50px"><input type="checkbox" name="select-all" id="select-all"></th>
                                        <th style="width:50px">{{__('No.')}}</th>
                                        <th>{{__('Emp. no.')}}</th>
                                        <th>{{__('Emp. Name')}}</th>
                                        <th>Position</th>
                                        <th>Div.</th>
                                        <th>Dept.</th>
                                        <th>Section</th>
                                        <th>{{__('Status')}}</th>
                                        @can('edit review evaluate employees')
                                        <th>{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tableMobile" style="display:none;">
                        <div class="d-inline-flex">
                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#approveModal'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Approved</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Transferred</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-exit-right fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Resigned</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::Menu-->
                            </div>
                        <div class="overflow-y overflow-auto" style="height:50vh">
                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                        Emp no.: 123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="row gx-2">
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Div.:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Dept:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Sect:<br></span>xxxx</p>
                                    </div>
                                </div>
                                <p class="mb-1 text-black"><span class="small text-gray-800">สถานะ: </span><span class="badge badge-light-warning">Status</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-2"></i>
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <i class="ki-solid ki-arrows-loop fs-2"></i>
                                        Transferred
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <i class="ki-solid ki-cross-circle fs-2"></i>
                                        Resigned
                                    </button>
                                </div>
                            </div>
                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                        Emp no.: 123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="row gx-2">
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Div.:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Dept:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Sect:<br></span>xxxx</p>
                                    </div>
                                </div>
                                <p class="mb-1 text-black"><span class="small text-gray-800">สถานะ: </span><span class="badge badge-light-warning">Status</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-2"></i>
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <i class="ki-solid ki-arrows-loop fs-2"></i>
                                        Transferred
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <i class="ki-solid ki-cross-circle fs-2"></i>
                                        Resigned
                                    </button>
                                </div>
                            </div>
                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                        Emp no.: 123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="row gx-2">
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Div.:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Dept:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Sect:<br></span>xxxx</p>
                                    </div>
                                </div>
                                <p class="mb-1 text-black"><span class="small text-gray-800">สถานะ: </span><span class="badge badge-light-warning">Status</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-2"></i>
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <i class="ki-solid ki-arrows-loop fs-2"></i>
                                        Transferred
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <i class="ki-solid ki-cross-circle fs-2"></i>
                                        Resigned
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="text-center pt-3">
                        <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                    </div> -->
                    
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->
    <!--begin::info modal-->
    <div
        id="infoModal_content"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#infoModal"
        data-kt-drawer-close="#editList_close"
        data-kt-drawer-width="{default:'300px', 'md': '400px'}"
        >
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5 py-3">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Infomation</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="editList_close">
                    <i class="ki-outline ki-cross fs-1"></i>              
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <i class="ki-duotone ki-user-square fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3>จันทรัตว์ ชัยชนา</h3>
                        <span class="badge badge-warning rounded-pill text-black">Emp.Code : 123456789</span>
                    </div>
                </div>
                <ul class="list-group rounded-3 mb-3">
                    <li class="list-group-item bg-light-primary">
                        <p class="mb-0 small">Division:</p>
                        <p class="mb-0 fw-semibold">MIL</p>
                    </li>
                    <li class="list-group-item bg-light-primary">
                        <p class="mb-0 small">Department:</p>
                        <p class="mb-0 fw-semibold">PROD.</p>
                    </li>
                    <li class="list-group-item bg-light-primary">
                        <p class="mb-0 small">Section:</p>
                        <p class="mb-0 fw-semibold">EXP1</p>
                    </li>
                    <li class="list-group-item bg-light-primary">
                        <p class="mb-0 small">Type:</p>
                        <p class="mb-0 fw-semibold">Monthly</p>
                    </li>
                    <li class="list-group-item bg-light-primary">
                        <p class="mb-0 small">Grade:</p>
                        <p class="mb-0 fw-semibold">L700</p>
                    </li>
                </ul>
                <div class="row g-3">
                    <div class="col-6">
                        <ul class="list-group rounded-3">
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Joining Date:</p>
                                <p class="mb-0 fw-semibold">8/16/2011</p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-group rounded-3">
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Service Period:</p>
                                <p class="mb-0 fw-semibold">365</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="card border-danger rounded-3 shadow-none mb-3">
                    <div class="card-header bg-danger  py-2 min-h-30px fw-bold text-white h4">
                        Attendance
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">SL</p>
                            <p class="text-end mb-0">3.6</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">PL</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">LATE</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">ABS</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">OL</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item bg-light-danger d-flex justify-content-between">
                            <p class="fw-bold mb-0">Total</p>
                            <p class="text-end mb-0">3.6</p>
                        </li>
                    </ul>
                </div>
                <div class="card border-primary rounded-3 shadow-none">
                    <div class="card-header bg-primary  py-2 min-h-30px fw-bold text-white h4">
                        Compliance with company regulation
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">Absent</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">VWAR</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">WWAR</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-bold mb-0">SUS</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                        <li class="list-group-item bg-light-primary d-flex justify-content-between">
                            <p class="fw-bold mb-0">Total</p>
                            <p class="text-end mb-0">0.0</p>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end py-3">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Cancel</button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::info modal-->
    <!--begin::Transferred modal-->
    <div class="modal fade" tabindex="-1" id="transferModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Transferred</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Employee Name (TH)</label>
                        <input type="text" class="form-control" name="employee_name" placeholder="" id="employee_name" disabled/>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Employee Name (EN)</label>
                        <input type="text" class="form-control" name="employee_name_en" placeholder="" id="employee_name_en" disabled/>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Div</label>
                        <select class="form-select form-select-solid" id="division" name="division" data-control="select2" data-dropdown-parent="#transferModal" data-placeholder="Select an option">
                            
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Dept</label>
                        <select class="form-select form-select-solid" id="department" name="department" data-control="select2" data-dropdown-parent="#transferModal" data-placeholder="Select an option" onchange="filter_section_transfer()">
                              
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Sect</label>
                        <select class="form-select form-select-solid" id="section" name="section" data-control="select2" data-dropdown-parent="#transferModal" data-placeholder="Select an option">
                        
                        </select>
                    </div>
                    <div class="col-12 col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                        <input type="date" class="form-control" id="transferred_effective_date" name="transferred_effective_date">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success rounded-pill" onclick="save_transferred();"><i
                                class="bi bi-floppy fs-5"></i>Save</button>
                        <input type="hidden" id="id_employee" value="">
                        <input type="hidden" id="id_employee_final" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Transferred modal-->
    <!--begin::Resigned modal-->
    <div class="modal fade" tabindex="-1" id="resignModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Resigned</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Employee name</label>
                            <input type="text" class="form-control" id="resign_employee_name_en" name="resign_employee_name_en" disabled>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                            <input type="date" class="form-control" id="resign_effective_date" name="resign_effective_date">
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success rounded-pill" onclick="save_resign()">Submit</button>
                    <input type="hidden" id="id_employee_resign" value="">
                    <input type="hidden" id="id_employee_final_resign" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="resignModal_na">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Not Evaluate (NE)</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-cross-circle text-danger fs-5r"></h1>
                    <p>{{ __('Confirm pass') }} ?</p>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success rounded-pill" onclick="save_resign_na()">Submit</button>
                    <input type="hidden" id="id_employee_resign_na" value="">
                    <input type="hidden" id="id_employee_final_resign_na" value="">
                </div>
            </div>
        </div>
    </div>
    <!--end::Resigned modal-->

    <!--begin::complain modal-->
    <div class="modal fade" tabindex="-1" id="complainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Compliance with company regulations</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="bg-light-primary">
                            <tr class="text-center">
                                <th colspan="6">Compliance with company regulations</th>
                            </tr>
                            <tr class="text-center">
                                <th>ABT</th>
                                <th>VWAR</th>
                                <th>WWAR</th>
                                <th>ABS</th>
                                <th>OL</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="fw-bold text-primary">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::complain modal-->
    <!--begin::attendance modal-->
    <div class="modal fade" tabindex="-1" id="attendanceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Attendance record</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="bg-light-warning">
                            <tr class="text-center">
                                <th colspan="6">Attendance record</th>
                            </tr>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>PL</th>
                                <th>LATE</th>
                                <th>ABS</th>
                                <th>OL</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>3.6</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="fw-bold text-danger">3.6</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::attendance modal-->
    <!--begin::approve modal-->
    <div class="modal fade" tabindex="-1" id="approveModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm pass') }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>{{ __('Confirm pass') }} ?</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="approveModal_update_all();">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="approveModalSingle">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm pass') }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>{{ __('Confirm pass') }} ?</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="save_pass();">Confirm</button>
                    <input type="hidden" id="id_employee_pass" value="">
                    <input type="hidden" id="id_employee_final_pass" value="">
                </div>
            </div>
        </div>
    </div>
    <!--end::approve modal-->
    <!--begin::reject modal-->
    <div class="modal fade" tabindex="-1" id="rejectModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Not approved, reevaluated</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                    <h1 class="ki-solid ki-cross-circle text-danger fs-5r"></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger  rounded-pill btn-sm">Confirm Reject</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::reject modal-->

    <div class="modal fade" tabindex="-1" id="modal_attendance">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Update Attendance & Compliance</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">SL</label>
                            <input type="number" class="form-control" id="edit_SL" name="edit_SL" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">PL</label>
                            <input type="number" class="form-control" id="edit_PL" name="edit_PL" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">LATE</label>
                            <input type="number" class="form-control" id="edit_LATE" name="edit_LATE" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">ABS</label>
                            <input type="number" class="form-control" id="edit_ABS" name="edit_ABS" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">ABT</label>
                            <input type="number" class="form-control" id="edit_ABT" name="edit_ABT" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">CL</label>
                            <input type="number" class="form-control" id="edit_CL" name="edit_CL" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">OL</label>
                            <input type="number" class="form-control" id="edit_OL" name="edit_OL" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">SUS</label>
                            <input type="number" class="form-control" id="edit_SUS" name="edit_SUS" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">WWAR</label>
                            <input type="number" class="form-control" id="edit_WWAR" name="edit_WWAR" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-2">
                            <label class="form-label mb-0">VWAR</label>
                            <input type="number" class="form-control" id="edit_VWAR" name="edit_VWAR" onkeyup="cal_attendance()">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label mb-0">Compliance record Score =</label>
                            <input type="number" class="form-control text-center fw-bold text-primary" id="compliance_score" name="compliance_score" readonly>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-label mb-0">Attendance record <span class="fw-bold text-danger showscore">Score = 0</span></div>
                            <input type="number" class="form-control text-center fw-bold text-danger" id="attendance_score" name="attendance_score" readonly>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="form-group" style="display: flex;align-items: center;gap: 5px;">
                                <input type="checkbox" id="edit_not_up_salary" name="edit_not_up_salary" value="1">
                                <label for="edit_not_up_salary" class="form-label mb-0">พนักงานที่ไม่ได้ปรับค่าแรง</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" onclick="save_attendance()">Update</button>
                    <input type="hidden" id="id_employee_final_attendance" value="">
                    <input type="hidden" id="code_employee_final_attendance" value="">
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script type="text/javascript">
    $(function(){
        get_division();
        // filter_section();
        
        // let table = new DataTable('#example', {
        //     layout: {
        //         topStart: {
        //             buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        //         }
        //     },
        //     "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        //     searchDelay: 500,
        //     processing: true,
        //     // serverSide: true,
        //     // scrollY: true,
        //     // scrollX: true,
        //     scrollCollapse: true,
        //     "ajax": {
        //         "url": "{{ url(Request::segment(1).'/table_listE_getdata') }}",
        //         "type": 'POST', 
        //         "data" : { 
        //             "_token": "{{ csrf_token() }}",
        //             "search_year":$('#search_year').val(),
        //             "search_position":$('#search_position').val(),
        //             "search_division":$('#search_division').val(),
        //             "search_department":$('#search_department').val(),
        //             "search_section":$('#search_section').val(),
        //             "search_status":$('#search_status').val(),
        //         },   
        //     },
        //     colReorder: true,
        //     columns: [
        //         { data: 'id' },
        //         { data: 'order' },
        //         { data: 'code' },
        //         { data: 'name' },
        //         { data: 'position' },
        //         { data: 'div' },
        //         { data: 'dept' },
        //         { data: 'sect' },
        //         { data: 'status' },
        //         { data: 'action' },
        //     ],
        //     columnDefs: [],
        //     "language": {
        //         "lengthMenu": "Show _MENU_",
        //     },
        //     "dom":
        //         "<'row'" +
        //         "<'col-sm-6 d-flex align-items-center justify-content-start'B>" +
        //         "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        //         ">" +
        //         "<'table-responsive'tr>" +
        //         "<'row'" +
        //         "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        //         "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        //         "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
        //         ">"
            
        // });
        // // table.colReorder.order([0, 1, 2, 3, 4, 5], true);
        //     // Add event listener for opening and closing details
        // table.on('click', 'td.dt-control', function (e) {
        //     let tr = e.target.closest('tr');
        //     let row = table.row(tr);

        //     if (row.child.isShown()) {
        //         // This row is already open - close it
        //         row.child.hide();
        //     }
        //     else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //     }
        // });

        // $('#select-all').click(function(event) {   
        //     if(this.checked) {
        //         // Iterate each checkbox
        //         $('.checkbox-select').each(function() {
        //             this.checked = true;                        
        //         });
        //     } else {
        //         $('.checkbox-select').each(function() {
        //             this.checked = false;                       
        //         });
        //     }
        // }); 

    // document.querySelectorAll('a.toggle-vis').forEach((el) => {
    //     el.addEventListener('click', function (e) {
    //         e.preventDefault();
    
    //         let columnIdx = e.target.getAttribute('data-column');
    //         let column = table.column(columnIdx);
    
    //         // Toggle the visibility
    //         column.visible(!column.visible());
    //     });
    // });
        // $(".toggle-vis").change(function(e) {
        //     e.preventDefault();

        //     let columnIdx = e.target.getAttribute('data-column');
        //     let column = table.column(columnIdx);

        //     // Toggle the visibility
        //     column.visible(!column.visible());
        // });
    });



function destroy_table(){
    $('#example').DataTable().destroy();
    setTimeout(() => {
        search_data();
    }, 200);
}
function search_data(){
    var vis = $('.toggle-vis'); 
    for(var i = 0;i < vis.length;i++){
        $(vis[i]).prop('checked',true);
    }
    
    let table = new DataTable('#example', {
        layout: {
            topStart: {
                buttons: ['excel']
            }
        },
        fixedHeader: {
            header: true,
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
    processing: true,
    // serverSide: true,
    // scrollY: true,
    // scrollX: true,
    scrollCollapse: true,
    "ajax": {
        "url": "{{ url(Request::segment(1).'/table_listE_getdata') }}",
        "type": 'POST', 
        "data" : { 
            "_token": "{{ csrf_token() }}",
            "search_year":$('#search_year').val(),
            "search_position":$('#search_position').val(),
            "search_division":$('#search_division').val(),
            "search_department":$('#search_department').val(),
            "search_section":$('#search_section').val(),
            "search_status":$('#search_status').val(),
        },     
    },
    colReorder: true,
    columns: [
        { data: 'id' },
        { data: 'order' },
        { data: 'code' },
        { data: 'name' },
        { data: 'position' },
        { data: 'div' },
        { data: 'dept' },
        { data: 'sect' },
        { data: 'status' },
        { data: 'action' },
    ],
    columnDefs: [{
            targets: 0,
            orderable: false,
    }],
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
    table.colReorder.order([0, 1, 2, 3, 4, 5], true);
        // Add event listener for opening and closing details
    table.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
        }
    });
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.checkbox-select').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.checkbox-select').each(function() {
                this.checked = false;                       
            });
        }
    }); 
    $(".toggle-vis").change(function(e) {
        e.preventDefault();
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        column.visible(!column.visible());
    })
}
function approveModal_update_all(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            getCheckbox.push(this.value);
        }                
    });
    if(getCheckbox.length == 0){
        Swal.fire({
            title: "{{ __('Please Select Employee') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/ListEvaluator_update_status_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":getCheckbox,
                "status_evaluation":"3",
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                destroy_table();
                $('.checkbox-select').each(function() {
                    this.checked = false;                       
                });
                // window.location.reload();
                // $('.checkbox-select').each(function() {
                //     if(this.checked == true){
                //         $('.set_status'+this.value).html('ผ่าน');
                //         $('.set_status'+this.value).removeClass('badge-light-warning');
                //         $('.set_status'+this.value).removeClass('badge-light-danger');
                //         $('.set_status'+this.value).addClass('badge-light-success');
                //     }                
                // });
            }
        });
    }
}
function fetchEmployee_pass(id,final_id) {
    $.ajax({
        type: 'POST',
        url: "{{ url(Request::segment(1).'/get/employee') }}/" + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            console.log(res);
            $('#id_employee_pass').val(id);
            $('#id_employee_final_pass').val(final_id);
        },
        error: function(res) {
            console.log("error");
            console.log(res);
        }
    });
}
function fetchEmployee(id,final_id) {
    KTApp.showPageLoading();
    $.ajax({
        type: 'POST',
        url: "{{ url(Request::segment(1).'/get/employee') }}/" + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            console.log(res);
            $('#id_employee').val(id);
            $('#id_employee_final').val(final_id);
            $('#employee_name').val(res.employee_local_name_th);
            $('#employee_name_en').val(res.employee_local_name_en);
            $('#transferred_effective_date').val(res.transferred_effective_date);

            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_division") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "pagenow":"1"
                    },
                    success: function (result) { 
                        if(result.data.length > 1){
                            var html = ``;
                        }else{
                            var html = ``;
                        }
                        result.data.forEach(element => {
                            html += `<option value="${element.division_code}">${element.division_code} - ${element.division_description}</option>`;
                        });
                        $('#division').html(html);
                        $('#division').val(res.division_code);
                        if(res.division_code_transferred != null){
                            $('#division').val(res.division_code_transferred);
                        }
                        setTimeout(() => {
                            $.ajax({
                                type: 'POST',
                                url: '{{ url(Request::segment(1)."/get_department") }}',
                                dataType: 'json',
                                data : { 
                                    "_token": "{{ csrf_token() }}",
                                    "search_division":$('#division').val()
                                },
                                success: function (result) { 
                                    if(result.data.length > 1){
                                        var html = ``;
                                    }else{
                                        var html = ``;
                                    }
                                    result.data.forEach(element => {
                                        html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                                    });
                                    $('#department').html(html);
                                    $('#department').val(res.department_code);
                                    if(res.department_code_transferred != null){
                                        $('#department').val(res.department_code_transferred);
                                    }
                                    setTimeout(() => {
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ url(Request::segment(1)."/get_section") }}',
                                            dataType: 'json',
                                            data : { 
                                                "_token": "{{ csrf_token() }}",
                                                "search_division":$('#division').val(),
                                                "search_department":$('#department').val()
                                            },
                                            success: function (result) { 
                                                if(result.data.length > 1){
                                                    var html = ``;
                                                }else{
                                                    var html = ``;
                                                }
                                                result.data.forEach(element => {
                                                    html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                                                });
                                                $('#section').html(html);
                                                $('#section').val(res.section_code);
                                                if(res.section_code_transferred != null){
                                                    $('#section').val(res.section_code_transferred);
                                                }
                                                
                                                $('#select2-division-container').html(res.division_code+" - "+res.division_description);
                                                $('#select2-division-container').attr('title',res.division_code+" - "+res.division_description);
                                                if(res.division_code_transferred != null){
                                                    $('#select2-division-container').html(res.division_code_transferred+" - "+res.division_code_transferred_description);
                                                    $('#select2-division-container').attr('title',res.division_code_transferred+" - "+res.division_code_transferred_description);
                                                }
                                                $('#select2-department-container').html(res.department_code+" - "+res.department_description);
                                                $('#select2-department-container').attr('title',res.department_code+" - "+res.department_description);
                                                if(res.department_code_transferred != null){
                                                    $('#select2-department-container').html(res.department_code_transferred+" - "+res.department_code_transferred_description);
                                                    $('#select2-department-container').attr('title',res.department_code_transferred+" - "+res.department_code_transferred_description);
                                                }
                                                $('#select2-section-container').html(res.section_code+" - "+res.section_description);
                                                $('#select2-section-container').attr('title',res.section_code+" - "+res.section_description);
                                                if(res.section_code_transferred != null){
                                                    $('#select2-section-container').html(res.section_code_transferred+" - "+res.section_code_transferred_description);
                                                    $('#select2-section-container').attr('title',res.section_code_transferred+" - "+res.section_code_transferred_description);
                                                }
                                                KTApp.hidePageLoading();
                                            }
                                        });
                                    }, 200);
                                }
                            });
                        }, 200);
                    }
                });
            }, 200);
        },
        error: function(res) {
            console.log("error");
            console.log(res);
        }
    });
    
}
function fetchEmployee_resign(id,final_id) {
    $.ajax({
        type: 'POST',
        url: "{{ url(Request::segment(1).'/get/employee') }}/" + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            console.log(res);
            $('#id_employee_resign').val(id);
            $('#id_employee_final_resign').val(final_id);
            $('#resign_employee_name_en').val(res.employee_local_name_en);
            $('#resign_effective_date').val(res.resign_effective_date);
        },
        error: function(res) {
            console.log("error");
            console.log(res);
        }
    });
}
function fetchEmployee_resign_na(id,final_id) {
    $.ajax({
        type: 'POST',
        url: "{{ url(Request::segment(1).'/get/employee') }}/" + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            console.log(res);
            $('#id_employee_resign_na').val(id);
            $('#id_employee_final_resign_na').val(final_id);
        },
        error: function(res) {
            console.log("error");
            console.log(res);
        }
    });
}
$("#edit_employee").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    Swal.fire({
        title: 'Are you sure ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'POST',
                url: "{{ url(Request::segment(1).'/edit/employee') }}/" + $('#id_employee').val(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        Swal.fire({
                            title: "Success",
                            text: "Saved Successfully",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                        // window.location.reload();
                        destroy_table();
                    }
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                    Swal.fire({
                        title: "ไม่สำเร็จ",
                        text: "ระบบบันทึกข้อมูลไม่สำเร็จ",
                        icon: "error",
                        allowOutsideClick: false,
                    });
                }
            });

        }
    });
});
function resignEmployee(id){
    Swal.fire({
        title: 'confirm?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/resignEmployee") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "search_year":$('#search_year').val(),
                },
                success: function (result) { 
                    $('.set_status'+id).html('Resign');
                    $('.set_status'+id).removeClass('badge-light');
                    $('.set_status'+id).removeClass('badge-light-success');
                    $('.set_status'+id).addClass('badge-light-danger');
                }
            });
        }
    });
}
function save_pass(id){
    var id = $('#id_employee_final_pass').val();
    if($('#pass_effective_date').val() == ""){
        Swal.fire({
            title: "กรุณาระบุ Effective Date",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/save_pass") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":$('#id_employee_pass').val(),
                "id_final_pass":$('#id_employee_final_pass').val(),
                "pass_effective_date":$('#pass_effective_date').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                $('.set_status'+id).html('Passed');
                $('.set_status'+id).removeClass('badge-light');
                $('.set_status'+id).removeClass('badge-light-danger');
                $('.set_status'+id).removeClass('badge-light-warning');
                $('.set_status'+id).addClass('badge-light-success');
                $('#approveModalSingle').modal('hide');
            }
        });
    }
}
function save_transferred(){
    var id = $('#id_employee_final').val();
    if($('#transferred_effective_date').val() == ""){
        Swal.fire({
            title: "กรุณาระบุ Effective Date",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/save_transferred") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":$('#id_employee').val(),
                "id_employee_final":$('#id_employee_final').val(),
                "division":$('#division').val(),
                "department":$('#department').val(),
                "section":$('#section').val(),
                "transferred_effective_date":$('#transferred_effective_date').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                $('.set_status'+id).html('Transferred');
                $('.set_status'+id).removeClass('badge-light');
                $('.set_status'+id).removeClass('badge-light-danger');
                $('.set_status'+id).removeClass('badge-light-success');
                $('.set_status'+id).addClass('badge-light-warning');
                $('#transferModal').modal('hide');
            }
        });
    }
}
function save_resign(id){
    var id = $('#id_employee_final_resign').val();
    if($('#resign_effective_date').val() == ""){
        Swal.fire({
            title: "กรุณาระบุ Effective Date",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        Swal.fire({
            title: 'confirm?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/save_resign") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":$('#id_employee_resign').val(),
                        "id_final_resign":$('#id_employee_final_resign').val(),
                        "resign_effective_date":$('#resign_effective_date').val(),
                        "search_year":$('#search_year').val(),
                    },
                    success: function (result) { 
                        $('.set_status'+id).html('Resigned');
                        $('.set_status'+id).removeClass('badge-light');
                        $('.set_status'+id).removeClass('badge-light-success');
                        $('.set_status'+id).removeClass('badge-light-warning');
                        $('.set_status'+id).addClass('badge-light-danger');
                        $('#resignModal').modal('hide');
                    }
                });
            }
        });
    }
}
function save_resign_na(id){
    var id = $('#id_employee_final_resign').val();
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/save_resign_na") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":$('#id_employee_resign_na').val(),
            "id_final_resign":$('#id_employee_final_resign_na').val(),
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            $('.set_status'+id).html('NE');
            $('.set_status'+id).removeClass('badge-light');
            $('.set_status'+id).removeClass('badge-light-success');
            $('.set_status'+id).removeClass('badge-light-warning');
            $('.set_status'+id).addClass('badge-light-danger');
            $('#resignModal_na').modal('hide');
        }
    });
}
function get_division(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_division") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "pagenow":"1",
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            if(result.data.length > 1){
                var html = `<option value="0">All</option>`;
            }else{
                var html = ``;
            }
            result.data.forEach(element => {
                html += `<option value="${element.division_code}">${element.division_code} - ${element.division_description}</option>`;
            });
            $('#search_division').html(html);
            if(result.data.length > 1){
                $('#search_division').val('0');
            }
            setTimeout(() => {
                get_department();
            }, 200);
        }
    });
}
function get_department(){
    if($('#search_division').val() == '0'){
        var html = `<option value="0">All</option>`;
        $('#search_department').html(html);
        var html2 = `<option value="0">All</option>`;
        $('#search_section').html(html2);
        $('#search_department').val('0');
        $('#search_section').val('0');
        get_section();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_department") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                if(result.data.length > 1){
                    var html = `<option value="0">All</option>`;
                }else{
                    var html = ``;
                }
                result.data.forEach(element => {
                    html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                });
                $('#search_department').html(html);
                if(result.data.length > 1){
                    $('#search_department').val('0');
                }
                setTimeout(() => {
                    get_section();
                }, 200);
            }
        });
    }
}
function get_section(){
    if($('#search_department').val() == '0'){
        var html = `<option value="0">All</option>`;
        $('#search_section').html(html);
        $('#search_section').val('0');
        destroy_table();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_section") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                if(result.data.length > 1){
                    var html = `<option value="0">All</option>`;
                }else{
                    var html = ``;
                }
                result.data.forEach(element => {
                    html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                });
                $('#search_section').html(html);
                if(result.data.length > 1){
                    $('#search_section').val('0');
                }
                setTimeout(() => {
                    destroy_table();
                }, 200);
            }
        });
    }
}
function filter_section(){
    // $('#search_section').val('0');
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/filter_section") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_division":$('#search_division').val(),
            "search_department":$('#search_department').val(),
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            if(result.data.length > 1){
                var html = `<option value="all">All</option>`;
            }else{
                var html = ``;
            }
            result.data.forEach(element => {
                html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
            });
            // $('#search_section').val('all');
            $('#search_section').html(html);
            if(result.data.length > 1){
                $('#search_section').val('all');
            }
            if($('#search_department').val() == '0'){
                $('#search_section').val('all');
            }
            setTimeout(() => {
                
                destroy_table();
            }, 200);
        }
    });
}
function filter_section_transfer(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/filter_section") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_division":$('#division').val(),
            "search_department":$('#department').val(),
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            if(result.data.length > 1){
                var html = `<option value="all">All</option>`;
            }else{
                var html = ``;
            }
            result.data.forEach(element => {
                html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
            });
            // $('#section').val('all');
            $('#section').html(html);
            if(result.data.length > 1){
                $('#section').val('all');
            }
            if($('#department').val() == '0'){
                $('#section').val('all');
            }
        }
    });
}
function export_excel_list_Employees(){
    var search_year = $('#search_year').val();
    var search_position = $('#search_position').val();
    var search_division = $('#search_division').val();
    var search_department = $('#search_department').val();
    var search_section = $('#search_section').val();
    var search_status = $('#search_status').val();
    
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Export'
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url(Request::segment(1).'/export_excel_list_Employees/') }}"+"?search_year="+search_year+"&search_position="+search_position+"&search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_status="+search_status;
        }
    });
}
function get_attendance(id){
    console.log(id);
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_attendance") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":id
        },
        success: function (result) { 
            $("#id_employee_final_attendance").val(id);
            $("#code_employee_final_attendance").val(result.employee_no);
            $("#edit_SL").val(result.attendance_sl);
            $("#edit_PL").val(result.attendance_pl);
            $("#edit_LATE").val(result.attendance_late);
            $("#edit_ABS").val(result.attendance_abs);
            $("#edit_ABT").val(result.attendance_abt);
            $("#edit_CL").val(result.attendance_cl);
            $("#edit_OL").val(result.attendance_ol);
            $("#edit_SUS").val(result.attendance_sus);
            $("#edit_WWAR").val(result.attendance_wwar);
            $("#edit_VWAR").val(result.attendance_vwar);
            var compliance_score = parseFloat(10) - (parseFloat(result.attendance_abt) + (parseFloat(result.attendance_vwar) * 2) + (parseFloat(result.attendance_wwar) * 5) + (parseFloat(result.attendance_sus) * 10));
            $("#compliance_score").val(compliance_score.toFixed(2));

            var cal2 = parseFloat(result.attendance_sl)+parseFloat(result.attendance_pl)+parseFloat(result.attendance_late)+parseFloat(result.attendance_abs);
            var cal2x = 0;
            var newcal2 = Math.round(cal2).toFixed(2);
            if(newcal2 >= 0 && newcal2 <= 2){
                cal2x = 10;
            }else if(newcal2 >= 17 && newcal2 <= 18){
                cal2x = 2;
            }else if(newcal2 >= 15 && newcal2 <= 16){
                cal2x = 3;
            }else if(newcal2 >= 13 && newcal2 <= 14){
                cal2x = 4;
            }else if(newcal2 >= 11 && newcal2 <= 12){
                cal2x = 5;
            }else if(newcal2 >= 9 && newcal2 <= 10){
                cal2x = 6;
            }else if(newcal2 >= 7 && newcal2 <= 8){
                cal2x = 7;
            }else if(newcal2 >= 5 && newcal2 <= 6){
                cal2x = 8;
            }else if(newcal2 >= 3 && newcal2 <= 4){
                cal2x = 9;
            }else{
                cal2x = 1;
            }
            $("#attendance_score").val(cal2.toFixed(2));
            $('.showscore').html('Score = '+cal2x.toFixed(2));
            if(result.not_up_salary && result.not_up_salary != ""){
                $("#edit_not_up_salary").prop('checked',true);
            }else{
                $("#edit_not_up_salary").prop('checked',false);
            }
        }
    });
}
function cal_attendance(){
    var edit_SL = $("#edit_SL").val();
    var edit_PL = $("#edit_PL").val();
    var edit_LATE = $("#edit_LATE").val();
    var edit_ABS = $("#edit_ABS").val();
    var edit_ABT = $("#edit_ABT").val();
    var edit_CL = $("#edit_CL").val();
    var edit_OL = $("#edit_OL").val();
    var edit_SUS = $("#edit_SUS").val();
    var edit_WWAR = $("#edit_WWAR").val();
    var edit_VWAR = $("#edit_VWAR").val();
    var compliance_score = parseFloat(10) - (parseFloat(edit_ABT) + (parseFloat(edit_VWAR) * 2) + (parseFloat(edit_WWAR) * 5) + (parseFloat(edit_SUS) * 10));
    $("#compliance_score").val(compliance_score.toFixed(2));

    var cal2 = parseFloat(edit_SL)+parseFloat(edit_PL)+parseFloat(edit_LATE)+parseFloat(edit_ABS);
    var cal2x = 0;
    var newcal2 = cal2.toFixed(2);
    if(newcal2 >= 0 && newcal2 <= 2){
        cal2x = 10;
    }else if(newcal2 >= 17 && newcal2 <= 18){
        cal2x = 2;
    }else if(newcal2 >= 15 && newcal2 <= 16){
        cal2x = 3;
    }else if(newcal2 >= 13 && newcal2 <= 14){
        cal2x = 4;
    }else if(newcal2 >= 11 && newcal2 <= 12){
        cal2x = 5;
    }else if(newcal2 >= 9 && newcal2 <= 10){
        cal2x = 6;
    }else if(newcal2 >= 7 && newcal2 <= 8){
        cal2x = 7;
    }else if(newcal2 >= 5 && newcal2 <= 6){
        cal2x = 8;
    }else if(newcal2 >= 3 && newcal2 <= 4){
        cal2x = 9;
    }else{
        cal2x = 1;
    }
    $("#attendance_score").val(cal2.toFixed(2));
    $('.showscore').html('Score = '+cal2x.toFixed(2));
}
function save_attendance(){
    var edit_SL = $("#edit_SL").val();
    var edit_PL = $("#edit_PL").val();
    var edit_LATE = $("#edit_LATE").val();
    var edit_ABS = $("#edit_ABS").val();
    var edit_ABT = $("#edit_ABT").val();
    var edit_CL = $("#edit_CL").val();
    var edit_OL = $("#edit_OL").val();
    var edit_SUS = $("#edit_SUS").val();
    var edit_WWAR = $("#edit_WWAR").val();
    var edit_VWAR = $("#edit_VWAR").val();
    if(edit_SL== "" || edit_PL== "" || edit_LATE== "" || edit_ABS== "" || edit_ABT== "" || edit_CL== "" || edit_OL== "" || edit_SUS== "" || edit_WWAR== "" || edit_VWAR== ""){
        Swal.fire({
            title: "{{ __('Some fields have values; if a field is empty or null, display 0 instead.') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        Swal.fire({
            title: 'Are you sure ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/update_attendance") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":$("#id_employee_final_attendance").val(),
                        "attendance_sl":$("#edit_SL").val(),
                        "attendance_pl":$("#edit_PL").val(),
                        "attendance_late":$("#edit_LATE").val(),
                        "attendance_abs":$("#edit_ABS").val(),
                        "attendance_abt":$("#edit_ABT").val(),
                        "attendance_cl":$("#edit_CL").val(),
                        "attendance_ol":$("#edit_OL").val(),
                        "attendance_sus":$("#edit_SUS").val(),
                        "attendance_wwar":$("#edit_WWAR").val(),
                        "attendance_vwar":$("#edit_VWAR").val(),
                        "compliance_score":$("#compliance_score").val(),
                        "attendance_score":$("#attendance_score").val(),
                        "not_up_salary":($('#edit_not_up_salary:checked').val()?1:0),
                        "code_employee_final_attendance":$("#code_employee_final_attendance").val(),
                    },
                    success: function (result) { 
                        Swal.fire({
                            title: "Success",
                            text: "Saved Successfully",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                        destroy_table();
                    }
                });
            }
        });
    }
}
</script>

@endpush
</x-default-layout>
<style>
    body{
        font-size: 14px !important;
    }
    .form-label {
        font-size: 14px !important;
    }
    .buttons-copy,.buttons-csv,.buttons-pdf,.buttons-print{
        display: none !important;
    }
    table.dataTable {
        font-size: 14px;
    }
    .table th, .table:not(.table-bordered) th ,.d-inline-flex,.d-inline-flex button,.sec_active,.rounded-pill{
        font-size: 14px !important;
    }
    .buttons-excel span{
        font-size: 14px !important;
    }
    .dtfh-floatingparent-head{
        top: 3.5em !important;
    }
    .dtfh-floatingparent,.dtfh-floatingparenthead{
        top: 3.5em !important;
        border: 1px solid;
        z-index: 9;
    }
</style>