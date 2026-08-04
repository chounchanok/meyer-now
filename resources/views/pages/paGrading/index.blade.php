<x-default-layout>

    @section('title')
    {{ __('PA Grading') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('paGrading.index') }}
    @endsection

    <!--begin::Row-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-flag fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('PA Grading') }}
                    </span>
                    </h3>
                    <!--end::Title-->

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    <div class="d-md-block">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                <select class="form-select" data-control="select2" id="search_division" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_department();">
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                <select class="form-select" data-control="select2" id="search_department" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_section();">
                                    <!-- <option value="all">All</option> -->
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                <select class="form-select" data-control="select2" id="search_section" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_eva_list();">
                                    <!-- <option value="all">All</option> -->
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1"class="form-label mb-0">Monthly/Daily</label>
                                <select class="form-select" data-control="select2" id="search_month_day" name="search_month_day" data-placeholder="-Choose-" onchange="destroy_table();">
                                    <option value="all" selected>All</option>
                                    <option value="2">Monthly</option>
                                    <option value="1" >Daily</option>
                                </select>
                            </div>
                            
                            <div class="col-8 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Status')}}</label>
                                <select class="form-select" data-control="select2" id="search_status" data-placeholder="-Choose-" onchange="destroy_table();">
                                    <!-- <option value="0">All employees</option> -->
                                    <option value="1">Submit to HR</option>
                                    <option value="2">Wait for HR Grading</option>
                                    <option value="3">HR Grading Complated</option>
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
                            <!-- <div class="col-4 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                                <button type="button" class="btn btn-primary rounded-pill" onclick="destroy_table();">
                                    <i class="ki-outline ki-magnifier"></i>
                                    {{__('Search')}}
                                </button>
                            </div> -->
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-12">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluator')}}</label>
                                <select class="form-select" data-control="select2" id="search_employee_no" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="destroy_table();">
                                    <!-- <option value="all">All</option> -->
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="d-black d-md-none" style="display:none;">
                        <div>
                            <div class="collapse" id="collapseSearchMobile">
                                <div class="row g-3">
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

                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            <option>In progress</option>
                                            <option>Approved</option>
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
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ki-outline ki-magnifier"></i>
                                Search
                            </button>
                        </div>
                    </div>
                    <hr class="border-gray-400">
                    <div class="row">
                        <div class="col-sm-9">
                            <h6 class="fw-bold">Bell Curve information <span class="fw-normal">(Theoretical)</span></h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="">
                                        <tr class="text-center">
                                            <td></td>
                                            @if(!empty($bell_curve))
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
                                            <th><h1 class='badge {{$grade}} w-100 text-center fs-3 d-block py-2 mb-0'>{{$val->grade_name}}</h1></th>
                                            @endforeach
                                            @endif
                                            <th style="min-width: 100px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center bg-light">
                                            <td></td>
                                            @if(!empty($bell_curve))
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
                                            <td>
                                                {{$val->percent}}%
                                                <input type="hidden" id="bell_percent{{$val->grade_name}}" value="{{$val->percent}}">
                                            </td>
                                            @endforeach
                                            @endif
                                            <td></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Theoretical >>> </td>
                                            @if(!empty($bell_curve))
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
                                            <td class="total_theoretical_Level{{$val->grade_name}}"></td>
                                            @endforeach
                                            @endif
                                            <td class="bell_total_all1">0</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center bg-light-success">
                                            <td>Actual >>> </td>
                                            @if(!empty($bell_curve))
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
                                            <td class="total_adjust_Level{{$val->grade_name}}"></td>
                                            @endforeach
                                            @endif
                                            <td class="bell_total_all2">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <h6 class="fw-bold">{{__('Status')}}</h6>
                            <div class="card shadow-none rounded-3 p-3 mb-2">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-light">
                                        <i class="ki-outline ki-profile-user fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">All employees</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_employee">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 mb-2">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-light">
                                        <i class="ki-outline ki-profile-user fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Submit to HR</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_submit">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 bg-light-secondary mb-2">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-warning">
                                        <i class="ki-outline ki-loading fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Wait for HR Grading</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_inprogress">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 bg-light-success mb-3">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-success">
                                        <i class="ki-outline ki-check-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">HR Grading Completed</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_finish">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" position-relative">
                        <div class="tableMobile" style="height:40px"></div>
                        <!--begin::Toggle-->
                        <div style="position:absolute;top:0;left:0;z-index:99;">
                            @can('edit pa grading')
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#approveModalAll'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Approved</span>
                                        </a>
                                    </div> -->
                                    <!--end::Menu item-->

                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#editModalAll">
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-pencil fs-3 text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">{{__('Edit')}}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::Menu-->
                            </div>
                            @endcan
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
                                            <input checked type="checkbox" class="toggle-vis" data-column="1"> Evaluator
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="2"> Emp. no.
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="3"> Name - Surname
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="4"> Position
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="5"> Division
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="6"> Department
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="7"> Section
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="checkbox p-2">
                                            <label>
                                            <input checked type="checkbox" class="toggle-vis" data-column="11"> Status
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::Menu-->
                            </div>
                            @can('edit pa grading')
                            <div class="d-inline-flex AutoAdjust" style="display:none !important;">
                                <button type="button" class="btn btn-icon btn-warning rotate text-dark btn-xs me-1 p-2" data-bs-toggle="modal" data-bs-target="#adjustModalAll" style="width: 100%;">
                                    <i class="ki-solid ki-pencil fs-5" style="margin-right:10px;"></i>
                                    {{__('Auto Adjust')}}
                                </button>
                            </div>
                            @endcan
                        </div>
                        <!--end::Dropdown wrapper-->

                        
                        
                        <div class="table-responsive">
                            <table id="example" class="table table-striped rounded">
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th style="width:50px"><input type="checkbox" name="select-all" id="select-all"></th>
                                        <th>{{__('Evaluator')}}</th>
                                        <th>{{__('Emp. no.')}}</th>
                                        <th>{{__('Emp. Name')}}</th>
                                        <th>Position</th>
                                        <th>Div.</th>
                                        <th>Dept.</th>
                                        <th>Section</th>
                                        <th style="width:50px;">Theoretical G.</th>
                                        <th>{{__('score')}}</th>
                                        <th style="width:50px;">Adjust G.</th>
                                        <th>{{__('Status')}}</th>
                                        @can('edit pa grading')
                                        <th style="min-width:80px;">{{__('Action')}}</th>
                                        @endcan
                                    </tr>
                                </thead>
                            </table>

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

    <!--begin::approve modal-->
    <div class="modal fade" tabindex="-1" id="approveModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm approval') }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>{{ __('Confirm approval') }} ?</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="approveModal_update();">Confirm</button>
                    <input type="hidden" id="approveModal_id" value="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="approveModalAll">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm approval') }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>{{ __('Confirm approval') }} ?</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="approveModal_update_all();">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="adjustModalAll">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Confirm Auto Adjust</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>Confirm Auto Adjust ?</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="adjustModal_update_all();">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::approve modal-->
    <!--begin::edit modal-->
    <div class="modal fade" tabindex="-1" id="editModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Adjust grade</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div>
                        <p class="fw-bold mb-2">Adjust grade</p>
                        <select
                            class="form-select form-select-sm selectG editG_color editG_color_all mb-2"
                            id="edit_grade_select"
                        >
                            <option class="" value="">{{ __('Select') }}</option>
                            <option class="" value="AR">AR</option>
                            <option class="gradeP" value="P">P</option>
                            <option class="gradeA" value="A">A</option>
                            <option class="gradeB" value="B">B</option>
                            <option class="gradeC" value="C">C</option>
                            <option class="gradeD" value="D">D</option>
                            <option class="gradeE" value="E">E</option>
                            <option class="" value="U">U</option>
                            <option class="" value="CD">CD</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" onclick="editModal_update();">Submit</button>
                    <input type="hidden" id="editModal_id" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="theory_editModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Theoretical grade</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div>
                        <p class="fw-bold mb-2">Theoretical grade</p>
                        <select
                            class="form-select form-select-sm selectG editG_color editG_color_all mb-2"
                            id="edit_theoretical_grade_select"
                        >
                            <option class="" value="">{{ __('Select') }}</option>
                            <option class="" value="AR">AR</option>
                            <option class="gradeP" value="P">P</option>
                            <option class="gradeA" value="A">A</option>
                            <option class="gradeB" value="B">B</option>
                            <option class="gradeC" value="C">C</option>
                            <option class="gradeD" value="D">D</option>
                            <option class="gradeE" value="E">E</option>
                            <option class="" value="U">U</option>
                            <option class="" value="CD">CD</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" onclick="editModal_theoretical_update();">Submit</button>
                    <input type="hidden" id="edit_theoretical_Modal_id" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="editModalAll">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Adjust grade</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <div>
                        <p class="fw-bold mb-2">Adjust grade</p>
                        <select
                            class="form-select form-select-sm selectG editG_color editG_color_all mb-2"
                            id="edit_grade_select_all"
                        >
                            <option class="" value="">{{ __('Select') }}</option>
                            <option class="" value="AR">AR</option>
                            <option class="gradeP" value="P">P</option>
                            <option class="gradeA" value="A">A</option>
                            <option class="gradeB" value="B">B</option>
                            <option class="gradeC" value="C">C</option>
                            <option class="gradeD" value="D">D</option>
                            <option class="gradeE" value="E">E</option>
                            <option class="" value="U">U</option>
                            <option class="" value="CD">CD</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill btn-sm" onclick="editModal_update_all();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::reject modal-->
@push('scripts')
<script type="text/javascript">
$(function() {
    get_division();
    count_pa_grade();
    bell_curve_detail();
    if($('#search_employee_no').val().length > 0){
        $('.AutoAdjust').css('display','inline-flex');
    }   
});
// const availWidth = window.screen.availWidth;
// var fixedColumns = 3;
// if(availWidth < 630){
//     fixedColumns = 2;
// }
// let table = new DataTable('#example', {
//     fixedColumns: {
//         left: fixedColumns,
//     },
//     "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
//     searchDelay: 500,
//     processing: true,
//     // serverSide: true,
//     // scrollY: true,
//     // scrollX: true,
//     scrollCollapse: true,
//     "ajax": {
//         "url": "{{ url(Request::segment(1).'/table_paGrading_getdata') }}",
//         "type": 'POST', 
//         "data" : { 
//             "_token": "{{ csrf_token() }}",
//             "search_division":$('#search_division').val(),
//             "search_department":$('#search_department').val(),
//             "search_section":$('#search_section').val(),
//             "search_employee_no":$('#search_employee_no').val(),
//             "search_status":$('#search_status').val(),
//             "update_grade":'0'
//         },     
//     },
//     colReorder: true,
//     columns: [
//         { data: 'id' },
//         { data: 'evaluator' },
//         { data: 'code' },
//         { data: 'name' },
//         { data: 'position' },
//         { data: 'div' },
//         { data: 'dept' },
//         { data: 'sect' },
//         { data: 'theoryG' },
//         { data: 'total_score' },
//         { data: 'adjust_grade' },
//         { data: 'status' },
//         { data: 'action' },
//     ],
//     columnDefs: [ {
//         targets: 0,
//         orderable: false,
//     },{
//         targets: 12,
//         orderable: false,
//     } ],
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
    
//     });
//     table.colReorder.order([0, 1, 2, 3, 4, 5], true);
//         // Add event listener for opening and closing details
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
// count_pa_grade();
// bell_curve_detail();
// if($('#search_employee_no').val() != "all"){
//     $('.AutoAdjust').css('display','inline-flex');
// }   
// document.querySelectorAll('a.toggle-vis').forEach((el) => {
//     el.addEventListener('click', function (e) {
//         e.preventDefault();
 
//         let columnIdx = e.target.getAttribute('data-column');
//         let column = table.column(columnIdx);
 
//         // Toggle the visibility
//         column.visible(!column.visible());
//     });
// });

function destroy_table(){
    $('#example').DataTable().destroy();
    setTimeout(() => {
        search_data();
        count_pa_grade();
        bell_curve_detail();
    }, 200);
}
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
function search_data(){
    if($('#search_employee_no').val().length > 0){
        $('.AutoAdjust').css('display','inline-flex');
    }else{
        $('.AutoAdjust').css('display','none !important');
    }   
    
    const availWidth = window.screen.availWidth;
    var fixedColumns = 3;
    if(availWidth < 630){
        fixedColumns = 2;
    }
    let table = new DataTable('#example', {
        fixedColumns: {
            left: fixedColumns,
        },
        "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
        searchDelay: 500,
        processing: true,
        // serverSide: true,
        // scrollY: true,
        // scrollX: true,
        scrollCollapse: true,
        "ajax": {
            "url": "{{ url(Request::segment(1).'/table_paGrading_getdata') }}",
            "type": 'POST', 
            "data" : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_section":$('#search_section').val(),
                "search_employee_no":$('#search_employee_no').val(),
                "search_status":$('#search_status').val(),
                "update_grade":'1',
                "search_month_day":$('#search_month_day').val(),
                "search_year":$('#search_year').val()
            },     
        },
        colReorder: true,
        columns: [
            { data: 'id' },
            { data: 'evaluator' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'div' },
            { data: 'dept' },
            { data: 'sect' },
            { data: 'theoryG' },
            { data: 'total_score' },
            { data: 'adjust_grade' },
            { data: 'status' },
            { data: 'action' },
        ],
        columnDefs: [ {
            targets: 0,
            orderable: false,
        },{
            targets: 12,
            orderable: false,
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

    $('#select-all').click(function(event) {   
        if(this.checked) {
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

        // Toggle the visibility
        column.visible(!column.visible());
    });
}
function count_pa_grade(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/count_pa_grade") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_division":$('#search_division').val(),
            "search_department":$('#search_department').val(),
            "search_section":$('#search_section').val(),
            "search_employee_no":$('#search_employee_no').val(),
            "search_status":$('#search_status').val(),
            "search_month_day":$('#search_month_day').val(),
            "search_year":$('#search_year').val()
        },
        success: function (result) { 
            $('.all_employee').text(result.data);
            $('.all_submit').text(result.data4);
            $('.all_inprogress').text(result.data1);
            $('.all_finish').text(result.data3);
        }
    });
}
function set_approveModal_id(id){
    $('#approveModal_id').val(id);
}
function set_editModal_id(id,adjust){
    $('#editModal_id').val(id);
    $('#edit_grade_select').val(adjust);
}
function set_edittheory_Modal_id(id,pa_grade){
    $('#edit_theoretical_Modal_id').val(id);
    $('#edit_theoretical_grade_select').val(pa_grade);
}
function approveModal_update(){
    var approveModal_id = $('#approveModal_id').val();
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/Review_update_status") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "id":approveModal_id,
            "status_evaluation":"3",
            "search_year":$('#search_year').val()
        },
        success: function (result) { 
            $('.set_status'+approveModal_id).html('Approved');
            $('.set_status'+approveModal_id).removeClass('badge-light');
            $('.set_status'+approveModal_id).addClass('badge-light-success');
            count_pa_grade();
            bell_curve_detail();
        }
    });
}
function approveModal_update_all(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            var cut = this.value.split(',');
            getCheckbox.push(cut[0]);
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
            url: '{{ url(Request::segment(1)."/Review_update_status_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":getCheckbox,
                "status_evaluation":"3",
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                // $('.checkbox-select').each(function() {
                //     if(this.checked == true){
                //         $('.set_status'+this.value).html('Approved');
                //         $('.set_status'+this.value).removeClass('badge-light');
                //         $('.set_status'+this.value).addClass('badge-light-success');
                //     }                
                // });
                // count_pa_grade();
                // bell_curve_detail();
                // window.location.reload();
                destroy_table();
                // $('#approveModalAll').modal('hide');
            }
        });
    }
}
function editModal_update(){
    var editModal_id = $('#editModal_id').val();
    var edit_grade_select = $('#edit_grade_select').val();
    if(edit_grade_select == ""){
        Swal.fire({
            title: "Please Select Adjust grade",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/editModal_update") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":editModal_id,
                "adjust_grade":edit_grade_select,
                "pa_grade":$('#theoryG_'+editModal_id).val(),
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                if(edit_grade_select == 'A'){
                    var adjust_grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                }else if(edit_grade_select == 'B'){
                    var adjust_grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                }else if(edit_grade_select == 'C'){
                    var adjust_grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                }else if(edit_grade_select == 'D'){
                    var adjust_grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                }else if(edit_grade_select == 'E'){
                    var adjust_grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                }else{
                    var adjust_grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                }
                $('.set_adjust_grade'+editModal_id).html(adjust_grade);
                $('.set_adjust_grade'+editModal_id).removeClass('gradeAR');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeP');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeA');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeB');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeC');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeD');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeE');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeU');
                $('.set_adjust_grade'+editModal_id).removeClass('gradeCD');
                $('.set_adjust_grade'+editModal_id).addClass('grade'+edit_grade_select);

                $('.set_status'+editModal_id).html('Wait for approval');
                $('.set_status'+editModal_id).removeClass('badge-light');
                $('.set_status'+editModal_id).removeClass('badge-light-success');
                $('.set_status'+editModal_id).removeClass('badge-light-danger');
                $('.set_status'+editModal_id).addClass('badge-light');
                count_pa_grade();
                bell_curve_detail();
                $('#editModal').modal('hide');
            }
        });
    }
}
function editModal_theoretical_update(){
    var edit_theoretical_Modal_id = $('#edit_theoretical_Modal_id').val();
    var edit_theoretical_grade_select = $('#edit_theoretical_grade_select').val();
    if(edit_theoretical_grade_select == ""){
        Swal.fire({
            title: "Please Select Theoretical grade",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/editModal_theoretical_update") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":edit_theoretical_Modal_id,
                "pa_grade":edit_theoretical_grade_select,
                "search_year":$('#search_year').val()
            },
            success: function (result) {
                destroy_table();
                $('#theory_editModal').modal('hide');
            }
        });
    }
}
function editModal_update_all(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            var cut = this.value.split(',');
            getCheckbox.push({
                id:cut[0],
                grade:cut[1]
            });
        }                
    });
    console.log(getCheckbox);
    var edit_grade_select = $('#edit_grade_select_all').val();
    if(edit_grade_select == ""){
        Swal.fire({
            title: "Please Select Adjust grade",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
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
                url: '{{ url(Request::segment(1)."/editModal_update_all") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "id":getCheckbox,
                    "adjust_grade":edit_grade_select,
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    $('.checkbox-select').each(function() {
                        if(this.checked == true){
                            if(edit_grade_select == 'A'){
                                var adjust_grade = '<h1 class="badge gradeA w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                            }else if(edit_grade_select == 'B'){
                                var adjust_grade = '<h1 class="badge gradeB w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                            }else if(edit_grade_select == 'C'){
                                var adjust_grade = '<h1 class="badge gradeC w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                            }else if(edit_grade_select == 'D'){
                                var adjust_grade = '<h1 class="badge gradeD w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                            }else if(edit_grade_select == 'E'){
                                var adjust_grade = '<h1 class="badge gradeE w-100 text-center fs-3 d-block py-2 mb-0">'+edit_grade_select+'</h1>';
                            }else{
                                var adjust_grade = '<h1 class="badge w-100 text-center fs-3 d-block py-2 mb-0"></h1>';
                            }
                            // $('.set_adjust_grade'+this.value).html(adjust_grade);
                            // $('.set_adjust_grade'+this.value).removeClass('gradeAR');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeP');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeA');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeB');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeC');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeD');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeE');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeU');
                            // $('.set_adjust_grade'+this.value).removeClass('gradeCD');
                            // $('.set_adjust_grade'+this.value).addClass('grade'+edit_grade_select);

                            // $('.set_status'+this.value).html('Wait for approval');
                            // $('.set_status'+this.value).removeClass('badge-light');
                            // $('.set_status'+this.value).removeClass('badge-light-success');
                            // $('.set_status'+this.value).removeClass('badge-light-danger');
                            // $('.set_status'+this.value).addClass('badge-light');
                        }                
                    });
                    count_pa_grade();
                    bell_curve_detail();
                    $('.checkbox-select').each(function() {
                        this.checked = false;                       
                    });
                    $('#editModalAll').modal('hide');
                    // window.location.reload();
                }
            });
        }
    }
}
function bell_curve_detail(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/bell_curve_detail") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_division":$('#search_division').val(),
            "search_department":$('#search_department').val(),
            "search_section":$('#search_section').val(),
            "search_employee_no":$('#search_employee_no').val(),
            "search_status":$('#search_status').val(),
            "search_month_day":$('#search_month_day').val(),
            "search_year":$('#search_year').val()
        },
        success: function (result) {
            if(result){
                if(result.countdata){
                    var countA = 0;
                    var countB = 0;
                    var countC = 0;
                    var countD = 0;
                    var countE = 0;
                    var countNoNull = 0;
                    $.each(result.countdata, function (key, value) {	
                        if(value.adjust_grade == 'A'){
                            countA++;
                            // countNoNull++;
                        }
                        if(value.adjust_grade == 'B'){
                            countB++;
                            // countNoNull++;
                        }
                        if(value.adjust_grade == 'C'){
                            countC++;
                            // countNoNull++;
                        }
                        if(value.adjust_grade == 'D'){
                            countD++;
                            // countNoNull++;
                        }
                        if(value.adjust_grade == 'E'){
                            countE++;
                            // countNoNull++;
                        }
                        countNoNull++;
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
                }
            }
        }
    });
}
function adjustModal_update_all(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        var cut = this.value.split(',');
        getCheckbox.push(cut[0]);              
    });
    console.log(getCheckbox.length);
    if(getCheckbox.length == 0){
        Swal.fire({
            title: "{{ __('no data') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        const loadingEl = document.createElement("div");
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `
            <span class="spinner-border text-primary" role="status"></span>
            <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
        `;

        // Show page loading
        KTApp.showPageLoading();

        
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/adjustModal_update_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_section":$('#search_section').val(),
                "search_employee_no":$('#search_employee_no').val(),
                "search_status":$('#search_status').val(),
                "search_month_day":$('#search_month_day').val(),
                "search_year":$('#search_year').val()
            },
            success: function (result) { 
                KTApp.hidePageLoading();
                loadingEl.remove();
                Swal.fire({
                    icon: 'success',
                    title: "Success",
                    html: "I will close in <b></b> milliseconds.",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        destroy_table();
                        $('#adjustModalAll').modal('hide');
                        // window.location.reload();
                    }
                });
            }
        });
    }
}

/////////////////////////////////////////////////////////////////////////////////////
function get_eva(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_eva_pa_grade") }}',
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
            console.log(result.data);
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
function get_department(){
    if($('#search_division').val().length == 0){
        var html = ``;
        // $('#search_department').html([]);
        var html2 = ``;
        // $('#search_section').html(html2);
        $('#search_department').val([]);
        $('#search_section').val([]);
        get_section();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_department_pa_grade") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_year":$('#search_year').val()
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
                $('#search_department').html(html);
                if(result.data.length > 1){
                    $('#search_department').val([]);
                }
                setTimeout(() => {
                    get_section();
                }, 200);
            }
        });
    }
}
function get_section(){
    if($('#search_department').val().length == 0){
        var html = ``;
        // $('#search_section').html(html);
        $('#search_section').val([]);
        get_eva();
        destroy_table();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_section_pa_grade") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_year":$('#search_year').val()
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
                $('#search_section').html(html);
                if(result.data.length > 1){
                    $('#search_section').val([]);
                    get_eva();
                }else{
                    get_eva();
                }
                setTimeout(() => {
                    destroy_table();
                }, 200);
            }
        });
    }
}
function get_eva_list(){
    get_eva();
    destroy_table();
}
</script>

@endpush
</x-default-layout>
