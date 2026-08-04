<x-default-layout>

    @section('title')
        {{ __('Evaluate employees') }}
    @endsection


    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <!-- <div class="card-header">
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-profile-user fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Evaluate employees') }}
                    </span>
                    </h3>
                </div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    
                    <div class="accordion accordion-icon-collapse" id="kt_accordion_3">
                        <div class="">
                            <div class="accordion-header d-flex collapsed" data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_item_2">
                                
                                <div class="row g-3 " style="width: 100%;">
                                    <div class="col-6 col-md-2  d-flex" style="align-items: center;">
                                        <span class="accordion-icon">
                                        <i class="ki-duotone ki-plus-square fs-3 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <i class="ki-duotone ki-minus-square fs-3 accordion-icon-on"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <h3 class="fs-4 fw-semibold mb-0 ms-4">Search</h3>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="card shadow-none rounded-3 p-3" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">  
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="badge badge-square "><i class="ki-outline ki-profile-user fs-2 text-black"></i></span>
                                                </div>
                                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p class="text-gray-800 small fw-normal mb-0" style="font-size: 0.775em;">All employees</p>
                                                        <h4 class="text-black fw-bold d-block text-end mb-0 all_employee">0</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-secondary" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">  
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="badge badge-square badge-warning"><i class="ki-outline ki-loading fs-2 text-black"></i></span>
                                                </div>
                                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p class="text-gray-800 small fw-normal mb-0">In progress</p>
                                                        <h4 class="text-black fw-bold d-block text-end mb-0 all_inprogress">0</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-danger" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">  
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                                                </div>
                                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p class="text-gray-800 small fw-normal mb-0">Reject</p>
                                                        <h4 class="text-black fw-bold d-block text-end mb-0 all_reject">0</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="card shadow-none rounded-3 p-3 bg-light-success" style="padding: 0px !important;">
                                            <div class="d-flex flex-stack">  
                                                <div class="symbol symbol-40px me-4">
                                                    <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                                            </div>
                                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p class="text-gray-800 small fw-normal mb-0">Finished</p>
                                                        <h4 class="text-black fw-bold d-block text-end mb-0 all_finish">0</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kt_accordion_3_item_2" class="collapse fs-6" data-bs-parent="#kt_accordion_3">
                                <div class="d-md-block">
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-sm-2">
                                            <label for="exampleFormControlInput1" class="form-label mb-0">Compliance score</label>
                                            <select class="form-select" data-control="select2" id="search_complaince_score" data-placeholder="-Choose-" multiple>
                                                <option value="0">All</option>
                                                <option value="1">{{__('Below Standard')}}</option>
                                                <option value="2">{{__('Standard')}}</option>
                                                <option value="3">{{__('Above Standard')}}</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <label for="exampleFormControlInput1" class="form-label mb-0">Attendance score</label>
                                            <select class="form-select" data-control="select2" id="search_attendance_score" data-placeholder="-Choose-" multiple>
                                                <option value="0">All</option>
                                                <option value="1">{{__('Below Standard')}}</option>
                                                <option value="2">{{__('Standard')}}</option>
                                                <option value="3">{{__('Above Standard')}}</option>
                                            </select>
                                        </div>

                                        <div class="col-8 col-sm-2">
                                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Status')}}</label>
                                            <select class="form-select" data-control="select2" id="search_status" data-placeholder="-Select-" multiple>
                                                <option value="0">All</option>
                                                <option value="1">In progress</option>
                                                <option value="2">Reject</option>
                                                <option value="3">Finished</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-sm-2">
                                            <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                            <select id="search_section" name="search_section" aria-label="All" data-control="select2" data-placeholder="All" class="form-select" multiple>
                                                @if(Auth::user()->orisoft_code != "000002")
                                                    @if(count($section) > 1)
                                                        <option value="0">All</option>
                                                    @endif
                                                @endif
                                                
                                                @foreach ($section as $key => $val)
                                                <option value="{{ $val->section_code }}">{{ $val->section_code }} - {{ $val->section_description }}</option>
                                                @endforeach
                                                <!-- @foreach ($section as $key => $val)
                                                    @if($key == 0)
                                                        <option value="{{ $val->section_code }}" selected>{{ $val->section_code }} - {{ $val->section_description }}</option>
                                                    @else
                                                        <option value="{{ $val->section_code }}">{{ $val->section_code }} - {{ $val->section_description }}</option>
                                                    @endif
                                                @endforeach    -->
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <label
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >Monthly/Daily</label
                                            >
                                            <select class="form-select myLike" data-control="select2" id="search_month_day" name="search_month_day" data-placeholder="-Select-" multiple>
                                                <option value="all" selected>All</option>
                                                <option value="2">Monthly</option>
                                                <option value="1" >Daily</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-2" style="font-size: 14px;">
                                            <label
                                                style="font-size: 14px;"
                                                for="exampleFormControlInput1"
                                                class="form-label mb-0"
                                                >{{__('Year')}}</label
                                            >
                                            <select class="form-select" data-control="select2" id="search_year" name="search_year" data-placeholder="-Select-" onchange="destroy_table();" multiple>
                                                @if(!empty($search_year))
                                                @foreach ($search_year as $key => $val)
                                                <option value="{{$val->rec_year}}">{{$val->rec_year}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-4 col-sm-2">
                                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                                            <button type="button" class="btn btn-primary rounded-pill" onclick="destroy_table();">
                                                <i class="ki-outline ki-magnifier"></i>
                                                {{__('Search')}}
                                            </button>
                                            <input type="hidden" id="search_form" value="F1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="border-gray-400">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab_1">
                            <div class="title-sect">
                                <span class="sec_active"> <small class="fw-normal total_employee_sec">(0)</small></span>
                            </div>
                            <ul class="nav nav-pills nav-pills-custom mb-3">
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden pt-3 pb-3 setblinkAll setblink1 allactive active" id="tabF_link_1" data-bs-toggle="pill" onclick="active_tab_form('F1');">
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center ">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F1
                                            <small class="fw-normal count_f1" style="font-size: 17px;color: blue;font-weight: bold !important;">(0)</small>
                                        </span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3 setblinkAll setblink2 allactive" id="tabF_link_2" data-bs-toggle="pill" onclick="active_tab_form('F2');">
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center ">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F2
                                            <small class="fw-normal count_f2" style="font-size: 17px;color: blue;font-weight: bold !important;">(0)</small>
                                        </span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                                
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3 setblinkAll setblink3 allactive" id="tabF_link_3" data-bs-toggle="pill" onclick="active_tab_form('F3');">
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center ">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F3
                                            <small class="fw-normal count_f3" style="font-size: 17px;color: blue;font-weight: bold !important;">(0)</small>
                                        </span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>

                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3 setblinkAll setblink4 allactive" id="tabF_link_4" data-bs-toggle="pill" onclick="active_tab_form('F4');">
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center ">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F4
                                            <small class="fw-normal count_f4" style="font-size: 17px;color: blue;font-weight: bold !important;">(0)</small>
                                        </span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>

                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3 allactive" id="tabF_link_5" data-bs-toggle="pill" onclick="active_tab_all();">
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            All
                                            <!-- <small class="fw-normal count_f4">(0)</small> -->
                                        </span>
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    </a>
                                </li>
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <button type="button" class="btn btn-success rounded-pill" onclick="freeze();"><i class="bi bi-floppy fs-5"></i>Submit to Manager</button>
                                </li>
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <button type="button" class="btn btn-primary rounded-pill" onclick="export_excel_evaluate();"><i class="bi-file-earmark-excel fs-5"></i>Export Excel</button>
                                </li>
                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tabF_1">
                                    
                                    <!-- <div class="mb-4">
                                        Toggle column: 
                                        <a class="toggle-vis" data-column="1">Emp. no.</a> - 
                                        <a class="toggle-vis" data-column="2">Name</a> - 
                                        <a class="toggle-vis" data-column="3">Position</a> - 
                                        <a class="toggle-vis" data-column="4">Date joined</a> - 
                                        <a class="toggle-vis" data-column="5">Service days</a> - 
                                        <a class="toggle-vis" data-column="6">Evaluator</a>
                                    </div> -->
                                    <!-- <div class="detail_topic">
                                        
                                    </div> -->
                                    <div class="detail_topic2" style="font-size: 12px !important;position: fixed;bottom: 0;right: 0px;width: 100%;padding: 10px 15px;z-index: 9999;">
                                        
                                    </div>
                                    <!-- tableDesktop -->
                                    <div class=" position-relative">
                                        <div style="position:absolute;top:0;left:0;z-index:99;">
                                            <div class="d-inline-flex" style="display:none !important;">
                                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                    Action
                                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                                </button>
                                                <!--end::Toggle-->

                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
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
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-light rotate mb-3 p-2 ps-3 rounded-pill" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                    Display
                                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                                </button>
                                                <!--end::Toggle-->

                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="0"> Emp. no.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="1"> Name - Surname
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="2"> Position
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="3"> Date joined
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="4"> Service days
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <!-- <div class="menu-item px-3 toggleF1">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="15"> Remark
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="menu-item px-3 toggleF2" style="display:none;">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="17"> Remark
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="menu-item px-3 toggleF3" style="display:none;">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="15"> Remark
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="menu-item px-3 toggleF4" style="display:none;">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="16"> Remark
                                                            </label>
                                                        </div>
                                                    </div> -->
                                                    <!--end::Menu item-->

                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                        </div>

                                        
                                        
                                        <div class="table-responsive example" style="display:none;">
                                            <table id="example" class="table table-striped rounded" >
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <!-- <th rowspan="2"><input type="checkbox"></th> -->
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. no.')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. Name')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Position</th>
                                                        <th rowspan="2" style="min-width:90px;width:90px;">Date joined</th>
                                                        <th rowspan="2">Service days</th>
                                                        <th colspan="9" class="text-center check_colspan">Criteria</th>
                                                        <th rowspan="2">Total</th>
                                                        <th rowspan="2">{{__('Remark Eva')}}</th>
                                                        <!-- <th rowspan="2">{{__('Remark Manager')}}</th> -->
                                                        <th rowspan="2">{{__('Status')}}</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7 check_th">
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="table-responsive example2" style="display:none;">
                                            <table id="example2" class="table table-striped rounded" >
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <!-- <th rowspan="2"><input type="checkbox"></th> -->
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. no.')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. Name')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Position</th>
                                                        <th rowspan="2" style="min-width:90px;width:90px;">Date joined</th>
                                                        <th rowspan="2">Service days</th>
                                                        <th colspan="11" class="text-center check_colspan">Criteria</th>
                                                        <th rowspan="2">Total</th>
                                                        <th rowspan="2">{{__('Remark Eva')}}</th>
                                                        <!-- <th rowspan="2">{{__('Remark Manager')}}</th> -->
                                                        <th rowspan="2">{{__('Status')}}</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7 check_th">
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                        <th class="text-center">10</th>
                                                        <th class="text-center">11</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="table-responsive example3" style="display:none;">
                                            <table id="example3" class="table table-striped rounded" >
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <!-- <th rowspan="2"><input type="checkbox"></th> -->
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. no.')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. Name')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Position</th>
                                                        <th rowspan="2" style="min-width:90px;width:90px;">Date joined</th>
                                                        <th rowspan="2">Service days</th>
                                                        <th colspan="9" class="text-center check_colspan">Criteria</th>
                                                        <th rowspan="2">Total</th>
                                                        <th rowspan="2">{{__('Remark Eva')}}</th>
                                                        <!-- <th rowspan="2">{{__('Remark Manager')}}</th> -->
                                                        <th rowspan="2">{{__('Status')}}</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7 check_th">
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="table-responsive example4" style="display:none;">
                                            <table id="example4" class="table table-striped rounded" >
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <!-- <th rowspan="2"><input type="checkbox"></th> -->
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. no.')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">{{__('Emp. Name')}}</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Position</th>
                                                        <th rowspan="2" style="min-width:90px;width:90px;">Date joined</th>
                                                        <th rowspan="2">Service days</th>
                                                        <th colspan="10" class="text-center check_colspan">Criteria</th>
                                                        <th rowspan="2">Total</th>
                                                        <th rowspan="2">{{__('Remark Eva')}}</th>
                                                        <!-- <th rowspan="2">{{__('Remark Manager')}}</th> -->
                                                        <th rowspan="2">{{__('Status')}}</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7 check_th">
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                        <th class="text-center">10</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive example_all" style="display:none;">
                                            <table id="example_all" class="table table-striped rounded" >
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <!-- <th rowspan="2"><input type="checkbox"></th> -->
                                                        <th style="text-wrap:nowrap">{{__('Emp. no.')}}</th>
                                                        <th style="text-wrap:nowrap">{{__('Emp. Name')}}</th>
                                                        <th style="text-wrap:nowrap">Position</th>
                                                        <th style="min-width:90px;width:90px;">Date joined</th>
                                                        <th class="text-center">Service days</th>
                                                        <th class="text-center">Form</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">{{__('Remark Eva')}}</th>
                                                        <!-- <th class="text-center">{{__('Remark Manager')}}</th> -->
                                                        <th class="text-center">{{__('Status')}}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div class="text-center pt-3">
                                                <input type="hidden" class="check_value_null" value="0">
                                                <input type="hidden" class="check_value_null_same" value="0">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tableMobile" style="display:none;">
                                        <div class="d-inline-flex" style="display:none !important;">
                                            <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                Action
                                                <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                            </button>
                                            <!--end::Toggle-->

                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                                <div class="separator mt-3 opacity-75"></div>
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
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
                                                    <a href="#" class="menu-link px-3">
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
                                            <div class="table-responsive example_m">
                                                <table id="example_m" class="table table-striped rounded" >
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="text-center pt-3">
                                    <button type="button" class="btn btn-success rounded-pill" onclick="freeze();"><i class="bi bi-floppy fs-5"></i>Submit to Manager</button>
                                    </div> -->
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
                    <p class="showname"></p>
                    <!-- <table class="table table-bordered">
                        <thead class="bg-light-primary">
                            <tr class="text-center">
                                <th colspan="6">Compliance with company regulations</th>
                            </tr>
                            <tr class="text-center" style="background-color:#ffffff !important">
                                <th>ABT</th>
                                <th>VWAR</th>
                                <th>WWAR</th>
                                <th>SUS</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="Compliance_ABT">0</td>
                                <td class="Compliance_VWAR">0</td>
                                <td class="Compliance_WWAR">0</td>
                                <td class="Compliance_SUS">0</td>
                                <td class="Compliance_TOTAL Compliance_abtfw-bold text-primary">0</td>
                            </tr>
                        </tbody>
                    </table> -->

                    <table class="table table-bordered">
                    <thead class="bg-light-primary">
                            <tr class="text-center">
                                <th>Compliance with company regulations</th>
                                <th>Deduction Rate</th>
                                <th>Amount</th>
                                <th>Deduction Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-left">
                                <td class="text-left">ขาดงาน (Absent)</td>
                                <td class="text-center">1 / Time</td>
                                <td class="text-center Compliance_ABT">0</td>
                                <td class="text-center Compliance_ABT_cal">0</td>
                            </tr>
                            <tr class="text-left">
                                <td class="text-left">เตือนวาจา (VWAR)</td>
                                <td class="text-center">2 / Time</td>
                                <td class="text-center Compliance_VWAR">0</td>
                                <td class="text-center Compliance_VWAR_cal">0</td>
                            </tr>
                            <tr class="text-left">
                                <td class="text-left">เตือนอักษร (WWAR)</td>
                                <td class="text-center">5 / Time</td>
                                <td class="text-center Compliance_WWAR">0</td>
                                <td class="text-center Compliance_WWAR_cal">0</td>
                            </tr>
                            <tr class="text-left">
                                <td class="text-left">พักงาน (SUS)</td>
                                <td class="text-center">10 / Day</td>
                                <td class="text-center Compliance_SUS">0</td>
                                <td class="text-center Compliance_SUS_cal">0</td>
                            </tr>
                            <tr class="text-left">
                                <td>Total scores</td>
                                <td></td>
                                <td></td>
                                <td class="text-center Compliance_TOTAL fw-bold text-primary">0</td>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Attendance record </h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <p class="showname"></p>
                    <table class="table table-bordered">
                        <thead class="bg-light-warning">
                            <tr class="text-center">
                                <th colspan="6">Attendance record <span class="fw-bold text-danger showscore">Score = 0</span></th>
                            </tr>
                            <tr class="text-center" style="background-color:#ffffff !important">
                                <th>SL</th>
                                <th>PL</th>
                                <th>LATE</th>
                                <th>ABS</th>
                                <!-- <th>OL</th> -->
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="Attendance_SL">3.6</td>
                                <td class="Attendance_PL">0</td>
                                <td class="Attendance_LATE">0</td>
                                <td class="Attendance_ABS">0</td>
                                <!-- <td class="Attendance_SUS">0</td> -->
                                <td class="Attendance_TOTAL fw-bold text-danger">3.6</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead class="bg-light-primary">
                            <tr class="text-left">
                                <th>Based on leaves of personal, sick, company special and late to work : </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-left">
                                <td class="text-left">0-2 days = 10, 3-4 days = 9, 5-6 days = 8</td>
                                <td class="text-left">Above Standard</td>
                                <td class="text-center">8-10</td>
                            </tr>
                            <tr class="text-left">
                                <td class="text-left">7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4/td>
                                <td class="text-left">Standard</td>
                                <td class="text-center">4-7</td>
                            </tr>
                            <tr class="text-left">
                                <td class="text-left">15-16 days = 3, 17-18 days = 2, 19-20 days = 1</td>
                                <td class="text-left">Below Standard</td>
                                <td class="text-center">1-3</td>
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
                    <button type="button" class="btn btn-outline btn-outline-dark rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
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
                    <p class="fw-bold mb-2">Additional detail:</p>
                    <textarea class="form-control" rows="3"></textarea>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-outline btn-outline-dark rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::reject modal-->
@push('scripts')
<script type="text/javascript">
function format(d) {
    // `d` is the original data object for the row
    return (
        '<dl>'+
        ($("#isLocale").val() == '1'?'<h4 class="mb-2 title1">1.Knowledge in job <span class="fw-normal text-gray-700">(x1)</span></h4>'+
        '<h6 class="mb-0 ps-4 title2">Above Standard <span class="fw-normal">(8-10)</span></h6>'+
        '<p class="ps-4 title3">Expert in all facets of the job, can tech others how to do</p>'+
        '<h6 class="mb-0 ps-4 title4">Standard <span class="fw-normal">(4-7)</span></h6>'+
        '<p class="ps-4 title5">Has sufficient knowledge of how to do the job</p>'+
        '<h6 class="mb-0 ps-4 title6">Below Standard <span class="fw-normal">(1-3)</span></h6>'+
        '<p class="ps-4 title7">Needs further coaching / training on how to do his/her job</p>':'<h4 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h4>'+
        '<h6 class="mb-0 ps-4 title2">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>'+
        '<p class="ps-4 title3">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>'+
        '<h6 class="mb-0 ps-4 title4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>'+
        '<p class="ps-4 title5">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>'+
        '<h6 class="mb-0 ps-4 title6">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>'+
        '<p class="ps-4 title7">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>')+
        '<table class="table table-bordered bg-white table-sm">'+
            '<thead class="bg-light-primary">'+ 
                '<tr>'+
                    '<th colspan="11" class="text-center fw-bold">Criteria</th>'+
                '</tr>'+
                '<tr>'+
                    '<td class="text-center">1</td>'+
                    '<td class="text-center">2</td>'+
                    '<td class="text-center">3</td>'+
                    '<td class="text-center">4</td>'+
                    '<td class="text-center">5</td>'+
                    '<td class="text-center">6</td>'+
                    '<td class="text-center">7</td>'+
                    '<td class="text-center">8</td>'+
                    '<td class="text-center">9</td>'+
                    '<td class="text-center">Total</td>'+
                '</tr>'+
            '</thead>'+
            '<tbody>'+
                '<tr class="text-center">'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="9" onclick="gettitle(1);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="9" onclick="gettitle(2);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="7" onclick="gettitle(3);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="5" onclick="gettitle(4);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="10" onclick="gettitle(5);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="6" onclick="gettitle(6);"></td>'+
                    '<td><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="6" onclick="gettitle(7);"></td>'+
                    '<td  class="">'+
                        '<button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>'+
                    '</td>'+
                    '<td  class="">'+
                        '<button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>'+
                    '</td>'+
                    '<td  class="fw-bold text-black fs-4">82.5</td>'+
                '</tr>'+
            '</tbody>'+
        '<table>'+
        '<p class="text-gray-800 mb-0">Note:</p>'+
        '<p class="mb-0 text-danger">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>'+
        '</dl>'
    );
}
const availWidth = window.screen.availWidth;
$('.sec_active').html(`${$("#search_section option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
// if(availWidth > 767){
    $('.example').css('display','');
    var fixedColumns = 2;
    if(availWidth < 630){
        fixedColumns = 1;
    }
    let table = new DataTable('#example', {
        fixedColumns: {
            left: fixedColumns
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        // "pageLength": 100,
        // serverSide: true,
        // scrollY: true,
        // scrollX: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_month_day":$('#search_month_day').val() || [],
                "search_year":$('#search_year').val() || []
            },      
        },
        colReorder: true,
        columns: [
            // { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'date' },
            { data: 'service' },
            { data: '1' },
            { data: '2' },
            { data: '3' },
            { data: '4' },
            { data: '5' },
            { data: '6' },
            { data: '7' },
            { data: '8' },
            { data: '0' },
            { data: 'total' },
            { data: 'remark' },
            // { data: 'remark_manager' },
            { data: 'status' }
        ],
        columnDefs: [ {
            targets: 1,
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
    get_form();
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
    $(".toggle-vis").change(function(e) {
        e.preventDefault();

        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);

        // Toggle the visibility
        column.visible(!column.visible());
    });
// }
// if(availWidth <= 767){
//     let table_m = new DataTable('#example_m', {
//         "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
//         searchDelay: 500,
//         processing: true,
//         scrollCollapse: true,
//         ordering:false,
//         "ajax": {
//             "url": "{{ url(Request::segment(1).'/table_test_getdata_m') }}",
//             "type": 'POST', 
//             "data" : { 
//                 "_token": "{{ csrf_token() }}",
//                 "search_complaince_score":$('#search_complaince_score_m').val(),
//                 "search_attendance_score":$('#search_attendance_score_m').val(),
//                 "search_status":$('#search_status_m').val(),
//                 "search_section":$('#search_section_m').val(),
//                 "search_form":$('#search_form').val(),
//             },      
//         },
//         colReorder: true,
//         columns: [
//             { data: 'data_id' },
//         ],
//         columnDefs: [],
//         "language": {
//             "lengthMenu": "Show _MENU_",
//         },
//         "dom":
//             "<'row'" +
//             "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
//             ">" +
//             "<'table-responsive'tr>" +
//             "<'row'" +
//             "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
//             "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
//             "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
//             ">"
        
//     });
//     get_form_m();
//     table_m.on('click', 'td.dt-control', function (e) {
//         let tr = e.target.closest('tr');
//         let row = table_m.row(tr);

//         if (row.child.isShown()) {
//             // This row is already open - close it
//             row.child.hide();
//         }
//         else {
//             // Open this row
//             row.child(format(row.data())).show();
//         }
//     });
//     $(".toggle-vis").change(function(e) {
//         e.preventDefault();

//         let columnIdx = e.target.getAttribute('data-column');
//         let column = table_m.column(columnIdx);

//         // Toggle the visibility
//         column.visible(!column.visible());
//     });
// }

evaluate_get_all();
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
    if($('#search_form').val() == ""){
        setTimeout(() => {
            active_tab_all();
        }, 200);
    }else{
        if($('#search_form').val() == "F1"){
            $('.example').css('display','');
            $('.example2').css('display','none');
            $('.example3').css('display','none');
            $('.example4').css('display','none');
            $('.example_all').css('display','none');
            $('#example').DataTable().destroy();
        }else if($('#search_form').val() == "F2"){
            $('.example').css('display','none');
            $('.example2').css('display','');
            $('.example3').css('display','none');
            $('.example4').css('display','none');
            $('.example_all').css('display','none');
            $('#example2').DataTable().destroy();
        }else if($('#search_form').val() == "F3"){
            $('.example').css('display','none');
            $('.example2').css('display','none');
            $('.example3').css('display','');
            $('.example4').css('display','none');
            $('.example_all').css('display','none');
            $('#example3').DataTable().destroy();
        }else{
            $('.example').css('display','none');
            $('.example2').css('display','none');
            $('.example3').css('display','none');
            $('.example4').css('display','');
            $('.example_all').css('display','none');
            $('#example4').DataTable().destroy();
        }
        $('.sec_active').html(`${$("#search_section option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
        get_form();
        setTimeout(() => {
            search_data();
            evaluate_get_all();
        }, 200);
    }
    
    
}
function destroy_table_all(){   
    $('.example').css('display','none');
    $('.example2').css('display','none');
    $('.example3').css('display','none');
    $('.example4').css('display','none');
    $('.example_all').css('display','');
    $('#example_all').DataTable().destroy();
    $('.sec_active').html(`${$("#search_section option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
    get_form_all();
    setTimeout(() => {
        search_data_all();
        evaluate_get_all();
    }, 200);
}
function destroy_table_m(){
    $('#example_m').DataTable().destroy();
    $('.sec_active').html(`${$("#search_section_m option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
    get_form_m();
    setTimeout(() => {
        search_data_m();
    }, 200);
}
function search_data(){
    
    var search_complaince_score = $('#search_complaince_score').val() || [];
    var search_attendance_score = $('#search_attendance_score').val() || [];
    var search_status           = $('#search_status').val() || [];
    var search_section          = $('#search_section').val() || [];
    var search_form          = $('#search_form').val() || [];
    var search_month_day          = $('#search_month_day').val() || [];

    var vis = $('.toggle-vis'); 
    for(var i = 0;i < vis.length;i++){
        $(vis[i]).prop('checked',true);
    }

    const availWidth = window.screen.availWidth;
    var fixedColumns = 2;
    if(availWidth < 630){
        fixedColumns = 1;
    }
    
    if(search_form == "F1"){
        let table = new DataTable('#example', {
        fixedColumns: {
            left: fixedColumns
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_month_day":$('#search_month_day').val() || [],
                "search_year":$('#search_year').val() || []
            },      
        },
        colReorder: true,
        columns: [
            // { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'date' },
            { data: 'service' },
            { data: '1' },
            { data: '2' },
            { data: '3' },
            { data: '4' },
            { data: '5' },
            { data: '6' },
            { data: '7' },
            { data: '8' },
            { data: '0' },
            { data: 'total' },
            { data: 'remark' },
            // { data: 'remark_manager' },
            { data: 'status' }
        ],
        columnDefs: [],
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
        $(".toggle-vis").change(function(e) {
            e.preventDefault();
            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);
            column.visible(!column.visible());
        });
    }else if(search_form == "F2"){
        let table = new DataTable('#example2', {
        fixedColumns: {
            left: fixedColumns
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_month_day":$('#search_month_day').val() || [],
                "search_year":$('#search_year').val() || []
            },      
        },
        colReorder: true,
        columns: [
            // { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'date' },
            { data: 'service' },
            { data: '1' },
            { data: '2' },
            { data: '3' },
            { data: '4' },
            { data: '5' },
            { data: '6' },
            { data: '7' },
            { data: '8' },
            { data: '9' },
            { data: '10' },
            { data: '0' },
            { data: 'total' },
            { data: 'remark' },
            // { data: 'remark_manager' },
            { data: 'status' }
        ],
        columnDefs: [],
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
        $(".toggle-vis").change(function(e) {
            e.preventDefault();
            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);
            column.visible(!column.visible());
        });
    }else if(search_form == "F3"){
        let table = new DataTable('#example3', {
        fixedColumns: {
            left: fixedColumns
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_month_day":$('#search_month_day').val() || [],
                "search_year":$('#search_year').val() || []
            },      
        },
        colReorder: true,
        columns: [
            // { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'date' },
            { data: 'service' },
            { data: '1' },
            { data: '2' },
            { data: '3' },
            { data: '4' },
            { data: '5' },
            { data: '6' },
            { data: '7' },
            { data: '8' },
            { data: '0' },
            { data: 'total' },
            { data: 'remark' },
            // { data: 'remark_manager' },
            { data: 'status' }
        ],
        columnDefs: [],
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
        $(".toggle-vis").change(function(e) {
            e.preventDefault();
            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);
            column.visible(!column.visible());
        });
    }else if(search_form == "F4"){
        let table = new DataTable('#example4', {
            fixedColumns: {
                left: fixedColumns
            },
            "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
            searchDelay: 500,
            processing: true,
            scrollCollapse: true,
            "ajax": {
                "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
                "type": 'POST', 
                "data" : { 
                    "_token": "{{ csrf_token() }}",
                    "search_complaince_score":$('#search_complaince_score').val() || [],
                    "search_attendance_score":$('#search_attendance_score').val() || [],
                    "search_status":$('#search_status').val() || [],
                    "search_section":$('#search_section').val() || [],
                    "search_form":$('#search_form').val() || [],
                    "search_month_day":$('#search_month_day').val() || [],
                    "search_year":$('#search_year').val() || []
                },      
            },
            colReorder: true,
            columns: [
                // { data: 'id' },
                { data: 'code' },
                { data: 'name' },
                { data: 'position' },
                { data: 'date' },
                { data: 'service' },
                { data: '1' },
                { data: '2' },
                { data: '3' },
                { data: '4' },
                { data: '5' },
                { data: '6' },
                { data: '7' },
                { data: '8' },
                { data: '9' },
                { data: '0' },
                { data: 'total' },
                { data: 'remark' },
                // { data: 'remark_manager' },
                { data: 'status' }
            ],
            columnDefs: [],
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
        $(".toggle-vis").change(function(e) {
            e.preventDefault();
            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);
            column.visible(!column.visible());
        });
    }else{
        // let table = new DataTable('#example_all', {
        //     fixedColumns: {
        //         left: fixedColumns
        //     },
        //     "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        //     searchDelay: 500,
        //     processing: true,
        //     scrollCollapse: true,
        //     "ajax": {
        //         "url": "{{ url(Request::segment(1).'/table_test_getdata') }}",
        //         "type": 'POST', 
        //         "data" : { 
        //             "_token": "{{ csrf_token() }}",
        //             "search_complaince_score":$('#search_complaince_score').val(),
        //             "search_attendance_score":$('#search_attendance_score').val(),
        //             "search_status":$('#search_status').val(),
        //             "search_section":$('#search_section').val(),
        //             "search_form":$('#search_form').val(),
        //         },      
        //     },
        //     colReorder: true,
        //     columns: [
        //         // { data: 'id' },
        //         { data: 'code' },
        //         { data: 'name' },
        //         { data: 'position' },
        //         { data: 'date' },
        //         { data: 'service' },
        //         { data: 'form' },
        //         { data: 'total' },
        //         { data: 'remark' },
        //         { data: 'status' }
        //     ],
        //     columnDefs: [],
        //     "language": {
        //         "lengthMenu": "Show _MENU_",
        //     },
        //     "dom":
        //         "<'row'" +
        //         "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
        //         ">" +
        //         "<'table-responsive'tr>" +
        //         "<'row'" +
        //         "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        //         "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        //         "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
        //         ">"
        
        // });
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
        // $(".toggle-vis").change(function(e) {
        //     e.preventDefault();
        //     let columnIdx = e.target.getAttribute('data-column');
        //     let column = table.column(columnIdx);
        //     column.visible(!column.visible());
        // });
    }
    get_form();
    // Add event listener for opening and closing details
    

//    $('.sec_active').html(`${$("#search_section option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
   
}
function search_data_all(){
    
    var search_complaince_score = $('#search_complaince_score').val() || [];
    var search_attendance_score = $('#search_attendance_score').val() || [];
    var search_status           = $('#search_status').val() || [];
    var search_section          = $('#search_section').val() || [];
    var search_form          = $('#search_form').val() || [];
    var search_month_day          = $('#search_month_day').val() || [];

    var vis = $('.toggle-vis'); 
    for(var i = 0;i < vis.length;i++){
        $(vis[i]).prop('checked',true);
    }

    const availWidth = window.screen.availWidth;
    var fixedColumns = 2;
    if(availWidth < 630){
        fixedColumns = 1;
    }
    
        let table = new DataTable('#example_all', {
        order: [[6, 'desc']],
        fixedColumns: {
            left: fixedColumns
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_test_getdata_all') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_month_day":$('#search_month_day').val() || [],
                "search_year":$('#search_year').val() || []
            },      
        },
        colReorder: true,
        columns: [
            // { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'date' },
            { data: 'service' },
            { data: 'form' },
            { data: 'total' },
            { data: 'remark' },
            // { data: 'remark_manager' },
            { data: 'status' }
        ],
        columnDefs: [],
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
        $(".toggle-vis").change(function(e) {
            e.preventDefault();
            let columnIdx = e.target.getAttribute('data-column');
            let column = table.column(columnIdx);
            column.visible(!column.visible());
        });
    
    get_form_all();
}
function search_data_m(){
    let table_m = new DataTable('#example_m', {
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
    searchDelay: 500,
    processing: true,
    scrollCollapse: true,
    ordering:false,
    "ajax": {
        "url": "{{ url(Request::segment(1).'/table_test_getdata_m') }}",
        "type": 'POST', 
        "data" : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score_m').val() || [],
            "search_attendance_score":$('#search_attendance_score_m').val() || [],
            "search_status":$('#search_status_m').val() || [],
            "search_section":$('#search_section_m').val() || [],
            "search_form":$('#search_form').val() || [],
            "search_year":$('#search_year').val() || []
        },      
    },
    colReorder: true,
    columns: [
        { data: 'data_id' },
    ],
    columnDefs: [],
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
    
    table_m.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = table_m.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
        }
    });
    $(".toggle-vis").change(function(e) {
        e.preventDefault();
        let columnIdx = e.target.getAttribute('data-column');
        let column = table_m.column(columnIdx);
        column.visible(!column.visible());
    });
   $('.sec_active').html(`${$("#search_section_m option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
   get_form_m();
}
function gettitle(id,number,no,check,score_id,code,name){
    console.log(check);
    if(check == '1'){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_compliance_attendance") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":score_id,
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                var cal2 = parseFloat(10)-(parseFloat(result.attendance_abt)+parseFloat(result.attendance_vwar*2)+parseFloat(result.attendance_wwar*5)+parseFloat(result.attendance_sus*10));
                $('.Compliance_ABT').html(result.attendance_abt);
                $('.Compliance_VWAR').html(result.attendance_vwar);
                $('.Compliance_WWAR').html(result.attendance_wwar);
                $('.Compliance_SUS').html(result.attendance_sus);
                $('.Compliance_ABT_cal').html(result.attendance_abt);
                $('.Compliance_VWAR_cal').html(parseFloat(result.attendance_vwar*2));
                $('.Compliance_WWAR_cal').html(parseFloat(result.attendance_wwar*5));
                $('.Compliance_SUS_cal').html(parseFloat(result.attendance_sus*10));
                $('.Compliance_TOTAL').html((cal2>0?cal2:1));
                $('.showname').html(code+' - '+name);
                var newcal2 = 0;
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
                $('.showscore').html('Score = '+number_format2(cal2x));
            }
        });
    }
    if(check == '2'){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_compliance_attendance") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":score_id,
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                var cal2 = parseFloat(result.attendance_sl)+parseFloat(result.attendance_pl)+parseFloat(result.attendance_late)+parseFloat(result.attendance_abs);
                $('.Attendance_SL').html(result.attendance_sl);
                $('.Attendance_PL').html(result.attendance_pl);
                $('.Attendance_LATE').html(result.attendance_late);
                $('.Attendance_ABS').html(result.attendance_abs);
                $('.Attendance_TOTAL').html(number_format2(cal2,2));
                $('.showname').html(code+' - '+name);
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
                $('.showscore').html('Score = '+number_format2(cal2x));
            }
        });
    }
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/gettitle") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":id,
            "number":number,
            "search_year":$('#search_year').val()
        },
        success: function (result) { 
            if(result.data2){
                if($("#isLocale").val() == '1'){
                    if(number == '0.1'){
                        // $('.detail_topic').html(`
                        //     <h5 class="mb-2 title1">${no}.Compliance with Company Regulations<span class="fw-normal text-gray-700">(x${result.compliance_weight})</span></h5>
                        //     <h6 class="mb-0 ps-4">Above Standard<span class="fw-normal">(8-10)</span></h6>
                        //     <p class="ps-4">Excellent behavior, always follows company rules and regulations and sets a good example for others</p>
                        //     <h6 class="mb-0 ps-4">Standard <span class="fw-normal">(4-7)</span></h6>
                        //     <p class="ps-4">Good behavior, follows company rules and regulations</p>
                        //     <h6 class="mb-0 ps-4">Below Standard <span class="fw-normal">(1-3)</span></h6>
                        //     <p class="ps-4">Poor behavior, dose not follow company rules and regulations and has bad influence on others</p>
                        // `);
                        $('.detail_topic2').html(`
                            <h5 class="mb-2 title1">${no}.Compliance with Company Regulations<span class="fw-normal text-gray-700">(x${result.compliance_weight})</span></h5>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">Above Standard</h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(8-10)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">Excellent behavior, always follows company rules and regulations and sets a good example for others</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">Standard</h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(4-7)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">Good behavior, follows company rules and regulations</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">Below Standard</h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(1-3)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">Poor behavior, dose not follow company rules and regulations and has bad influence on others</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }else if(number == '0'){
                        // $('.detail_topic').html(`
                        //     <h4 class="mb-2 title1">${no}.Attendance - Based on leaves of personal, sick, company special and late ot work : <span class="fw-normal text-gray-700">(x${result.criteria_weight})</span></h4>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">0-2 days = 10, 3-4 days = 9, 5-6 days = 8</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //         <p class="ps-4 title7">15-16 days = 3, 17-18 days = 2, 19-20 days = 1</p>
                        //         </div>
                        //     </div>
                        // `);
                        $('.detail_topic2').html(`
                            <h4 class="mb-2 title1" style="font-size: 15px !important;">${no}.Attendance - Based on leaves of personal, sick, company special and late ot work : <span class="fw-normal text-gray-700">(x${result.criteria_weight})</span></h4>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">0-2 days = 10, 3-4 days = 9, 5-6 days = 8</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title7 m-0">15-16 days = 3, 17-18 days = 2, 19-20 days = 1</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }else{
                        // $('.detail_topic').html(`
                        //     <h4 class="mb-2 title1">${no}.${result.data.criteria_en} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h4>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">${result.data.detail_high_en}</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">${result.data.detail_medium_en}</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_en} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //         <p class="ps-4 title7">${result.data.detail_low_en}</p>
                        //         </div>
                        //     </div>
                        // `);
                        $('.detail_topic2').html(`
                            <h4 class="mb-2 title1" style="font-size: 15px !important;">${no}.${result.data.criteria_en} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h4>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">${result.data.detail_high_en}</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">${result.data.detail_medium_en}</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_en} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                    <p class="ps-4 title7 m-0">${result.data.detail_low_en}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }
                }else{
                    if(number == '0.1'){
                        // $('.detail_topic').html(`
                        //     <h5 class="mb-2 title1">${no}.การปฏิบัติตามกฎระเบียบของบริษัท<span class="fw-normal text-gray-700">(x${result.compliance_weight})</span></h5>
                        //     <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน<span class="fw-normal">(8-10)</span></h6>
                        //     <p class="ps-4">ประพฤติตนดีเยี่ยม, ปฏิบัติตามกฎและข้อบังคับของบริษัทอยู่เสมอและเป็นตัวอย่างที่ดีแก่ผู้อื่น</p>
                        //     <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                        //     <p class="ps-4">ประพฤติตนดี, ปฏิบัติตามกฎและข้อบังคับของบริษัท</p>
                        //     <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                        //     <p class="ps-4">มีพฤติกรรมที่ไม่ดี ไม่ค่อยปฏิบัติตามกฎของบริษัทฯ และเป็นตัวอย่างที่ไม่ดีต่อพนักงานท่านอื่น</p>
                        // `);
                        $('.detail_topic2').html(`
                            <h5 class="mb-2 title1">${no}.การปฏิบัติตามกฎระเบียบของบริษัท<span class="fw-normal text-gray-700">(x${result.compliance_weight})</span></h5>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน<span class="fw-normal">(8-10)</span></h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(8-10)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">ประพฤติตนดีเยี่ยม, ปฏิบัติตามกฎและข้อบังคับของบริษัทอยู่เสมอและเป็นตัวอย่างที่ดีแก่ผู้อื่น</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(4-7)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">ประพฤติตนดี, ปฏิบัติตามกฎและข้อบังคับของบริษัท</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(1-3)</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 m-0">มีพฤติกรรมที่ไม่ดี ไม่ค่อยปฏิบัติตามกฎของบริษัทฯ และเป็นตัวอย่างที่ไม่ดีต่อพนักงานท่านอื่น</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }else if(number == '0'){
                        // $('.detail_topic').html(`
                        //     <h4 class="mb-2 title1">${no}.สถิติการมาทํางาน - พิจารณาตามจำนวนวันลากิจป่วยกิจบริษัทและสาย <span class="fw-normal text-gray-700">(x${result.criteria_weight})</span></h4>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">0-2 วัน = 10, 3-4 วัน = 9, 5-6 วัน = 8</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">7-8 วัน = 7, 9-10 วัน = 6, 11-12 วัน = 5, 13-14 วัน = 4</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //         <p class="ps-4 title7">15-16 วัน = 3, 17-18 วัน = 2, 19-20 วัน = 1</p>
                        //         </div>
                        //     </div>
                        // `);
                        $('.detail_topic2').html(`
                            <h4 class="mb-2 title1" style="font-size: 15px !important;">${no}.สถิติการมาทํางาน - พิจารณาตามจำนวนวันลากิจป่วยกิจบริษัทและสาย <span class="fw-normal text-gray-700">(x${result.criteria_weight})</span></h4>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">0-2 วัน = 10, 3-4 วัน = 9, 5-6 วัน = 8</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">7-8 วัน = 7, 9-10 วัน = 6, 11-12 วัน = 5, 13-14 วัน = 4</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title7 m-0">15-16 วัน = 3, 17-18 วัน = 2, 19-20 วัน = 1</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }else{
                        // $('.detail_topic').html(`
                        //     <h4 class="mb-2 title1">${no}.${result.data.criteria_th} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h4>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">${result.data.detail_high_th}</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //             <p class="ps-4 title3">${result.data.detail_medium_th}</p>
                        //         </div>
                        //     </div>
                        //     <div class="row g-3">
                        //         <div class="col-6 col-sm-2 col-md-2">
                        //             <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_th} </h6>
                        //         </div>
                        //         <div class="col-6 col-sm-1 col-md-1">
                        //             <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                        //         </div>
                        //         <div class="col-12 col-sm-9 col-md-9">
                        //         <p class="ps-4 title7">${result.data.detail_low_th}</p>
                        //         </div>
                        //     </div>
                        // `);
                        $('.detail_topic2').html(`
                            <h4 class="mb-2 title1" style="font-size: 15px !important;">${no}.${result.data.criteria_th} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h4>
                            <div class="row g-3">
                                <div class="col-4 col-sm-4 col-md-4 bg-light-success" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title2">${result.data2[2].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">${result.data.detail_high_th}</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-warning" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title4">${result.data2[1].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                        <p class="ps-4 title3 m-0">${result.data.detail_medium_th}</p>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 bg-light-danger" style="display: flex;align-items: center;justify-content: center;border: 1px solid;">
                                    <div class="col-6 col-sm-4 col-md-4">
                                        <h6 class="mb-0 ps-4 title6">${result.data2[0].score_level_th} </h6>
                                    </div>
                                    <div class="col-6 col-sm-1 col-md-1">
                                        <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span>
                                    </div>
                                    <div class="col-6 col-sm-7 col-md-7">
                                    <p class="ps-4 title7 m-0">${result.data.detail_low_th}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('.detail_topic2').css('background-color','#ffffff');
                        $('.detail_topic2').css('border-radius','8px');
                        $('.detail_topic2').css('border','1px solid');
                    }   
                }
            }
        }
    });

    // if($("#isLocale").val() == '1'){
    //     if(number == 1){
    //         $('.title1').html(`1.Knowledge in job <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`Expert in all facets of the job, can tech others how to do.`);
    //         $('.title5').html(`Has sufficient knowledge of how to do the job.`);
    //         $('.title7').html(`Needs further coaching / training on how to do his/her job.`);
    //     }else if(number == 2){
    //         $('.title1').html(`2.Quality of Work <span class="fw-normal text-gray-700">(x2)</span>`);
    //         $('.title3').html(`Your quality of work is always excellent and exceeds expectation.`);
    //         $('.title5').html(`Your quality of work meets the standard on a consistent basis.`);
    //         $('.title7').html(`Your quality of work must improve immediately by increasing output, accuracy, speed and/or organization.`);
    //     }else if(number == 3){
    //         $('.title1').html(`3.Team Player <span class="fw-normal text-gray-700">(x0.5)</span>`);
    //         $('.title3').html(`Able to work effectively with others, always welcomed as a team member, open to feedback from others.`);
    //         $('.title5').html(`Usually able to work effectively with others.`);
    //         $('.title7').html(`Has problems working with others, or create conflicts, or unable to accept feedback from others.`);
    //     }else if(number == 4){
    //         $('.title1').html(`4.Job Attitude <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`Accepts job assignments with enthusiasm and a positive attitude.`);
    //         $('.title5').html(`Accepts job assignments willingly`);
    //         $('.title7').html(`Accepts job assignments with poor attitude, or finds excuses to avoid job assignments`);
    //     }else if(number == 5){
    //         $('.title1').html(`5.Work in a Safe Way <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`Follows safety rules, always uses safety equipment, advises others to follow, and reports unsafe conditions`);
    //         $('.title5').html(`Follows safety rules and always uses safety equipment`);
    //         $('.title7').html(`Does not folloe safety rules, rarely uses safety equipment`);
    //     }else if(number == 6){
    //         $('.title1').html(`6.Participation in Company Activities <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`Enthusiastically participates in company activities, including taking leading role(s) if asked`);
    //         $('.title5').html(`Participates as required in company activities`);
    //         $('.title7').html(`Exhibitd a negative attitude when joining company activities`);
    //     }else if(number == 7){
    //         $('.title1').html(`7.Initiative and Innovation <span class="fw-normal text-gray-700">(x0.5)</span>`);
    //         $('.title3').html(`Always has suggestions or ideas on how to improve`);
    //         $('.title5').html(`Occasionallu has suggestions or ideas on how to improve`);
    //         $('.title7').html(`Rarely has suggestions or ideas on how to improve`);
    //     }else if(number == 8){
    //         $('.title1').html(`8.Compliance with Company Regulations <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`Excellent behavior, always follows company rules and regulations and sets a good example for others`);
    //         $('.title5').html(`Good behavior, follows company rules and regulations`);
    //         $('.title7').html(`Poor behavior, does not follow company rules and regulations and has bad influence on others`);
    //     }else{
    //         $('.title1').html(`9.Attendance <span class="fw-normal text-gray-700">(x2)</span>`);
    //         $('.title3').html(`0-2 days = 10, 3-4 days = 9, 5-6 days = 8`);
    //         $('.title5').html(`7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4`);
    //         $('.title7').html(`15-16 days = 3, 17-18 days = 2, 19-20 days = 1`);
    //     }
    // }else{
    //     if(number == 1){
    //         $('.title1').html(`1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 2){
    //         $('.title1').html(`2.คุณภาพงาน <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 3){
    //         $('.title1').html(`3.การทำงานเป็นทีม <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 4){
    //         $('.title1').html(`4.ทัศนคติในการทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 5){
    //         $('.title1').html(`5.ความปลอดภัยในการทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 6){
    //         $('.title1').html(`6.ความร่วมมือในกิจกรรมของบริษัท <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 7){
    //         $('.title1').html(`7.ความคิดริเริ่มและสร้างสรรค์ <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else if(number == 8){
    //         $('.title1').html(`8.การปฏิบัติตามกฎระเบียบของบริษัท <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }else{
    //         $('.title1').html(`9.สถิติการมาทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
    //         $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
    //         $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
    //         $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
    //     }
    // }
    
}
function gettitle_m(id,number,no,check,score_id){
    console.log(check);
    if(check == '1'){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_compliance_attendance") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":score_id,
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                var cal1 = parseFloat(result.attendance_abt)+parseFloat(result.attendance_vwar)+parseFloat(result.attendance_wwar)+parseFloat(result.attendance_sus);
                $('.Compliance_ABT').html(result.attendance_abt);
                $('.Compliance_VWAR').html(result.attendance_vwar);
                $('.Compliance_WWAR').html(result.attendance_wwar);
                $('.Compliance_SUS').html(result.attendance_sus);
                $('.Compliance_TOTAL').html(cal1);
            }
        });
    }
    if(check == '2'){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_compliance_attendance") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":score_id,
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                var cal2 = parseFloat(result.attendance_sl)+parseFloat(result.attendance_pl)+parseFloat(result.attendance_late)+parseFloat(result.attendance_abs);
                $('.Attendance_SL').html(result.attendance_sl);
                $('.Attendance_PL').html(result.attendance_pl);
                $('.Attendance_LATE').html(result.attendance_late);
                $('.Attendance_ABS').html(result.attendance_abs);
                $('.Attendance_TOTAL').html(number_format2(cal2,2));
            }
        });
    }
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/gettitle") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":id,
            "number":number,
            "search_year":$('#search_year').val()
        },
        success: function (result) { 
            if(result.data2){
                if($("#isLocale").val() == '1'){
                    if(number == '0.1'){
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.Compliance with Company Regulations<span class="fw-normal text-gray-700">(x${result.data.compliance_weight})</span></h5>
                            <h6 class="mb-0 ps-4">Above Standard<span class="fw-normal">(8-10)</span></h6>
                            <p class="ps-4">Excellent behavior, always follows company rules and regulations and sets a good example for others</p>
                            <h6 class="mb-0 ps-4">Standard <span class="fw-normal">(4-7)</span></h6>
                            <p class="ps-4">Good behavior, follows company rules and regulations</p>
                            <h6 class="mb-0 ps-4">Below Standard <span class="fw-normal">(1-3)</span></h6>
                            <p class="ps-4">Poor behavior, dose not follow company rules and regulations and has bad influence on others</p>
                        `);
                    }else if(number == '0'){
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.Attendance <span class="fw-normal text-gray-700">(x${result.data.criteria_weight})</span></h5>
                            <h6 class="mb-0 ps-4">${result.data2[2].score_level_en} <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span></h6>
                            <p class="ps-4">0-2 days = 10, 3-4 days = 9, 5-6 days = 8</p>
                            <h6 class="mb-0 ps-4">${result.data2[1].score_level_en} <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span></h6>
                            <p class="ps-4">7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4</p>
                            <h6 class="mb-0 ps-4">${result.data2[0].score_level_en} <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span></h6>
                            <p class="ps-4">15-16 days = 3, 17-18 days = 2, 19-20 days = 1</p>
                        `);
                    }else{
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.${result.data.criteria_en} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h5>
                            <h6 class="mb-0 ps-4">${result.data2[2].score_level_en} <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_high_en}</p>
                            <h6 class="mb-0 ps-4">${result.data2[1].score_level_en} <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_medium_en}</p>
                            <h6 class="mb-0 ps-4">${result.data2[0].score_level_en} <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_low_en}</p>
                        `);
                    }
                }else{
                    if(number == '0.1'){
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.การปฏิบัติตามกฎระเบียบของบริษัท<span class="fw-normal text-gray-700">(x${result.data.compliance_weight})</span></h5>
                            <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน<span class="fw-normal">(8-10)</span></h6>
                            <p class="ps-4">ประพฤติตนดีเยี่ยม, ปฏิบัติตามกฎและข้อบังคับของบริษัทอยู่เสมอและเป็นตัวอย่างที่ดีแก่ผู้อื่น</p>
                            <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                            <p class="ps-4">ประพฤติตนดี, ปฏิบัติตามกฎและข้อบังคับของบริษัท</p>
                            <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                            <p class="ps-4">มีพฤติกรรมที่ไม่ดี ไม่ค่อยปฏิบัติตามกฎของบริษัทฯ และเป็นตัวอย่างที่ไม่ดีต่อพนักงานท่านอื่น</p>
                        `);
                    }else if(number == '0'){
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.Attendance <span class="fw-normal text-gray-700">(x${result.data.criteria_weight})</span></h5>
                            <h6 class="mb-0 ps-4">${result.data2[2].score_level_th} <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span></h6>
                            <p class="ps-4">0-2 days = 10, 3-4 days = 9, 5-6 days = 8</p>
                            <h6 class="mb-0 ps-4">${result.data2[1].score_level_th} <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span></h6>
                            <p class="ps-4">7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4</p>
                            <h6 class="mb-0 ps-4">${result.data2[0].score_level_th} <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span></h6>
                            <p class="ps-4">15-16 days = 3, 17-18 days = 2, 19-20 days = 1</p>
                        `);
                    }else{
                        $('.showdetail_score'+score_id).html(`
                            <h5 class="mb-2 title1">${no}.${result.data.criteria_th} <span class="fw-normal text-gray-700">(x${result.data.topic_weight})</span></h5>
                            <h6 class="mb-0 ps-4">${result.data2[2].score_level_th} <span class="fw-normal">(${result.data2[2].score_start}-${result.data2[2].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_high_th}</p>
                            <h6 class="mb-0 ps-4">${result.data2[1].score_level_th} <span class="fw-normal">(${result.data2[1].score_start}-${result.data2[1].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_medium_th}</p>
                            <h6 class="mb-0 ps-4">${result.data2[0].score_level_th} <span class="fw-normal">(${result.data2[0].score_start}-${result.data2[0].score_end})</span></h6>
                            <p class="ps-4">${result.data.detail_low_th}</p>
                        `);
                    }   
                }
            }
        }
    });
}
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

function get_section(){
    console.log($("#search_section option:selected").text());
    console.log($("#search_section option:selected").val());
    $('.sec_active').html(`${$("#search_section option:selected").text()} <small class="fw-normal total_employee_sec">(0)</small>`);
}
function active_tab_form(form){
    $('#search_form').val(form);
    $('.allactive').removeAttr('active');
    $('.example_all').css('display','none');
    // $('.detail_topic').css('display','none !important');
    // $('.detail_topic2').css('display','none !important');
    if(form == 'F1'){
        $('#tabF_link_1').attr('active');
        $('.toggleF1').css('display','block');
        $('.toggleF2').css('display','none');
        // $('.toggleF3').css('display','none');
        $('.toggleF4').css('display','none');
        // $('.example_all').css('display','none');
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_form_2") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_year":$('#search_year').val() || []
            },
            success: function (result) { 
                var html = ``;
                for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
                    html += `<th class="text-center">${i}</th>`;
                }
                $('.check_th').html(html);
                $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
            }
        });
    }else if(form == 'F2'){
        $('#tabF_link_2').attr('active');
        $('.toggleF1').css('display','none');
        $('.toggleF2').css('display','block');
        // $('.toggleF3').css('display','none');
        $('.toggleF4').css('display','none');
        // $('.example_all').css('display','none');
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_form_2") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_year":$('#search_year').val() || []
            },
            success: function (result) { 
                var html = ``;
                for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
                    html += `<th class="text-center">${i}</th>`;
                }
                $('.check_th').html(html);
                $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
            }
        });
    }else if(form == 'F3'){
        $('#tabF_link_3').attr('active');
        $('.toggleF1').css('display','none');
        $('.toggleF2').css('display','none');
        // $('.toggleF3').css('display','block');
        $('.toggleF4').css('display','none');
        // $('.example_all').css('display','none');
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_form_2") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_year":$('#search_year').val() || []
            },
            success: function (result) { 
                var html = ``;
                for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
                    html += `<th class="text-center">${i}</th>`;
                }
                $('.check_th').html(html);
                $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
            }
        });
    }else{
        $('#tabF_link_4').attr('active');
        $('.toggleF1').css('display','none');
        $('.toggleF2').css('display','none');
        // $('.toggleF3').css('display','none');
        $('.toggleF4').css('display','block');
        // $('.example_all').css('display','none');
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_form_2") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_complaince_score":$('#search_complaince_score').val() || [],
                "search_attendance_score":$('#search_attendance_score').val() || [],
                "search_status":$('#search_status').val() || [],
                "search_section":$('#search_section').val() || [],
                "search_form":$('#search_form').val() || [],
                "search_year":$('#search_year').val() || []
            },
            success: function (result) { 
                var html = ``;
                for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
                    html += `<th class="text-center">${i}</th>`;
                }
                $('.check_th').html(html);
                $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
            }
        });
    }
    $('.setblinkAll').removeClass('board'); 

    $('.detail_topic2').css('display','none !important');
    $('.detail_topic2').html('');
    $('.detail_topic2').css('background-color','');
    $('.detail_topic2').css('border-radius','');
    $('.detail_topic2').css('border','');

        setTimeout(() => {
            // if(availWidth > 767){
                destroy_table();
            // }
            // if(availWidth <= 767){
            //     destroy_table_m();
            // }
        }, 200);
    
}
function active_tab_all(form){
    $('#search_form').val(form);
    $('.allactive').removeAttr('active');
    

    $('#tabF_link_5').attr('active');
    $('.example').css('display','none');
    $('.example2').css('display','none');
    $('.example3').css('display','none');
    $('.example4').css('display','none');
    $('.example_all').css('display','');
    destroy_table_all();
    // $('.detail_topic').css('display','none !important');
    // $('.detail_topic').html('');
    $('.detail_topic2').css('display','none !important');
    $('.detail_topic2').html('');
    $('.detail_topic2').css('background-color','');
    $('.detail_topic2').css('border-radius','');
    $('.detail_topic2').css('border','');
}
function get_form(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_form") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score').val() || [],
            "search_attendance_score":$('#search_attendance_score').val() || [],
            "search_status":$('#search_status').val() || [],
            "search_section":$('#search_section').val() || [],
            "search_form":$('#search_form').val() || [],
            "search_month_day":$('#search_month_day').val() || [],
            "search_year":$('#search_year').val() || []
        },
        success: function (result) { 
            // $('.setblinkAll').removeClass('board');
            // if(result.checkCountF1 > 0){
            //     $('.setblink1').addClass('board');
            // }
            // if(result.checkCountF2 > 0){
            //     $('.setblink2').addClass('board');
            // }
            // if(result.checkCountF3 > 0){
            //     $('.setblink3').addClass('board');
            // }
            // if(result.checkCountF4 > 0){
            //     $('.setblink4').addClass('board');
            // }
            $('.check_value_null').val(parseFloat(result.checkCountF1)+parseFloat(result.checkCountF2)+parseFloat(result.checkCountF3)+parseFloat(result.checkCountF4));
            $('.check_value_null_same').val(parseFloat(result.checkCountF1_same)+parseFloat(result.checkCountF2_same)+parseFloat(result.checkCountF3_same)+parseFloat(result.checkCountF4_same));
            $('.count_f1').text('('+result.f1+')');
            $('.count_f2').text('('+result.f2+')');
            $('.count_f3').text('('+result.f3+')');
            $('.count_f4').text('('+result.f4+')');
            var cal = parseFloat(result.f1)+parseFloat(result.f2)+parseFloat(result.f3)+parseFloat(result.f4);
            $('.total_employee_sec').text('('+cal+')');

            var html = ``;
            for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
                var topic_weight = '';
                if(result.count_topic_weight[i-1]){
                    console.log(result.count_topic_weight[i-1].topic_weight);
                    topic_weight = '(x'+result.count_topic_weight[i-1].topic_weight+')';
                }
                if(i == parseFloat(result.count_total_td+1)){
                    topic_weight = '(x'+result.compliance_weight+')';
                }
                if(i == parseFloat(result.count_total_td+2)){
                    topic_weight = '(x'+result.criteria_weight+')';
                }
                html += `<th class="text-center">${i}<br>${topic_weight}</th>`;
            }
            $('.check_th').html(html);
            $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
            // if($('#search_form').val() == "F1"){

            //     $('.check_th').html(`
            //         <th class="text-center">1</th>
            //         <th class="text-center">2</th>
            //         <th class="text-center">3</th>
            //         <th class="text-center">4</th>
            //         <th class="text-center">5</th>
            //         <th class="text-center">6</th>
            //         <th class="text-center">7</th>
            //         <th class="text-center">8</th>
            //         <th class="text-center">9</th>
            //     `);
            //     $('.check_colspan').attr('colspan','9');
            // }else if($('#search_form').val() == "F2"){
            //     $('.check_th').html(`
            //         <th class="text-center">1</th>
            //         <th class="text-center">2</th>
            //         <th class="text-center">3</th>
            //         <th class="text-center">4</th>
            //         <th class="text-center">5</th>
            //         <th class="text-center">6</th>
            //         <th class="text-center">7</th>
            //         <th class="text-center">8</th>
            //         <th class="text-center">9</th>
            //         <th class="text-center">10</th>
            //         <th class="text-center">11</th>
            //     `);
            //     $('.check_colspan').attr('colspan','11');
            // }else if($('#search_form').val() == "F3"){
            //     $('.check_th').html(`
            //         <th class="text-center">1</th>
            //         <th class="text-center">2</th>
            //         <th class="text-center">3</th>
            //         <th class="text-center">4</th>
            //         <th class="text-center">5</th>
            //         <th class="text-center">6</th>
            //         <th class="text-center">7</th>
            //         <th class="text-center">8</th>
            //         <th class="text-center">9</th>
            //     `);
            //     $('.check_colspan').attr('colspan','9');
            // }else{
            //     $('.check_th').html(`
            //         <th class="text-center">1</th>
            //         <th class="text-center">2</th>
            //         <th class="text-center">3</th>
            //         <th class="text-center">4</th>
            //         <th class="text-center">5</th>
            //         <th class="text-center">6</th>
            //         <th class="text-center">7</th>
            //         <th class="text-center">8</th>
            //         <th class="text-center">9</th>
            //         <th class="text-center">10</th>
            //     `);
            //     $('.check_colspan').attr('colspan','10');
            // }
            
        }
    });
}
function get_form_all(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_form_all") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score').val() || [],
            "search_attendance_score":$('#search_attendance_score').val() || [],
            "search_status":$('#search_status').val() || [],
            "search_section":$('#search_section').val() || [],
            "search_form":'F1',
            "search_month_day":$('#search_month_day').val() || [],
            "search_year":$('#search_year').val() || []
        },
        success: function (result) { 
            $('.check_value_null').val(parseFloat(result.checkCountF1)+parseFloat(result.checkCountF2)+parseFloat(result.checkCountF3)+parseFloat(result.checkCountF4));
            $('.check_value_null_same').val(parseFloat(result.checkCountF1_same)+parseFloat(result.checkCountF2_same)+parseFloat(result.checkCountF3_same)+parseFloat(result.checkCountF4_same));
            // $('.count_f1').text('('+result.f1+')');
            // $('.count_f2').text('('+result.f2+')');
            // $('.count_f3').text('('+result.f3+')');
            // $('.count_f4').text('('+result.f4+')');
            var cal = parseFloat(result.f1)+parseFloat(result.f2)+parseFloat(result.f3)+parseFloat(result.f4);
            $('.total_employee_sec').text('('+cal+')');

            // var html = ``;
            // for(var i = 1;i <= parseFloat(result.count_total_td+2);i++){
            //     html += `<th class="text-center">${i}</th>`;
            // }
            // $('.check_th').html(html);
            // $('.check_colspan').attr('colspan',parseFloat(result.count_total_td)+2);
        }
    });
}
function get_form_m(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_form") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score_m').val() || [],
            "search_attendance_score":$('#search_attendance_score_m').val() || [],
            "search_status":$('#search_status_m').val() || [],
            "search_section":$('#search_section_m').val() || [],
            "search_form":$('#search_form').val() || [],
            "search_year":$('#search_year').val() || []
        },
        success: function (result) { 
            $('.count_f1').text('('+result.f1+')');
            $('.count_f2').text('('+result.f2+')');
            $('.count_f3').text('('+result.f3+')');
            $('.count_f4').text('('+result.f4+')');
            var cal = parseFloat(result.f1)+parseFloat(result.f2)+parseFloat(result.f3)+parseFloat(result.f4);
            $('.total_employee_sec').text('('+cal+')');
            if($('#search_form').val() == "F1"){
                $('.check_th').html(`
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">6</th>
                    <th class="text-center">7</th>
                    <th class="text-center">8</th>
                    <th class="text-center">9</th>
                `);
                $('.check_colspan').attr('colspan','9');
            }else if($('#search_form').val() == "F2"){
                $('.check_th').html(`
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">6</th>
                    <th class="text-center">7</th>
                    <th class="text-center">8</th>
                    <th class="text-center">9</th>
                    <th class="text-center">10</th>
                    <th class="text-center">11</th>
                `);
                $('.check_colspan').attr('colspan','11');
            }else if($('#search_form').val() == "F3"){
                $('.check_th').html(`
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">6</th>
                    <th class="text-center">7</th>
                    <th class="text-center">8</th>
                    <th class="text-center">9</th>
                `);
                $('.check_colspan').attr('colspan','9');
            }else{
                $('.check_th').html(`
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                    <th class="text-center">6</th>
                    <th class="text-center">7</th>
                    <th class="text-center">8</th>
                    <th class="text-center">9</th>
                    <th class="text-center">10</th>
                `);
                $('.check_colspan').attr('colspan','10');
            }
            
        }
    });
}
function update_score(id,score,number){
    var total_score = $('#total_score'+id).val();
    // var cal = parseFloat(total_score)+(parseFloat(score)>=0?parseFloat(score):0);
    
    var cal_total = 0;
    var calAll = $('.calAll'+id); 
    
    var check_calAll = 0;
    
    var calAll_topic_weight = $('.calAll_topic_weight'+id); 
    var criteria_score_old = '';
    for(var i = 0;i < calAll.length;i++){
        var newi = i+1;
        if(newi == calAll.length){
            // if(calAll[i].value >= 19){
            //     calAll[i].value = 1;
            // }else if(calAll[i].value >= 17 && calAll[i].value <= 18){
            //     calAll[i].value = 2;
            // }else if(calAll[i].value >= 15 && calAll[i].value <= 16){
            //     calAll[i].value = 3;
            // }else if(calAll[i].value >= 13 && calAll[i].value <= 14){
            //     calAll[i].value = 4;
            // }else if(calAll[i].value >= 11 && calAll[i].value <= 12){
            //     calAll[i].value = 5;
            // }else if(calAll[i].value >= 9 && calAll[i].value <= 10){
            //     calAll[i].value = 6;
            // }else if(calAll[i].value >= 7 && calAll[i].value <= 8){
            //     calAll[i].value = 7;
            // }else if(calAll[i].value >= 5 && calAll[i].value <= 6){
            //     calAll[i].value = 8;
            // }else if(calAll[i].value >= 3 && calAll[i].value <= 4){
            //     calAll[i].value = 9;
            // }else if(calAll[i].value >= 0 && calAll[i].value <= 2){
            //     calAll[i].value = 10;
            // }
            console.log(parseFloat((calAll[i].value?calAll[i].value:0)));
            cal_total += parseFloat((calAll[i].value?calAll[i].value:0))*parseFloat(calAll_topic_weight[i].value);
            criteria_score_old += (calAll[i].value?calAll[i].value:'')+',';
        }else{
            console.log(parseFloat((calAll[i].value?calAll[i].value:0)));
            cal_total += parseFloat((calAll[i].value?calAll[i].value:0))*parseFloat(calAll_topic_weight[i].value);
            criteria_score_old += (calAll[i].value?calAll[i].value:'')+',';
        }
        console.log('check_calAll = '+calAll[i].value);
        if(parseFloat(calAll[i].value) < 1 || parseFloat(calAll[i].value) > 10){
            Swal.fire({
                title: "กรุณาระบุคะแนนตั้งแต่ 1-10 เท่านั้น",
                icon: "warning",
                allowOutsideClick: false,
            });
            calAll[i].value = '';
            check_calAll++;
            // $('.calAll'+id).val('');
        }
        if(parseFloat(calAll[i].value) == ''){
            Swal.fire({
                title: "กรุณาระบุคะแนน",
                icon: "warning",
                allowOutsideClick: false,
            });
            check_calAll++;
            // $('.calAll'+id).val('');
        }
    }
    if(check_calAll == 0){
        criteria_score_old = criteria_score_old.slice(0, -1);
        let split = criteria_score_old.split(",");
        let criteria_score_old_all = split.slice(0, split.length - 2).join(",") + ",";
        console.log('cal_total = '+cal_total);
        $('.total_score'+id).html(number_format2(cal_total,1));
        $('#total_score'+id).val(number_format2(cal_total,1));
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/update_score") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":id,
                "criteria_score_old_all":criteria_score_old_all,
                "score":(score>=0?score:0),
                "total_score":$('#total_score'+id).val(),
                "number":number,
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                
            }
        });
    }
}
function update_remark(id,remark){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/update_remark") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":id,
            "remark":remark,
            "search_year":$('#search_year').val()
        },
        success: function (result) { 
            
        }
    });
}

function evaluate_get_all(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/evaluate_get_all") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score').val() || [],
            "search_attendance_score":$('#search_attendance_score').val() || [],
            "search_status":$('#search_status').val() || [],
            "search_section":$('#search_section').val() || [],
            "search_form":$('#search_form').val() || [],
            "search_month_day":$('#search_month_day').val() || [],
            "search_year":$('#search_year').val() || []
        },
        success: function (result) { 
            $('.all_employee').text(result.data);
            $('.all_inprogress').text(result.data1);
            $('.all_reject').text(result.data2);
            $('.all_finish').text(result.data3);
        }
    });
}
function freeze(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_form_all") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_complaince_score":$('#search_complaince_score').val() || [],
            "search_attendance_score":$('#search_attendance_score').val() || [],
            "search_status":$('#search_status').val() || [],
            "search_section":$('#search_section').val() || [],
            "search_form":'F1' || [],
            "search_year":$('#search_year').val() || []
        },
        success: function (result) { 
            $('.check_value_null').val(parseFloat(result.checkCountF1)+parseFloat(result.checkCountF2)+parseFloat(result.checkCountF3)+parseFloat(result.checkCountF4));
            $('.check_value_null_same').val(parseFloat(result.checkCountF1_same)+parseFloat(result.checkCountF2_same)+parseFloat(result.checkCountF3_same)+parseFloat(result.checkCountF4_same));
            if($('.check_value_null').val() > 0){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/check_value_null") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_complaince_score":$('#search_complaince_score').val() || [],
                        "search_attendance_score":$('#search_attendance_score').val() || [],
                        "search_status":$('#search_status').val() || [],
                        "search_section":$('#search_section').val() || [],
                        "search_form":$('#search_form').val() || [],
                        "search_month_day":$('#search_month_day').val() || [],
                        "search_year":$('#search_year').val() || []
                    },
                    success: function (result) { 
                        $('.setblinkAll').removeClass('board');
                        if(result.checkCountF1 > 0){
                            $('.setblink1').addClass('board');
                        }
                        if(result.checkCountF2 > 0){
                            $('.setblink2').addClass('board');
                        }
                        if(result.checkCountF3 > 0){
                            $('.setblink3').addClass('board');
                        }
                        if(result.checkCountF4 > 0){
                            $('.setblink4').addClass('board');
                        }
                        Swal.fire({
                            title: "{{ __('Found some information. No score specified.') }}",
                            text: "{{ __('Please check again.') }}",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }
                });
            }else if($('.check_value_null_same').val() > 0){
                // Swal.fire({
                //     title: "{{ __('Found some information at The specified score is the same.') }}",
                //     text: "{{ __('Please check again.') }}",
                //     icon: "warning",
                //     allowOutsideClick: false,
                // });
                Swal.fire({
                    title: '{{ __('Found some information at The specified score is the same.') }}',
                    text: "Are you sure ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/freeze") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "search_complaince_score":$('#search_complaince_score').val() || [],
                                "search_attendance_score":$('#search_attendance_score').val() || [],
                                "search_status":$('#search_status').val() || [],
                                "search_section":$('#search_section').val() || [],
                                "search_form":$('#search_form').val() || [],
                                "search_month_day":$('#search_month_day').val() || [],
                                "search_year":$('#search_year').val() || []
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
                            url: '{{ url(Request::segment(1)."/freeze") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "search_complaince_score":$('#search_complaince_score').val() || [],
                                "search_attendance_score":$('#search_attendance_score').val() || [],
                                "search_status":$('#search_status').val() || [],
                                "search_section":$('#search_section').val() || [],
                                "search_form":$('#search_form').val() || [],
                                "search_month_day":$('#search_month_day').val() || [],
                                "search_year":$('#search_year').val() || []
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
function checknumber(ele,id){
    var vchar = String.fromCharCode(event.keyCode);
    if ((vchar<'0' || vchar>'9')) return false;
    ele.onKeyPress=vchar;
}
function export_excel_evaluate(){
    var search_complaince_score = $('#search_complaince_score').val() || [];
    var search_attendance_score = $('#search_attendance_score').val() || [];
    var search_status = $('#search_status').val() || [];
    var search_section = $('#search_section').val() || [];
    var search_month_day = $('#search_month_day').val() || [];
    var search_year = $('#search_year').val() || [];
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Export'
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url(Request::segment(1).'/export_excel_evaluate/') }}"+"?search_complaince_score="+search_complaince_score+"&search_attendance_score="+search_attendance_score+"&search_status="+search_status+"&search_section="+search_section+"&search_month_day="+search_month_day+"&search_year="+search_year;
        }
    });
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
    /* table.dataTable.table-striped > tbody > tr:nth-of-type(2n) > *{
        padding: 0px !important;
    }
    table.dataTable.table-striped > tbody > tr:nth-of-type(2n+1) > *{
        padding: 0px !important;
    } */
    #example_m:not(.table-bordered) tr:first-child, #example_m:not(.table-bordered) th:first-child, #example_m:not(.table-bordered) td:first-child {
        padding: 0px !important;
    }
    .board {
        /* width: 420px;
        padding: 4rem;
        border: 10px dotted #53ff50; */
    }

    .board span {
        /* font-size: 4rem;
        margin: 1.25rem 0;
        letter-spacing: 4px;
        text-align: center; */
        /* animation: blink 4s infinite alternate; */
        text-shadow: 0 0 0 transparent, 0 0 5px #f00, 0 0 10px #f00, 0 0 20px #f00, 0 0 40px #f00,
        0 0 100px #f00, 0 0 200px #f00, 0 0 500px #f00;
    }
    #author.moveUp {
        padding: 4rem 1rem;
        transition: all 0.5s ease-in-out;
        opacity: 1;
    }

    @keyframes blink {
        41% {
            opacity: 1;
        }
        43% {
            opacity: 0.6;
        }
        45% {
            opacity: 1;
        }
        47% {
            opacity: 0.8;
        }
        50% {
            opacity: 1;
        }
    }
    .board span {
        animation: blink 4s infinite alternate;
    }
    table.dataTable {
        font-size: 14px;
    }
    .table th, .table:not(.table-bordered) th ,.d-inline-flex,.d-inline-flex button,.sec_active,.rounded-pill,
    .select2-selection__rendered{
        font-size: 14px !important;
    }
    /* .symbol.symbol-40px .symbol-label {
        width: 1.75rem;
        height: 1.75rem;
    } */
    .symbol.symbol-40px .symbol-label {
        width: 30px;
        height: 30px;
    }
    @media (max-width: 768px) {
        .detail_topic2{
            /* display:none; */
            width: 100% !important;
        }
    }
    @media (max-width: 575px) {
        .detail_topic2{
            display:none;
            /* width: 100% !important; */
        }
    }
</style>
