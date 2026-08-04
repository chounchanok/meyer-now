<x-default-layout>

    @section('title')
    {{ __('Review Lists of Evaluated Employees') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('evaluate.index') }}
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
                    <!--begin::Menu wrapper-->
                    <div class="d-none d-md-block">
                        <form class="row g-3 mb-3">
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
                            <div class="col-4 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="ki-outline ki-magnifier"></i>
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="d-black d-md-none">
                        <form>
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
                        </form>
                    </div>
                    <hr class="border-gray-400">
                    <p>หมายเหตุ: 
                            <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                            Approved / 
                            <span class="badge badge-square badge-warning"><i class="ki-solid ki-arrows-loop text-white"></i></span>
                            Transferred /
                            <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                            Resigned
                        </p>
                    <div class="tableDesktop position-relative">
                        <!--begin::Toggle-->
                        <div style="position:absolute;top:0;left:0;z-index:99;">
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
                        </div>
                        <!--end::Dropdown wrapper-->

                        
                        
                        <div class="table-responsive">
                            <table id="example" class="table table-striped rounded" style="text-wrap:nowrap">
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th style="width:50px"><input type="checkbox"></th>
                                        <th style="width:50px">No.</th>
                                        <th>Emp. no</th>
                                        <th>Name - Surname</th>
                                        <th>Position</th>
                                        <th>Div.</th>
                                        <th>Dept.</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    <div class="tableMobile">
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
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
                    <div class="text-center pt-3">
                        <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                    </div>
                    
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
                <button class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Cancel</button>
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
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Employee name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Div.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Dept.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Sect.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal">Submit</button>
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
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal">Submit</button>
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
                    <h3 class="modal-title">Confirm approval</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm">Confirm</button>
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
@push('scripts')
<script type="text/javascript">

let table = new DataTable('#example', {
    searchDelay: 500,
    processing: true,
    // serverSide: true,
    // scrollY: true,
    // scrollX: true,
    scrollCollapse: true,
    "ajax": {
        "url": "{{ url(Request::segment(1).'/table_listE_getdata') }}",
        "type": 'GET',       
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
    columnDefs: [ {
        targets: 8,
        orderable: false,
        render: function (data) {
            return `<span class="badge badge-light-warning">Status</span>`;
        },
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

// document.querySelectorAll('a.toggle-vis').forEach((el) => {
//     el.addEventListener('click', function (e) {
//         e.preventDefault();
 
//         let columnIdx = e.target.getAttribute('data-column');
//         let column = table.column(columnIdx);
 
//         // Toggle the visibility
//         column.visible(!column.visible());
//     });
// });
$(".toggle-vis").change(function(e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
 
        // Toggle the visibility
        column.visible(!column.visible());
    });

</script>

@endpush
</x-default-layout>
