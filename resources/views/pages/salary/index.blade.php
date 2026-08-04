<x-default-layout>
    @section('title')
    {{ __("Salary Increase") }}
    @endsection 
    
    @php
        $previousYear3 = date('Y', strtotime('-3 year'));
        $previousYear2 = date('Y', strtotime('-2 year'));
        $previousYear1 = date('Y', strtotime('-1 year'));
        
            $previousYear = date('Y');
        
    @endphp
    

    <link rel="stylesheet" href="../assets/plugins/custom/datatables/dataTables.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedHeader.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedColumns.dataTables.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedHeader.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedHeader.dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedColumns.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedColumns.dataTables.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    
    <!--begin::Row-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="card h-xl-100">
                @php
                    $checkYear = date('Y');
                    $segment = trans(request()->segment(1));
                @endphp
                <input type="hidden" id="segment" value="{{$segment}}">
                <input type="hidden" id="nowyear" value="{{$checkYear}}">
                <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
                <!--begin::Header-->
                <!-- <div class="card-header">
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-wallet fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            {{ __("Salary Increase") }}
                        </span>
                    </h3>
                </div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->

                    <!--begin::Accordion-->
                    <div class="accordion accordion-icon-collapse mb-3" id="kt_accordion_3">
                        <div class="">
                            <div class="accordion-header py-3 d-flex collapsed mb-3" data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_item_2">
                                <div class="row g-3" style="width: 100%;">
                                    <div class="col-6 col-md-2  d-flex" style="align-items: center;">
                                        <span class="accordion-icon">
                                        <i class="ki-duotone ki-plus-square fs-3 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <i class="ki-duotone ki-minus-square fs-3 accordion-icon-on"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <h3 class="fs-4 fw-semibold mb-0 ms-4">Search</h3>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="card shadow-none rounded-3 p-3 mb-2" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol symbol-40px me-3">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-light"
                                                    >
                                                        <i
                                                            class="ki-outline ki-profile-user fs-2 text-black"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center flex-row-fluid flex-wrap"
                                                >
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                            style="padding-right: 10px;"
                                                        >
                                                            All employees
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_all"
                                                            style="padding-right: 10px;"
                                                        >
                                                            
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-secondary mb-2" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol symbol-40px me-3">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-warning"
                                                    >
                                                        <i
                                                            class="ki-outline ki-loading fs-2 text-black"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center flex-row-fluid flex-wrap"
                                                >
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                            style="padding-right: 10px;"
                                                        >
                                                            In progress
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_in"
                                                            style="padding-right: 10px;"
                                                        >
                                                        
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-danger mb-2" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol symbol-40px me-3">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-danger"
                                                    >
                                                        <i
                                                            class="ki-outline ki-cross-circle fs-2 text-white"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center flex-row-fluid flex-wrap"
                                                >
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                            style="padding-right: 10px;"
                                                        >
                                                            Reject
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_reject"
                                                            style="padding-right: 10px;"
                                                        >
                                                            
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-success" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">
                                                <div class="symbol symbol-40px me-3">
                                                    <div
                                                        class="symbol-label fs-2 fw-semibold bg-success"
                                                    >
                                                        <i
                                                            class="ki-outline ki-check-circle fs-2 text-white"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center flex-row-fluid flex-wrap"
                                                >
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                            style="padding-right: 10px;"
                                                        >
                                                            Finished
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_finish"
                                                            style="padding-right: 10px;"
                                                        >
                                                            
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_accordion_3_item_2" class="collapse fs-6" data-bs-parent="#kt_accordion_3">
                                <div class="d-md-block">
                                    <div class="row g-3 mb-3" style="font-size: 14px;">
                                        
                                        
                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Division</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_division" name="search_division[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_department();">
                                                
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Department</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_department" name="search_department[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_section();">
                                                
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Section</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_section" name="search_section[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_eva_list();">
                                            
                                            </select>
                                        </div>
                                        
                                        <div class="col-12 col-sm-6" style="font-size: 14px;">
                                            <label style="font-size: 14px;" for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluator')}}</label>
                                            <select class="form-select myLike" id="search_employee_no" name="search_employee_no[]" data-control="select2" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="destroy_table();">
                                                
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2" style="font-size: 14px;">
                                            <label style="font-size: 14px;" for="exampleFormControlInput1" class="form-label mb-0">Compliance score</label>
                                            <select class="form-select myLike" data-control="select2" id="search_complaince_score" name="search_complaince_score" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="all">All</option>
                                                <option value="1">{{__('Below Standard')}}</option>
                                                <option value="2">{{__('Standard')}}</option>
                                                <option value="3">{{__('Above Standard')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2" style="font-size: 14px;">
                                            <label style="font-size: 14px;" for="exampleFormControlInput1" class="form-label mb-0">Attendance score</label>
                                            <select class="form-select myLike" data-control="select2" id="search_attendance_score" name="search_attendance_score" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="all">All</option>
                                                <option value="1">{{__('Below Standard')}}</option>
                                                <option value="2">{{__('Standard')}}</option>
                                                <option value="3">{{__('Above Standard')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Monthly/Daily</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_month_day" name="search_month_day" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="all" selected>All</option>
                                                <option value="2">Monthly</option>
                                                <option value="1" >Daily</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Grade</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_grade" name="search_grade" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="all">All</option>
                                                <option value="AR">AR</option>
                                                <option value="P">P</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="U">U</option>
                                                <option value="CD">CD</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-sm-1" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Status</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_status" name="search_status" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="all">All</option>
                                                <option value="-1">In progress</option>
                                                <option value="2">Reject</option>
                                                <option value="1">Finished</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >{{__('Year')}}</label
                                            >
                                            <select class="form-select" data-control="select2" id="search_year" name="search_year" data-placeholder="-Select-" onchange="destroy_table();">
                                                @if(!empty($search_year))
                                                @foreach ($search_year as $key => $val)
                                                <option value="{{$val->rec_year}}">{{$val->rec_year}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-3" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                class="form-label mb-0"
                                                >{{__('Adjust Salary / No Salary Adjustment')}}</label
                                            >
                                            <select class="form-select" id="search_not_up_salary" name="search_not_up_salary" data-placeholder="-Select-" onchange="destroy_table();">
                                                <option value="3" selected>All</option>
                                                <option value="2" >{{__('Received Salary Adjustment')}}</option>
                                                <option value="1">{{__('Did Not Receive Salary Adjustment')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3 d-flex d-md-none" style="display:none !important;">
                        <div class="col-6">
                            <div class="card shadow-none rounded-3 p-3">
                                <div class="d-flex flex-stack">
                                    <div class="symbol symbol-40px me-4">
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-light"
                                        >
                                            <i
                                                class="ki-outline ki-profile-user fs-2 text-black"
                                            ></i>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-row-fluid flex-wrap"
                                    >
                                        <div class="flex-grow-1 me-2">
                                            <p
                                                class="text-gray-800 small fw-normal mb-0"
                                            >
                                                All employees
                                            </p>
                                            <h4
                                                class="text-black fw-bold d-block text-end mb-0"
                                            >
                                                32
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                class="card shadow-none rounded-3 p-3 bg-light-secondary"
                            >
                                <div class="d-flex flex-stack">
                                    <div class="symbol symbol-40px me-4">
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-warning"
                                        >
                                            <i
                                                class="ki-outline ki-loading fs-2 text-black"
                                            ></i>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-row-fluid flex-wrap"
                                    >
                                        <div class="flex-grow-1 me-2">
                                            <p
                                                class="text-gray-800 small fw-normal mb-0"
                                            >
                                                Im progress
                                            </p>
                                            <h4
                                                class="text-black fw-bold d-block text-end mb-0"
                                            >
                                                17
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                class="card shadow-none rounded-3 p-3 bg-light-danger"
                            >
                                <div class="d-flex flex-stack">
                                    <div class="symbol symbol-40px me-4">
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-danger"
                                        >
                                            <i
                                                class="ki-outline ki-cross-circle fs-2 text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-row-fluid flex-wrap"
                                    >
                                        <div class="flex-grow-1 me-2">
                                            <p
                                                class="text-gray-800 small fw-normal mb-0"
                                            >
                                                Reject
                                            </p>
                                            <h4
                                                class="text-black fw-bold d-block text-end mb-0"
                                            >
                                                5
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                class="card shadow-none rounded-3 p-3 bg-light-success"
                            >
                                <div class="d-flex flex-stack">
                                    <div class="symbol symbol-40px me-4">
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-success"
                                        >
                                            <i
                                                class="ki-outline ki-check-circle fs-2 text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center flex-row-fluid flex-wrap"
                                    >
                                        <div class="flex-grow-1 me-2">
                                            <p
                                                class="text-gray-800 small fw-normal mb-0"
                                            >
                                                Finished
                                            </p>
                                            <h4
                                                class="text-black fw-bold d-block text-end mb-0"
                                            >
                                                10
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button
                                type="button"
                                class="btn btn-outline btn-active-light p-2"
                                id=""
                            >
                                <div class="d-flex flex-column">
                                    <div
                                        class="symbol symbol-25px mb-2 d-flex justify-content-center"
                                    >
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-light-info"
                                        >
                                            <i
                                                class="ki-solid ki-star fs-2 text-info"
                                            ></i>
                                        </div>
                                    </div>
                                    <b>Bell curve info.</b>
                                </div>
                            </button>
                        </div>
                        <div class="col-4">
                            <button
                                type="button"
                                class="btn btn-outline btn-active-light p-2"
                                id=""
                            >
                                <div class="d-flex flex-column">
                                    <div
                                        class="symbol symbol-25px mb-2 d-flex justify-content-center"
                                    >
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-light"
                                        >
                                            %
                                        </div>
                                    </div>
                                    <b>Budget range G.</b>
                                </div>
                            </button>
                        </div>
                        <div class="col-4">
                            <button
                                type="button"
                                class="btn btn-outline btn-active-light p-2"
                                id=""
                            >
                                <div class="d-flex flex-column">
                                    <div
                                        class="symbol symbol-25px mb-2 d-flex justify-content-center"
                                    >
                                        <div
                                            class="symbol-label fs-2 fw-semibold bg-light-success"
                                        >
                                            <i
                                                class="ki-solid ki-wallet fs-2 text-success"
                                            ></i>
                                        </div>
                                    </div>
                                    <b>Approve Budget</b>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class=" position-relative">
                        <!--begin::Toggle-->
                        <div
                            style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                z-index: 99;
                            "
                        >
                            <div class="d-inline-flex" style="font-size: 14px !important;">
                                <button
                                    type="button"
                                    class="btn btn-light-primary rotate mb-3 p-2"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-start"
                                    data-kt-menu-offset="0px, 0px"
                                    style="font-size: 14px !important;"
                                >
                                    Action
                                    <i
                                        class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"
                                    ></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2"
                                    data-kt-menu="true"
                                >
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editG"
                                            onclick="reset_edit_grade();"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-notepad-edit fs-3 text-warning"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Edit grade</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPct"
                                            onclick="reset_edit_percent();"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-notepad-edit fs-3 text-warning"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Edit %</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div
                                        class="separator mt-3 opacity-75"
                                    ></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#transferModal"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-arrows-loop fs-3 text-dark"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Transferred</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#resignModal"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-exit-right fs-3 text-dark"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Resigned</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <div class="d-inline-flex" style="font-size: 14px !important;">
                                <button
                                    type="button"
                                    class="btn btn-light rotate mb-3 p-2 ps-3 rounded-pill"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-start"
                                    data-kt-menu-offset="0px, 0px"
                                    style="font-size: 14px !important;"
                                >
                                    Display
                                    <i
                                        class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"
                                    ></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2"
                                    data-kt-menu="true"
                                >
                                    <!--begin::Menu item-->
                                    <div
                                        class="menu-item menu-sub-indention menu-accordion bg-light-secondary"
                                        data-kt-menu-trigger="click"
                                    >
                                        
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >
                                                Employee info</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all1"
                                                            value="1"
                                                            onchange="check_all_group();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-1"
                                                            class="toggle-vis"
                                                            data-column="1"
                                                            onchange="check_all();"

                                                        />
                                                        Emp. no.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-2"
                                                            class="toggle-vis"
                                                            data-column="2"
                                                            onchange="check_all();"

                                                        />
                                                        Emp. Name.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-3"
                                                            class="toggle-vis"
                                                            data-column="3"
                                                            onchange="check_all();"

                                                        />
                                                        Div
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-4"
                                                            class="toggle-vis"
                                                            data-column="4"
                                                            onchange="check_all();"                                                            />
                                                        Dept
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-5"
                                                            class="toggle-vis"
                                                            data-column="5"
                                                            onchange="check_all();"                                                            />
                                                        Sect
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-6"
                                                            class="toggle-vis"
                                                            data-column="6"
                                                            onchange="check_all();"                                                            />
                                                        Position
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-7"
                                                            class="toggle-vis"
                                                            data-column="7"
                                                            onchange="check_all();"                                                            />
                                                        Group
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-8"
                                                            class="toggle-vis"
                                                            data-column="8"
                                                            onchange="check_all();"                                                            />
                                                        Date joined
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-9"
                                                            class="toggle-vis"
                                                            data-column="9"
                                                            onchange="check_all();"                                                            />
                                                        Service days
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item attendance-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-secondary"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >Attendance</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all2"
                                                            value="1"
                                                            onchange="check_all_group2();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-10"
                                                            class="toggle-vis"
                                                            data-column="10"
                                                            onchange="check_all();"
                                                        />
                                                        SL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-11"
                                                            class="toggle-vis"
                                                            data-column="11"
                                                            onchange="check_all();"
                                                        />
                                                        PL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-12"
                                                            class="toggle-vis"
                                                            data-column="12"
                                                            onchange="check_all();"
                                                        />
                                                        Late(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-13"
                                                            class="toggle-vis"
                                                            data-column="13"
                                                            onchange="check_all();"
                                                        />
                                                        Late(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-14"
                                                            class="toggle-vis"
                                                            data-column="14"
                                                            onchange="check_all();"
                                                        />
                                                        Absent(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-15"
                                                            class="toggle-vis"
                                                            data-column="15"
                                                            onchange="check_all();"
                                                        />
                                                        Absent(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-16"
                                                            class="toggle-vis"
                                                            data-column="16"
                                                            onchange="check_all();"
                                                        />
                                                        OL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-17"
                                                            class="toggle-vis"
                                                            data-column="17"
                                                            onchange="check_all();"
                                                        />
                                                        Total days
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item warning-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-light-danger"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >Warning record</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all3"
                                                            value="1"
                                                            onchange="check_all_group3();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-18"
                                                            class="toggle-vis"
                                                            data-column="18"
                                                            onchange="check_all();"
                                                        />
                                                        Verbal(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-19"
                                                            class="toggle-vis"
                                                            data-column="19"
                                                            onchange="check_all();"
                                                        />
                                                        Written(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-20"
                                                            class="toggle-vis"
                                                            data-column="20"
                                                            onchange="check_all();"
                                                        />
                                                        Suspension(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item PA old-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-light-secondary"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >PA year before</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->
                                        
                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all4"
                                                            value="1"
                                                            onchange="check_all_group4();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-21"
                                                            class="toggle-vis"
                                                            data-column="21"
                                                            onchange="check_all();"
                                                        />
                                                        PA {{$previousYear3}}
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-22"
                                                            class="toggle-vis"
                                                            data-column="22"
                                                            onchange="check_all();"
                                                        />
                                                        PA {{$previousYear2}}
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-23"
                                                            class="toggle-vis"
                                                            data-column="23"
                                                            onchange="check_all();"
                                                        />
                                                        PA <span class="previousYear1"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item PA current-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-light-secondary"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >PA Current</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all5"
                                                            value="1"
                                                            onchange="check_all_group5();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-24"
                                                            class="toggle-vis"
                                                            data-column="24"
                                                            onchange="check_all();"
                                                        />
                                                        Form
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-25"
                                                            class="toggle-vis"
                                                            data-column="25"
                                                            onchange="check_all();"
                                                        />
                                                        Evaluator 2023
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-26"
                                                            class="toggle-vis"
                                                            data-column="26"
                                                            onchange="check_all();"
                                                        />
                                                        Approvedl score
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-27"
                                                            class="toggle-vis"
                                                            data-column="27"
                                                            onchange="check_all();"
                                                        />
                                                        Theoretical level
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-28"
                                                            class="toggle-vis"
                                                            data-column="28"
                                                            onchange="check_all();"
                                                        />
                                                        Adjust level
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 bg-light-warning">
                                        <div class="checkbox p-2">
                                            <label>
                                                <input
                                                    checked
                                                    type="checkbox"
                                                    id="toggle-vis-click-29"
                                                    class="toggle-vis"
                                                    data-column="29"
                                                    onchange="check_all_group_salary(29);"
                                                />
                                                Current B. Salary/Wage
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item Theory salary-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-light-warning"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title"
                                                >Theory salary</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all6"
                                                            value="1"
                                                            onchange="check_all_group6();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-30"
                                                            class="toggle-vis"
                                                            data-column="30"
                                                            onchange="check_all();"
                                                        />
                                                        L800 AVG. wage of min.
                                                        wage adj.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-31"
                                                            class="toggle-vis"
                                                            data-column="31"
                                                            onchange="check_all();"
                                                        />
                                                        B. salary/wage for calc
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-32"
                                                            class="toggle-vis"
                                                            data-column="32"
                                                            onchange="check_all();"
                                                        />
                                                        Current
                                                        B. salary/wage(THB/mth)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-33"
                                                            class="toggle-vis"
                                                            data-column="33"
                                                            onchange="check_all();"
                                                        />
                                                        Company suggested(%)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-34"
                                                            class="toggle-vis"
                                                            data-column="34"
                                                            onchange="check_all();"
                                                        />
                                                        Company
                                                        suggested(Amount)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-35"
                                                            class="toggle-vis"
                                                            data-column="35"
                                                            onchange="check_all();"
                                                        />
                                                        Company suggested New
                                                        basic
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item Manager salary-->
                                    <div
                                        class="menu-item menu-link-indention menu-accordion bg-primary"
                                        style="color:white;"
                                        data-kt-menu-trigger="click"
                                    >
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3" style="border-radius: 0px;">
                                            <span class="menu-title"
                                                >Manager salary</span
                                            >
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div
                                            class="menu-sub menu-sub-accordion pt-3"
                                        >
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis-all7"
                                                            value="1"
                                                            onchange="check_all_group7();"
                                                        />
                                                        All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-36"
                                                            class="toggle-vis"
                                                            data-column="36"
                                                            onchange="check_all();"
                                                        />
                                                        Grade by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-37"
                                                            class="toggle-vis"
                                                            data-column="37"
                                                            onchange="check_all();"
                                                        />
                                                        Inc% proposed by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-38"
                                                            class="toggle-vis"
                                                            data-column="38"
                                                            onchange="check_all();"
                                                        />
                                                        Inc. amount proposed by
                                                        mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-39"
                                                            class="toggle-vis"
                                                            data-column="39"
                                                            onchange="check_all();"
                                                        />
                                                        New basic/wage by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            id="toggle-vis-click-40"
                                                            class="toggle-vis"
                                                            data-column="40"
                                                            onchange="check_all();"
                                                        />
                                                        New
                                                        B. Salary/wage(THB/Mth)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="menu-item px-3 bg-success" style="color:white;">
                                        <div class="checkbox p-2">
                                            <label>
                                                <input
                                                    checked
                                                    type="checkbox"
                                                    id="toggle-vis-click-final-41"
                                                    class="toggle-vis"
                                                    data-column="41"
                                                    onchange="check_all_final(41);"
                                                />
                                                Final by DM/GM
                                            </label>
                                        </div>
                                    </div>
                                    <div class="menu-item px-3 bg-light" style="color:black;">
                                        <div class="checkbox p-2">
                                            <label>
                                                <input
                                                    checked
                                                    type="checkbox"
                                                    id="toggle-vis-click-remark-42"
                                                    class="toggle-vis"
                                                    data-column="42"
                                                    onchange="check_all_remark(42);"
                                                />
                                                Remark
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </div>
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-success rotate p-2 ps-3 rounded-pill" style="font-size:14px;" onclick="freeze();"><i class="bi bi-floppy fs-5"></i>Submit to GM/DM</button>
                            </div>
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-primary rotate p-2 ps-3 rounded-pill" style="font-size:14px;" onclick="export_excel();"><i class="bi-file-earmark-excel fs-5"></i>Export Excel</button>
                            </div>
                            <div class="d-inline-flex" style="font-size: 14px !important;">
                                
                            </div>
                        </div>
                        <!--end::Dropdown wrapper-->
                        <div class="table-responsive">
                            <table
                                id="kt_datatable_dom_positioning"
                                class="table table-striped rounded"
                            >
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th class="text-center" rowspan="2">
                                            <input type="checkbox" name="select-all" id="select-all">
                                        </th>
                                        <th class="text-left" rowspan="2" style="min-width:100px;width:100px;">Emp. no.</th>
                                        <th class="text-left" rowspan="2">Name-Surname</th>
                                        <th class="text-left" rowspan="2">Div</th>
                                        <th class="text-left" rowspan="2">Dept</th>
                                        <th class="text-left" rowspan="2">Sect</th>
                                        <th class="text-left" rowspan="2">Position</th>
                                        <th class="text-center" rowspan="2">Group</th>
                                        <th class="text-center" rowspan="2" style="min-width:50px;width:50px;">Join date</th>
                                        <th class="text-center" rowspan="2">
                                            Service period(days)
                                        </th>
                                        <th
                                            colspan="8"
                                            class="text-center bg-light-dark"
                                        >
                                            Attendance
                                        </th>
                                        <th
                                            colspan="3"
                                            class="text-center bg-light-danger"
                                        >
                                            Warning record
                                        </th>
                                        
                                        <th class="text-center previousYear3_table" rowspan="2">PA {{$previousYear3}}</th>
                                        <th class="text-center previousYear2_table" rowspan="2">PA {{$previousYear2}}</th>
                                        <th class="text-center previousYear1_table" rowspan="2">PA {{$previousYear1}}</th>
                                        <th class="text-center" rowspan="2">Form</th>
                                        <th class="text-center" rowspan="2">Evaluator {{$previousYear}}</th>
                                        <th class="text-center" rowspan="2">Approved score</th>
                                        <th class="text-center" rowspan="2">Theoretical Level</th>
                                        <th class="text-center" rowspan="2">Adjust Level</th>
                                        <th class="text-center bg-light-warning" rowspan="2">Current B. Salary/Wage</th>
                                        <th class="text-center bg-light-warning" rowspan="2">L800 AVG. Wage of Min.Wage Adjusted</th>
                                        <th class="text-center bg-light-warning" rowspan="2">B. Salary/Wage for Calculation</th>
                                        <th class="text-center bg-light-warning" rowspan="2">Current B. Salary/Wage (THB/Mth)</th>
                                        <th class="text-center bg-light-warning" rowspan="2">Company Suggested (%)</th>
                                        <th class="text-center bg-light-warning" rowspan="2">Company Suggestged (Amount)</th>
                                        <th class="text-center bg-light-warning" rowspan="2">Company Suggestged New Basic</th>
                                        <th class="text-center bg-primary" style="color:white;" rowspan="2">Grade by Mgr.</th>
                                        <th class="text-center bg-primary" style="color:white;" rowspan="2" style="min-width:150px;">Inc. % Proposed by Mgr.</th>
                                        <th class="text-center bg-primary" style="color:white;" rowspan="2">Inc. Amount Proposed by Mgr.</th>
                                        <th class="text-center bg-primary" style="color:white;" rowspan="2">New Basic/Wage Proposed by Mgr.</th>
                                        <th class="text-center bg-primary" style="color:white;" rowspan="2">New B. Salary/Wage (THB/Mth)</th>
                                        <th class="text-center bg-success" style="color:white;" rowspan="2">Final by DM/GM (Amount)</th>
                                        <th class="text-center" rowspan="2">Remark(P,AR,U)</th>
                                        <th class="text-center" rowspan="2">Remark(special salary adjustment during the year)</th>
                                        <!-- <th class="text-center" rowspan="2">พนักงานที่ไม่ได้ปรับค่าแรง</th> -->
                                        <th class="text-center" rowspan="2">Status</th>
                                    </tr>
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th class="text-left bg-light-dark" style="min-width:30px;width:30px;">
                                            SL
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            PL<br /><span class="small"
                                                >(Unpaid)</span
                                            >
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            LATE<br /><span class="small"
                                                >(Times)</span
                                            >
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            LATE<br /><span class="small"
                                                >(Days)</span
                                            >
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            Absent<br /><span class="small"
                                                >(Times)</span
                                            >
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            Absent<br /><span class="small"
                                                >(Days)</span
                                            >
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            OL
                                        </th>
                                        <th class="text-left bg-light-dark">
                                            Total days
                                        </th>
                                        <th class="bg-light-danger text-left">
                                            Verbal<br /><span class="small"
                                                >(Times)</span
                                            >
                                        </th>
                                        <th class="bg-light-danger text-left">
                                            Written<br /><span class="small"
                                                >(Times)</span
                                            >
                                        </th>
                                        <th class="bg-light-danger text-left">
                                            Suspension<br /><span class="small"
                                                >(Days)</span
                                            >
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tableMobile" style="display:none;">
                        <div class="row gx-2">
                            <div class="col-6">
                                <button
                                    type="button"
                                    class="btn btn-light-primary rotate mb-3 py-2"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-start"
                                    data-kt-menu-offset="0px, 0px"
                                >
                                Action
                                    <i
                                        class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"
                                    ></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2"
                                    data-kt-menu="true"
                                >
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editG"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-notepad-edit fs-3 text-warning"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Edit grade</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPct"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-notepad-edit fs-3 text-warning"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Edit %</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div
                                        class="separator mt-3 opacity-75"
                                    ></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#transferModal"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-arrows-loop fs-3 text-dark"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Transferred</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#resignModal"
                                        >
                                            <span class="menu-icon">
                                                <i
                                                    class="ki-duotone ki-exit-right fs-3 text-dark"
                                                >
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title"
                                                >Resigned</span
                                            >
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <div class="col-4">Search:</div>
                                    <div class="col-8">
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="overflow-y overflow-auto"
                            style="height: 50vh"
                        >
                            <div
                                class="card p-5 shadow-none border-gray-300 mb-3"
                            >
                                <div class="form-check">
                                    <input
                                        class="form-check-input h-20px w-20px"
                                        type="checkbox"
                                        value=""
                                        id="flexCheckDefault"
                                    />
                                    <label
                                        class="form-check-label text-dark"
                                        for="flexCheckDefault"
                                    >
                                        Emp no.: 123456789
                                        <button
                                            type="button"
                                            class="btn btn-icon btn-light btn-xs me-1"
                                            id="infoModal"
                                        >
                                            <i
                                                class="ki-outline ki-information-2 fs-5"
                                            ></i>
                                        </button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-1">
                                    จันทรัตว์ ชัยชนา
                                </p>
                                <div class="table-responsive">
                                    <table
                                        class="table table-sm table-bordered mb-2"
                                    >
                                        <thead class="bg-light-dark">
                                            <tr class="text-center">
                                                <th colspan="8">Attendance</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>SL</th>
                                                <th>
                                                    PL
                                                    <p
                                                        class="small mb-0 fw-normal"
                                                    >
                                                        (Unpaid)
                                                    </p>
                                                </th>
                                                <th>
                                                    LATE
                                                    <p
                                                        class="small mb-0 fw-normal"
                                                    >
                                                        (Times)
                                                    </p>
                                                </th>
                                                <th>
                                                    LATE
                                                    <p
                                                        class="small mb-0 fw-normal"
                                                    >
                                                        (Days)
                                                    </p>
                                                </th>
                                                <th>
                                                    Absent
                                                    <p
                                                        class="small mb-0 fw-normal"
                                                    >
                                                        (Times)
                                                    </p>
                                                </th>
                                                <th>
                                                    Absent
                                                    <p
                                                        class="small mb-0 fw-normal"
                                                    >
                                                        (Days)
                                                    </p>
                                                </th>
                                                <th>OL</th>
                                                <th>Total days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td>2</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>-</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>2.0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <table
                                    class="table table-sm table-bordered mb-2"
                                >
                                    <thead class="bg-light-danger">
                                        <tr class="text-center">
                                            <th colspan="3">Warning record</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>
                                                Verbal
                                                <p class="small mb-0 fw-normal">
                                                    (Times)
                                                </p>
                                            </th>
                                            <th>
                                                Written
                                                <p class="small mb-0 fw-normal">
                                                    (Times)
                                                </p>
                                            </th>
                                            <th>
                                                Suspension
                                                <p class="small mb-0 fw-normal">
                                                    (Days)
                                                </p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800"
                                                >PA {{$previousYear3}}:<br
                                            /></span>
                                            <h1
                                                class="badge gradeP w-100 text-center fs-3 d-block py-2 mb-0"
                                            >
                                                P
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800"
                                                >PA {{$previousYear2}}:<br
                                            /></span>
                                            <h1
                                                class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0"
                                            >
                                                A
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800 previousYear1_Action"
                                                >PA {{$previousYear1}}:<br
                                            /></span>
                                            <h1
                                                class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0"
                                            >
                                                B
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Form: </span
                                    ><span class="fs-4 text-black fw-semibold"
                                        >F2</span
                                    >
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Evaluator: </span
                                    ><span class="fs-4 text-black fw-semibold"
                                        >xxxxxxxxxxx</span
                                    >
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Approved score: </span
                                    ><span class="fs-4 text-black fw-semibold"
                                        >93.0</span
                                    >
                                </p>
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800"
                                                >Theoretical G.:<br
                                            /></span>
                                            <h1
                                                class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0"
                                            >
                                                A
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800"
                                                >Adjust G.:<br
                                            /></span>
                                            <h1
                                                class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0"
                                            >
                                                A
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                                <p class="mb-3">
                                    <span class="small text-gray-800"
                                        >Current B.  Salary/Wage: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >15,070.00</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >L800 AVG. Wage of Min.Wage Adjusted: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >-</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >B. Salary/Wage for Calculation: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >15,070.00</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Current B. Salary/Wage(THB/Mth): </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >15,070.00</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Company Suggested(%): </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >6.00%</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Company Suggestged (Amount): </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >904.20</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Company Suggestged New Basic: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >15,907.00</span
                                    >
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Grade by Mgr.:
                                    </span>
                                </p>
                                <select
                                    class="form-select form-select-sm selectG gradeC mb-2"
                                    onchange="change_class(this);"
                                >
                                    <option class="" value="AR">AR</option>
                                    <option class="gradeP" value="P">
                                        P
                                    </option>
                                    <option class="gradeA" value="A">
                                        A
                                    </option>
                                    <option class="gradeB" value="B">
                                        B
                                    </option>
                                    <option
                                        class="gradeC"
                                        value="C"
                                        selected
                                    >
                                        C
                                    </option>
                                    <option class="gradeD" value="D">
                                        D
                                    </option>
                                    <option class="gradeE" value="E">
                                        E
                                    </option>
                                    <option class="" value="U">U</option>
                                    <option class="" value="CD">CD</option>
                                </select>
                                <span class="small fw-bold"
                                    >A &#62;
                                    <span class="text-primary">C</span></span
                                >
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Inc. % Proposed by Mgr.:
                                    </span>
                                </p>
                                <div class="row gx-2 mb-3 align-items-center">
                                    <div class="col-10">
                                        <input
                                            type="text"
                                            class="form-control form-control-sm bg-light-warning"
                                            value="3.00"
                                        />
                                    </div>
                                    <div class="col-2">%</div>
                                    <div class="col-12">
                                        <span class="small fw-bold"
                                            >6.00% &#62;
                                            <span class="text-primary"
                                                >3.00%</span
                                            ></span
                                        >
                                    </div>
                                </div>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Inc. Amount Proposed by Mgr.: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >452.10</span
                                    >
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >New Basic/Wage Proposed by Mgr.: </span
                                    ><br />
                                    <span class="fs-4 text-black fw-semibold"
                                        >15,520.00</span
                                    >
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >New B. Salary/Wage (THB/Mth):
                                    </span>
                                </p>
                                <p class="fw-bold text-primary fs-4">
                                    15520.00
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Final by DM/GM (Amount):
                                    </span>
                                </p>
                                <p class="fw-bold text-success fs-4">
                                    15520.00
                                </p>
                                <p class="mb-1 text-black">
                                    <span class="small text-gray-800"
                                        >Remark(P,AR,U):
                                    </span>
                                </p>
                                <input
                                    type="text"
                                    class="form-control mb-3"
                                    value=""
                                />
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800"
                                        >Status: </span
                                    ><span class="badge badge-light-danger"
                                        >Reject</span
                                    >
                                </p>
                                <div class="d-flex">
                                    <button
                                        type="button"
                                        class="btn btn-success me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#approveModal"
                                    >
                                        <i
                                            class="ki-solid ki-check-circle fs-1"
                                        ></i>
                                        Approve
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal"
                                    >
                                        <i
                                            class="ki-solid ki-cross-circle fs-1"
                                        ></i>
                                        Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="text-center pt-3">
                        <button class="btn btn-success rounded-pill">
                            <i class="bi bi-floppy fs-5"></i>Save
                        </button>
                    </div> -->
                    <!--table summary-->
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-rounded">
                            <thead class="table-light">
                                <tr class="text-center fw-bold align-middle">
                                    <th>Monthly/Daily</th>
                                    <th class="bg-light-warning" id="footer-vis-click">Current B. Salary/Wage</th>
                                    <th class="bg-light-warning" id="footer-vis-click">L800 AVG. Wage of Min.Wage Adjusted</th>
                                    <th class="bg-light-warning" id="footer-vis-click">B. Salary/Wage for Calculation</th>
                                    <th class="bg-light-warning" id="footer-vis-click">Current B. Salary/Wage (THB/Mth)</th>
                                    <th class="bg-light-warning" id="footer-vis-click">Company Suggested (%)</th>
                                    <th class="bg-light-warning" id="footer-vis-click">Company Suggestged (Amount)</th>
                                    <th class="bg-light-warning" id="footer-vis-click">Company Suggestged New Basic</th>
                                    <th></th>
                                    <th class="bg-primary" id="footer-vis-click" style="color:white;">Inc. % Proposed by Mgr.</th>
                                    <th class="bg-primary" id="footer-vis-click" style="color:white;">Inc. Amount Proposed by Mgr.</th>
                                    <th class="bg-primary" id="footer-vis-click" style="color:white;">New Basic/Wage Proposed by Mgr.</th>
                                    <th class="bg-primary" id="footer-vis-click" style="color:white;">New B. Salary/Wage (THB/Mth)</th>
                                    <th class="bg-success" id="footer-vis-click" style="color:white;">Final by DM/GM (Amount)</th>
                                </tr>
                            </thead>
                            <tbody class="data_footer">
                                
                            </tbody>
                        </table>
                    </div>

                    <hr class="border-gray-400">
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <div class="col-xl-6">
                            <div class="card-body d-flex align-items-end p-0">
                                <div class="min-h-auto w-100 ps-4 pe-6 chartreport" style="position: relative;">
                                    <canvas id="myChart"></canvas>
                                    <button type="button" class="btn btn-primary rotate p-2 ps-3 rounded-pill" onclick="download1();" style="position: absolute;top: 0px;right: 2em;">
                                        <i class="bi-filetype-png fs-5"></i>Export PNG
                                    </button>
                                    <a href="#" id="download_chart1">
                                        
                                    </a>
                                    <input type="hidden" id="hide_download_chart1">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body d-flex align-items-end p-0">
                                <div class="min-h-auto w-100 ps-4 pe-6 chartreport2" style="position: relative;">
                                    <canvas id="myChart2"></canvas>
                                    <button type="button" class="btn btn-primary rotate p-2 ps-3 rounded-pill" onclick="download2();" style="position: absolute;top: 0px;right: 2em;">
                                        <i class="bi-filetype-png fs-5"></i>Export PNG
                                    </button>
                                    <a href="#" id="download_chart2">
                                        
                                    </a>
                                    <input type="hidden" id="hide_download_chart2">
                                </div>
                            </div>
                        </div>
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
                        <a
                            href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1"
                            >Infomation</a
                        >
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div
                        class="btn btn-sm btn-icon btn-active-light-primary"
                        id="editList_close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y show_info">
                
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end py-3">
                <!--begin::Dismiss button-->
                <button
                    class="btn btn-outline btn-outline-dark rounded-pill"
                    data-kt-drawer-dismiss="true"
                >
                    Cancel
                </button>
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
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Employee name</label
                            >
                            <input type="text" class="form-control" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Div.</label
                            >
                            <select
                                class="form-select"
                                data-control="select2"
                                data-placeholder="-Choose-"
                            >
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Dept.</label
                            >
                            <select
                                class="form-select"
                                data-control="select2"
                                data-placeholder="-Choose-"
                            >
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Sect.</label
                            >
                            <select
                                class="form-select"
                                data-control="select2"
                                data-placeholder="-Choose-"
                            >
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Effective Date</label
                            >
                            <input type="date" class="form-control" />
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button
                        type="button"
                        class="btn btn-light rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-success rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Submit
                    </button>
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
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Employee name</label
                            >
                            <input type="text" class="form-control" />
                        </div>
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Effective Date</label
                            >
                            <input type="date" class="form-control" />
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button
                        type="button"
                        class="btn btn-light rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-success rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Resigned modal-->
    <!--begin::bell curve modal-->
    <div
        id="bellcurve_content"
        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#bellcurveModal"
        data-kt-drawer-close="#bellcurve_close"
        data-kt-drawer-width="320px"
        data-kt-drawer-direction="start"
    >
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5 py-3">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a
                            href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1"
                            >Bell curve info.</a
                        >
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div
                        class="btn btn-sm btn-icon btn-active-light-primary"
                        id="bellcurve_close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th colspan="5" class="text-center">
                                    Bell Curve information
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    
                                </th>
                                <th class="text-center">
                                    
                                </th>
                                <th class="text-center">
                                    Theoretical
                                </th>
                                <th class="text-center">
                                    Adjusted by HR
                                </th>
                                <th class="text-center">
                                    Actual
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($bell_curve))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($bell_curve as $key => $val)
                            @php
                                $grade = '';
                                if($val->grade_name=='P'){
                                    $grade = 'gradeP';
                                }
                                if($val->grade_name=='A'){
                                    $grade = 'gradeA';
                                }
                                if($val->grade_name=='B'){
                                    $grade = 'gradeB';
                                }
                                if($val->grade_name=='C'){
                                    $grade = 'gradeC';
                                }
                                if($val->grade_name=='D'){
                                    $grade = 'gradeD';
                                }
                                if($val->grade_name=='E'){
                                    $grade = 'gradeE';
                                }
                            @endphp
                            <tr class="text-center align-middle">
                                <td>
                                    @if($val->grade_name == "AR")
                                    <h1
                                        class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                        data-bs-toggle="tooltip" data-bs-placement="right" title="A,B,C"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                    @elseif($val->grade_name == "U")
                                    <h1
                                        class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                        data-bs-toggle="tooltip" data-bs-placement="right" title="Under Paid"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                    @elseif($val->grade_name == "CD")
                                    <h1
                                        class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                        data-bs-toggle="tooltip" data-bs-placement="right" title="Convert Daily to Monthly"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                    @else
                                    <h1
                                        class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                    @endif
                                </td>
                                <td class="table-secondary">
                                    {{$val->percent}}%
                                    <input type="hidden" id="bell_percent{{$val->grade_name}}" value="{{$val->percent}}">
                                </td>
                                <td class="total_theoretical_Level{{$val->grade_name}}"></td>
                                <td class="table-warning total_adjust_Level{{$val->grade_name}}">
                                    <input type="hidden" name="hidden_bell_curve_grade_name[]" value="{{$val->grade_name}}">
                                    <input type="hidden" name="hidden_bell_curve_percent[]" value="{{$val->percent}}">
                                </td>
                                <td class="table-success total_actual_Level{{$val->grade_name}}"></td>
                            </tr>
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th>Total</th>
                                <th class="table-secondary"></th>
                                <th class="bell_total_all1">0</th>
                                <th class="bell_total_all2 table-warning">0</th>
                                <th class="bell_total_all3 table-success"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th colspan="4" class="text-center">
                                    Bell Curve information
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        AR
                                    </h1>
                                </td>
                                <td class="table-secondary"></td>
                                <td></td>
                                <td class="table-success">0</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeP w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        P
                                    </h1>
                                </td>
                                <td class="table-secondary"></td>
                                <td></td>
                                <td class="table-success">0</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        A
                                    </h1>
                                </td>
                                <td class="table-secondary">10%</td>
                                <td>4.7</td>
                                <td class="table-success">7</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        B
                                    </h1>
                                </td>
                                <td class="table-secondary">20%</td>
                                <td>9.4</td>
                                <td class="table-success">5</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        C
                                    </h1>
                                </td>
                                <td class="table-secondary">50%</td>
                                <td>23.5</td>
                                <td class="table-success">22</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        D
                                    </h1>
                                </td>
                                <td class="table-secondary">15%</td>
                                <td>7.1</td>
                                <td class="table-success">7</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        E
                                    </h1>
                                </td>
                                <td class="table-secondary">5%</td>
                                <td>2.4</td>
                                <td class="table-success">6</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        U
                                    </h1>
                                </td>
                                <td class="table-secondary"></td>
                                <td></td>
                                <td class="table-success">0</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        CD
                                    </h1>
                                </td>
                                <td class="table-secondary"></td>
                                <td></td>
                                <td class="table-success">0</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th>Total</th>
                                <th class="table-secondary"></th>
                                <th>0</th>
                                <th class="table-success">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div> -->
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end py-3">
                <!--begin::Dismiss button-->
                <button
                    class="btn btn-outline btn-outline-dark rounded-pill"
                    data-kt-drawer-dismiss="true"
                >
                    Cancel
                </button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::bell curve modal-->
    <!--begin::budget range modal-->
    <div
        id="budgetG_content"
        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#budgetGModal"
        data-kt-drawer-close="#budgetG_close"
        data-kt-drawer-width="320px"
        data-kt-drawer-direction="start"
    >
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5 py-3">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a
                            href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1"
                            >Budget range Grade</a
                        >
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div
                        class="btn btn-sm btn-icon btn-active-light-primary"
                        id="budgetG_close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Budget Range</th>
                                <th>Grade</th>
                                <th>STD%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($budget))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($budget as $key => $val)
                            @php
                                $grade = '';
                                $td_color = '';
                                $std = $val->std.'%';
                                $budget_range = $val->budget_range_start.'% - '.$val->budget_range_end.'%';
                                if($val->grade_name=='AR'){
                                    $grade = '';
                                    $td_color = 'text-success';
                                    $budget_range = $val->budget_range_start.'%';
                                }
                                if($val->grade_name=='P'){
                                    $grade = 'gradeP';
                                    $td_color = 'text-primary';
                                }
                                if($val->grade_name=='A'){
                                    $grade = 'gradeA';
                                }
                                if($val->grade_name=='B'){
                                    $grade = 'gradeB';
                                }
                                if($val->grade_name=='C'){
                                    $grade = 'gradeC';
                                }
                                if($val->grade_name=='D'){
                                    $grade = 'gradeD';
                                }
                                if($val->grade_name=='E'){
                                    $grade = 'gradeE';
                                }
                                if($val->grade_name=='U'){
                                    $grade = '';
                                    $budget_range = '';
                                    $std = '';
                                }
                                if($val->grade_name=='CD'){
                                    $grade = '';
                                    $budget_range = '';
                                    $std = '';
                                }
                            @endphp
                            <tr class="text-center align-middle">
                                <td class="{{$td_color}}">
                                    {{$budget_range}}
                                </td>
                                <td>
                                    <h1
                                        class="badge {{$grade}} w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                </td>
                                <td class="{{$td_color}}">
                                    {{$std}}
                                    <input type="hidden" class="hidden_budget_range_start" name="hidden_budget_range_start[]" value="{{$val->budget_range_start}}">
                                    <input type="hidden" class="hidden_budget_range_end" name="hidden_budget_range_end[]" value="{{$val->budget_range_end}}">
                                    <input type="hidden" class="hidden_budget_grade_name" name="hidden_budget_grade_name[]" value="{{$val->grade_name}}">
                                    <input type="hidden" class="hidden_budget_std" name="hidden_budget_std[]" value="{{$val->std}}">
                                </td>
                            </tr>
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Budget Range</th>
                                <th>Grade</th>
                                <th>STD%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center align-middle">
                                <td class="text-success">1.50%</td>
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        AR
                                    </h1>
                                </td>
                                <td class="text-success">1.50%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="text-primary">10.00%-12.00%</td>
                                <td>
                                    <h1
                                        class="badge gradeP w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        P
                                    </h1>
                                </td>
                                <td class="text-primary">10.00%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="">5.50%-6.50%</td>
                                <td>
                                    <h1
                                        class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        A
                                    </h1>
                                </td>
                                <td class="">6.00%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="">4.00%-5.00%</td>
                                <td>
                                    <h1
                                        class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        B
                                    </h1>
                                </td>
                                <td class="">4.50%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="">2.50%-3.50%</td>
                                <td>
                                    <h1
                                        class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        C
                                    </h1>
                                </td>
                                <td class="">3.00%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="">1.00%-1.50%</td>
                                <td>
                                    <h1
                                        class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        D
                                    </h1>
                                </td>
                                <td class="">1.00%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="">0.25%-0.50%</td>
                                <td>
                                    <h1
                                        class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        E
                                    </h1>
                                </td>
                                <td class="">0.25%</td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class=""></td>
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        U
                                    </h1>
                                </td>
                                <td class=""></td>
                            </tr>
                            <tr class="text-center align-middle">
                                <td class="text-primary"></td>
                                <td>
                                    <h1
                                        class="badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        CD
                                    </h1>
                                </td>
                                <td class="text-primary"></td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end py-3">
                <!--begin::Dismiss button-->
                <button
                    class="btn btn-outline btn-outline-dark rounded-pill"
                    data-kt-drawer-dismiss="true"
                >
                    Cancel
                </button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::budget range modal-->
    <!--begin::approve budget modal-->
    <div
        id="approveB_content"
        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#approveBudgetModal"
        data-kt-drawer-close="#approveB_close"
        data-kt-drawer-width="320px"
        data-kt-drawer-direction="start"
    >
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5 py-3">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a
                            href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1"
                            >Approve Budget</a
                        >
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div
                        class="btn btn-sm btn-icon btn-active-light-primary"
                        id="approveB_close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="card shadow-none rounded-3 mb-3 hide_Daily">
                    <div
                        class="card-header py-2 min-h-30px bg-light-dark"
                    >
                        <p class="card-title fw-bold mb-0 mt-0">
                            Daily - L800
                        </p>
                        @php
                            
                                $previousYear = date('Y');
                            
                        @endphp
                    </div>
                    <div class="card-body py-3">
                        <div
                            class="row justify-content-between mb-2"
                        >
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_daily_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_daily_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none rounded-3 mb-3 hide_Monthly" >
                    <div
                        class="card-header py-2 min-h-30px bg-light-dark"
                    >
                        <p class="card-title fw-bold mb-0 mt-0">
                            Monthly (L600 - L700)
                        </p>
                    </div>
                    <div class="card-body py-3">
                        <div
                            class="row justify-content-between mb-2"
                        >
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none rounded-3 mb-3">
                    <div
                        class="card-header py-2 min-h-30px bg-light-dark"
                    >
                        <p class="card-title fw-bold mb-0 mt-0">
                            Daily+Monthly
                        </p>
                    </div>
                    <div class="card-body py-3">
                        <div
                            class="row justify-content-between mb-2"
                        >
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_Dailymonthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_Dailymonthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card shadow-none rounded-3 mb-3 hide_Daily">
                    <div class="card-header py-2 min-h-30px bg-light-dark">
                        <p class="card-title fw-bold mb-0 mt-0">Daily - L800</p>
                    </div>
                    <div class="card-body py-3">
                        <div class="row justify-content-between mb-2">
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_daily_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_daily_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none rounded-3 mb-3 hide_Monthly" style="display:none;">
                    <div class="card-header py-2 min-h-30px bg-light-dark">
                        <p class="card-title fw-bold mb-0 mt-0">
                            Monthly (L600 - L700)
                        </p>
                    </div>
                    <div class="card-body py-3">
                        <div class="row justify-content-between mb-2">
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="card shadow-none rounded-3 mb-3">
                    <div class="card-header py-2 min-h-30px bg-light-dark">
                        <p class="card-title fw-bold mb-0 mt-0">
                            Daily+Monthly
                        </p>
                    </div>
                    <div class="card-body py-3">
                        <div class="row justify-content-between mb-2">
                            <div class="col-sm-auto">
                                <b>% Overall Increment - Actual</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-success text-center py-2 mb-0 Overall_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget {{$previousYear}}</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_monthly_percent"
                                >
                                    0.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end py-3">
                <!--begin::Dismiss button-->
                <button
                    class="btn btn-outline btn-outline-dark rounded-pill"
                    data-kt-drawer-dismiss="true"
                >
                    Cancel
                </button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::approve budget modal-->
    <!--begin::complain modal-->
    <div class="modal fade" tabindex="-1" id="complainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">
                        Compliance with company regulations
                    </h3>

                    <!--begin::Close-->
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="bg-light-primary">
                            <tr class="text-center">
                                <th colspan="6">
                                    Compliance with company regulations
                                </th>
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
                    <button
                        type="button"
                        class="btn btn-light rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
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
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
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
                    <button
                        type="button"
                        class="btn btn-light rounded-pill"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::attendance modal-->

    <!--begin::edit grade modal-->
    <div class="modal fade" tabindex="-1" id="editG">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit grade</h3>

                    <!--begin::Close-->
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div>
                        <p class="fw-bold mb-2">Grade</p>
                        <select
                            class="form-select form-select-sm selectG editG_color editG_color_all mb-2"
                            id="edit_grade_select"
                            onchange="change_editG_color();"
                        >
                            <option class="" value="">{{ __('Select') }}</option>
                            <!-- <option class="" value="AR">AR</option>
                            <option class="gradeP" value="P">P</option> -->
                            <option class="gradeA" value="A">A</option>
                            <option class="gradeB" value="B">B</option>
                            <option class="gradeC" value="C">C</option>
                            <option class="gradeD" value="D">D</option>
                            <option class="gradeE" value="E">E</option>
                            <!-- <option class="" value="U">U</option> -->
                            <option class="" value="CD">CD</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-success" onclick="change_grade_select();">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::edit grade modal-->
    <!--begin::edit % modal-->
    <div class="modal fade" tabindex="-1" id="editPct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit %</h3>

                    <!--begin::Close-->
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    >
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div>
                        <p class="fw-bold mb-2">%</p>
                        <input type="text" class="form-control" id="edit_percent_select"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-success" onclick="change_percent_select();">Save</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade" id="update_grade_p" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title showpromotion">Grade</h3>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        onclick="destroy_table()"
                    >
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-12 showhide_p" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >From Current position </label
                            >
                            <select class="form-select form-select-solid" id="change_position_old" name="change_position_old" data-control="select2" data-dropdown-parent="#update_grade_p" data-placeholder="-Choose-" disabled>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 showhide_p" style="display:none;margin-top: 30px;">
                            <input type="radio" id="exiting_1" name="exitingx" value="1" onchange="showhide(1);" checked>
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Existing</label
                            >
                            
                        </div>
                        <div class="col-12 col-sm-6 showhide_p" style="display:none;margin-top: 30px;">
                            <input type="radio" id="exiting_2" name="exitingx" value="2" onchange="showhide(2);">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >To New position</label
                            >
                            
                        </div>
                        <div class="col-12 col-sm-12 showhide_p hide_exiting_position" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                ></label
                            >
                            <select class="form-select form-select-solid" id="change_position_new" name="change_position_new" data-control="select2" data-dropdown-parent="#update_grade_p" data-placeholder="-Choose-">
                                    <option value="0">- Select -</option>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 showhide_p hide_new_position" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                ></label
                            >
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="new_position_code" placeholder="New Position Code">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control" id="new_position_description" placeholder="New Position Description">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 showhide_p" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Job Description</label
                            >
<textarea class="form-control" name="change_position_remark" id="change_position_remark" cols="30" rows="10">
1. Job Header
1.1 Position
1.2 Position Description
1.3 Company
1.4 Level
1.5 Division
1.6 Department
1.7 Section
1.8 Position Backup
1.9 Position report to this role
1.10 Position Report to
1.11 Higher Line of Order

2. Role and Responsibilities (Key Responsibility / Task)

3. Job Competencies
3.1 Knowledge
3.2 Skills
3.3 Personality Traits
</textarea>
                        </div>
                        <div class="col-12 col-sm-12 showhide_change_position_reasons_info" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0 text_change_position_reasons_info"
                                >Reasons for Promotion</label
                            >
                            <textarea class="form-control" name="change_position_reasons" id="change_position_reasons" cols="20" rows="10"></textarea>
                        </div>
                        
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                        onclick="change_position_p_close()"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-success" onclick="change_position_p();">Save</button>
                    <input type="hidden" id="change_position_employee_id">
                    <input type="hidden" id="change_position_final_id">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update_grade_p_info" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title showpromotion">Grade</h3>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        onclick="destroy_table()"
                    >
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-12 showhide_p" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Current position </label
                            >
                            <select class="form-select form-select-solid" id="change_position_old_info" name="change_position_old_info" data-control="select2" data-dropdown-parent="#update_grade_p_info" data-placeholder="-Choose-" disabled>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 showhide_p" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >New position</label
                            >
                            <select class="form-select form-select-solid" id="change_position_new_info" name="change_position_new_info" data-control="select2" data-dropdown-parent="#update_grade_p_info" data-placeholder="-Choose-">
                                    <option value="0">- Select -</option>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 showhide_p" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Job Description</label
                            >
                            <textarea class="form-control" name="change_position_remark_info" id="change_position_remark_info" cols="30" rows="10" >
                            1. Job Header
                            1.1 Position
                            1.2 Position Description
                            1.3 Company
                            1.4 Level
                            1.5 Division
                            1.6 Department
                            1.7 Section
                            1.8 Position Backup
                            1.9 Position report to this role
                            1.10 Position Report to
                            1.11 Higher Line of Order

                            2. Role and Responsibilities (Key Responsibility / Task)

                            3. Job Competencies
                            3.1 Knowledge
                            3.2 Skills
                            3.3 Personality Traits
                            </textarea>
                        </div>
                        <div class="col-12 col-sm-12 showhide_change_position_reasons_info" style="display:none;">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0 text_change_position_reasons_info"
                                >Reasons for Promotion</label
                            >
                            <textarea class="form-control" name="change_position_reasons_info" id="change_position_reasons_info" cols="20" rows="10"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-success" onclick="change_position_p_info();">Save</button>
                    <input type="hidden" id="change_position_employee_id_info">
                    <input type="hidden" id="change_position_final_id_info">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update_jd" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="update_jd" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #231950;color: white;">
                    <h3 class="modal-title" style="color: white;"><i class="ki-solid ki-pencil fs-5"></i> Write a job Description</h3>
                    <div
                        class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        onclick="destroy_table()"
                    >
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="row col-12 col-sm-9">
                            <div class="col-12 col-sm-4 mt-4">
                                <label class="form-label mb-0">1) Position </label>
                                <select class="form-select form-select-solid" id="jd_position" name="jd_position" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_code }}">{{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-4">
                                <label class="form-label mb-0">2) Position Description</label>
                                <input type="text" class="form-control form-control-solid" id="jd_position_description" name="jd_position_description">
                            </div>
                            <div class="col-12 col-sm-4 mt-4">
                                <label class="form-label mb-0">3) Company</label>
                                <select class="form-select form-select-solid" id="jd_company" name="jd_company" data-placeholder="-Choose-">
                                    <option value="MIL">MIL</option> 
                                    <option value="MTL">MTL</option> 
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-3">
                                <label class="form-label mb-0">4) Level</label>
                                <select class="form-select form-select-solid" id="jd_level" name="jd_level" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                    @foreach ($grade_code as $key => $val)
                                        <option value="{{ $val->grade_code }}">{{ $val->grade_code }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-3">
                                <label class="form-label mb-0">5) Division</label>
                                <select class="form-select form-select-solid" id="jd_division" name="jd_division" onchange="get_department_jd();" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                      
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-3">
                                <label class="form-label mb-0">6) Department</label>
                                <select class="form-select form-select-solid" id="jd_department" name="jd_department" onchange="get_section_jd();" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                    <option value="0">เลือก</option> 
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-4">
                                <label class="form-label mb-0">7) Section</label>
                                <select class="form-select form-select-solid" id="jd_section" name="jd_section" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                    <option value="0">เลือก</option>    
                                </select>
                            </div>
                            <div class="col-12 col-sm-4 mt-4">
                                <label class="form-label mb-0">8) Position Backup</label>
                                <select class="form-select form-select-solid" id="jd_position_backup" name="jd_position_backup" data-control="select2" data-dropdown-parent="#update_jd" data-placeholder="-Choose-">
                                    <option value="0">เลือก</option> 
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_code }}">{{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 mt-4 setheight_jd">
                                <label class="form-label mb-0">9) Position report to this role</label>
                                <!-- <select class="form-select form-select-solid" id="jd_position_report" name="jd_position_report" data-control="select2" data-dropdown-parent="#update_jd" mutiple data-placeholder="-Choose-" multiple="multiple">
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                    @endforeach   
                                </select> -->
                                <select class="form-select form-select-solid" id="jd_position_report" name="jd_position_report[]" data-control="select2" data-dropdown-parent="#update_jd" data-close-on-select="false" data-placeholder="Choose" data-allow-clear="true" multiple="multiple">
                                    <option value="0">เลือก</option> 
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_description }}">{{ $val->position_description }}</option>
                                    @endforeach          
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3" style="border: 2px solid #d7d7d7;border-radius: 8px;padding: 0px;">
                            <div class="col-12 col-sm-12" style="background-color: #f06e19;color: white !important;padding: 6px;border-top-left-radius: 8px;border-top-right-radius: 8px;">
                                <h3 class="card-title align-items-center flex-row mb-0">
                                    
                                    <span class="card-label fw-bold ">
                                        Organization Chart
                                    </span>
                                </h3>
                                
                            </div>
                            <div class="col-12 col-sm-12" style="padding: 10px;">
                                <label class="form-label mb-0">Higher Line of Order</label>
                                <select class="form-select form-select-solid" id="jd_organization_position" name="jd_organization_position" data-control="select2" data-dropdown-parent="#update_jd" mutiple data-placeholder="-Choose-">
                                    <option value="0">เลือก</option> 
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_description }}">{{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-12" style="padding: 10px;">
                                <label class="form-label mb-0">Position Report to</label>
                                <select class="form-select form-select-solid" id="jd_organization_level" name="jd_organization_level" data-control="select2" data-dropdown-parent="#update_jd" mutiple data-placeholder="-Choose-">
                                    <option value="0">เลือก</option> 
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_description }}">{{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8" style="padding: 5px;background-color: #231950;color: white;border-radius: 8px;">
                        <h3 class="m-0" style="color: white;">Roles and Responsibilities</h3>
                    </div>

                    <div class="row g-3 mb-3 mt-8">
                        <div class="row col-12 col-sm-12">
                            <div class="card-body hover-scroll-overlay-y">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">
                                                    หน้าที่หลัก<br>(Key Responsibility) 
                                                </th>
                                                <th class="text-center">
                                                    รายละเอียดงาน<br>(Task)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr class="text-center align-middle">
                                                <td style="background-color: rgb(250 225 205);min-width:200px;width:200px;">
                                                <input type="text" id="KEY_RESPONSIBILITY" name="KEY_RESPONSIBILITY" class="form-control" value="Recruitment">
                                                <input type="hidden" id="countrow_jd" value="0">
                                                </td>
                                                <td  style="background-color: rgb(250 225 205);padding: 10px;">
                                                    <div class="show_jd">

                                                    </div>
                                                    <div class="row_jd_0" style="display: flex;align-items: center;justify-content: center;">
                                                        <input type="text" id="row_jd_0" name="TASK[]" class="form-control">
                                                        <button type="button" onclick="addrow_jd();" class="btn btn-icon btn-warning text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                            <i class="ki_jd_0 ki-solid ki-plus fs-5"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="padding: 5px;background-color: #231950;color: white;border-radius: 8px;">
                        <h3 class="m-0" style="color: white;">Specific Key Competencies for this role</h3>
                    </div>

                    <div class="row g-3 mb-3 mt-8">
                        <div class="row col-12 col-sm-12">
                            <div class="card-body hover-scroll-overlay-y">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="background-color: #e6e6e6;border-top-left-radius: 8px;border-top-right-radius: 8px;">
                                                    ความรู้<br>(Knowledge)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr class="text-center align-middle">
                                                <td  style="padding: 10px;">
                                                    <div class="showKnowledge_jd">

                                                    </div>
                                                    <div class="rowKnowledge_jd_0" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                        <input type="text" id="rowKnowledge_jd_0" name="KNOWLEDGE[]" class="form-control">
                                                        <button type="button" onclick="addrowKnowledge_jd();" class="btn btn-icon btn-warning text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                            <i class="ki_jd_0 ki-solid ki-plus fs-5"></i>
                                                        </button>
                                                        <input type="hidden" id="countrowKnowledge_jd" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 mt-8">
                        <div class="row col-12 col-sm-12">
                            <div class="card-body hover-scroll-overlay-y">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="background-color: #e6e6e6;border-top-left-radius: 8px;border-top-right-radius: 8px;">
                                                    ทักษะ<br>(Skills)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr class="text-center align-middle">
                                                <td  style="padding: 10px;">
                                                    <div class="showSkills_jd">

                                                    </div>
                                                    <div class="rowSkills_jd_0" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                        <input type="text" id="rowSkills_jd_0" name="SKILLS[]" class="form-control">
                                                        <button type="button" onclick="addrowSkills_jd();" class="btn btn-icon btn-warning text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                            <i class="ki_jd_0 ki-solid ki-plus fs-5"></i>
                                                        </button>
                                                        <input type="hidden" id="countrowSkills_jd" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3 mt-8">
                        <div class="row col-12 col-sm-12">
                            <div class="card-body hover-scroll-overlay-y">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="background-color: #e6e6e6;border-top-left-radius: 8px;border-top-right-radius: 8px;">
                                                    ความสามารถด้านความคิด/บุคลิกภาพ<br>(Personality Traits)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <tr class="text-center align-middle">
                                                <td  style="padding: 10px;">
                                                    <div class="showPersonality_jd">

                                                    </div>
                                                    <div class="rowPersonality_jd_0" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                        <input type="text" id="rowPersonality_jd_0" name="PERSONALITY_TRAITS[]" class="form-control">
                                                        <button type="button" onclick="addrowPersonality_jd();" class="btn btn-icon btn-warning text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                            <i class="ki_jd_0 ki-solid ki-plus fs-5"></i>
                                                        </button>
                                                        <input type="hidden" id="countrowPersonality_jd" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        ปิด
                    </button>
                    <button type="button" class="btn btn-success" onclick="save_jd();">บันทึก</button>
                    <input type="hidden" id="jd_position_employee_id_info">
                    <input type="hidden" id="jd_position_final_id_info">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="text/javascript">
        $(function() {
            get_division_first();
            all_detail();
            $('#bellcurveModal').css('display','flex');
            $('#budgetGModal').css('display','flex');
            $('#approveBudgetModal').css('display','flex');

            
            // const availWidth = window.screen.availWidth;
            // var fixedColumns = 3;
            // if(availWidth < 630){
            //     fixedColumns = 2;
            // }
            // var otable = $("#kt_datatable_dom_positioning").DataTable({
            //     fixedColumns: {
            //         left: fixedColumns,
            //     },
            //     "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
            //     searchDelay: 500,
            //     processing: true,
            //     serverSide: true,
            //     scrollY: true,
            //     scrollX: true,
            //     scrollCollapse: true,
            //     "columnDefs": [{
            //         "visible": false,
            //         "targets": -1
            //     }],
            //     ajax: {
            //         url: "{{ url(Request::segment(1).'/table_salary_getdata') }}",
            //         type: 'POST',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         data: function(d) {
            //             d.Like = {};
            //             $('.myLike').each(function() {
            //                 if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
            //                     d.Like[$(this).attr('name')] = $.trim($(this)
            //                         .val());
            //                 }
            //             });
            //             console.log(d);
            //             oData = d
            //         },
            //     },
            //     columns: [
            //         { data: "id" },
            //         { data: "code" },
            //         { data: "name" },
            //         { data: "position" },
            //         { data: "group" },
            //         { data: "joindate" },
            //         { data: "serviced" },
            //         { data: "sl" },
            //         { data: "pl" },
            //         { data: "latet" },
            //         { data: "lated" },
            //         { data: "abst" },
            //         { data: "absd" },
            //         { data: "ol" },
            //         { data: "totald" },
            //         { data: "verbal" },
            //         { data: "written" },
            //         { data: "susd" },
            //         { data: "pa1" },
            //         { data: "pa2" },
            //         { data: "pa3" },
            //         { data: "form" },
            //         { data: "evaluator" },
            //         { data: "total" },
            //         { data: "theoryg" },
            //         { data: "adjustg" },
            //         { data: "current" },
            //         { data: "l800avg" },
            //         { data: "bsalaryw" },
            //         { data: "cbsalaryw" },
            //         { data: "comsugpct" },
            //         { data: "comsugamt" },
            //         { data: "companynewb" },
            //         { data: "gmgr" },
            //         { data: "incpctmgr" },
            //         { data: "incamount" },
            //         { data: "newbwage" },
            //         { data: "newbsalary" },
            //         { data: "finaldmgm" },
            //         { data: "remark" },
            //         { data: "status" },
            //     ],
            //     columnDefs: [ {
            //         "targets": 0,
            //         "orderable": false
            //     },{
            //         "targets": 7,
            //         "orderable": false
            //     },{
            //         "targets": 7,
            //         "orderable": false
            //     }],
            //     "language": {
            //         "lengthMenu": "Show _MENU_",
            //     },
            //     "dom": "<'row'" +
            //         "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
            //         ">" +

            //         "<'table-responsive'tr>" +

            //         "<'row'" +
            //         "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            //         "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            //         "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
            //         ">"
            // });
            // $('#search_division').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_department').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_section').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_month_day').on('change', function(e) {
            //     if($('#search_month_day').val() == '1'){
            //         $('.hide_Daily').css('display','');
            //         $('.hide_Monthly').css('display','none');
            //     }else{
            //         $('.hide_Daily').css('display','none');
            //         $('.hide_Monthly').css('display','');
            //     }
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_grade').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_status').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
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

            function format(d) {
                // `d` is the original data object for the row
                return (
                    "<dl>" +
                    '<h6 class="mb-2 title1">Remark (P,AR,U)</h6>' +
                    '<input type="text" class="form-control form-control-sm">' +
                    "</dl>"
                );
            }

            // otable.on("click", "td.dt-control", function (e) {
            //     let tr = e.target.closest("tr");
            //     let row = otable.row(tr);

            //     if (row.child.isShown()) {
            //         // This row is already open - close it
            //         row.child.hide();
            //     } else {
            //         // Open this row
            //         row.child(format(row.data())).show();
            //     }
            // });
            // $(".toggle-vis").change(function (e) {
            //     e.preventDefault();

            //     let columnIdx = e.target.getAttribute("data-column");
            //     let column = otable.column(columnIdx);

            //     // Toggle the visibility
            //     column.visible(!column.visible());
            // });
            
            
        });
        function number_format(number, decimals, dec_point, thousands_sep) {
            var n = !isFinite(+number) ? 0 : +number, 
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                toFixedFix = function (n, prec) {
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    var k = Math.pow(10, prec);
                    return Math.round(n * k) / k;
                },
                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        function number_format2(number, decimals, dec_point, thousands_sep) {
            var n = !isFinite(+number) ? 0 : +number, 
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? '' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                toFixedFix = function (n, prec) {
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    var k = Math.pow(10, prec);
                    return Math.round(n * k) / k;
                },
                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        function destroy_table(){
            loading();
            $(".chartreport #myChart").remove();
            $(".chartreport").append('<canvas id="myChart"></canvas>');
            var grapharea = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(grapharea);
            myChart.destroy();

            $(".chartreport2 #myChart2").remove();
            $(".chartreport2").append('<canvas id="myChart2"></canvas>');
            var grapharea2 = document.getElementById("myChart2").getContext("2d");
            var myChart2 = new Chart(grapharea2);
            myChart2.destroy();

            var selectedYear = parseInt($('#search_year').val()); // แปลงค่าจาก select ให้เป็นตัวเลข
            var previousYear1 = selectedYear - 1; // หาปีก่อนหน้า
            var previousYear2 = selectedYear - 2; // หาปีก่อนหน้า
            var previousYear3 = selectedYear - 3; // หาปีก่อนหน้า
            $('.previousYear1').html(previousYear1);
            $('.previousYear1_table').html('PA '+previousYear1);
            $('.previousYear2_table').html('PA '+previousYear2);
            $('.previousYear3_table').html('PA '+previousYear3);
            $('.previousYear1_Action').html('PA '+previousYear1+':<br />');
            setTimeout(() => {
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                search_data();
            }, 200);
        }
        // function destroy_table(){
        //     loading();
        //     $(".chartreport #myChart").remove();
        //     $(".chartreport").append('<canvas id="myChart"></canvas>');
        //     var grapharea = document.getElementById("myChart").getContext("2d");
        //     var myChart = new Chart(grapharea);
        //     myChart.destroy();

        //     $(".chartreport2 #myChart2").remove();
        //     $(".chartreport2").append('<canvas id="myChart2"></canvas>');
        //     var grapharea2 = document.getElementById("myChart2").getContext("2d");
        //     var myChart2 = new Chart(grapharea2);
        //     myChart2.destroy();
        //     setTimeout(() => {
        //         $('#kt_datatable_dom_positioning').DataTable().destroy();
        //         search_data();
                
        //     }, 200);
        // }
        function search_data(){
            const availWidth = window.screen.availWidth;
            if($('#segment').val() == 'mtl'){
                var fixedColumns = 3;
                if(availWidth < 630){
                    fixedColumns = 3;
                }
            }else{
                var fixedColumns = 3;
                if(availWidth < 630){
                    fixedColumns = 3;
                }
            }
            
            var otable = $("#kt_datatable_dom_positioning").DataTable({
                fixedHeader: {
                    header: true,
                },
                fixedColumns: {
                    left: fixedColumns,
                },
                "lengthMenu": [[100,500, 1000, 2000, 3000], [100,500, 1000, 2000, 3000]],
                pageLength: 500,
                scrollCollapse: true,
                scrollY: '500px',
                scrollX: true,
                // scrollY: '200px',
                searchDelay: 500,
                processing: true,
                serverSide: true,
                // scrollY: true,
                // scrollX: true,
                // scrollCollapse: true,
                "columnDefs": [{
                    "visible": false,
                    "targets": -1
                }],
                ajax: {
                    url: "{{ url(Request::segment(1).'/table_salary_getdata') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.Like = {};
                        $('.myLike').each(function() {
                            if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
                                d.Like[$(this).attr('name')] = $.trim($(this)
                                    .val());
                            }
                        });
                        // console.log(d);
                        if($('#search_division').val().length > 0){
                            d.search_division = $('#search_division').val();
                        }   
                        if($('#search_department').val().length > 0){
                            d.search_department = $('#search_department').val();
                        }   
                        if($('#search_section').val().length > 0){
                            d.search_section = $('#search_section').val();
                        }   
                        if($('#search_employee_no').val().length > 0){
                            d.search_employee_no = $('#search_employee_no').val();
                        }  
                        if($('#search_year').val().length > 0){
                            d.search_year = $('#search_year').val();
                        }  
                        if($('#search_not_up_salary').val().length > 0){
                            d.search_not_up_salary = $('#search_not_up_salary').val();
                        } 
                        d.pagenow = '1';
                        oData = d
                    },
                },
                columns: [
                    { data: "id",className: 'text-center' },
                    { data: "code",className: 'text-center' },
                    { data: "name" },
                    { data: "divi" },
                    { data: "dept" },
                    { data: "sect" },
                    { data: "position" },
                    { data: "group" },
                    { data: "joindate" },
                    { data: "serviced" },
                    { data: "sl",className: 'text-center' },
                    { data: "pl",className: 'text-center' },
                    { data: "latet",className: 'text-center' },
                    { data: "lated",className: 'text-center' },
                    { data: "abst",className: 'text-center' },
                    { data: "absd",className: 'text-center' },
                    { data: "ol",className: 'text-center' },
                    { data: "totald",className: 'text-center' },
                    { data: "verbal",className: 'text-center' },
                    { data: "written",className: 'text-center' },
                    { data: "susd",className: 'text-center' },
                    { data: "pa1" },
                    { data: "pa2" },
                    { data: "pa3" },
                    { data: "form",className: 'text-center' },
                    { data: "evaluator" },
                    { data: "total",className: 'text-right' },
                    { data: "theoryg" },
                    { data: "adjustg" },
                    { data: "current",className: 'text-right' },
                    { data: "l800avg",className: 'text-right'  },
                    { data: "bsalaryw",className: 'text-right'  },
                    { data: "cbsalaryw",className: 'text-right'  },
                    { data: "comsugpct",className: 'text-right'  },
                    { data: "comsugamt",className: 'text-right'  },
                    { data: "companynewb",className: 'text-right'  },
                    { data: "gmgr" },
                    { data: "incpctmgr" },
                    { data: "incamount",className: 'text-right'  },
                    { data: "newbwage",className: 'text-right'  },
                    { data: "newbsalary",className: 'text-right'  },
                    { data: "finaldmgm",className: 'text-right'  },
                    { data: "remark" },
                    { data: "remark_special" },
                    // { data: "not_up_salary",className: 'text-center' },
                    { data: "status" },
                ],
                columnDefs: [ {
                    "targets": 0,
                    "orderable": false
                }],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
                    ">"
            });
            // $('#search_division').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_department').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_section').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_month_day').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_grade').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
            // $('#search_status').on('change', function(e) {
            //     otable.draw();
            //     all_detail();
            // });
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

            function format(d) {
                // `d` is the original data object for the row
                return (
                    "<dl>" +
                    '<h6 class="mb-2 title1">Remark (P,AR,U)</h6>' +
                    '<input type="text" class="form-control form-control-sm">' +
                    "</dl>"
                );
            }

            otable.on("click", "td.dt-control", function (e) {
                let tr = e.target.closest("tr");
                let row = otable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                }
            });
            $(".toggle-vis").change(function (e) {
                e.preventDefault();
                // $('#footer-vis-click-'+id).css('display','table-cell');
                //         $('.footer-hide-'+id).css('display','table-cell');
                var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
                var toggle_vis_all1_final = localStorage.getItem("toggle_vis_all1_final");
                var toggle_vis_all1_remark = localStorage.getItem("toggle_vis_all1_remark");
                
                let columnIdx = e.target.getAttribute("data-column");
                if(get_toggle_vis_all1 != ""){
                    var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    const result = cut_get_toggle_vis_all1.includes(columnIdx.toString());
                    if(result){
                        // $("#footer-vis-click-"+columnIdx).css("display", 'table-cell');
                        let column = otable.column(columnIdx);
                        column.visible(true);
                        if(columnIdx >= 29 && columnIdx <= 41 && columnIdx != 36){
                            $('#footer-vis-click-'+columnIdx).css('display','table-cell');
                            $('.footer-hide-'+columnIdx).css('display','table-cell');
                        }
                    }else{
                        // $("#footer-vis-click-"+columnIdx).css("display", 'none');
                        let column = otable.column(columnIdx);
                        column.visible(false);
                        if(columnIdx >= 29 && columnIdx <= 41 && columnIdx != 36){
                            $('#footer-vis-click-'+columnIdx).css('display','none');
                            $('.footer-hide-'+columnIdx).css('display','none');
                        }
                    }
                }else{
                    // $("#footer-vis-click-"+columnIdx).css("display", 'none');
                    let column = otable.column(columnIdx);
                    column.visible(!column.visible());
                    if(columnIdx >= 29 && columnIdx <= 41 && columnIdx != 36){
                        $('#footer-vis-click-'+columnIdx).css('display','none');
                        $('.footer-hide-'+columnIdx).css('display','none');
                    }
                }

                if(toggle_vis_all1_final != ""){
                    var cut_toggle_vis_all1_final = toggle_vis_all1_final.split(',');
                    const resultxx = cut_toggle_vis_all1_final.includes('41');
                    if(resultxx){
                        // $("#footer-vis-click-41").css("display", 'table-cell');
                        $("#toggle-vis-click-final-41").prop("checked", true);
                        let column = otable.column(41);
                        column.visible(true);
                        $('#footer-vis-click-41').css('display','table-cell');
                        $('.footer-hide-41').css('display','table-cell');
                    }else{
                        // $("#footer-vis-click-41").css("display", 'none');
                        $("#toggle-vis-click-final-41").prop("checked", false);
                        let column = otable.column(41);
                        column.visible(false);
                        $('#footer-vis-click-41').css('display','none');
                        $('.footer-hide-41').css('display','none');
                    }
                }else{
                    // $("#footer-vis-click-41").css("display", 'none');
                    $("#toggle-vis-click-final-41").prop("checked", false);
                    let column = otable.column(41);
                    column.visible(false);
                    $('#footer-vis-click-41').css('display','none');
                    $('.footer-hide-41').css('display','none');
                }
                if(toggle_vis_all1_remark != ""){
                    var cut_toggle_vis_all1_remark = toggle_vis_all1_remark.split(',');
                    const resultxx = cut_toggle_vis_all1_remark.includes('42');
                    if(resultxx){
                        $("#toggle-vis-click-remark-42").prop("checked", true);
                        let column = otable.column(42);
                        column.visible(true);
                    }else{
                        $("#toggle-vis-click-remark-42").prop("checked", false);
                        let column = otable.column(42);
                        // console.log(columnIdxx);
                        column.visible(false);
                    }
                }else{
                    $("#toggle-vis-click-remark-42").prop("checked", false);
                    let column = otable.column(42);
                    column.visible(false);
                }
                // let column = otable.column(columnIdx);
                
                
                // Toggle the visibility
                
            });
            // $(".toggle-vis-all1").change(function (ee) {
            //     for (let index = 3; index <= 9; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }                
            //         });
            //     }
            // });
            // $(".toggle-vis-all2").change(function (ee) {
            //     for (let index = 10; index <= 17; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }           
            //         });
            //     }
            // });
            // $(".toggle-vis-all3").change(function (ee) {
            //     for (let index = 18; index <= 20; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }           
            //         });
            //     }
            // });
            // $(".toggle-vis-all4").change(function (ee) {
            //     for (let index = 21; index <= 23; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }           
            //         });
            //     }
            // });
            // $(".toggle-vis-all5").change(function (ee) {
            //     for (let index = 24; index <= 28; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }           
            //         });
            //     }
            // });
            // $(".toggle-vis-all6").change(function (ee) {
            //     for (let index = 30; index <= 35; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 $('#toggle-vis-click-'+e).click();
            //             }           
            //         });
            //     }
            // });
            // $(".toggle-vis-all7").change(function (ee) {
            //     $('#toggle-vis-click-36').click();
            //     $('#toggle-vis-click-37').click();
            //     $('#toggle-vis-click-38').click();
            //     $('#toggle-vis-click-39').click();
            //     $('#toggle-vis-click-40').click();
            //     $('#toggle-vis-click-41').click();
            //     $('#toggle-vis-click-42').click();
            // });
            all_detail();
            bell_curve_detail();
            var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            var toggle_vis_all1_final = localStorage.getItem("toggle_vis_all1_final");
            var toggle_vis_all1_remark = localStorage.getItem("toggle_vis_all1_remark");
            
            
            console.log(get_toggle_vis_all1);
            console.log(toggle_vis_all1_final);
            console.log(toggle_vis_all1_remark);
            if(get_toggle_vis_all1 != ""){
                var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                for (let columnIdxx = 1; columnIdxx <= 42; columnIdxx++) {
                    const resultxx = cut_get_toggle_vis_all1.includes(columnIdxx.toString());
                    
                    if(resultxx){
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'table-cell');
                        $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                        let column = otable.column(columnIdxx);
                        column.visible(true);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                            $('#footer-vis-click-'+columnIdxx).css('display','table-cell');
                            $('.footer-hide-'+columnIdxx).css('display','table-cell');
                        }
                    }else{
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'none');
                        $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                        let column = otable.column(columnIdxx);
                        // console.log(columnIdxx);
                        column.visible(false);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                            $('#footer-vis-click-'+columnIdxx).css('display','none');
                            $('.footer-hide-'+columnIdxx).css('display','none');
                        }
                    }
                }
            }
            if(toggle_vis_all1_final != ""){
                var cut_toggle_vis_all1_final = toggle_vis_all1_final.split(',');
                const resultxx = cut_toggle_vis_all1_final.includes('41');
                if(resultxx){
                    // $("#footer-vis-click-41").css("display", 'table-cell');
                    $("#toggle-vis-click-final-41").prop("checked", true);
                    let column = otable.column(41);
                    column.visible(true);
                    $('#footer-vis-click-41').css('display','table-cell');
                    $('.footer-hide-41').css('display','table-cell');
                }else{
                    // $("#footer-vis-click-41").css("display", 'none');
                    $("#toggle-vis-click-final-41").prop("checked", false);
                    let column = otable.column(41);
                    column.visible(false);
                    $('#footer-vis-click-41').css('display','none');
                    $('.footer-hide-41').css('display','none');
                }
            }else{
                // $("#footer-vis-click-41").css("display", 'none');
                $("#toggle-vis-click-final-41").prop("checked", false);
                let column = otable.column(41);
                column.visible(false);
                $('#footer-vis-click-41').css('display','none');
                $('.footer-hide-41').css('display','none');
            }
            if(toggle_vis_all1_remark != ""){
                var cut_toggle_vis_all1_remark = toggle_vis_all1_remark.split(',');
                const resultxx = cut_toggle_vis_all1_remark.includes('42');
                if(resultxx){
                    $("#toggle-vis-click-remark-42").prop("checked", true);
                    let column = otable.column(42);
                    column.visible(true);
                }else{
                    $("#toggle-vis-click-remark-42").prop("checked", false);
                    let column = otable.column(42);
                    column.visible(false);
                }
            }else{
                $("#toggle-vis-click-remark-42").prop("checked", false);
                let column = otable.column(42);
                column.visible(false);
            }
            // console.log('get_toggle_vis_all1',get_toggle_vis_all1);
            // if(get_toggle_vis_all1 != ""){
            //     var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
            //     $('.toggle-vis').each(function(e) {
            //         if($('#toggle-vis-click-'+e).is(':checked') == true){
            //             $('#toggle-vis-click-'+e).click(); 
            //         }   
            //     });
            //     if(xtoggle_all7 == 'true'){
            //         if($('#toggle-vis-click-40').is(':checked') == true){
            //             get_toggle_vis_all1 += '40,';   
            //         }
            //         if($('#toggle-vis-click-41').is(':checked') == true){
            //             get_toggle_vis_all1 += '41,';
            //         }
            //         if($('#toggle-vis-click-42').is(':checked') == true){
            //             get_toggle_vis_all1 += '42,';
            //         }
            //     }
            //     if(xtoggle_all7 == 'false'){
            //         if($('#toggle-vis-click-40').is(':checked') == true){
            //             $('#toggle-vis-click-40').click(); 
            //         }
            //         if($('#toggle-vis-click-41').is(':checked') == true){
            //             $('#toggle-vis-click-41').click(); 
            //         }
            //         if($('#toggle-vis-click-42').is(':checked') == true){
            //             $('#toggle-vis-click-42').click(); 
            //         }
            //     }
            //     // console.log(get_toggle_vis_all1);
            //     setTimeout(() => {
            //         cut_get_toggle_vis_all1.forEach(element => {
                        
            //             if(element != ""){
            //                 if(xtoggle_all7 == 'false'){
            //                     if(element != '36' && element != '37' && element != '38' && element != '39' && element != '40' && element != '41' && element != '42'){
            //                         console.log(element);
            //                         $('#toggle-vis-click-'+element).click();
            //                     }
            //                 }else{
            //                     // console.log(element);
            //                     if(element != '36' && element != '37' && element != '38' && element != '39' && element != '40' && element != '41' && element != '42'){
            //                         $('#toggle-vis-click-'+element).click();
            //                     }
            //                     // if($('#toggle-vis-click-35').is(':checked') == false){
            //                     //     $('#toggle-vis-click-35').click(); 
            //                     // }
            //                     if($('#toggle-vis-click-36').is(':checked') == false){
            //                         $('#toggle-vis-click-36').click(); 
            //                     }
            //                     if($('#toggle-vis-click-37').is(':checked') == false){
            //                         $('#toggle-vis-click-37').click(); 
            //                     }
            //                     if($('#toggle-vis-click-38').is(':checked') == false){
            //                         $('#toggle-vis-click-38').click(); 
            //                     }
            //                     if($('#toggle-vis-click-39').is(':checked') == false){
            //                         $('#toggle-vis-click-39').click(); 
            //                     }
            //                     if($('#toggle-vis-click-40').is(':checked') == false){
            //                         $('#toggle-vis-click-40').click(); 
            //                     }
            //                     if($('#toggle-vis-click-41').is(':checked') == false){
            //                         $('#toggle-vis-click-41').click(); 
            //                     }
            //                     if($('#toggle-vis-click-42').is(':checked') == false){
            //                         $('#toggle-vis-click-42').click(); 
            //                     }
            //                 }
            //             }
            //         });
            //     }, 200);
                
            // }
            
            // var toggle_all1 = localStorage.getItem("toggle_all1");
            // if(toggle_all1 == false){
            //     $('#toggle-vis-click-'+e).click();    
            // }   

            // var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            // console.log(get_toggle_vis_all1);
            // if(get_toggle_vis_all1 != ""){
            //     console.log('111');
            //     var cut_toggle_vis_all1 = get_toggle_vis_all1.split(',');
            //         $('.toggle-vis').each(function(e) {
            //             $('#toggle-vis-click-'+e).attr('checked', false);               
            //         });
            //     // for (let index = 3; index <= 9; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(cut_toggle_vis_all1.includes(e.toString()) == true){
            //                 $('#toggle-vis-click-'+e).attr('checked', true);
            //             }else{
            //                 $('#toggle-vis-click-'+e).attr('checked', false);
            //             }
            //             // if(e == index){
            //             //     // $('#toggle-vis-click-'+e).attr('checked', true);
            //             //     // console.log(e);
            //             //     // $('#toggle-vis-click-'+e).click();
            //             // }else{

            //             // }                
            //         });
            //     // }
            //     cut_toggle_vis_all1.forEach(element => {
            //         // console.log(element);
            //         if(element != ""){
            //             // $('#toggle-vis-click-'+element).attr('checked', true);
            //         }
            //     });
            //     if(cut_toggle_vis_all1.length < 7){
            //         // $('.toggle-vis-all1').click();
            //     }
            // }else{
            //     console.log('222');
            //     for (let index = 3; index <= 9; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 // console.log(e);
            //                 // $('#toggle-vis-click-'+e).click();
            //             }                
            //         });
            //     }
            //     // $('.toggle-vis-all1').click();
            // }
        }
        // function search_data(){
        //     const availWidth = window.screen.availWidth;
        //     var fixedColumns = 2;
        //     if(availWidth < 630){
        //         fixedColumns = 2;
        //     }
        //     var otable = $("#kt_datatable_dom_positioning").DataTable({
        //         // layout: {
        //         //     topStart: {
        //         //         buttons: ['excel']
        //         //     }
        //         // },
        //         fixedHeader: {
        //             header: true,
        //         },
        //         fixedColumns: {
        //             left: fixedColumns,
        //         },
        //         "lengthMenu": [[100,500, 1000, 2000, 3000], [100,500, 1000, 2000, 3000]],
        //         scrollCollapse: true,
        //         scrollY: '500px',
        //         scrollX: true,
        //         // scrollY: '200px',
        //         searchDelay: 500,
        //         processing: true,
        //         serverSide: true,
        //         // scrollY: true,
        //         // scrollX: true,
        //         // scrollCollapse: true,
        //         "columnDefs": [{
        //             "visible": false,
        //             "targets": -1
        //         }],
        //         ajax: {
        //             url: "{{ url(Request::segment(1).'/table_salary_getdata') }}",
        //             type: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: function(d) {
        //                 d.Like = {};
        //                 $('.myLike').each(function() {
        //                     if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
        //                         d.Like[$(this).attr('name')] = $.trim($(this)
        //                             .val());
        //                     }
        //                 });
        //                 // console.log(d);
        //                 if($('#search_division').val().length > 0){
        //                     d.search_division = $('#search_division').val();
        //                 }   
        //                 if($('#search_department').val().length > 0){
        //                     d.search_department = $('#search_department').val();
        //                 }   
        //                 if($('#search_section').val().length > 0){
        //                     d.search_section = $('#search_section').val();
        //                 }   
        //                 if($('#search_employee_no').val().length > 0){
        //                     d.search_employee_no = $('#search_employee_no').val();
        //                 }   
        //                 d.pagenow = '1';
        //                 oData = d
        //             },
        //         },
        //         columns: [
        //             { data: "id",className: 'text-center' },
        //             { data: "code",className: 'text-center' },
        //             { data: "name" },
        //             { data: "divi" },
        //             { data: "dept" },
        //             { data: "sect" },
        //             { data: "position" },
        //             { data: "group" },
        //             { data: "joindate" },
        //             { data: "serviced" },
        //             { data: "sl",className: 'text-center' },
        //             { data: "pl",className: 'text-center' },
        //             { data: "latet",className: 'text-center' },
        //             { data: "lated",className: 'text-center' },
        //             { data: "abst",className: 'text-center' },
        //             { data: "absd",className: 'text-center' },
        //             { data: "ol",className: 'text-center' },
        //             { data: "totald",className: 'text-center' },
        //             { data: "verbal",className: 'text-center' },
        //             { data: "written",className: 'text-center' },
        //             { data: "susd",className: 'text-center' },
        //             { data: "pa1" },
        //             { data: "pa2" },
        //             { data: "pa3" },
        //             { data: "form",className: 'text-center' },
        //             { data: "evaluator" },
        //             { data: "total",className: 'text-right' },
        //             { data: "theoryg" },
        //             { data: "adjustg" },
        //             { data: "current",className: 'text-right' },
        //             { data: "l800avg",className: 'text-right'  },
        //             { data: "bsalaryw",className: 'text-right'  },
        //             { data: "cbsalaryw",className: 'text-right'  },
        //             { data: "comsugpct",className: 'text-right'  },
        //             { data: "comsugamt",className: 'text-right'  },
        //             { data: "companynewb",className: 'text-right'  },
        //             { data: "gmgr" },
        //             { data: "incpctmgr" },
        //             { data: "incamount",className: 'text-right'  },
        //             { data: "newbwage",className: 'text-right'  },
        //             { data: "newbsalary",className: 'text-right'  },
        //             { data: "finaldmgm",className: 'text-right'  },
        //             { data: "remark" },
        //             { data: "status" },
        //         ],
        //         columnDefs: [ {
        //             "targets": 0,
        //             "orderable": false
        //         }],
        //         "language": {
        //             "lengthMenu": "Show _MENU_",
        //         },
        //         "dom": "<'row'" +
        //             "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
        //             ">" +

        //             "<'table-responsive'tr>" +

        //             "<'row'" +
        //             "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        //             "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        //             "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
        //             ">"
        //     });
        //     // $('#search_division').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     // $('#search_department').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     // $('#search_section').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     // $('#search_month_day').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     // $('#search_grade').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     // $('#search_status').on('change', function(e) {
        //     //     otable.draw();
        //     //     all_detail();
        //     // });
        //     $('#select-all').click(function(event) {   
        //         if(this.checked) {
        //             // Iterate each checkbox
        //             $('.checkbox-select').each(function() {
        //                 this.checked = true;                        
        //             });
        //         } else {
        //             $('.checkbox-select').each(function() {
        //                 this.checked = false;                       
        //             });
        //         }
        //     }); 

        //     function format(d) {
        //         // `d` is the original data object for the row
        //         return (
        //             "<dl>" +
        //             '<h6 class="mb-2 title1">Remark (P,AR,U)</h6>' +
        //             '<input type="text" class="form-control form-control-sm">' +
        //             "</dl>"
        //         );
        //     }

        //     otable.on("click", "td.dt-control", function (e) {
        //         let tr = e.target.closest("tr");
        //         let row = otable.row(tr);

        //         if (row.child.isShown()) {
        //             // This row is already open - close it
        //             row.child.hide();
        //         } else {
        //             // Open this row
        //             row.child(format(row.data())).show();
        //         }
        //     });
        //     $(".toggle-vis").change(function (e) {
        //         e.preventDefault();

        //         let columnIdx = e.target.getAttribute("data-column");
        //         let column = otable.column(columnIdx);

        //         // Toggle the visibility
        //         column.visible(!column.visible());
        //     });
        //     // $(".toggle-vis-all1").change(function (ee) {
        //     //     for (let index = 3; index <= 9; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }                
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all2").change(function (ee) {
        //     //     for (let index = 10; index <= 17; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }           
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all3").change(function (ee) {
        //     //     for (let index = 18; index <= 20; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }           
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all4").change(function (ee) {
        //     //     for (let index = 21; index <= 23; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }           
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all5").change(function (ee) {
        //     //     for (let index = 24; index <= 28; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }           
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all6").change(function (ee) {
        //     //     for (let index = 30; index <= 35; index++) {
        //     //         $('.toggle-vis').each(function(e) {
        //     //             if(e == index){
        //     //                 $('#toggle-vis-click-'+e).click();
        //     //             }           
        //     //         });
        //     //     }
        //     // });
        //     // $(".toggle-vis-all7").change(function (ee) {
        //     //     $('#toggle-vis-click-36').click();
        //     //     $('#toggle-vis-click-37').click();
        //     //     $('#toggle-vis-click-38').click();
        //     //     $('#toggle-vis-click-39').click();
        //     //     $('#toggle-vis-click-40').click();
        //     //     $('#toggle-vis-click-41').click();
        //     //     $('#toggle-vis-click-42').click();
        //     // });
        //     all_detail();
        //     setTimeout(() => {
        //         bell_curve_detail();
        //     }, 200);
        // }
        function change_class(e,i,id,employee_id) {
            var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
            var hidden_budget_std = $('.hidden_budget_std'); 
            // console.log(id);
            if(e.value == 'P' || e.value == 'AR' || e.value == 'U' || e.value == 'CD'){
                $.ajax({
                        type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_positoon_for_change") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":employee_id,
                        "search_year":$('#search_year').val(),
                    },
                    success: function (result) {
                        $('#change_position_employee_id').val(employee_id);
                        $('#change_position_final_id').val(id);
                        $('#change_position_old').val(result.position_code);
                        $('#change_position_new').val((result.position_code_change?result.position_code_change:result.position_code));
                        $('#select2-change_position_old-container').text(result.position_code+' - '+result.position_description);
                        $('#select2-change_position_new-container').text((result.position_code_change?result.position_code_change:result.position_code)+' - '+(result.position_description_change?result.position_description_change:result.position_description));
                        if(result.change_position_remark && result.change_position_remark != ""){
                            $('#change_position_remark').val(result.change_position_remark);
                        }else{
                            $('#change_position_remark').val(`1. Job Header
                                1.1 Position
                                1.2 Position Description
                                1.3 Company
                                1.4 Level
                                1.5 Division
                                1.6 Department
                                1.7 Section
                                1.8 Position Backup
                                1.9 Position report to this role
                                1.10 Position Report to
                                1.11 Higher Line of Order

                                2. Role and Responsibilities (Key Responsibility / Task)

                                3. Job Competencies
                                3.1 Knowledge
                                3.2 Skills
                                3.3 Personality Traits`);
                        }
                        
                        $('#change_position_reasons').val(result.change_position_reasons);

                        if(e.value == 'P' || e.value == 'CD'){
                            $('.showhide_p').css('display','');
                            $('.hide_exiting_position').css('display','');
                            $('.showhide_change_position_reasons_info').css('display','');
                            if(e.value == 'P'){
                                $('.text_change_position_reasons_info').html('Reasons for Promotion');
                                $('.showpromotion').html('Promotion');
                            }else{
                                $('.text_change_position_reasons_info').html('Reasons for CD');
                                $('.showpromotion').html('Grade CD');
                            }
                        }else{
                            $('.showhide_p').css('display','none');
                            $('.hide_exiting_position').css('display','none');
                            $('.showhide_change_position_reasons_info').css('display','');
                            $('.text_change_position_reasons_info').html('Reasons');
                            $('.showpromotion').html('Grade');
                        }
                        
                        $('.hide_new_position').css('display','none');
                        
                        $('#update_grade_p').modal('show');
                        $('#exiting_1').click();
                        $('#new_position_code').val('');
                        $('#new_position_description').val('');
                        $('.change_class_info'+id).css("display", "");
                        $('#percent_proposed'+id).css("background", "");
                    }
                });
            }else{
                for(var i = 0;i < hidden_budget_std.length;i++){
                    if(hidden_budget_grade_name[i].value == e.value){
                        $('#percent_proposed'+id).val((e.value=='CD'?10:hidden_budget_std[i].value));
                        $('.percent_proposed'+id).html((e.value=='CD'?10:hidden_budget_std[i].value)+'%');
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/update_percent_proposed") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "id":id,
                                "grade_proposed":e.value,
                                "percent_proposed":(e.value=='CD'?10:hidden_budget_std[i].value),
                                "search_year":$('#search_year').val(),
                            },
                            success: function (result) {
                                if(e.value == 'P'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeP");
                                    $('.changecolor'+id).css("color", "var(--bs-primary)");
                                    $('.changecolor'+id).text("P");
                                }else if(e.value == 'A'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeA");
                                    $('.changecolor'+id).css("color", "var(--bs-success)");
                                    $('.changecolor'+id).text("A");
                                }else if(e.value == 'B'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeB");
                                    $('.changecolor'+id).css("color", "var(--bs-primary)");
                                    $('.changecolor'+id).text("B");
                                }else if(e.value == 'C'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeC");
                                    $('.changecolor'+id).css("color", "var(--bs-success)");
                                    $('.changecolor'+id).text("C");
                                }else if(e.value == 'D'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeD");
                                    $('.changecolor'+id).css("color", "var(--bs-warning)");
                                    $('.changecolor'+id).text("D");
                                }else if(e.value == 'E'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2 gradeE");
                                    $('.changecolor'+id).css("color", "var(--bs-danger)");
                                    $('.changecolor'+id).text("E");
                                }else if(e.value == 'U'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2");
                                    $('.changecolor'+id).css("color", "black");
                                    $('.changecolor'+id).text("U");
                                }else if(e.value == 'CD'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2");
                                    $('.changecolor'+id).css("color", "black");
                                    $('.changecolor'+id).text("CD");
                                    $('#percent_proposed'+id).val(10);
                                }else if(e.value == 'AR'){
                                    $(e).attr("class", "form-select form-select-sm selectG mb-2");
                                    $('.changecolor'+id).css("color", "black");
                                    $('.changecolor'+id).text("AR");
                                }
                                $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                                $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                                $('.amount_proposed'+id).html(result.amount_proposed);
                                $('.salary_new'+id).html(result.salary_new);
                                $('.salary_month_new'+id).html(result.salary_month_new);

                                
                                // $('.final_by_md_gm_amount'+id).html(result.final_by_md_gm_amount);
                                if(e.value != 'P' && e.value != 'CD' && e.value != 'AR'){
                                    // $('#remark_grade'+id).val('');
                                }
                                $('.change_class_info'+id).css("display", "none");
                                $('#percent_proposed'+id).css("background", "");

                                if(result.grade_proposed_old == 'P' && e.value != 'P'){
                                    $('#remark_grade'+id).val('');
                                    $('.open_jd'+id).css('display','none');
                                }
                                // destroy_table();
                                all_detail();
                                Swal.fire({
                                    title: "Update Success",
                                    text: "",
                                    icon: "success",
                                    allowOutsideClick: false,
                                });
                                if(e.value == 'P'){
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 200);
                                }
                            }
                        });
                    }
                }
            }
        }
        function change_class_info(e,i,id,employee_id) {
            var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
            var hidden_budget_std = $('.hidden_budget_std'); 
            var id_gmgr = $('#id_gmgr'+id).val();
            // console.log(id);
            if(id_gmgr == 'P' || id_gmgr == 'AR' || id_gmgr == 'U' || id_gmgr == 'CD'){
                $.ajax({
                        type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_positoon_for_change") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":employee_id
                    },
                    success: function (result) {
                        $('#change_position_employee_id_info').val(employee_id);
                        $('#change_position_final_id_info').val(id);
                        // $('#change_position_old_info').val((result.position_code_old?result.position_code_old:result.position_code));
                        // $('#change_position_new_info').val(result.position_code);
                        // $('#select2-change_position_old_info-container').text((result.position_code_old?result.position_code_old:result.position_code)+' - '+(result.position_description_old?result.position_description_old:result.position_description));
                        // $('#select2-change_position_new_info-container').text(result.position_code+' - '+result.position_description);
                        $('#change_position_old_info').val(result.position_code);
                        $('#change_position_new_info').val((result.position_code_change?result.position_code_change:result.position_code));
                        $('#select2-change_position_old_info-container').text(result.position_code+' - '+result.position_description);
                        $('#select2-change_position_new_info-container').text((result.position_code_change?result.position_code_change:result.position_code)+' - '+(result.position_description_change?result.position_description_change:result.position_description));
                        
                        if(result.change_position_remark && result.change_position_remark != ""){
                            $('#change_position_remark_info').val(result.change_position_remark);
                        }else{
                            $('#change_position_remark_info').val(`1. Job Header
                                1.1 Position
                                1.2 Position Description
                                1.3 Company
                                1.4 Level
                                1.5 Division
                                1.6 Department
                                1.7 Section
                                1.8 Position Backup
                                1.9 Position report to this role
                                1.10 Position Report to
                                1.11 Higher Line of Order

                                2. Role and Responsibilities (Key Responsibility / Task)

                                3. Job Competencies
                                3.1 Knowledge
                                3.2 Skills
                                3.3 Personality Traits`);
                        }
                        $('#change_position_reasons_info').val(result.change_position_reasons);

                        if(e == 'P' || e == 'CD'){
                            $('.showhide_p').css('display','');
                            $('.hide_exiting_position').css('display','');
                            $('.showhide_change_position_reasons_info').css('display','');
                            if(e == 'P'){
                                $('.text_change_position_reasons_info').html('Reasons for Promotion');
                                $('.showpromotion').html('Promotion');
                            }else{
                                $('.text_change_position_reasons_info').html('Reasons for CD');
                                $('.showpromotion').html('Grade CD');
                            }
                        }else{
                            $('.showhide_p').css('display','none');
                            $('.showhide_change_position_reasons_info').css('display','');
                            $('.text_change_position_reasons_info').html('Reasons');
                            $('.showpromotion').html('Grade');
                        }

                        $('#update_grade_p_info').modal('show');
                    }
                });
            }
        }
        function change_class_input(e,i,id) {
            $('#percent_proposed'+id).val(e.value);
            $('.percent_proposed'+id).html(e.value+'%');
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/update_percent_proposed_input") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "grade_proposed":$('#id_gmgr'+id).val(),
                    "percent_proposed":e.value,
                    "search_year":$('#search_year').val(),
                },
                success: function (result) {
                    $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                    $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                    $('.amount_proposed'+id).html(result.amount_proposed);
                    $('.salary_new'+id).html(result.salary_new);
                    $('.salary_month_new'+id).html(result.salary_month_new);
                    if($('#id_gmgr'+id).val() != 'P' && $('#id_gmgr'+id).val() != 'CD' && $('#id_gmgr'+id).val() != 'AR'){
                        // $('#remark_grade'+id).val('');
                    }
                    all_detail();
                    Swal.fire({
                        title: "Update Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                }
            });
        }
        function change_date(date){
            if(date){
                var cut = date.split(' ');
                date = cut[0];
            }
            return date;
        }
        function set_info(id){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/salary_set_info") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":id
                },
                success: function (result) {
                    var total1 = parseFloat(result.attendance_sl)+parseFloat(result.attendance_pl)+parseFloat(result.attendance_late)+parseFloat(result.attendance_abs);
                    var total2 = parseFloat(result.attendance_abt)+parseFloat(result.attendance_vwar)+parseFloat(result.attendance_wwar)+parseFloat(result.attendance_sus);
                    $('.show_info').html(`
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i
                                    class="ki-duotone ki-user-square fs-1 text-primary me-2"
                                >
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3>${result.employee_local_name_en}</h3>
                                <span
                                    class="badge badge-warning rounded-pill text-black"
                                    >Emp.Code : ${result.employee_no}</span
                                >
                            </div>
                        </div>
                        <ul class="list-group rounded-3 mb-3">
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Division:</p>
                                <p class="mb-0 fw-semibold">${result.division_code}</p>
                            </li>
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Department:</p>
                                <p class="mb-0 fw-semibold">${result.department_code}</p>
                            </li>
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Section:</p>
                                <p class="mb-0 fw-semibold">${result.section_code}</p>
                            </li>
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Type:</p>
                                <p class="mb-0 fw-semibold">${(result.salary_type?result.salary_type:'&nbsp;')}</p>
                            </li>
                            <li class="list-group-item bg-light-primary">
                                <p class="mb-0 small">Grade:</p>
                                <p class="mb-0 fw-semibold">${result.grade_code}</p>
                            </li>
                        </ul>
                        <div class="row g-3">
                            <div class="col-6">
                                <ul class="list-group rounded-3">
                                    <li class="list-group-item bg-light-primary">
                                        <p class="mb-0 small">Joining Date:</p>
                                        <p class="mb-0 fw-semibold">${change_date(result.date_joined)}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="list-group rounded-3">
                                    <li class="list-group-item bg-light-primary">
                                        <p class="mb-0 small">Service Period:</p>
                                        <p class="mb-0 fw-semibold">${result.service_days}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr />
                        <div class="card border-danger rounded-3 shadow-none mb-3">
                            <div
                                class="card-header bg-danger py-2 min-h-30px fw-bold text-white h4"
                            >
                                Attendance
                            </div>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">SL</p>
                                    <p class="text-end mb-0">${result.attendance_sl}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">PL</p>
                                    <p class="text-end mb-0">${result.attendance_pl}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">LATE</p>
                                    <p class="text-end mb-0">${result.attendance_late}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">ABS</p>
                                    <p class="text-end mb-0">${result.attendance_abs}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">OL</p>
                                    <p class="text-end mb-0">0</p>
                                </li>
                                <li
                                    class="list-group-item bg-light-danger d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">Total</p>
                                    <p class="text-end mb-0">${total1}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="card border-primary rounded-3 shadow-none">
                            <div
                                class="card-header bg-primary py-2 min-h-30px fw-bold text-white h4"
                            >
                                Compliance with company regulation
                            </div>
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">Absent</p>
                                    <p class="text-end mb-0">${result.attendance_abt}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">VWAR</p>
                                    <p class="text-end mb-0">${result.attendance_vwar}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">WWAR</p>
                                    <p class="text-end mb-0">${result.attendance_wwar}</p>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">SUS</p>
                                    <p class="text-end mb-0">${result.attendance_sus}</p>
                                </li>
                                <li
                                    class="list-group-item bg-light-primary d-flex justify-content-between"
                                >
                                    <p class="fw-bold mb-0">Total</p>
                                    <p class="text-end mb-0">${total2}</p>
                                </li>
                            </ul>
                        </div>
                    `);
                }
            });
        }
        function update_remark_grade(id){

            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/update_remark_grade") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "remark_grade":$('#remark_grade'+id).val()
                },
                success: function (result) {
                    Swal.fire({
                        title: "Update Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                }
            });
        }
        function all_detail(){
            loading_hide();
            loading();
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/all_detail") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division":$('#search_division').val(),
                    "search_department":$('#search_department').val(),
                    "search_section":$('#search_section').val(),
                    "search_employee_no":$('#search_employee_no').val(),
                    "search_month_day":$('#search_month_day').val(),
                    "search_grade":$('#search_grade').val(),
                    "search_status":$('#search_status').val(),
                    "search_complaince_score":$('#search_complaince_score').val(),
                    "search_attendance_score":$('#search_attendance_score').val(),
                    "pagenow":"1",
                    "pagenow_salary":"",
                    "search_year":$('#search_year').val(),
                    "search_not_up_salary":$('#search_not_up_salary').val(),
                },
                success: function (result) {
                    if(result){
                        if(result.percent_department){
                            var percent_daily = (result.percent_department.percent_daily>0?result.percent_department.percent_daily:0);
                            var percent_monthly = (result.percent_department.percent_monthly>0?result.percent_department.percent_monthly:0);
                            var percent_all = parseFloat(percent_daily)+parseFloat(percent_monthly);
                            $('.percent_department_daily_percent').html((percent_daily>0?number_format2(percent_daily,3)+'%':''));
                            $('.percent_department_monthly_percent').html((percent_monthly>0?number_format2(percent_monthly,3)+'%':''));
                            $('.percent_department_Dailymonthly_percent').html((percent_monthly>0?number_format2(percent_monthly,3)+'%':''));
                            var salary_old = $('.salary_old'); 
                            var salary_new = $('.salary_new'); 
                            var sum_salary_old = 0;
                            var sum_salary_new = 0;
                            for(var i = 0;i < salary_old.length;i++){
                                sum_salary_old += parseFloat(salary_old[i].value);
                                sum_salary_new += parseFloat(salary_new[i].value);
                            }

                            var salary_month_old = $('.salary_month_old'); 
                            var salary_month_new = $('.salary_month_new'); 
                            var sum_salary_month_old = 0;
                            var sum_salary_month_new = 0;
                            for(var i = 0;i < salary_month_old.length;i++){
                                sum_salary_month_old += parseFloat(salary_month_old[i].value);
                                sum_salary_month_new += parseFloat(salary_month_new[i].value);
                            }

                            // var cal_daily = (parseFloat(sum_salary_new)/parseFloat(sum_salary_old)-1)*100;
                            // var cal_month = (parseFloat(sum_salary_month_new)/parseFloat(sum_salary_month_old)-1)*100;
                            // if($('#search_month_day').val() == '1'){
                            //     $('.Overall_daily_percent').html(number_format2(cal_daily,3)+'%');
                            // }else{
                            //     $('.Overall_monthly_percent').html(number_format2(cal_month,3)+'%');
                            // }   
                        }     
                        if(result.total_Daily || result.total_Monthly || result.total_Daily_Monthly){
                            var html = ``;
                            var Monthly = ``;
                            var Daily = ``;
                            var All = ``;

                            Monthly += `
                                <tr class="align-middle">
                                    <td class="fw-bold">Monthly</td>
                                    <td class="text-end footer-hide-29">${(result.total_Monthly.current_salary_wage>0?number_format(result.total_Monthly.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end footer-hide-30">${(result.total_Monthly.L800_avg_wage_mwa>0?number_format(result.total_Monthly.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end footer-hide-31">${(result.total_Monthly.salary_wage_calculation>0?number_format(result.total_Monthly.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end footer-hide-32">${(result.total_Monthly.current_salary_wage_month>0?number_format(result.total_Monthly.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center footer-hide-33">${(result.total_Monthly.company_suggested_percent>0?number_format(result.total_Monthly.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end footer-hide-34">${(result.total_Monthly.company_suggested_amount>0?number_format(result.total_Monthly.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end footer-hide-35">${(result.total_Monthly.company_suggested_new_basic>0?number_format(result.total_Monthly.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="bg-light-primary text-center footer-hide-37">${(result.total_Monthly.inc_percent_proposed>0?number_format(result.total_Monthly.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="bg-light-primary text-end footer-hide-38">${(result.total_Monthly.inc_amount_proposed>0?number_format(result.total_Monthly.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-39">${(result.total_Monthly.new_basic_wage_proposed>0?number_format(result.total_Monthly.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-40">${(result.total_Monthly.new_salary_wage_month>0?number_format(result.total_Monthly.new_salary_wage_month,2):'0.00')}</td>
                                    <td class="bg-light-success text-end footer-hide-41 showhide_total_Monthly">${(result.total_Monthly.final_by_md_gm_amount>0?number_format(result.total_Monthly.final_by_md_gm_amount,2):'0.00')}</td>
                                </tr>
                            `;
                    
                            Daily += `
                                <tr class="align-middle">
                                    <td class="fw-bold">Daily</td>
                                    <td class="text-end footer-hide-29">${(result.total_Daily.current_salary_wage>0?number_format(result.total_Daily.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end footer-hide-30">${(result.total_Daily.L800_avg_wage_mwa>0?number_format(result.total_Daily.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end footer-hide-31">${(result.total_Daily.salary_wage_calculation>0?number_format(result.total_Daily.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end footer-hide-32">${(result.total_Daily.current_salary_wage_month>0?number_format(result.total_Daily.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center footer-hide-33">${(result.total_Daily.company_suggested_percent>0?number_format(result.total_Daily.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end footer-hide-34">${(result.total_Daily.company_suggested_amount>0?number_format(result.total_Daily.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end footer-hide-35">${(result.total_Daily.company_suggested_new_basic>0?number_format(result.total_Daily.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="bg-light-primary text-center footer-hide-37">${(result.total_Daily.inc_percent_proposed>0?number_format(result.total_Daily.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="bg-light-primary text-end footer-hide-38">${(result.total_Daily.inc_amount_proposed>0?number_format(result.total_Daily.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-39">${(result.total_Daily.new_basic_wage_proposed>0?number_format(result.total_Daily.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-40">${(result.total_Daily.new_salary_wage_month>0?number_format(result.total_Daily.new_salary_wage_month,2):'0.00')}</td>
                                    <td class="bg-light-success text-end footer-hide-41 showhide_total_Daily">${(result.total_Daily.final_by_md_gm_amount>0?number_format(result.total_Daily.final_by_md_gm_amount,2):'0.00')}</td>
                                </tr>
                            `;

                            All += `
                                <tr class="align-middle">
                                    <td class="fw-bold">Total Monthly+Daily</td>
                                    <td class="text-end footer-hide-29">${(result.total_Daily_Monthly.current_salary_wage>0?number_format(result.total_Daily_Monthly.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end footer-hide-30">${(result.total_Daily_Monthly.L800_avg_wage_mwa>0?number_format(result.total_Daily_Monthly.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end footer-hide-31">${(result.total_Daily_Monthly.salary_wage_calculation>0?number_format(result.total_Daily_Monthly.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end footer-hide-32">${(result.total_Daily_Monthly.current_salary_wage_month>0?number_format(result.total_Daily_Monthly.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center footer-hide-33">${(result.total_Daily_Monthly.company_suggested_percent>0?number_format(result.total_Daily_Monthly.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end footer-hide-34">${(result.total_Daily_Monthly.company_suggested_amount>0?number_format(result.total_Daily_Monthly.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end footer-hide-35">${(result.total_Daily_Monthly.company_suggested_new_basic>0?number_format(result.total_Daily_Monthly.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="bg-light-primary text-center footer-hide-37">${(result.total_Daily_Monthly.inc_percent_proposed>0?number_format(result.total_Daily_Monthly.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="bg-light-primary text-end footer-hide-38">${(result.total_Daily_Monthly.inc_amount_proposed>0?number_format(result.total_Daily_Monthly.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-39">${(result.total_Daily_Monthly.new_basic_wage_proposed>0?number_format(result.total_Daily_Monthly.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="bg-light-primary text-end footer-hide-40">${(result.total_Daily_Monthly.new_salary_wage_month>0?number_format(result.total_Daily_Monthly.new_salary_wage_month,2):'0.00')}</td>
                                    <td class="bg-light-success text-end footer-hide-41 showhide_total_Daily_Monthly">${(result.total_Daily_Monthly.final_by_md_gm_amount>0?number_format(result.total_Daily_Monthly.final_by_md_gm_amount,2):'0.00')}</td>
                                </tr>
                            `;
                            html = Monthly+Daily+All;
                            $('.data_footer').html(html);

                            if(result.total_Daily.new_basic_wage_proposed > 0){
                                var cal_daily = Math.round(((parseFloat(result.total_Daily.new_basic_wage_proposed)/parseFloat(result.total_Daily.current_salary_wage)-1)*100)* 1000)/ 1000;
                            }else{
                                var cal_daily = 0;
                            }
                            if(result.total_Monthly.new_salary_wage_month > 0){
                                var cal_month = Math.round(((parseFloat(result.total_Monthly.new_salary_wage_month)/parseFloat(result.total_Monthly.current_salary_wage_month)-1)*100)* 1000)/ 1000;
                            }else{
                                var cal_month = 0;
                            }
                            // alert(cal_daily+'//'+cal_month);
                            // if($('#search_month_day').val() == '1'){
                            //     $('.Overall_daily_percent').html(number_format2(cal_daily,3)+'%');
                            // }else{
                            //     $('.Overall_monthly_percent').html(number_format2(cal_month,3)+'%');
                            // } 
                            $('.Overall_daily_percent').html((result.total_Daily.inc_percent_proposed>0?number_format(result.total_Daily.inc_percent_proposed,3):'0.00')+'%');
                            $('.Overall_monthly_percent').html((result.total_Monthly.inc_percent_proposed>0?number_format(result.total_Monthly.inc_percent_proposed,3):'0.00')+'%');
                            var cal_all = parseFloat(cal_daily)+parseFloat(cal_month);
                            $('.Overall_Dailymonthly_percent').html((result.total_Daily_Monthly.inc_percent_proposed>0?number_format(result.total_Daily_Monthly.inc_percent_proposed,3):'0.00')+'%');
                        } 
                        // if(result.footer){
                        //     var html = ``;
                        //     var Monthly = ``;
                        //     var Daily = ``;
                        //     var All = ``;
                        //     $.each(result.footer, function (key, value) {	
                        //         if(value.total_type == '1'){
                        //             Monthly += `
                        //                 <tr class="align-middle">
                        //                     <td class="fw-bold">Monthly</td>
                        //                     <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                        //                     <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                        //                     <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                        //                     <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                        //                     <td class="text-center">${(value.company_suggested_percent>0?number_format(value.company_suggested_percent,2):'')}%</td>
                        //                     <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                        //                     <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                        //                     <td></td>
                        //                     <td class="text-center">${(value.inc_percent_proposed>0?number_format(value.inc_percent_proposed,2):'')}%</td>
                        //                     <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                        //                 </tr>
                        //             `;
                        //         }
                        //         if(value.total_type == '0'){
                        //             Daily += `
                        //                 <tr class="align-middle">
                        //                     <td class="fw-bold">Daily</td>
                        //                     <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                        //                     <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                        //                     <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                        //                     <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                        //                     <td class="text-center">${(value.company_suggested_percent>0?number_format(value.company_suggested_percent,2):'')}%</td>
                        //                     <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                        //                     <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                        //                     <td></td>
                        //                     <td class="text-center">${(value.inc_percent_proposed>0?number_format(value.inc_percent_proposed,2):'')}%</td>
                        //                     <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                        //                 </tr>
                        //             `;
                        //         }
                        //         if(value.total_type == '2'){
                        //             All += `
                        //                 <tr class="align-middle">
                        //                     <td class="fw-bold">Total Monthly+Daily</td>
                        //                     <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                        //                     <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                        //                     <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                        //                     <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                        //                     <td class="text-center">${(value.company_suggested_percent>0?number_format(value.company_suggested_percent,2):'')}%</td>
                        //                     <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                        //                     <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                        //                     <td></td>
                        //                     <td class="text-center">${(value.inc_percent_proposed>0?number_format(value.inc_percent_proposed,2):'')}%</td>
                        //                     <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                        //                     <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                        //                 </tr>
                        //             `;
                        //         }
                        //     })
                        //     html = Monthly+Daily+All;
                        //     $('.data_footer').html(html);
                        // } 
                        if(result.countdata){
                            var countA = 0;
                            var countB = 0;
                            var countC = 0;
                            var countD = 0;
                            var countE = 0;
                            var countNoNull = 0;

                            var proposed_countAR = 0;
                            var proposed_countP = 0;
                            var proposed_countA = 0;
                            var proposed_countB = 0;
                            var proposed_countC = 0;
                            var proposed_countD = 0;
                            var proposed_countE = 0;
                            var proposed_countU = 0;
                            var proposed_countCD = 0;
                            var proposed_countNoNull = 0;

                            $.each(result.countdata, function (key, value) {	
                                if(value.adjust_grade == 'A'){
                                    countA++;
                                    countNoNull++;
                                }
                                if(value.adjust_grade == 'B'){
                                    countB++;
                                    countNoNull++;
                                }
                                if(value.adjust_grade == 'C'){
                                    countC++;
                                    countNoNull++;
                                }
                                if(value.adjust_grade == 'D'){
                                    countD++;
                                    countNoNull++;
                                }
                                if(value.adjust_grade == 'E'){
                                    countE++;
                                    countNoNull++;
                                }

                                ///////////

                                if(value.grade_proposed == 'AR'){
                                    proposed_countAR++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'P'){
                                    proposed_countP++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'A'){
                                    proposed_countA++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'B'){
                                    proposed_countB++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'C'){
                                    proposed_countC++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'D'){
                                    proposed_countD++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'E'){
                                    proposed_countE++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'U'){
                                    proposed_countU++;
                                    proposed_countNoNull++;
                                }
                                if(value.grade_proposed == 'CD'){
                                    proposed_countCD++;
                                    proposed_countNoNull++;
                                }
                            });
                            
                            $('.bell_total_all2').html(number_format2(countNoNull,1));
                            $('.total_adjust_LevelA').html(number_format2(countA,1));
                            $('.total_adjust_LevelB').html(number_format2(countB,1));
                            $('.total_adjust_LevelC').html(number_format2(countC,1));
                            $('.total_adjust_LevelD').html(number_format2(countD,1));
                            $('.total_adjust_LevelE').html(number_format2(countE,1));
                            
                            var sumA = (countNoNull*parseFloat($('#bell_percentA').val()))/100;
                            var sumB = (countNoNull*parseFloat($('#bell_percentB').val()))/100;
                            var sumC = (countNoNull*parseFloat($('#bell_percentC').val()))/100;
                            var sumD = (countNoNull*parseFloat($('#bell_percentD').val()))/100;
                            var sumE = (countNoNull*parseFloat($('#bell_percentE').val()))/100;
                            var sumAll = sumA+sumB+sumC+sumD+sumE;
                            $('.bell_total_all1').html(number_format2(sumAll,1));
                            $('.total_theoretical_LevelA').html(number_format2(sumA,1));
                            $('.total_theoretical_LevelB').html(number_format2(sumB,1));
                            $('.total_theoretical_LevelC').html(number_format2(sumC,1));
                            $('.total_theoretical_LevelD').html(number_format2(sumD,1));
                            $('.total_theoretical_LevelE').html(number_format2(sumE,1));

                            ////////
                            
                            $('.total_actual_LevelAR').html(number_format2(proposed_countAR,1));
                            $('.total_actual_LevelP').html(number_format2(proposed_countP,1));
                            $('.total_actual_LevelA').html(number_format2(proposed_countA,1));
                            $('.total_actual_LevelB').html(number_format2(proposed_countB,1));
                            $('.total_actual_LevelC').html(number_format2(proposed_countC,1));
                            $('.total_actual_LevelD').html(number_format2(proposed_countD,1));
                            $('.total_actual_LevelE').html(number_format2(proposed_countE,1));
                            $('.total_actual_LevelU').html(number_format2(proposed_countU,1));
                            $('.total_actual_LevelCD').html(number_format2(proposed_countCD,1));
                            $('.bell_total_all3').html(number_format2(proposed_countNoNull,1));
                        }

                        if(result.data_all>=0){
                            $('.data_all').html(result.data_all);
                        }
                        $('.data_in').html(parseFloat(result.data_all)-parseFloat(result.data_finish)-parseFloat(result.data_reject));
                        if(result.data_reject>=0){
                            $('.data_reject').html(result.data_reject);
                        }
                        if(result.data_finish >= 0){
                            $('.data_finish').html(result.data_finish);
                        }

                        var test = 0;
                        var sumdaily = 0;
                        var summonthly = 0;
                        var sum = 0;
                        $('.finaldmgm_hide').each(function(key, value) {
                            if($('.grade_code_hide')[key].value == 'L800' && $('.status_salary_hide')[key].value == '1'){
                                if(this.value){
                                    sumdaily += parseFloat(this.value);
                                } 
                            }
                            if($('.grade_code_hide')[key].value != 'L800' && $('.status_salary_hide')[key].value == '1'){
                                if(this.value){
                                    summonthly += parseFloat(this.value);
                                } 
                            }
                            if($('.status_salary_hide')[key].value == '1'){
                                if(this.value){
                                    sum += parseFloat(this.value);
                                } 
                            }       
                        });

                        $('.showhide_total_Monthly').html((summonthly>0?number_format(summonthly,2):''));
                        $('.showhide_total_Daily').html((sumdaily>0?number_format(sumdaily,2):''));
                        $('.showhide_total_Daily_Monthly').html((sum>0?number_format(sum,2):''));
                        // console.log(sumdaily);
                        // console.log(summonthly);
                        // console.log(sum);
                    }
                    loading_hide();
                }
            });
            
        }
        function change_grade_select(){
            if($('#edit_grade_select').val() == ""){
                Swal.fire({
                    title: "Please Select Grade",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
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
                        url: '{{ url(Request::segment(1)."/change_grade_select") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "id":getCheckbox,
                            "grade_proposed":$('#edit_grade_select').val()
                        },
                        success: function (result) { 
                            Swal.fire({
                                title: "Update Success",
                                text: "",
                                icon: "success",
                                allowOutsideClick: false,
                            });
                            destroy_table();
                            // all_detail();
                            $('#editG').modal('hide');
                        }
                    });
                }
            }
        }
        function change_percent_select(){
            if($('#edit_percent_select').val() == ""){
                Swal.fire({
                    title: "Please input %",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
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
                        url: '{{ url(Request::segment(1)."/change_percent_select") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "id":getCheckbox,
                            "percent_proposed":$('#edit_percent_select').val()
                        },
                        success: function (result) { 
                            Swal.fire({
                                title: "Update Success",
                                text: "",
                                icon: "success",
                                allowOutsideClick: false,
                            });
                            destroy_table();
                            // all_detail();
                            $('#editG').modal('hide');
                        }
                    });
                }
            }
        }
        function change_editG_color(){
            $('.editG_color_all').removeClass('gradeAR');
            $('.editG_color_all').removeClass('gradeP');
            $('.editG_color_all').removeClass('gradeA');
            $('.editG_color_all').removeClass('gradeB');
            $('.editG_color_all').removeClass('gradeC');
            $('.editG_color_all').removeClass('gradeD');
            $('.editG_color_all').removeClass('gradeE');
            $('.editG_color_all').removeClass('gradeU');
            $('.editG_color_all').removeClass('gradeCD');
            $('.editG_color').addClass('grade'+$('#edit_grade_select').val());
        }
        function reset_edit_grade(){
            $('#edit_grade_select').val('');
            $('.editG_color_all').removeClass('gradeAR');
            $('.editG_color_all').removeClass('gradeP');
            $('.editG_color_all').removeClass('gradeA');
            $('.editG_color_all').removeClass('gradeB');
            $('.editG_color_all').removeClass('gradeC');
            $('.editG_color_all').removeClass('gradeD');
            $('.editG_color_all').removeClass('gradeE');
            $('.editG_color_all').removeClass('gradeU');
            $('.editG_color_all').removeClass('gradeCD');
        }
        function reset_edit_percent(){
            $('#edit_percent_select').val('');
        }
        function update_l800avg_wage(id){
            if(parseFloat($('#l800avg_wage'+id).val()) <= 0){
                Swal.fire({
                    title: "{{ __('Please specify amount greater than 0.') }}",
                    icon: "warning",
                    allowOutsideClick: false,
                });
                $('#l800avg_wage'+id).val() = '';
            }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/update_l800avg_wage") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":id,
                        "l800avg_wage":$('#l800avg_wage'+id).val()
                    },
                    success: function (result) {
                        Swal.fire({
                            title: "Update Success",
                            text: "",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                        destroy_table();
                        // all_detail();
                    }
                });
            }   
        }
        function checknumber(ele,id,text){
            var vchar = String.fromCharCode(event.keyCode);
            if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
            ele.onKeyPress=vchar;
        }
        function change_position_p_close(){
            var id = $('#change_position_final_id').val();
            var hidden_grade_proposed = $('#hidden_grade_proposed'+id).val();
            var grade_proposed = $('#id_gmgr'+id).val(hidden_grade_proposed);
        }
        function change_position_p(){
            var change_position_employee_id = $('#change_position_employee_id').val();
            var change_position_new = $('#change_position_new').val();
            var change_position_remark = $('#change_position_remark').val();
            var change_position_reasons = $('#change_position_reasons').val();

            var change_position_final_id = $('#change_position_final_id').val();
            var id_gmgr = $('#id_gmgr'+change_position_final_id).val();
            var exitingx = $('input[name="exitingx"]:checked').val();
            // alert(id_gmgr);
            
            if($('#change_position_old').val() == "0"){
                Swal.fire({
                    title: "กรุณาเลือก Current position",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
                if($('#change_position_reasons').val() == ""){
                    Swal.fire({
                        title: "Please input Reasons",
                        text: "",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    if(exitingx == "1"){
                        if($('#change_position_new').val() == "0"){
                            Swal.fire({
                                title: "กรุณาเลือก New position",
                                text: "",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        }else{
                            var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
                            var hidden_budget_std = $('.hidden_budget_std');
                            var id = change_position_final_id;
                            var hidden_budget_std2 = 0;
                            var hidden_budget_grade_name_value = '';
                            for(var i = 0;i < hidden_budget_std.length;i++){
                                if(hidden_budget_grade_name[i].value == 'P' && id_gmgr == 'P'){
                                    $('#percent_proposed'+id).val('10');
                                    $('.percent_proposed'+id).html('10%');
                                    hidden_budget_std2 = 10;
                                    // console.log(hidden_budget_std2);
                                    hidden_budget_grade_name_value = 'P';
                                    // console.log(id_gmgr);
                                }

                                if(hidden_budget_grade_name[i].value == 'CD' && id_gmgr == 'CD'){
                                    $('#percent_proposed'+id).val((hidden_budget_grade_name[i].value=='CD'?10:hidden_budget_std[i].value));
                                    $('.percent_proposed'+id).html((hidden_budget_grade_name[i].value=='CD'?10:hidden_budget_std[i].value)+'%');
                                    hidden_budget_std2 = 10;
                                    hidden_budget_grade_name_value = 'CD';
                                }

                                if(hidden_budget_grade_name[i].value == 'AR' && id_gmgr == 'AR'){
                                    // alert(id_gmgr);
                                    $('#percent_proposed'+id).val(parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value));
                                    $('.percent_proposed'+id).html(parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value)+'%');
                                    hidden_budget_std2 = parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value);
                                    console.log(hidden_budget_std2);
                                    hidden_budget_grade_name_value = id_gmgr;
                                }
                                
                                if(hidden_budget_grade_name[i].value == id_gmgr && id_gmgr != 'P' && id_gmgr != 'AR' && id_gmgr != 'CD'){
                                    $('#percent_proposed'+id).val(hidden_budget_std[i].value);
                                    $('.percent_proposed'+id).html(hidden_budget_std[i].value+'%');
                                    hidden_budget_std2 = hidden_budget_std[i].value;
                                    // console.log(hidden_budget_std2);
                                    hidden_budget_grade_name_value = id_gmgr;
                                    // console.log(id_gmgr);
                                }
                            } 
                            // console.log(id_gmgr);
                            $.ajax({
                                type: 'POST',
                                url: '{{ url(Request::segment(1)."/update_position_grade_p") }}',
                                dataType: 'json',
                                data : { 
                                    "_token": "{{ csrf_token() }}",
                                    "id":change_position_employee_id,
                                    "position_code":change_position_new,
                                    "change_position_remark":change_position_remark,
                                    "change_position_reasons":change_position_reasons,
                                    "grade_proposed":hidden_budget_grade_name_value,
                                    "search_year":$('#search_year').val(),
                                },
                                success: function (result2) {
                                    $('#remark_grade'+id).val(result2.remark_grade);
                                    $('.position_description'+id).text(result2.position_description);
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ url(Request::segment(1)."/update_percent_proposed") }}',
                                        dataType: 'json',
                                        data : { 
                                            "_token": "{{ csrf_token() }}",
                                            "id":id,
                                            "grade_proposed":hidden_budget_grade_name_value,
                                            "percent_proposed":hidden_budget_std2
                                        },
                                        success: function (result) {
                                            
                                            $('#id_gmgr'+id).attr("class", "form-select form-select-sm selectG mb-2 grade"+hidden_budget_grade_name_value);
                                            $('.changecolor'+id).css("color", "var(--bs-primary)");
                                            $('.changecolor'+id).text(hidden_budget_grade_name_value);
                                            $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                                            $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                                            $('.amount_proposed'+id).html(result.amount_proposed);
                                            $('.salary_new'+id).html(result.salary_new);
                                            $('.salary_month_new'+id).html(result.salary_month_new);
                                            // $('.final_by_md_gm_amount'+id).html(result.final_by_md_gm_amount);
                                            $('#update_grade_p').modal('hide');
                                            // destroy_table();
                                            if(hidden_budget_grade_name_value != 'P' && hidden_budget_grade_name_value != 'CD' && hidden_budget_grade_name_value != 'AR'){
                                                // $('#remark_grade'+id).val('');
                                            }
                                            if(result.grade_proposed_old == 'P' && hidden_budget_grade_name_value != 'P'){
                                                $('#remark_grade'+id).val('');
                                                $('.open_jd'+id).css('display','none');
                                            }
                                            $('.change_class_info'+id).css("display", "");
                                            $('#percent_proposed'+id).css("background", "");
                                            all_detail();
                                            Swal.fire({
                                                title: "Update Success",
                                                text: "",
                                                icon: "success",
                                                allowOutsideClick: false,
                                            });
                                            if(hidden_budget_grade_name_value == 'P'){
                                                setTimeout(() => {
                                                    window.location.reload();
                                                }, 200);
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }else{
                        if($('#new_position_code').val() == ""){
                            Swal.fire({
                                title: "Please input New position Code",
                                text: "",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        }else{
                            if($('#new_position_description').val() == ""){
                                Swal.fire({
                                    title: "Please input New position Description",
                                    text: "",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }else{
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url(Request::segment(1)."/check_new_position") }}',
                                    dataType: 'json',
                                    data : { 
                                        "_token": "{{ csrf_token() }}",
                                        "new_position_code":$('#new_position_code').val(),
                                        "new_position_description":$('#new_position_description').val()
                                    },
                                    success: function (result2) {
                                        // console.log(result2);
                                        if(result2 == '1'){
                                            Swal.fire({
                                                title: "มีตำแหน่งนี้อยู่ในระบบแล้ว กรุณาลองใหม่อีกครั้ง",
                                                text: "",
                                                icon: "warning",
                                                allowOutsideClick: false,
                                            });
                                        }else{
                                            $.ajax({
                                                type: 'POST',
                                                url: '{{ url(Request::segment(1)."/add_new_position") }}',
                                                dataType: 'json',
                                                data : { 
                                                    "_token": "{{ csrf_token() }}",
                                                    "new_position_code":$('#new_position_code').val(),
                                                    "new_position_description":$('#new_position_description').val()
                                                },
                                                success: function (result33) {
                                                    var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
                                                    var hidden_budget_std = $('.hidden_budget_std');
                                                    var id = change_position_final_id;
                                                    var hidden_budget_std2 = 0;
                                                    var hidden_budget_grade_name_value = '';
                                                    for(var i = 0;i < hidden_budget_std.length;i++){
                                                        if(hidden_budget_grade_name[i].value == 'P' && id_gmgr == 'P'){
                                                            $('#percent_proposed'+id).val('10');
                                                            $('.percent_proposed'+id).html('10%');
                                                            hidden_budget_std2 = 10;
                                                            // console.log(hidden_budget_std2);
                                                            hidden_budget_grade_name_value = 'P';
                                                            // console.log(id_gmgr);
                                                        }

                                                        if(hidden_budget_grade_name[i].value == 'CD' && id_gmgr == 'CD'){
                                                            $('#percent_proposed'+id).val((hidden_budget_grade_name[i].value=='CD'?10:hidden_budget_std[i].value));
                                                            $('.percent_proposed'+id).html((hidden_budget_grade_name[i].value=='CD'?10:hidden_budget_std[i].value)+'%');
                                                            hidden_budget_std2 = 10;
                                                            hidden_budget_grade_name_value = 'CD';
                                                        }

                                                        if(hidden_budget_grade_name[i].value == 'AR' && id_gmgr == 'AR'){
                                                            // alert(id_gmgr);
                                                            $('#percent_proposed'+id).val(parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value));
                                                            $('.percent_proposed'+id).html(parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value)+'%');
                                                            hidden_budget_std2 = parseFloat($('#comsugpct'+id).val())+parseFloat(hidden_budget_std[i].value);
                                                            console.log(hidden_budget_std2);
                                                            hidden_budget_grade_name_value = id_gmgr;
                                                        }
                                                        
                                                        if(hidden_budget_grade_name[i].value == id_gmgr && id_gmgr != 'P' && id_gmgr != 'AR' && id_gmgr != 'CD'){
                                                            $('#percent_proposed'+id).val(hidden_budget_std[i].value);
                                                            $('.percent_proposed'+id).html(hidden_budget_std[i].value+'%');
                                                            hidden_budget_std2 = hidden_budget_std[i].value;
                                                            // console.log(hidden_budget_std2);
                                                            hidden_budget_grade_name_value = id_gmgr;
                                                            // console.log(id_gmgr);
                                                        }
                                                    } 
                                                    // console.log(id_gmgr);
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '{{ url(Request::segment(1)."/update_position_grade_p") }}',
                                                        dataType: 'json',
                                                        data : { 
                                                            "_token": "{{ csrf_token() }}",
                                                            "id":change_position_employee_id,
                                                            "position_code":$('#new_position_code').val(),
                                                            "change_position_remark":change_position_remark,
                                                            "change_position_reasons":change_position_reasons,
                                                            "grade_proposed":hidden_budget_grade_name_value,
                                                        },
                                                        success: function (result2) {
                                                            $('#remark_grade'+id).val(result2.remark_grade);
                                                            $('.position_description'+id).text(result2.position_description);
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: '{{ url(Request::segment(1)."/update_percent_proposed") }}',
                                                                dataType: 'json',
                                                                data : { 
                                                                    "_token": "{{ csrf_token() }}",
                                                                    "id":id,
                                                                    "grade_proposed":hidden_budget_grade_name_value,
                                                                    "percent_proposed":hidden_budget_std2
                                                                },
                                                                success: function (result) {
                                                                    
                                                                    $('#id_gmgr'+id).attr("class", "form-select form-select-sm selectG mb-2 grade"+hidden_budget_grade_name_value);
                                                                    $('.changecolor'+id).css("color", "var(--bs-primary)");
                                                                    $('.changecolor'+id).text(hidden_budget_grade_name_value);
                                                                    $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                                                                    $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                                                                    $('.amount_proposed'+id).html(result.amount_proposed);
                                                                    $('.salary_new'+id).html(result.salary_new);
                                                                    $('.salary_month_new'+id).html(result.salary_month_new);
                                                                    // $('.final_by_md_gm_amount'+id).html(result.final_by_md_gm_amount);
                                                                    $('#update_grade_p').modal('hide');
                                                                    $('.change_class_info'+id).css("display", "");
                                                                    $('#percent_proposed'+id).css("background", "");
                                                                    // destroy_table();
                                                                    if(hidden_budget_grade_name_value != 'P' && hidden_budget_grade_name_value != 'CD' && hidden_budget_grade_name_value != 'AR'){
                                                                        // $('#remark_grade'+id).val('');
                                                                    }
                                                                    if(result.grade_proposed_old == 'P' && hidden_budget_grade_name_value != 'P'){
                                                                        $('#remark_grade'+id).val('');
                                                                        $('.open_jd'+id).css('display','none');
                                                                    }
                                                                    all_detail();
                                                                    Swal.fire({
                                                                        title: "Update Success",
                                                                        text: "",
                                                                        icon: "success",
                                                                        allowOutsideClick: false,
                                                                    });
                                                                    if(hidden_budget_grade_name_value == 'P'){
                                                                        setTimeout(() => {
                                                                            window.location.reload();
                                                                        }, 200);
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    }
                }
            }
        }
        function change_position_p_info(){
            var change_position_employee_id = $('#change_position_employee_id_info').val();
            var change_position_new = $('#change_position_new_info').val();
            var change_position_remark = $('#change_position_remark_info').val();
            var change_position_reasons = $('#change_position_reasons_info').val();

            var change_position_final_id = $('#change_position_final_id_info').val();
            if($('#change_position_reasons_info').val() == ""){
                Swal.fire({
                    title: "Please input Reasons",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/update_position_grade_p_info") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":change_position_employee_id,
                        "position_code":change_position_new,
                        "change_position_remark":change_position_remark,
                        "change_position_reasons":change_position_reasons,
                        "grade_proposed":$('#id_gmgr'+change_position_final_id).val(),
                        "search_year":$('#search_year').val(),
                    },
                    success: function (result2) {
                        $('#remark_grade'+change_position_final_id).val(result2.remark_grade);
                        $('#update_grade_p_info').modal('hide');
                        Swal.fire({
                            title: "Update Success",
                            text: "",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                    }
                });
            }
        }
        
        function get_eva(){
            $('#select2-search_employee_no-container').html('');
            $('.select2-selection__clear').val([]);
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/get_eva_salary") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division":$('#search_division').val(),
                    "search_department":$('#search_department').val(),
                    "section_code":$('#search_section').val(),
                    "search_month_day":$('#search_month_day').val(),
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    // console.log(result.data);
                    var html = ``;
                    result.data.forEach(element => {
                        if($("#isLocale").val() == '1'){
                            html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_en}</option>`;
                        }else{  
                            html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_th}</option>`;
                        }
                        
                    });
                    $('#search_employee_no').html(html);
                }
            });
        }
        function get_division_first(){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/get_division_salary") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "pagenow":'1',
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    // if(result.data.length > 1){
                    //     var html = `<option value="all">All</option>`;
                    // }else{
                        var html = ``;
                        var html_jd = `<option value="0">เลือก</option>`;
                    // }
                    result.data.forEach(element => {
                        html += `<option value="${element.division_code}">${element.division_code}</option>`;
                        html_jd += `<option value="${element.division_code}">${element.division_code} - ${element.division_description}</option>`;
                        // - ${element.division_description}
                    });
                    $('#search_division').html(html);
                    $('#jd_division').html(html_jd);
                    if(result.data.length > 1){
                        // $('#search_division').val('all');
                    }
                    setTimeout(() => {
                        get_department_first();
                    }, 200);
                }
            });
        }
        function get_division(){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/get_division_salary") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "pagenow":'1',
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    // if(result.data.length > 1){
                    //     var html = `<option value="all">All</option>`;
                    // }else{
                        var html = ``;
                    // }
                    result.data.forEach(element => {
                        html += `<option value="${element.division_code}">${element.division_code}</option>`;
                        // - ${element.division_description}
                    });
                    $('#search_division').html(html);
                    if(result.data.length > 1){
                        // $('#search_division').val('all');
                    }
                    setTimeout(() => {
                        get_department();
                    }, 200);
                }
            });
        }
        function get_department_first(){
            // if($('#search_division').val().length == 0){
            //     var html = `<option value="all">All</option>`;
            //     $('#search_department').html(html);
            //     var html2 = `<option value="all">All</option>`;
            //     $('#search_section').html(html2);
            //     $('#search_department').val('all');
            //     $('#search_section').val('all');
            //     get_section();
            // }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_department_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "pagenow":'1',
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        // if(result.data.length > 1){
                        //     var html = `<option value="all">All</option>`;
                        // }else{
                            var html = ``;
                        // }
                        result.data.forEach(element => {
                            html += `<option value="${element.department_code}">${element.department_code}</option>`;
                            // - ${element.department_description}
                        });
                        $('#search_department').html(html);
                        if(result.data.length > 1){
                            // $('#search_department').val('all');
                        }
                        setTimeout(() => {
                            get_section_first();
                        }, 200);
                    }
                });
            // }
        }
        function get_department(){
            // if($('#search_division').val().length == 0){
            //     var html = `<option value="all">All</option>`;
            //     $('#search_department').html(html);
            //     var html2 = `<option value="all">All</option>`;
            //     $('#search_section').html(html2);
            //     $('#search_department').val('all');
            //     $('#search_section').val('all');
            //     get_section();
            // }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_department_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "pagenow":'1',
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        // if(result.data.length > 1){
                        //     var html = `<option value="all">All</option>`;
                        // }else{
                            var html = ``;
                        // }
                        result.data.forEach(element => {
                            html += `<option value="${element.department_code}">${element.department_code}</option>`;
                            // - ${element.department_description}
                        });
                        $('#search_department').html(html);
                        if(result.data.length > 1){
                            // $('#search_department').val('all');
                        }
                        setTimeout(() => {
                            get_section();
                        }, 200);
                    }
                });
            // }
        }
        
        function get_section_first(){
            // if($('#search_department').val() == 'all'){
            //     var html = `<option value="all">All</option>`;
            //     $('#search_section').html(html);
            //     $('#search_section').val('all');
            //     get_eva();
            //     destroy_table();
            // }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_section_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "search_department":$('#search_department').val(),
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        // if(result.data.length > 1){
                        //     var html = `<option value="all">All</option>`;
                        // }else{
                            var html = ``;
                        // }
                        result.data.forEach(element => {
                            html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                            // - ${element.section_description}
                        });
                        $('#search_section').html(html);
                        if(result.data.length > 1){
                            // $('#search_section').val('all');
                            get_eva();
                        }else{
                            get_eva();
                        }
                        setTimeout(() => {
                            destroy_table();
                        }, 200);
                    }
                });
            // }
        }
        function get_section(){
            // if($('#search_department').val() == 'all'){
            //     var html = `<option value="all">All</option>`;
            //     $('#search_section').html(html);
            //     $('#search_section').val('all');
            //     get_eva();
            //     destroy_table();
            // }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_section_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "search_department":$('#search_department').val(),
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        // if(result.data.length > 1){
                        //     var html = `<option value="all">All</option>`;
                        // }else{
                            var html = ``;
                        // }
                        result.data.forEach(element => {
                            html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                            // - ${element.section_description}
                        });
                        $('#search_section').html(html);
                        if(result.data.length > 1){
                            // $('#search_section').val('all');
                            get_eva();
                        }else{
                            get_eva();
                        }
                        setTimeout(() => {
                            destroy_table();
                        }, 200);
                    }
                });
            // }
        }
        
        function get_eva_list(){
            get_eva();
            destroy_table();
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////
        function freeze(){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/check_salary_null") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division":$('#search_division').val(),
                    "search_department":$('#search_department').val(),
                    "search_section":$('#search_section').val(),
                    "search_employee_no":$('#search_employee_no').val(),
                    "search_month_day":$('#search_month_day').val(),
                    "search_grade":$('#search_grade').val(),
                    "search_status":$('#search_status').val(),
                    "search_complaince_score":$('#search_complaince_score').val(),
                    "search_attendance_score":$('#search_attendance_score').val(),
                    "pagenow":'1',
                    "search_year":$('#search_year').val(),
                },
                success: function (result) { 
                    $('.check_salary_null').val(parseFloat(result.count));
                    if($('.check_salary_null').val() > 0){
                        // $('.setblinkAll').removeClass('board');
                        // $('.setblink1').addClass('board');
                        Swal.fire({
                            title: "{{ __('Found some information not yet approved') }}",
                            text: "{{ __('Please check again.') }}",
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
                                    url: '{{ url(Request::segment(1)."/freeze_to_gmdm") }}',
                                    dataType: 'json',
                                    data : { 
                                        "_token": "{{ csrf_token() }}",
                                        "search_division":$('#search_division').val(),
                                        "search_department":$('#search_department').val(),
                                        "search_section":$('#search_section').val(),
                                        "search_employee_no":$('#search_employee_no').val(),
                                        "search_month_day":$('#search_month_day').val(),
                                        "search_grade":$('#search_grade').val(),
                                        "search_status":$('#search_status').val(),
                                        "pagenow":'1',
                                        "search_year":$('#search_year').val(),
                                    },
                                    success: function (result) { 
                                        Swal.fire({
                                            title: "Save Success",
                                            text: "",
                                            icon: "success",
                                            allowOutsideClick: false,
                                        });
                                        destroy_table();
                                        $('.setblinkAll').removeClass('board'); 
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }
        function export_excel(){
            var search_division = $('#search_division').val();
            var search_department = $('#search_department').val();
            var search_section = $('#search_section').val();
            var search_employee_no = $('#search_employee_no').val();
            var search_month_day = $('#search_month_day').val();
            var search_grade = $('#search_grade').val();
            var search_status = $('#search_status').val();
            var search_complaince_score = $('#search_complaince_score').val();
            var search_attendance_score = $('#search_attendance_score').val();
            var pagenow = '1';
            var search_year = $('#search_year').val();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Export'
                }).then((result) => {
                if (result.isConfirmed) {
                    if(search_month_day == 'all'){
                    window.location.href = "{{ url(Request::segment(1).'/export_excel/') }}"+"?search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_employee_no="+search_employee_no+"&search_month_day="+search_month_day+"&search_grade="+search_grade+"&search_status="+search_status+"&search_complaince_score="+search_complaince_score+"&search_attendance_score="+search_attendance_score+"&pagenow="+pagenow+"&pagenow_salary=&search_year="+search_year;
                    }else if(search_month_day == '1'){
                    window.location.href = "{{ url(Request::segment(1).'/export_excel_day/') }}"+"?search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_employee_no="+search_employee_no+"&search_month_day="+search_month_day+"&search_grade="+search_grade+"&search_status="+search_status+"&search_complaince_score="+search_complaince_score+"&search_attendance_score="+search_attendance_score+"&pagenow="+pagenow+"&pagenow_salary=&search_year="+search_year;
                    }else{
                    window.location.href = "{{ url(Request::segment(1).'/export_excel_month/') }}"+"?search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_employee_no="+search_employee_no+"&search_month_day="+search_month_day+"&search_grade="+search_grade+"&search_status="+search_status+"&search_complaince_score="+search_complaince_score+"&search_attendance_score="+search_attendance_score+"&pagenow="+pagenow+"&pagenow_salary=&search_year="+search_year;
                    }
                    // window.location.href = "{{ url(Request::segment(1).'/export_excel/') }}"+"?search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_employee_no="+search_employee_no+"&search_month_day="+search_month_day+"&search_grade="+search_grade+"&search_status="+search_status+"&search_complaince_score="+search_complaince_score+"&search_attendance_score="+search_attendance_score+"&pagenow="+pagenow+"&pagenow_salary=&search_year="+search_year;
                }
            });
        }
        function showhide(val){
            if(val == '1'){
                $('.hide_exiting_position').css('display','');
                $('.hide_new_position').css('display','none');
            }else{
                $('.hide_exiting_position').css('display','none');
                $('.hide_new_position').css('display','');
            }
        }
        function loading(){
            KTApp.showPageLoading();
        }
        function loading_hide(){
            KTApp.hidePageLoading();
        }
        function check_all(){
            var toggle_vis_all1 = '';
            // $('.toggle-vis').attr('checked', false);      
            $('.toggle-vis').each(function(e) {
                // console.log($('#toggle-vis-click-'+e).is(':checked'));
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    toggle_vis_all1 += e+',';
                    // $('.toggle-vis').attr('checked', true);  
                }else{
                    // $('.toggle-vis').attr('checked', false);  
                }            
            });
            // console.log(toggle_vis_all1);
            localStorage.setItem("toggle_vis_all1", toggle_vis_all1);
            // var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            // localStorage.setItem("toggle_vis_all1", get_toggle_vis_all1+toggle_vis_all1);
        }
        function check_all_group(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all1').is(':checked') == true){
                for (let columnIdxx = 1; columnIdxx <= 9; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 1; columnIdxx <= 9; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 1; columnIdxx <= 9; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all1').is(':checked') == true){
                        column.visible(true);
                    }else{
                        column.visible(false);
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all1').is(':checked'));  
            // if($('.toggle-vis-all1').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 1; index <= 9; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 1; index <= 9; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all1", true);
            // }else{
            //     for (let index = 1; index <= 9; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all1", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            
            // let text = test_all.join(",");
            // localStorage.setItem("toggle_vis_all1", text);

            // console.log(toggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", toggle_vis_all1);
            // var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            // localStorage.setItem("toggle_vis_all1", get_toggle_vis_all1+toggle_vis_all1);
        }
        function check_all_group2(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all2').is(':checked'));  
            // if($('.toggle-vis-all2').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 10; index <= 17; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 10; index <= 17; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all2", true);
            // }else{
            //     for (let index = 10; index <= 17; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all2", false);
            // }   
            
            
            
            console.log($('.toggle-vis-all2').is(':checked'));
            if($('.toggle-vis-all2').is(':checked') == true){
                for (let columnIdxx = 10; columnIdxx <= 17; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 10; columnIdxx <= 17; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
            // console.log(xxxtoggle_vis_all1);
            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 10; columnIdxx <= 17; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all2').is(':checked') == true){
                        column.visible(true);
                    }else{
                        column.visible(false);
                    }
                }
            }
        }
        function check_all_group3(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all3').is(':checked') == true){
                for (let columnIdxx = 18; columnIdxx <= 20; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 18; columnIdxx <= 20; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 18; columnIdxx <= 20; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all3').is(':checked') == true){
                        column.visible(true);
                    }else{
                        column.visible(false);
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all3').is(':checked'));  
            // if($('.toggle-vis-all3').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 18; index <= 20; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 18; index <= 20; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all3", true);
            // }else{
            //     for (let index = 18; index <= 20; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all3", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
        }
        function check_all_group4(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all4').is(':checked') == true){
                for (let columnIdxx = 21; columnIdxx <= 23; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 21; columnIdxx <= 23; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 21; columnIdxx <= 23; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all4').is(':checked') == true){
                        column.visible(true);
                    }else{
                        column.visible(false);
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all4').is(':checked'));  
            // if($('.toggle-vis-all4').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 21; index <= 23; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 21; index <= 23; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all4", true);
            // }else{
            //     for (let index = 21; index <= 23; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all4", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
        }
        function check_all_group5(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all5').is(':checked') == true){
                for (let columnIdxx = 24; columnIdxx <= 29; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 24; columnIdxx <= 29; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 24; columnIdxx <= 29; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all5').is(':checked') == true){
                        column.visible(true);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','table-cell');
                        $('.footer-hide-'+columnIdxx).css('display','table-cell');
                        }
                    }else{
                        column.visible(false);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','none');
                        $('.footer-hide-'+columnIdxx).css('display','none');
                        }
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all5').is(':checked'));  
            // if($('.toggle-vis-all5').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 24; index <= 28; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 24; index <= 28; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all5", true);
            // }else{
            //     for (let index = 24; index <= 28; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all5", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
        }
        function check_all_group6(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all6').is(':checked') == true){
                for (let columnIdxx = 30; columnIdxx <= 35; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 30; columnIdxx <= 35; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 30; columnIdxx <= 35; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all6').is(':checked') == true){
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'table-cell');
                        column.visible(true);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','table-cell');
                        $('.footer-hide-'+columnIdxx).css('display','table-cell');
                        }
                    }else{
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'none');
                        column.visible(false);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','none');
                        $('.footer-hide-'+columnIdxx).css('display','none');
                        }
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all6').is(':checked'));  
            // if($('.toggle-vis-all6').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 30; index <= 35; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     for (let index = 30; index <= 35; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == false){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all6", true);
            // }else{
            //     for (let index = 30; index <= 35; index++) {
            //         $('.toggle-vis').each(function(e) {
            //             if(e == index){
            //                 if($('#toggle-vis-click-'+e).is(':checked') == true){
            //                     $('#toggle-vis-click-'+e).click();          
            //                 }
            //             }
            //         });
            //     }
            //     localStorage.setItem("toggle_all6", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
        }
        function check_all_group7(){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            if($('.toggle-vis-all7').is(':checked') == true){
                for (let columnIdxx = 36; columnIdxx <= 40; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", true);
                }
            }else{
                for (let columnIdxx = 36; columnIdxx <= 40; columnIdxx++) {
                    $("#toggle-vis-click-"+columnIdxx).prop("checked", false);
                }
            }
            
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);

            if(xxxtoggle_vis_all1 != ""){
                var cut_xxxtoggle_vis_all1 = xxxtoggle_vis_all1.split(',');
                for (let columnIdxx = 36; columnIdxx <= 40; columnIdxx++) {
                    let column = otable.column(columnIdxx);
                    if($('.toggle-vis-all7').is(':checked') == true){
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'table-cell');
                        column.visible(true);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','table-cell');
                        $('.footer-hide-'+columnIdxx).css('display','table-cell');
                        }
                    }else{
                        // $("#footer-vis-click-"+columnIdxx).css("display", 'none');
                        column.visible(false);
                        if(columnIdxx >= 29 && columnIdxx <= 41 && columnIdxx != 36){
                        $('#footer-vis-click-'+columnIdxx).css('display','none');
                        $('.footer-hide-'+columnIdxx).css('display','none');
                        }
                    }
                }
            }
            // var toggle_vis_all1 = '';
            // var test_all = [];

            // console.log($('.toggle-vis-all7').is(':checked'));  
            // if($('.toggle-vis-all7').is(':checked') == true){
            //     var get_toggle_vis_all1 = localStorage.getItem("toggle_vis_all1");
            //     if(get_toggle_vis_all1 != ""){
            //         var cut_get_toggle_vis_all1 = get_toggle_vis_all1.split(',');
                    
            //         cut_get_toggle_vis_all1.forEach(element => {
            //             if(element != ""){
            //                 test_all.push(parseInt(element));
            //             }
            //         });
            //         for (let index = 36; index <= 42; index++) {
            //             test_all.push(parseInt(index));
            //         }
            //         var test_all = Array.from(new Set(test_all));
            //         test_all = test_all.sort((a, b) => a - b);
            //         console.log(test_all);
            //     }
            //     if($('#toggle-vis-click-36').is(':checked') == false){
            //         $('#toggle-vis-click-36').click();     
            //     }
            //     if($('#toggle-vis-click-37').is(':checked') == false){
            //         $('#toggle-vis-click-37').click();     
            //     }
            //     if($('#toggle-vis-click-38').is(':checked') == false){
            //         $('#toggle-vis-click-38').click();     
            //     }
            //     if($('#toggle-vis-click-39').is(':checked') == false){
            //         $('#toggle-vis-click-39').click();     
            //     }
            //     if($('#toggle-vis-click-40').is(':checked') == false){
            //         $('#toggle-vis-click-40').click();     
            //     }
            //     if($('#toggle-vis-click-41').is(':checked') == false){
            //         $('#toggle-vis-click-41').click();     
            //     }
            //     if($('#toggle-vis-click-42').is(':checked') == false){
            //         $('#toggle-vis-click-42').click();     
            //     }
            //     localStorage.setItem("toggle_all7", true);
            // }else{
            //     if($('#toggle-vis-click-36').is(':checked') == true){
            //         $('#toggle-vis-click-36').click();     
            //     }
            //     if($('#toggle-vis-click-37').is(':checked') == true){
            //         $('#toggle-vis-click-37').click();     
            //     }
            //     if($('#toggle-vis-click-38').is(':checked') == true){
            //         $('#toggle-vis-click-38').click();     
            //     }
            //     if($('#toggle-vis-click-39').is(':checked') == true){
            //         $('#toggle-vis-click-39').click();     
            //     }
            //     if($('#toggle-vis-click-40').is(':checked') == true){
            //         $('#toggle-vis-click-40').click();     
            //     }
            //     if($('#toggle-vis-click-41').is(':checked') == true){
            //         $('#toggle-vis-click-41').click();     
            //     }
            //     if($('#toggle-vis-click-42').is(':checked') == true){
            //         $('#toggle-vis-click-42').click();     
            //     }
            //     localStorage.setItem("toggle_all7", false);
            // }   
            
            // var xxxtoggle_vis_all1 = ''; 
            // $('.toggle-vis').each(function(e) {
            //     console.log(e);
            //     if($('#toggle-vis-click-'+e).is(':checked') == true){
            //         xxxtoggle_vis_all1 += e+',';
            //     }          
            // });
            // if($('#toggle-vis-click-40').is(':checked') == true){
            //     xxxtoggle_vis_all1 += '40,';   
            // }
            // if($('#toggle-vis-click-41').is(':checked') == true){
            //     xxxtoggle_vis_all1 += '41,';
            // }
            // if($('#toggle-vis-click-42').is(':checked') == true){
            //     xxxtoggle_vis_all1 += '42,';
            // }
            // console.log(xxxtoggle_vis_all1);
            // localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
        }
        function check_all_group_salary(id){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            var xxxtoggle_vis_all1 = ''; 
            $('.toggle-vis').each(function(e) {
                if($('#toggle-vis-click-'+e).is(':checked') == true){
                    xxxtoggle_vis_all1 += e+',';
                }          
            });
            localStorage.setItem("toggle_vis_all1", xxxtoggle_vis_all1);
            console.log('id = '+id);
            console.log('xxxtoggle_vis_all1 = '+xxxtoggle_vis_all1);
            let column = otable.column(id);
            console.log('aaa',$('#toggle-vis-click-'+id).is(':checked'));
            if($('#toggle-vis-click-'+id).is(':checked') == true){
                // $("#footer-vis-click-"+id).css("display", 'table-cell');
                column.visible(true);
                if(id >= 29 && id <= 41 && id != 36){
                $('#footer-vis-click-'+id).css('display','table-cell');
                $('.footer-hide-'+id).css('display','table-cell');
                }
            }else{
                // $("#footer-vis-click-"+id).css("display", 'none');
                column.visible(false);
                if(id >= 29 && id <= 41 && id != 36){
                $('#footer-vis-click-'+id).css('display','none');
                $('.footer-hide-'+id).css('display','none');
                }
            }
            
        }
        function check_all_final(id){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            var xxxtoggle_vis_all1_final = ''; 
            if($('#toggle-vis-click-final-'+id).is(':checked') == true){
                xxxtoggle_vis_all1_final += id+',';
            } 
            localStorage.setItem("toggle_vis_all1_final", xxxtoggle_vis_all1_final);
            console.log('id = '+id);
            console.log('xxxtoggle_vis_all1_final = '+xxxtoggle_vis_all1_final);
            let column = otable.column(id);
            if($('#toggle-vis-click-final-'+id).is(':checked') == true){
                // $("#footer-vis-click-"+id).css("display", 'table-cell');
                column.visible(true);
                if(id >= 29 && id <= 41 && id != 36){
                $('#footer-vis-click-'+id).css('display','table-cell');
                $('.footer-hide-'+id).css('display','table-cell');
                }
            }else{
                // $("#footer-vis-click-"+id).css("display", 'none');
                column.visible(false);
                if(id >= 29 && id <= 41 && id != 36){
                $('#footer-vis-click-'+id).css('display','none');
                $('.footer-hide-'+id).css('display','none');
                }
            }
        }
        function check_all_remark(id){
            var otable = $("#kt_datatable_dom_positioning").DataTable();
            var xxxtoggle_vis_all1_remark = ''; 
            if($('#toggle-vis-click-remark-'+id).is(':checked') == true){
                xxxtoggle_vis_all1_remark += id+',';
            }    
            localStorage.setItem("toggle_vis_all1_remark", xxxtoggle_vis_all1_remark);
            console.log('id = '+id);
            console.log('xxxtoggle_vis_all1_remark = '+xxxtoggle_vis_all1_remark);
            let column = otable.column(id);
            if($('#toggle-vis-click-remark-'+id).is(':checked') == true){
                column.visible(true);
            }else{
                column.visible(false);
            }
        }
        ////////////////
        function bell_curve_detail(){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/chart_pa_grade_salary") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division_code":$('#search_division').val(),
                    "search_department_code":$('#search_department').val(),
                    "search_section":$('#search_section').val(),
                    "search_employee_no":$('#search_employee_no').val(),
                    "search_month_day":$('#search_month_day').val(),
                    "search_grade":$('#search_grade').val(),
                    "search_status":$('#search_status').val(),
                    "search_complaince_score":$('#search_complaince_score').val(),
                    "search_attendance_score":$('#search_attendance_score').val(),
                    "search_year":$('#search_year').val(),
                    "search_not_up_salary":$('#search_not_up_salary').val()
                },
                success: function (result) {
                    if(result){
                        if(result.countdata){
                            var countAR = 0;
                            var countP = 0;
                            var countA = 0;
                            var countB = 0;
                            var countC = 0;
                            var countD = 0;
                            var countE = 0;
                            var countU = 0;
                            var countCD = 0;
                            var countNoNull = 0;
                            var bell_percentAR = 0;
                            var bell_percentP = 0;
                            var bell_percentA = 0;
                            var bell_percentB = 0;
                            var bell_percentC = 0;
                            var bell_percentD = 0;
                            var bell_percentE = 0;
                            var bell_percentU = 0;
                            var bell_percentCD = 0;
                            if(result.bell_curve){
                                $.each(result.bell_curve, function (key, value) {	
                                    if(value.grade_name == 'AR'){
                                        bell_percentAR = value.percent;
                                    }
                                    if(value.grade_name == 'P'){
                                        bell_percentP = value.percent;
                                    }
                                    if(value.grade_name == 'A'){
                                        bell_percentA = value.percent;
                                    }
                                    if(value.grade_name == 'B'){
                                        bell_percentB = value.percent;
                                    }
                                    if(value.grade_name == 'C'){
                                        bell_percentC = value.percent;
                                    }
                                    if(value.grade_name == 'D'){
                                        bell_percentD = value.percent;
                                    }
                                    if(value.grade_name == 'E'){
                                        bell_percentE = value.percent;
                                    }
                                    if(value.grade_name == 'U'){
                                        bell_percentU = value.percent;
                                    }
                                    if(value.grade_name == 'CD'){
                                        bell_percentCD = value.percent;
                                    }
                                });
                            }
                            $.each(result.countdata, function (key, value) {	
                                if(value.grade_proposed == 'AR'){
                                    countAR++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentAR = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'P'){
                                    countP++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentP = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'A'){
                                    countA++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentA = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'B'){
                                    countB++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentB = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'C'){
                                    countC++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentC = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'D'){
                                    countD++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentD = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'E'){
                                    countE++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentE = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'U'){
                                    countU++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentU = value.percent;
                                    // }
                                }
                                if(value.grade_proposed == 'CD'){
                                    countCD++;
                                    countNoNull++;
                                    // if(value.percent){
                                    //     bell_percentCD = value.percent;
                                    // }
                                }
                            });

                            var QuotaAR1 = (countNoNull*parseFloat(bell_percentAR))/100;
                            var QuotaP1 = (countNoNull*parseFloat(bell_percentP))/100;
                            var QuotaA1 = (countNoNull*parseFloat(bell_percentA))/100;
                            var QuotaB1 = (countNoNull*parseFloat(bell_percentB))/100;
                            var QuotaC1 = (countNoNull*parseFloat(bell_percentC))/100;
                            var QuotaD1 = (countNoNull*parseFloat(bell_percentD))/100;
                            var QuotaE1 = (countNoNull*parseFloat(bell_percentE))/100;
                            var QuotaU1 = (countNoNull*parseFloat(bell_percentU))/100;
                            var QuotaCD1 = (countNoNull*parseFloat(bell_percentCD))/100;
                            
                            // var sumQuotaAR1 = (parseFloat(QuotaAR1)/parseFloat(countNoNull))*100;
                            // var sumQuotaP1 = (parseFloat(QuotaP1)/parseFloat(countNoNull))*100;
                            // var sumQuotaA1 = (parseFloat(QuotaA1)/parseFloat(countNoNull))*100;
                            // var sumQuotaB1 = (parseFloat(QuotaB1)/parseFloat(countNoNull))*100;
                            // var sumQuotaC1 = (parseFloat(QuotaC1)/parseFloat(countNoNull))*100;
                            // var sumQuotaD1 = (parseFloat(QuotaD1)/parseFloat(countNoNull))*100;
                            // var sumQuotaE1 = (parseFloat(QuotaE1)/parseFloat(countNoNull))*100;
                            // var sumQuotaU1 = (parseFloat(QuotaU1)/parseFloat(countNoNull))*100;
                            // var sumQuotaCD1 = (parseFloat(QuotaCD1)/parseFloat(countNoNull))*100;
                            // console.log('QuotaC1 = '+QuotaC1);
                            var chart_Quota1 = [];
                            chart_Quota1.push(number_format2(QuotaAR1,1));
                            chart_Quota1.push(number_format2(QuotaP1,1));
                            chart_Quota1.push(number_format2(QuotaA1,1));
                            chart_Quota1.push(number_format2(QuotaB1,1));
                            chart_Quota1.push(number_format2(QuotaC1,1));
                            chart_Quota1.push(number_format2(QuotaD1,1));
                            chart_Quota1.push(number_format2(QuotaE1,1));
                            chart_Quota1.push(number_format2(QuotaU1,1));
                            chart_Quota1.push(number_format2(QuotaCD1,1));

                            var chart1 = [];
                            chart1.push(number_format2(countAR,1));
                            chart1.push(number_format2(countP,1));
                            chart1.push(number_format2(countA,1));
                            chart1.push(number_format2(countB,1));
                            chart1.push(number_format2(countC,1));
                            chart1.push(number_format2(countD,1));
                            chart1.push(number_format2(countE,1));
                            chart1.push(number_format2(countU,1));
                            chart1.push(number_format2(countCD,1));
                            
                            var text_chart = '';
                            if($('#segment').val() == 'mil'){
                                text_chart = '(L600 - L800)';
                            }

                            const ctx1 = document.getElementById('myChart');
                            // Manually register the chartjs datalabels plugin
                            Chart.register(ChartDataLabels);
                            myChart3 = new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                                    datasets: [{
                                        label: 'Persons per Quota',
                                        data: chart_Quota1,
                                        fill: false,
                                        borderColor: 'rgb(255, 0, 0)',
                                        backgroundColor: 'rgb(255, 0, 0)',
                                        tension: 0.1,
                                        datalabels: {
                                            // Position of the labels 
                                            // (start, end, center, etc.)
                                            anchor: 'end',
                                            // Alignment of the labels 
                                            // (start, end, center, etc.)
                                            align: 'left',
                                            // Color of the labels
                                            color: 'black',
                                            font: {
                                                weight: 'bold',
                                                size: 8
                                            },
                                            formatter: function (value, context) {
                                                // Display the actual data value
                                                return (value>0?value:'');
                                            }
                                        }
                                    },{
                                        label: 'No. of Persons',
                                        data: chart1,
                                        fill: false,
                                        borderColor: 'rgb(0, 23, 255)',
                                        backgroundColor: 'rgb(0, 23, 255)',
                                        tension: 0.1,
                                        datalabels: {
                                            // Position of the labels 
                                            // (start, end, center, etc.)
                                            anchor: 'end',
                                            // Alignment of the labels 
                                            // (start, end, center, etc.)
                                            align: 'start',
                                            // Color of the labels
                                            color: 'black',
                                            font: {
                                                weight: 'bold',
                                                size: 8
                                            },
                                            formatter: function (value, context) {
                                                // Display the actual data value
                                                return (value>0?value:'');
                                            }
                                        }
                                    }]
                                },
                                options: {
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: $('#nowyear').val()+' PA Grade '+text_chart,
                                            color: 'blue',
                                            font: {
                                                weight: 'bold',
                                                size: 12
                                            }
                                        },
                                        
                                    },
                                    scales: {
                                        y: {
                                        beginAtZero: true
                                        }
                                    },
                                    animation: {
                                        onComplete: function () {
                                            $('#hide_download_chart1').val(myChart3.toBase64Image());
                                            
                                        },
                                    },
                                    
                                }
                            });

                            // const ctx = document.getElementById('myChart');
                            // // Manually register the chartjs datalabels plugin
                            // Chart.register(ChartDataLabels);
                            // myChart3 = new Chart(ctx, {
                            //     type: 'line',
                            //     data: {
                            //         labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                            //         datasets: [{
                            //             label: 'No. of Persons',
                            //             data: chart1,
                            //             fill: false,
                            //             borderColor: 'rgb(0, 23, 255)',
                            //             tension: 0.1
                            //         }]
                            //     },
                            //     options: {
                            //         plugins: {
                            //             title: {
                            //                 display: true,
                            //                 text: $('#nowyear').val()+' PA Grade '+text_chart,
                            //                 color: 'blue',
                            //                 font: {
                            //                     weight: 'bold',
                            //                     size: 20
                            //                 }
                            //             },
                            //             datalabels: {
                            //                 // Position of the labels 
                            //                 // (start, end, center, etc.)
                            //                 anchor: 'start',
                            //                 // Alignment of the labels 
                            //                 // (start, end, center, etc.)
                            //                 align: 'start',
                            //                 // Color of the labels
                            //                 color: 'blue',
                            //                 font: {
                            //                     weight: 'bold',
                            //                 },
                            //                 formatter: function (value, context) {
                            //                     // Display the actual data value
                            //                     return value;
                            //                 }
                            //             },
                            //             scales: {
                            //                 y: {
                            //                 beginAtZero: true
                            //                 }
                            //             },
                            //             animation: {
                            //                 onComplete: function () {
                            //                     $('#hide_download_chart1').val(myChart3.toBase64Image());
                                                
                            //                 },
                            //             },
                            //         }
                            //     }
                            // });

                            // var grapharea3 = document.getElementById("myChart");
                            // myChart3 = new Chart(grapharea3, {
                            //     type: 'line',
                            //     data: {
                            //         labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                            //         datasets: [{
                            //             label: 'No. of Persons',
                            //             data: chart1,
                            //             fill: false,
                            //             borderColor: 'rgb(0, 23, 255)',
                            //             tension: 0.1
                            //         }]
                            //     },
                            //     options: {
                            //         plugins: {
                            //             title: {
                            //                 display: true,
                            //                 text: $('#nowyear').val()+' PA Grade '+text_chart
                            //         }
                            //         },
                            //         scales: {
                            //             y: {
                            //             beginAtZero: true
                            //             }
                            //         },
                            //         animation: {
                            //             onComplete: function () {
                            //                 $('#hide_download_chart1').val(myChart3.toBase64Image());
                                            
                            //             },
                            //         },
                            //     }
                            // });


                            // const ctx = document.getElementById('myChart');
                            // var config = {};
                            // const myChart1 = new Chart(ctx, config);
                            // myChart1.destroy();
                            // const myChart = new Chart(ctx, {
                            //     type: 'line',
                            //     data: {
                            //         labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                            //         datasets: [{
                            //             label: 'No. of Persons',
                            //             data: chart1,
                            //             fill: false,
                            //             borderColor: 'rgb(0, 23, 255)',
                            //             tension: 0.1
                            //         }]
                            //     },
                            //     options: {
                            //         plugins: {
                            //             title: {
                            //                 display: true,
                            //                 text: $('#nowyear').val()+' PA Grade (L600 - L800)'
                            //             }
                            //         },
                            //         scales: {
                            //             y: {
                            //             beginAtZero: true
                            //             }
                            //         },
                            //         animation: {
                            //             onComplete: function () {
                            //                 $('#hide_download_chart1').val(myChart.toBase64Image());
                                            
                            //             },
                            //         },
                            //     }
                            // });
                            
                            // console.log(countNoNull);
                            // console.log(bell_percentA);
                            var QuotaAR = (countNoNull*parseFloat(bell_percentAR))/100;
                            var QuotaP = (countNoNull*parseFloat(bell_percentP))/100;
                            var QuotaA = (countNoNull*parseFloat(bell_percentA))/100;
                            var QuotaB = (countNoNull*parseFloat(bell_percentB))/100;
                            var QuotaC = (countNoNull*parseFloat(bell_percentC))/100;
                            var QuotaD = (countNoNull*parseFloat(bell_percentD))/100;
                            var QuotaE = (countNoNull*parseFloat(bell_percentE))/100;
                            var QuotaU = (countNoNull*parseFloat(bell_percentU))/100;
                            var QuotaCD = (countNoNull*parseFloat(bell_percentCD))/100;
                            
                            var sumQuotaAR = (parseFloat(QuotaAR)/parseFloat(countNoNull))*100;
                            var sumQuotaP = (parseFloat(QuotaP)/parseFloat(countNoNull))*100;
                            var sumQuotaA = (parseFloat(QuotaA)/parseFloat(countNoNull))*100;
                            var sumQuotaB = (parseFloat(QuotaB)/parseFloat(countNoNull))*100;
                            var sumQuotaC = (parseFloat(QuotaC)/parseFloat(countNoNull))*100;
                            var sumQuotaD = (parseFloat(QuotaD)/parseFloat(countNoNull))*100;
                            var sumQuotaE = (parseFloat(QuotaE)/parseFloat(countNoNull))*100;
                            var sumQuotaU = (parseFloat(QuotaU)/parseFloat(countNoNull))*100;
                            var sumQuotaCD = (parseFloat(QuotaCD)/parseFloat(countNoNull))*100;

                            var chart_Quota = [];
                            chart_Quota.push(number_format2(sumQuotaAR,1));
                            chart_Quota.push(number_format2(sumQuotaP,1));
                            chart_Quota.push(number_format2(sumQuotaA,1));
                            chart_Quota.push(number_format2(sumQuotaB,1));
                            chart_Quota.push(number_format2(sumQuotaC,1));
                            chart_Quota.push(number_format2(sumQuotaD,1));
                            chart_Quota.push(number_format2(sumQuotaE,1));
                            chart_Quota.push(number_format2(sumQuotaU,1));
                            chart_Quota.push(number_format2(sumQuotaCD,1));
                            
                            var sumAR = (parseFloat(countAR)/parseFloat(countNoNull))*100;
                            var sumP = (parseFloat(countP)/parseFloat(countNoNull))*100;
                            var sumA = (parseFloat(countA)/parseFloat(countNoNull))*100;
                            var sumB = (parseFloat(countB)/parseFloat(countNoNull))*100;
                            var sumC = (parseFloat(countC)/parseFloat(countNoNull))*100;
                            var sumD = (parseFloat(countD)/parseFloat(countNoNull))*100;
                            var sumE = (parseFloat(countE)/parseFloat(countNoNull))*100;
                            var sumU = (parseFloat(countU)/parseFloat(countNoNull))*100;
                            var sumCD = (parseFloat(countCD)/parseFloat(countNoNull))*100;

                            var chart_grade = [];
                            chart_grade.push(number_format2(sumAR,1));
                            chart_grade.push(number_format2(sumP,1));
                            chart_grade.push(number_format2(sumA,1));
                            chart_grade.push(number_format2(sumB,1));
                            chart_grade.push(number_format2(sumC,1));
                            chart_grade.push(number_format2(sumD,1));
                            chart_grade.push(number_format2(sumE,1));
                            chart_grade.push(number_format2(sumU,1));
                            chart_grade.push(number_format2(sumCD,1));

                            const ctx2 = document.getElementById('myChart2');
                            // Manually register the chartjs datalabels plugin
                            Chart.register(ChartDataLabels);
                            myChart4 = new Chart(ctx2, {
                                type: 'line',
                                data: {
                                    labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                                    datasets: [{
                                        label: '% Split per Quota',
                                        data: chart_Quota,
                                        fill: false,
                                        borderColor: 'rgb(255, 0, 0)',
                                        backgroundColor: 'rgb(255, 0, 0)',
                                        tension: 0.1,
                                        datalabels: {
                                            // Position of the labels 
                                            // (start, end, center, etc.)
                                            anchor: 'end',
                                            // Alignment of the labels 
                                            // (start, end, center, etc.)
                                            align: 'left',
                                            // Color of the labels
                                            color: 'black',
                                            font: {
                                                weight: 'bold',
                                                size: 8
                                            },
                                            formatter: function (value, context) {
                                                // Display the actual data value
                                                return (value>0?value+'%':'');
                                            }
                                        }
                                    },{
                                        label: $('#nowyear').val()+' PA Grade',
                                        data: chart_grade,
                                        fill: false,
                                        borderColor: 'rgb(0, 255, 54)',
                                        backgroundColor: 'rgb(0, 255, 54)',
                                        tension: 0.1,
                                        datalabels: {
                                            // Position of the labels 
                                            // (start, end, center, etc.)
                                            anchor: 'end',
                                            // Alignment of the labels 
                                            // (start, end, center, etc.)
                                            align: 'start',
                                            // Color of the labels
                                            color: 'black',
                                            font: {
                                                weight: 'bold',
                                                size: 8
                                            },
                                            formatter: function (value, context) {
                                                // Display the actual data value
                                                return (value>0?value+'%':'');
                                            }
                                        }
                                    }]
                                },
                                options: {
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: $('#nowyear').val()+' PA Grade '+text_chart+' (% Split each Grade)',
                                            color: 'blue',
                                            font: {
                                                weight: 'bold',
                                                size: 12
                                            }
                                        },
                                    },
                                    scales: {
                                        y: {
                                        beginAtZero: true
                                        }
                                    },
                                    animation: {
                                        onComplete: function () {
                                            $('#hide_download_chart2').val(myChart4.toBase64Image());
                                        },
                                    },
                                    
                                }
                            });

                            // const ctx2 = document.getElementById('myChart2');
                            // var config2 = {};
                            // const myChart22 = new Chart(ctx2, config2);
                            // myChart22.destroy();
                            // var myChart2 = new Chart(ctx2, {
                            //     type: 'line',
                            //     data: {
                            //         labels: ['AR', 'P', 'A', 'B', 'C', 'D', 'E', 'U', 'CD'],
                            //         datasets: [{
                            //             label: '% Split per Quota',
                            //             data: chart_Quota,
                            //             fill: false,
                            //             borderColor: 'rgb(255, 0, 0)',
                            //             tension: 0.1
                            //         },{
                            //             label: $('#nowyear').val()+' PA Grade',
                            //             data: chart_grade,
                            //             fill: false,
                            //             borderColor: 'rgb(0, 255, 54)',
                            //             tension: 0.1
                            //         }]
                            //     },
                            //     options: {
                            //         plugins: {
                            //             title: {
                            //                 display: true,
                            //                 text: $('#nowyear').val()+' PA Grade L600 - L800 (% Split each Grade)'
                            //             }
                            //         },
                            //         scales: {
                            //             y: {
                            //             beginAtZero: true
                            //             }
                            //         },
                            //         animation: {
                            //             onComplete: function () {
                            //                 $('#hide_download_chart2').val(myChart2.toBase64Image());
                            //             },
                            //         },
                            //     }
                            // });
                            
                        }else{

                        }
                    }
                }
            });
        }
        function download1(){
            var a = document.getElementById('download_chart1');
            a.href = $('#hide_download_chart1').val();
            a.download = $('#nowyear').val()+' PA Grade (L600 - L800).png';
            a.click();
        }
        function download2(){
            var a = document.getElementById('download_chart2');
            a.href = $('#hide_download_chart2').val();
            a.download = $('#nowyear').val()+' PA Grade L600 - L800 (% Split each Grade).png';
            a.click();
        }
        


        function get_department_jd(){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/get_department_salary_jd") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division":$('#jd_division').val(),
                    "pagenow":'1',
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    var html = `<option value="0">เลือก</option>`;
                    result.data.forEach(element => {
                        html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                    });
                    $('#jd_department').html(html);
                }
            });
        }
        function get_section_jd(section_code,section_description){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/get_section_salary_jd") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "search_division":$('#jd_division').val(),
                    "search_department":$('#jd_department').val(),
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    var html = `<option value="0">เลือก</option>`;
                    result.data.forEach(element => {
                        html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                    });
                    $('#jd_section').html(html);
                    $('#jd_section').val(section_code);
                    $('#select2-jd_section-container').text(section_code+' - '+section_description);
                }
            });
        }
        function save_jd(){
            const TASK = $('input[name="TASK[]"]').map(function () {
                if($(this).val() != ""){
                    return $(this).val();
                }
            }).get();
            const KNOWLEDGE = $('input[name="KNOWLEDGE[]"]').map(function () {
                if($(this).val() != ""){
                    return $(this).val();
                }
            }).get();
            const skills = $('input[name="SKILLS[]"]').map(function () {
                if($(this).val() != ""){
                    return $(this).val();
                }
            }).get();
            const PERSONALITY_TRAITS = $('input[name="PERSONALITY_TRAITS[]"]').map(function () {
                if($(this).val() != ""){
                    return $(this).val();
                }
            }).get();
            const jd_position = $('#jd_position').find(':selected').text();
            const jd_position_backup = $('#jd_position_backup').find(':selected').text();
            // const jd_position_report = $('#jd_position_report').find(':selected').text();

            const jd_position_report = $("#jd_position_report").val();
            var jd_position_report2 = "";
            if (jd_position_report && jd_position_report.length > 0) {
                jd_position_report2 = jd_position_report.join(','); 
            }
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/save_jd") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":$('#jd_position_employee_id_info').val(),
                    "jd_position":jd_position,
                    "jd_position_description":$('#jd_position_description').val(),
                    "jd_company":$('#jd_company').val(),
                    "jd_level":$('#jd_level').val(),
                    "jd_division":$('#jd_division').val(),
                    "jd_department":$('#jd_department').val(),
                    "jd_section":$('#jd_section').val(),
                    "jd_position_backup":jd_position_backup,
                    "jd_position_report":jd_position_report2,
                    "jd_organization_position":$('#jd_organization_position').val(),
                    "jd_organization_level":$('#jd_organization_level').val(),
                    "KEY_RESPONSIBILITY":$('#KEY_RESPONSIBILITY').val(),
                    "search_year":$('#search_year').val(),
                    TASK: TASK,
                    KNOWLEDGE: KNOWLEDGE,
                    SKILLS: skills,
                    PERSONALITY_TRAITS: PERSONALITY_TRAITS,
                },
                success: function (result2) {
                    destroy_table();
                    $('#update_jd').modal('hide');
                    Swal.fire({
                        title: "Update Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                }
            });
        }
        function open_jd(i,id,employee_id) {
            var id_gmgr = $('#id_gmgr'+id).val();
            // console.log(id);
            if(id_gmgr == 'P'){
                $.ajax({
                        type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_positoon_for_change_jd") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":employee_id,
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) {
                        $('#jd_position_employee_id_info').val(employee_id);
                        $('#jd_position_final_id_info').val(id);
                        if(result.tb_employee_final_score.JD_POSITION_BACKUP){
                            const $dropdownjd_position_backup = $('#jd_position_backup');
                            $dropdownjd_position_backup.find('option').each(function () {
                                if ($(this).text().trim() === result.tb_employee_final_score.JD_POSITION_BACKUP) {
                                    $(this).prop('selected', true);
                                    return false;
                                }
                            });
                            $dropdownjd_position_backup.trigger('change');
                        }else{
                            $('#jd_position_backup').val(result.position_code);
                            $('#select2-jd_position_backup-container').text(result.position_description);
                        }
                        if(result.tb_employee_final_score.JD_POSITION){
                            const $dropdownjd_position = $('#jd_position');
                            $dropdownjd_position.find('option').each(function () {
                                if ($(this).text().trim() === result.tb_employee_final_score.JD_POSITION) {
                                    $(this).prop('selected', true);
                                    return false;
                                }
                            });
                            $dropdownjd_position.trigger('change');
                        }else{
                            $('#jd_position').val((result.position_code_change?result.position_code_change:result.position_code));
                            $('#select2-jd_position-container').text((result.position_description_change?result.position_description_change:result.position_description));
                        }
                        if(result.tb_employee_final_score.JD_PREFIX){
                            $('#jd_position_description').val(result.tb_employee_final_score.JD_PREFIX);
                        }
                        if(result.tb_employee_final_score.JD_COMPANY){
                            $('#jd_company').val(result.tb_employee_final_score.JD_COMPANY);
                        }else{
                            var segment = $('#segment').val();
                            if(segment == "mtl"){
                                $('#jd_company').val('MTL');
                            }else{
                                $('#jd_company').val('MIL');
                            }
                        }
                        if(result.tb_employee_final_score.JD_GRADE_CODE){
                            const $dropdownjd_level = $('#jd_level');
                            $dropdownjd_level.find('option').each(function () {
                                if ($(this).text().trim() === result.tb_employee_final_score.JD_GRADE_CODE) {
                                    $(this).prop('selected', true);
                                    return false;
                                }
                            });
                            $dropdownjd_level.trigger('change');
                        }else{
                            $('#jd_level').val(result.grade_code);
                            $('#select2-jd_level-container').text(result.grade_code);
                        }
                        if(result.tb_employee_final_score.JD_DIVISION_CODE){
                            const $dropdownjd_division = $('#jd_division');
                            $dropdownjd_division.find('option').each(function () {
                                const optionTextjd_division = $(this).text().trim();
                                if (optionTextjd_division.startsWith(result.tb_employee_final_score.JD_DIVISION_CODE)) {
                                    $(this).prop('selected', true);
                                    return false;
                                }
                            });
                            $dropdownjd_division.trigger('change');
                        }else{
                            $('#jd_division').val(result.division_code);
                            $('#select2-jd_division-container').text(result.division_code+' - '+result.division_description);
                        }

                        if(result.tb_employee_final_score.JD_POSITION_REPORT_THIS_ROLE){
                            const selectedValuesREPORT = result.tb_employee_final_score.JD_POSITION_REPORT_THIS_ROLE.split(',');
                            $('#jd_position_report').val(selectedValuesREPORT).trigger('change');
                        }
                        

                        // get_department_jd(result.department_code,result.department_description);
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/get_department_salary_jd") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "search_division":$('#jd_division').val(),
                                "pagenow":'1',
                                "search_year":$('#search_year').val()
                            },
                            success: function (resultzzz) { 
                                var html = `<option value="0">เลือก</option>`;
                                resultzzz.data.forEach(element => {
                                    html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                                });
                                $('#jd_department').html(html);
                                setTimeout(() => {
                                    // get_department_jd(result.department_code,result.department_description);

                                    if(result.tb_employee_final_score.JD_DEPARTMENT_CODE){
                                        const $dropdownjd_department = $('#jd_department');
                                        $dropdownjd_department.find('option').each(function () {
                                            const optionTextjd_department = $(this).text().trim();
                                            
                                            if (optionTextjd_department.startsWith(result.tb_employee_final_score.JD_DEPARTMENT_CODE)) {
                                                console.log(optionTextjd_department+'------'+result.tb_employee_final_score.JD_DEPARTMENT_CODE);
                                                $(this).prop('selected', true);
                                                return false;
                                            }
                                        });
                                        $dropdownjd_department.trigger('change');
                                    }else{
                                        // alert(result.department_code+' - '+result.department_description);
                                        $('#jd_department').val(result.department_code);
                                        $('#select2-jd_department-container').text(result.department_code+' - '+result.department_description);
                                    }
                                    setTimeout(() => {
                                        get_section_jd(result.section_code,result.section_description);
                                        if(result.tb_employee_final_score.JD_SECTION_CODE){
                                            const $dropdownjd_section = $('#jd_section');
                                            $dropdownjd_section.find('option').each(function () {
                                                const optionTextjd_section = $(this).text().trim();
                                                
                                                if (optionTextjd_section.startsWith(result.tb_employee_final_score.JD_SECTION_CODE)) {
                                                    console.log(optionTextjd_section+'------'+result.tb_employee_final_score.JD_SECTION_CODE);
                                                    $(this).prop('selected', true);
                                                    return false;
                                                }
                                            });
                                            $dropdownjd_section.trigger('change');
                                        }
                                        $('#row_jd_0').val('');
                                        $('#rowKnowledge_jd_0').val('');
                                        $('#rowSkills_jd_0').val('');
                                        $('#rowPersonality_jd_0').val('');
                                        if(result.jd_tasks.length > 0){
                                            $('#countrow_jd').val(result.jd_tasks.length);
                                            var show_jd = ``;
                                            $.each(result.jd_tasks, function (key, value) {	
                                                show_jd += `<div class="row_jd_${(key+1)}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                                        <input type="text" id="row_jd_${(key+1)}" name="TASK[]" class="form-control" value="${(value.TASK?value.TASK:'')}">
                                                                        <button type="button" onclick="delrow_jd(${(key+1)});" class="addrow_jd_${(key+1)} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                                            <i class="ki_jd_${(key+1)} ki-solid ki-trash fs-5"></i>
                                                                        </button>
                                                                    </div>`;
                                                $('#KEY_RESPONSIBILITY').val(value.KEY_RESPONSIBILITY);
                                            });
                                            $('.show_jd').html(show_jd);
                                        }
                                        if(result.jd_knowledge.length > 0){
                                            $('#countrowKnowledge_jd').val(result.jd_knowledge.length);
                                            var showKnowledge_jd = ``;
                                            $.each(result.jd_knowledge, function (key, value) {	
                                                showKnowledge_jd += `<div class="rowKnowledge_jd_${(key+1)}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                                        <input type="text" id="rowKnowledge_jd_${(key+1)}" name="KNOWLEDGE[]" class="form-control" value="${(value.KNOWLEDGE?value.KNOWLEDGE:'')}">
                                                                        <button type="button" onclick="delrowKnowledge_jd(${(key+1)});" class="addrowKnowledge_jd_${(key+1)} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                                            <i class="ki_jd_${(key+1)} ki-solid ki-trash fs-5"></i>
                                                                        </button>
                                                                    </div>`;
                                            });
                                            $('.showKnowledge_jd').html(showKnowledge_jd);
                                        }
                                        if(result.jd_skills.length > 0){
                                            $('#countrowSkills_jd').val(result.jd_skills.length);
                                            var showSkills_jd = ``;
                                            $.each(result.jd_skills, function (key, value) {	
                                                showSkills_jd += `<div class="rowSkills_jd_${(key+1)}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                                        <input type="text" id="rowSkills_jd_${(key+1)}" name="SKILLS[]" class="form-control" value="${(value.SKILLS?value.SKILLS:'')}">
                                                                        <button type="button" onclick="delrowSkills_jd(${(key+1)});" class="addrowSkills_jd_${(key+1)} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                                            <i class="ki_jd_${(key+1)} ki-solid ki-trash fs-5"></i>
                                                                        </button>
                                                                    </div>`;
                                            });
                                            $('.showSkills_jd').html(showSkills_jd);
                                        }
                                        if(result.jd_personality.length > 0){
                                            $('#countrowPersonality_jd').val(result.jd_personality.length);
                                            var showPersonality_jd = ``;
                                            $.each(result.jd_personality, function (key, value) {	
                                                showPersonality_jd += `<div class="rowPersonality_jd_${(key+1)}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                                                                        <input type="text" id="rowPersonality_jd_${(key+1)}" name="PERSONALITY_TRAITS[]" class="form-control" value="${(value.PERSONALITY_TRAITS?value.PERSONALITY_TRAITS:'')}">
                                                                        <button type="button" onclick="delrowPersonality_jd(${(key+1)});" class="addrowPersonality_jd_${(key+1)} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                                                            <i class="ki_jd_${(key+1)} ki-solid ki-trash fs-5"></i>
                                                                        </button>
                                                                    </div>`;
                                            });
                                            $('.showPersonality_jd').html(showPersonality_jd);
                                        }
                                        if(result.organization_chart.length > 0){
                                            $('#jd_organization_position').val(result.organization_chart[0].POSITION).trigger('change');
                                            $('#jd_organization_level').val(result.organization_chart[0].LEVEL).trigger('change');
                                        }
                                        $('#update_jd').modal('show');
                                    }, 200);
                                }, 200);
                            }
                        });
                        

                        
                        
                    }
                });
            }
        }
        // function get_jd_position(){
        //     const jd_position = $('#jd_position').find(':selected').text();
        //     console.log(jd_position);
        //     $('#jd_position_description').val(jd_position);
        // }
        function addrow_jd(){
            var countrow_jd = $('#countrow_jd').val();
            var row_jd_0 = $('#row_jd_0').val();
            countrow_jd = parseInt(countrow_jd)+1;
            $('#countrow_jd').val(countrow_jd);
            $('.show_jd').append(`<div class="row_jd_${countrow_jd}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                            <input type="text" id="row_jd_${countrow_jd}" name="TASK[]" class="form-control" value="${(row_jd_0?row_jd_0:'')}">
                            <button type="button" onclick="delrow_jd(${countrow_jd});" class="addrow_jd_${countrow_jd} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                <i class="ki_jd_${countrow_jd} ki-solid ki-trash fs-5"></i>
                            </button>
                        </div>`);
            $('#row_jd_0').val('');
            $('#row_jd_0').focus();
        }
        function addrowKnowledge_jd(){
            var countrowKnowledge_jd = $('#countrowKnowledge_jd').val();
            var rowKnowledge_jd_0 = $('#rowKnowledge_jd_0').val();
            countrowKnowledge_jd = parseInt(countrowKnowledge_jd)+1;
            $('#countrowKnowledge_jd').val(countrowKnowledge_jd);
            $('.showKnowledge_jd').append(`<div class="rowKnowledge_jd_${countrowKnowledge_jd}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                            <input type="text" id="rowKnowledge_jd_${countrowKnowledge_jd}" name="KNOWLEDGE[]" class="form-control" value="${(rowKnowledge_jd_0?rowKnowledge_jd_0:'')}">
                            <button type="button" onclick="delrowKnowledge_jd(${countrowKnowledge_jd});" class="rowKnowledge_jd_${countrowKnowledge_jd} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                <i class="ki_jd_${countrowKnowledge_jd} ki-solid ki-trash fs-5"></i>
                            </button>
                        </div>`);
            $('#rowKnowledge_jd_0').val('');
            $('#rowKnowledge_jd_0').focus();
        }
        function addrowSkills_jd(){
            var countrowSkills_jd = $('#countrowSkills_jd').val();
            var rowSkills_jd_0 = $('#rowSkills_jd_0').val();
            countrowSkills_jd = parseInt(countrowSkills_jd)+1;
            $('#countrowSkills_jd').val(countrowSkills_jd);
            $('.showSkills_jd').append(`<div class="rowSkills_jd_${countrowSkills_jd}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                            <input type="text" id="rowSkills_jd_${countrowSkills_jd}" name="SKILLS[]" class="form-control" value="${(rowSkills_jd_0?rowSkills_jd_0:'')}">
                            <button type="button" onclick="delrowSkills_jd(${countrowSkills_jd});" class="rowSkills_jd_${countrowSkills_jd} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                <i class="ki_jd_${countrowSkills_jd} ki-solid ki-trash fs-5"></i>
                            </button>
                        </div>`);
            $('#rowSkills_jd_0').val('');
            $('#rowSkills_jd_0').focus();
        }
        function addrowPersonality_jd(){
            var countrowPersonality_jd = $('#countrowPersonality_jd').val();
            var rowPersonality_jd_0 = $('#rowPersonality_jd_0').val();
            countrowPersonality_jd = parseInt(countrowPersonality_jd)+1;
            $('#countrowPersonality_jd').val(countrowPersonality_jd);
            $('.showPersonality_jd').append(`<div class="rowPersonality_jd_${countrowPersonality_jd}" style="display: flex;align-items: center;justify-content: center;margin-bottom: 10px;">
                            <input type="text" id="rowPersonality_jd_${countrowPersonality_jd}" name="PERSONALITY_TRAITS[]" class="form-control" value="${(rowPersonality_jd_0?rowPersonality_jd_0:'')}">
                            <button type="button" onclick="delrowPersonality_jd(${countrowPersonality_jd});" class="addrowPersonality_jd_${countrowPersonality_jd} btn btn-icon btn-danger text-dark btn-xs me-1" style="border-radius: 50%;margin-left: 10px;">
                                <i class="ki_jd_${countrowPersonality_jd} ki-solid ki-trash fs-5"></i>
                            </button>
                        </div>`);
            $('#rowPersonality_jd_0').val('');
            $('#rowPersonality_jd_0').focus();
        }
        function delrow_jd(countrow_jd){
            $('.row_jd_'+countrow_jd).remove();
        }
        function delrowKnowledge_jd(countrowKnowledge_jd){
            $('.rowKnowledge_jd_'+countrowKnowledge_jd).remove();
        }
        function delrowSkills_jd(countrowSkills_jd){
            $('.rowSkills_jd_'+countrowSkills_jd).remove();
        }
        function delrowPersonality_jd(countrowPersonality_jd){
            $('.rowPersonality_jd_'+countrowPersonality_jd).remove();
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////
        function update_remark_special(id){

            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/update_remark_special") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "remark_special":$('#remark_special'+id).val(),
                    "search_year":$('#search_year').val()
                },
                success: function (result) {
                    Swal.fire({
                        title: "Update Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                }
            });
        }
    </script>
    @endpush
</x-default-layout>

<style>
    table.dataTable thead > tr > th.sorting{
        padding-right: 8px;
        font-size: 14px;
    }
    table.dataTable.table-striped > tbody > tr > td{
        font-size: 14px;
    }
    .table:not(.table-bordered) > :not(:last-child) > :last-child > * {
        font-size: 14px;
    }
    .table > tbody > tr > td{
        font-size: 14px !important;
    }
    .table > :not(caption) > * > *,table.dataTable > tbody > tr > th, table.dataTable > tbody > tr > td,table.dataTable thead > tr > th.dt-orderable-asc, table.dataTable thead > tr > th.dt-orderable-desc, table.dataTable thead > tr > th.dt-ordering-asc, table.dataTable thead > tr > th.dt-ordering-desc, table.dataTable thead > tr > td.dt-orderable-asc, table.dataTable thead > tr > td.dt-orderable-desc, table.dataTable thead > tr > td.dt-ordering-asc, table.dataTable thead > tr > td.dt-ordering-desc{
        padding:0px 5px;
        /* border-color: grey !important;
        border-width: thin !important;
        border-style: solid !important; */
    }
    .table td:first-child {
        border-radius: 0;
    }
    .table thead th:first-child {
        border-radius: 0;
    }
    .table thead th:last-child {
        border-radius: 0;
    }
    .table td:last-child {
        border-radius: 0;
    }
    .table th, .table:not(.table-bordered) th {
        font-size: 14px !important;
    }
    .buttons-copy,.buttons-csv,.buttons-pdf,.buttons-print{
        display: none !important;
    }
    .dtfh-floatingparent-head{
        top: 2.7em !important;
    }
    .dtfh-floatingparent,.dtfh-floatingparenthead{
        top: 2.7em !important;
        border: 1px solid;
        z-index: 9;
    }
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .select2-container--bootstrap5 .select2-selection--single .select2-selection__rendered{
        font-size: 14px;
    }
    .symbol.symbol-40px .symbol-label {
        width: 30px;
        height: 30px;
    }
    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-search__field ,
    .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--selected,
    .select2-container--bootstrap5 .select2-dropdown .select2-results__option,
    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-selection__choice .select2-selection__choice__display,
    #select2-search_employee_no-container
    {
        font-size: 14px;
    }
    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) {
        min-height: 37.14px;
        height: 37.14px !important;
        position: relative;

    }
    .select2-container{
        height: 37.14px !important;
        /* overflow: auto; */
    }
    .select2-container .selection{
        height: 37.14px !important;
        overflow: auto;
    }

    .setheight_jd .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) {
        min-height: auto;
        height: auto !important;

    }
    .setheight_jd .select2-container{
        height: auto !important;
    }
    .setheight_jd .select2-container .selection{
        height: auto !important;
    }

    .select2-container--bootstrap5 .select2-selection--multiple:not(.form-select-sm):not(.form-select-lg) .select2-search__field{
        height: 12px;
    }
</style>