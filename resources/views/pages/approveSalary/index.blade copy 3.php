<x-default-layout>
   @section('title')
        {{ __('Approved Salary') }}
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
    
    <!--begin::Row-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="card h-xl-100">
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
                    <ul class="nav nav-pills nav-pills-custom mb-3">
                        <li class="nav-item mb-3 me-2 me-lg-3">
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden pt-3 pb-3 active" id="tabS_link_1" data-bs-toggle="pill" href="#tabS_1">
                                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                                    Salary summary
                                </span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-2 me-lg-3">
                            <a onclick="destroy_table2();" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden pt-3 pb-3" id="tabS_link_2" data-bs-toggle="pill" href="#tabS_2">
                                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                                Orisoft upload file
                                </span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabS_1">
                            <div class="d-md-block">
                                <div class="row g-3 mb-3" style="font-size: 10px;">
                                    <div class="col-12 col-sm-2" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Division</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_division" name="search_division" data-placeholder="-Choose-" onchange="get_department();">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Department</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_department" name="search_department" data-placeholder="-Choose-" onchange="get_section();">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Section</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_section" name="search_section" data-placeholder="-Choose-" onchange="get_eva_list();">
                                        
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;" for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluator')}}</label>
                                        <select class="form-select myLike" data-control="select2" id="search_employee_no" name="search_employee_no" data-placeholder="-Choose-" onchange="destroy_table();">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-1" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
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

                                    <div class="col-12 col-sm-1" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
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

                                    <div class="col-12 col-sm-2" style="font-size: 10px;">
                                        <label
                                            style="font-size: 10px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Status</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_status" name="search_status" data-placeholder="-Select-" onchange="destroy_table();">
                                            <option value="all">All employees</option>
                                            <option value="-1">In progress</option>
                                            <option value="2">Reject</option>
                                            <option value="1">Finished</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-4 col-sm-2">
                                        <button
                                            type="button"
                                            class="btn btn-primary rounded-pill"
                                        >
                                            <i class="ki-outline ki-magnifier"></i>
                                            Search
                                        </button>
                                    </div> -->
                                    
                                    
                                    
                                    
                                    <div class="col-12 col-sm-2">
                                        <div class="card shadow-none rounded-3 p-3 mb-2" style="padding: 0px !important;">
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
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                        >
                                                            All employees
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_all"
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
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                        >
                                                            In progress
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_in"
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
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                        >
                                                            Reject
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_reject"
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
                                                    <div class="flex-grow-1 me-2" style="display: flex;align-items: center;justify-content: space-between;">
                                                        <p
                                                            class="text-gray-800 small fw-normal mb-0"
                                                        >
                                                            Finished
                                                        </p>
                                                        <h4
                                                            class="text-black fw-bold d-block text-end mb-0 data_finish"
                                                        >
                                                            
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- info desktop table-->
                            <div class="row g-3 mb-3 d-md-flex">
                                <div class="col-md-6 col-xl-3" style="display:none;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th colspan="4" class="text-center">
                                                        Bell Curve information
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
                                                        <h1
                                                            class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                                        >
                                                            {{$val->grade_name}}
                                                        </h1>
                                                    </td>
                                                    <td class="table-secondary">
                                                        {{$val->percent}}%
                                                        <input type="hidden" id="bell_percent{{$val->grade_name}}" value="{{$val->percent}}">
                                                    </td>
                                                    <td class="total_theoretical_Level{{$val->grade_name}}"></td>
                                                    <td class="table-success total_adjust_Level{{$val->grade_name}}">
                                                        <input type="hidden" name="hidden_bell_curve_grade_name[]" value="{{$val->grade_name}}">
                                                        <input type="hidden" name="hidden_bell_curve_percent[]" value="{{$val->percent}}">
                                                    </td>
                                                </tr>
                                                @php 
                                                    $no++;
                                                @endphp 
                                                @endforeach
                                                @endif
                                                <!-- <tr class="text-center align-middle">
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
                                                </tr> -->
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-center">
                                                    <th>Total</th>
                                                    <th class="table-secondary"></th>
                                                    <th class="bell_total_all1">0</th>
                                                    <th class="bell_total_all2 table-success">0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3" style="display:none;">
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
                                                <!-- <tr class="text-center align-middle">
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
                                                    <td class="text-primary">
                                                        10.00%-12.00%
                                                    </td>
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
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3" style="display:none;">
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
                                </div>
                                <div class="col-md-6 col-xl-2" style="display:none;">
                                    <div class="card shadow-none rounded-3 p-3 mb-2">
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
                                                        class="text-black fw-bold d-block text-end mb-0 data_all"
                                                    >
                                                        
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow-none rounded-3 p-3 bg-light-secondary mb-2">
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
                                                        In progress
                                                    </p>
                                                    <h4
                                                        class="text-black fw-bold d-block text-end mb-0 data_in"
                                                    >
                                                    
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow-none rounded-3 p-3 bg-light-danger mb-2">
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
                                                        class="text-black fw-bold d-block text-end mb-0 data_reject"
                                                    >
                                                        
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card shadow-none rounded-3 p-3 bg-light-success">
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
                                                        class="text-black fw-bold d-block text-end mb-0 data_finish"
                                                    >
                                                        
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    
                                    <div class="d-inline-flex" style="font-size: 10px !important;">
                                        <button
                                            type="button"
                                            class="btn btn-light rotate mb-3 p-2 ps-3 rounded-pill"
                                            data-kt-menu-trigger="click"
                                            data-kt-menu-placement="bottom-start"
                                            data-kt-menu-offset="0px, 0px"
                                            style="font-size: 10px !important;"
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
                                                class="menu-item menu-sub-indention menu-accordion"
                                                data-kt-menu-trigger="click"
                                            >
                                                <!--begin::Menu link-->
                                                <a href="#" class="menu-link py-3">
                                                    <span class="menu-title"
                                                        >Employee info</span
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
                                                                    class="toggle-vis"
                                                                    data-column="3"
                                                                />
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
                                                                    class="toggle-vis"
                                                                    data-column="4"
                                                                />
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
                                                                    class="toggle-vis"
                                                                    data-column="5"
                                                                />
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
                                                                    class="toggle-vis"
                                                                    data-column="6"
                                                                />
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
                                                class="menu-item menu-link-indention menu-accordion"
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
                                                                    class="toggle-vis"
                                                                    data-column="7"
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
                                                                    class="toggle-vis"
                                                                    data-column="8"
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
                                                                    class="toggle-vis"
                                                                    data-column="9"
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
                                                                    class="toggle-vis"
                                                                    data-column="10"
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
                                                                    class="toggle-vis"
                                                                    data-column="11"
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
                                                                    class="toggle-vis"
                                                                    data-column="12"
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
                                                                    class="toggle-vis"
                                                                    data-column="13"
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
                                                                    class="toggle-vis"
                                                                    data-column="14"
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
                                                class="menu-item menu-link-indention menu-accordion"
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
                                                                    class="toggle-vis"
                                                                    data-column="15"
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
                                                                    class="toggle-vis"
                                                                    data-column="16"
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
                                                                    class="toggle-vis"
                                                                    data-column="17"
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
                                                class="menu-item menu-link-indention menu-accordion"
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
                                                                    class="toggle-vis"
                                                                    data-column="18"
                                                                />
                                                                PA 2020
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
                                                                    class="toggle-vis"
                                                                    data-column="19"
                                                                />
                                                                PA 2021
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
                                                                    class="toggle-vis"
                                                                    data-column="20"
                                                                />
                                                                PA 2022
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
                                                class="menu-item menu-link-indention menu-accordion"
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
                                                                    class="toggle-vis"
                                                                    data-column="21"
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
                                                                    class="toggle-vis"
                                                                    data-column="22"
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
                                                                    class="toggle-vis"
                                                                    data-column="23"
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
                                                                    class="toggle-vis"
                                                                    data-column="24"
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
                                                                    class="toggle-vis"
                                                                    data-column="25"
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
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                        <input
                                                            checked
                                                            type="checkbox"
                                                            class="toggle-vis"
                                                            data-column="26"
                                                        />
                                                        Current B.Salary/Wage
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item Theory salary-->
                                            <div
                                                class="menu-item menu-link-indention menu-accordion"
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
                                                                    class="toggle-vis"
                                                                    data-column="27"
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
                                                                    class="toggle-vis"
                                                                    data-column="28"
                                                                />
                                                                B.salary/wage for calc
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
                                                                    class="toggle-vis"
                                                                    data-column="29"
                                                                />
                                                                Current
                                                                B.salary/wage(THB/mth)
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
                                                                    class="toggle-vis"
                                                                    data-column="30"
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
                                                                    class="toggle-vis"
                                                                    data-column="31"
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
                                                                    class="toggle-vis"
                                                                    data-column="32"
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
                                                class="menu-item menu-link-indention menu-accordion"
                                                data-kt-menu-trigger="click"
                                            >
                                                <!--begin::Menu link-->
                                                <a href="#" class="menu-link py-3">
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
                                                                    class="toggle-vis"
                                                                    data-column="33"
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
                                                                    class="toggle-vis"
                                                                    data-column="34"
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
                                                                    class="toggle-vis"
                                                                    data-column="35"
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
                                                                    class="toggle-vis"
                                                                    data-column="36"
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
                                                                    class="toggle-vis"
                                                                    data-column="37"
                                                                />
                                                                New
                                                                B.Salary/wage(THB/Mth)
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
                                                                    class="toggle-vis"
                                                                    data-column="38"
                                                                />
                                                                Final by DM/GM
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
                                                                    class="toggle-vis"
                                                                    data-column="39"
                                                                />
                                                                Remark
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu sub-->
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
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
                                                <th class="text-left" rowspan="2" style="min-width:100px;width:100px;">Emp. no.</th>
                                                <th class="text-left" rowspan="2">Name-Surname</th>
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
                                                @php
                                                    $previousYear3 = date('Y', strtotime('-3 year'));
                                                    $previousYear2 = date('Y', strtotime('-2 year'));
                                                    $previousYear1 = date('Y', strtotime('-1 year'));
                                                    
                                                        $previousYear = date('Y');
                                                    
                                                @endphp
                                                <th class="text-center" rowspan="2">PA {{$previousYear3}}</th>
                                                <th class="text-center" rowspan="2">PA {{$previousYear2}}</th>
                                                <th class="text-center" rowspan="2">PA {{$previousYear1}}</th>
                                                <th class="text-center" rowspan="2">Form</th>
                                                <th class="text-center" rowspan="2">Evaluator {{$previousYear}}</th>
                                                <th class="text-center" rowspan="2">Approved score</th>
                                                <th class="text-center" rowspan="2">Theoretical Level</th>
                                                <th class="text-center" rowspan="2">Adjust Level</th>
                                                <th class="text-center" rowspan="2">
                                                    Current B.Salary/Wage
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    L800 AVG. Wage of Min.Wage Adjusted
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    B.Salary/Wage for Calculation
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Current B.Salary/Wage (THB/Mth)
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Company Suggested (%)
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Company Suggestged (Amount)
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Company Suggestged New Basic
                                                </th>
                                                <th class="text-center" rowspan="2">Grade by Mgr.</th>
                                                <th class="text-center" rowspan="2" style="min-width:150px;">
                                                    Inc. % Proposed by Mgr.
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Inc. Amount Proposed by Mgr.
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    New Basic/Wage Proposed by Mgr.
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    New B.Salary/Wage (THB/Mth)
                                                </th>
                                                <th class="text-center" rowspan="2">
                                                    Final by DM/GM (Amount)
                                                </th>
                                                <th class="text-center" rowspan="2">Remark(P,AR,U)</th>
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

                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-rounded">
                                    <thead class="table-light">
                                        <tr class="text-center fw-bold align-middle">
                                            <th>Monthly/Daily</th>
                                            <th>Current B.Salary/Wage</th>
                                            <th>L800 AVG. Wage of Min.Wage Adjusted</th>
                                            <th>B.Salary/Wage for Calculation</th>
                                            <th>Current B.Salary/Wage (THB/Mth)</th>
                                            <th>Company Suggested (%)</th>
                                            <th>Company Suggestged (Amount)</th>
                                            <th>Company Suggestged New Basic</th>
                                            <th></th>
                                            <th>Inc. % Proposed by Mgr.</th>
                                            <th>Inc. Amount Proposed by Mgr.</th>
                                            <th>New Basic/Wage Proposed by Mgr.</th>
                                            <th>New B.Salary/Wage (THB/Mth)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="data_footer">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabS_2" >
                            <div class="d-md-block">
                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-sm-2">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Division</label
                                        >
                                        <select class="form-select myLike_tab2" data-control="select2" id="tab2_search_division" name="tab2_search_division" data-placeholder="-Choose-">
                                        <option value="all">All</option>
                                            @foreach ($division as $key => $val)
                                                <option value="{{ $val->division_code }}">{{ $val->division_code }} - {{ $val->division_description }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Department</label
                                        >
                                        <select class="form-select myLike_tab2" data-control="select2" id="tab2_search_department" name="tab2_search_department" data-placeholder="-Choose-">
                                        <option value="all">All</option>
                                            @foreach ($department as $key => $val)
                                                <option value="{{ $val->department_code }}">{{ $val->department_code }} - {{ $val->department_description }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Section</label
                                        >
                                        <select class="form-select myLike_tab2" data-control="select2" id="tab2_search_section" name="tab2_search_section" data-placeholder="-Choose-">
                                        <option value="all">All</option>
                                            @foreach ($section as $key => $val)
                                                <option value="{{ $val->section_code }}">{{ $val->section_code }} - {{ $val->section_description }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Monthly/Daily</label
                                        >
                                        <select class="form-select myLike_tab2" data-control="select2" id="tab2_search_month_day" name="tab2_search_month_day" data-placeholder="-Select-">
                                            <option value="2">Monthly</option>
                                            <option value="1" selected>Daily</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-sm-2">
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >{{__('Status')}}</label
                                        >
                                        <select class="form-select myLike_tab2" data-control="select2" id="tab2_search_status" name="tab2_search_status" data-placeholder="-Select-">
                                            <option value="all">All employees</option>
                                            <option value="-1">In progress</option>
                                            <option value="2">Reject</option>
                                            <option value="1">Finished</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-4 col-sm-2">
                                        <button type="button" class="btn btn-primary rounded-pill">
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
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Monthly/Daily</label>
                                                <select class="form-select">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Grade</label>
                                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                                    <option></option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-sm-2">
                                                <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="ki-outline ki-magnifier"></i>
                                        {{__('Search')}}
                                    </button>
                                </div>
                            </div>
                            <!-- tableDesktop -->
                            <div class=" position-relative">
                                <!--begin::Toggle-->
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
                                    <!--Display dropdown-->
                                    <div class="d-inline-flex">
                                        @can('export approve salary')
                                        <button type="button" class="btn btn-light-info mb-3 p-2 px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_export" >
                                            <i class="ki-solid ki-file-up fs-3 me-1"></i>
                                            Export
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                                <!--end::Dropdown wrapper-->
                                <div class="table-responsive">
                                    <table id="kt_datatable_dom_positioning2" class="table table-striped rounded">
                                        <thead class="table-light">
                                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                <!-- <th><input type="checkbox" name="select-all2" id="select-all2" ></th> -->
                                                <th style="min-width:100px;width:100px;">{{__('Emp. no.')}}</th>
                                                <th>{{__('Emp. Name')}}</th>
                                                <th>Reason</th>
                                                <th>{{__('Remark')}}</th>
                                                <th>Activity Date</th>
                                                <th>Value</th>
                                                <th>Effective Date</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                        </thead>
                                    </table>

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
                                <th colspan="4" class="text-center">
                                    Bell Curve information
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
                                    <h1
                                        class="{{$grade}} badge w-100 text-center fs-3 d-block py-2 mb-0"
                                    >
                                        {{$val->grade_name}}
                                    </h1>
                                </td>
                                <td class="table-secondary">
                                    {{$val->percent}}%
                                    <input type="hidden" id="bell_percent{{$val->grade_name}}" value="{{$val->percent}}">
                                </td>
                                <td class="total_theoretical_Level{{$val->grade_name}}"></td>
                                <td class="table-success total_adjust_Level{{$val->grade_name}}">
                                    <input type="hidden" name="hidden_bell_curve_grade_name[]" value="{{$val->grade_name}}">
                                    <input type="hidden" name="hidden_bell_curve_percent[]" value="{{$val->percent}}">
                                </td>
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
                                <th class="bell_total_all2 table-success">0</th>
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
                    <h3 class="modal-title">Grade</h3>
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
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Current position </label
                            >
                            <select class="form-select form-select-solid" id="change_position_old" name="change_position_old" data-control="select2" data-dropdown-parent="#update_grade_p" data-placeholder="-Choose-" disabled>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >New position</label
                            >
                            <select class="form-select form-select-solid" id="change_position_new" name="change_position_new" data-control="select2" data-dropdown-parent="#update_grade_p" data-placeholder="-Choose-">
                                    <option value="0">- Select -</option>
                                @foreach ($position as $key => $val)
                                    <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label
                                for="exampleFormControlInput1"
                                class="form-label mb-0"
                                >Job Description</label
                            >
                            <textarea class="form-control" name="change_position_remark" id="change_position_remark" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                        onclick="destroy_table()"
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

    <div class="modal fade" tabindex="-1" id="modal_export">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Activity Date</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input type="date" id="activity_date" name="activity_date" class="form-control mb-4" value="{{date('Y-m-d')}}" />
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" onclick="printexcel()">Export</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="text/javascript">
        $(function() {
            get_division();
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
            $('#kt_datatable_dom_positioning').DataTable().destroy();
            setTimeout(() => {
                search_data();
            }, 200);
        }
        function destroy_table2(){
            $('#kt_datatable_dom_positioning2').DataTable().destroy();
            setTimeout(() => {
                render_table();
            }, 200);
        }
        function search_data(){
            const availWidth = window.screen.availWidth;
            var fixedColumns = 3;
            if(availWidth < 630){
                fixedColumns = 2;
            }
            var otable = $("#kt_datatable_dom_positioning").DataTable({
                // layout: {
                //     topStart: {
                //         buttons: ['excel']
                //     }
                // },
                fixedHeader: {
                    header: true,
                },
                fixedColumns: {
                    left: fixedColumns,
                },
                "lengthMenu": [[100,500, 1000, 2000, 3000], [100,500, 1000, 2000, 3000]],
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
                        console.log(d);
                        oData = d
                    },
                },
                columns: [
                    // { data: "id",className: 'text-center' },
                    { data: "code",className: 'text-center' },
                    { data: "name" },
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
                    { data: "l800avg_gmdm",className: 'text-right'  },
                    { data: "bsalaryw",className: 'text-right'  },
                    { data: "cbsalaryw",className: 'text-right'  },
                    { data: "comsugpct",className: 'text-right'  },
                    { data: "comsugamt",className: 'text-right'  },
                    { data: "companynewb",className: 'text-right'  },
                    { data: "gmgr_span2" },
                    { data: "incpctmgr_span" },
                    { data: "incamount",className: 'text-right'  },
                    { data: "newbwage",className: 'text-right'  },
                    { data: "newbsalary",className: 'text-right'  },
                    { data: "finaldmgm",className: 'text-right'  },
                    { data: "remark_view" },
                    { data: "status" },
                ],
                columnDefs: [{
                    "targets": 6,
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

                let columnIdx = e.target.getAttribute("data-column");
                let column = otable.column(columnIdx);

                // Toggle the visibility
                column.visible(!column.visible());
            });

            all_detail();
        }
        function render_table(){
            var otable2 = $("#kt_datatable_dom_positioning2").DataTable({
                "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                searchDelay: 500,
                processing: true,
                serverSide: true,
                scrollY: true,
                scrollX: true,
                scrollCollapse: true,
                "columnDefs": [{
                    "visible": false,
                    "targets": -1
                }],
                ajax: {
                    url: "{{ url(Request::segment(1).'/table_ors_getdata') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.Like = {};
                        $('.myLike_tab2').each(function() {
                            if ($.trim($(this).val()) && $.trim($(this).val()) != '0') {
                                d.Like[$(this).attr('name')] = $.trim($(this)
                                    .val());
                            }
                        });
                        console.log(d);
                        oData = d
                    },
                },
                columns: [
                    // { data: 'id' },
                    { data: 'code' },
                    { data: 'name' },
                    { data: 'reason'},
                    { data: 'remark'},
                    { data: 'actDate'},
                    { data: 'value'},
                    { data: 'effDate'},
                    { data: 'status' }, 
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
            $('#tab2_search_division').on('change', function(e) {
                otable2.draw();
            });
            $('#tab2_search_department').on('change', function(e) {
                otable2.draw();
            });
            $('#tab2_search_section').on('change', function(e) {
                otable2.draw();
            });
            $('#tab2_search_month_day').on('change', function(e) {
                if($('#tab2_search_month_day').val() == '1'){
                    $('.hide_Daily').css('display','');
                    $('.hide_Monthly').css('display','none');
                }else{
                    $('.hide_Daily').css('display','none');
                    $('.hide_Monthly').css('display','');
                }
                otable2.draw();
            });
            $('#tab2_search_grade').on('change', function(e) {
                otable2.draw();
            });
            $('#tab2_search_status').on('change', function(e) {
                otable2.draw();
            });
            $('#select-all2').click(function(event) {   
                if(this.checked) {
                    // Iterate each checkbox
                    $('.checkbox-select2').each(function() {
                        this.checked = true;                        
                    });
                } else {
                    $('.checkbox-select2').each(function() {
                        this.checked = false;                       
                    });
                }
            }); 
        }
        function change_class(e,i,id,employee_id) {
            var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
            var hidden_budget_std = $('.hidden_budget_std'); 
            console.log(id);
            if(e.value == 'P' || e.value == 'AR' || e.value == 'U'){
                $.ajax({
                        type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_positoon_for_change") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":employee_id
                    },
                    success: function (result) {
                        $('#change_position_employee_id').val(employee_id);
                        $('#change_position_final_id').val(id);
                        $('#change_position_old').val(result.position_code);
                        $('#select2-change_position_old-container').text(result.position_code+' - '+result.position_description);
                        $('#change_position_remark').val(result.change_position_remark);
                        $('#update_grade_p').modal('show');
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
                                $('.final_by_md_gm_amount'+id).html(result.final_by_md_gm_amount);
                                if(result.grade_proposed_old == 'P'){
                                    $('#remark_grade'+id).val('');
                                }
                                all_detail();
                                Swal.fire({
                                    title: "Update Success",
                                    text: "",
                                    icon: "success",
                                    allowOutsideClick: false,
                                });
                                // destroy_table();
                            }
                        });
                    }
                }
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
                    "percent_proposed":e.value
                },
                success: function (result) {
                    $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                    $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                    $('.amount_proposed'+id).html(result.amount_proposed);
                    $('.salary_new'+id).html(result.salary_new);
                    $('.salary_month_new'+id).html(result.salary_month_new);
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
                    "search_status":$('#search_status').val()
                },
                success: function (result) {
                    if(result){
                        if(result.percent_department){
                            var percent_daily = (result.percent_department.percent_daily>0?result.percent_department.percent_daily:0);
                            var percent_monthly = (result.percent_department.percent_monthly>0?result.percent_department.percent_monthly:0);
                            var percent_all = parseFloat(percent_daily)+parseFloat(percent_monthly);
                            $('.percent_department_daily_percent').html((percent_daily>0?number_format2(percent_daily,3)+'%':''));
                            $('.percent_department_monthly_percent').html((percent_monthly>0?number_format2(percent_monthly,3)+'%':''));
                            $('.percent_department_Dailymonthly_percent').html((percent_all>0?number_format2(percent_all,3)+'%':''));
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
                                    <td class="text-end">${(result.total_Monthly.current_salary_wage>0?number_format(result.total_Monthly.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.L800_avg_wage_mwa>0?number_format(result.total_Monthly.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.salary_wage_calculation>0?number_format(result.total_Monthly.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.current_salary_wage_month>0?number_format(result.total_Monthly.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center">${(result.total_Monthly.company_suggested_percent>0?number_format(result.total_Monthly.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Monthly.company_suggested_amount>0?number_format(result.total_Monthly.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.company_suggested_new_basic>0?number_format(result.total_Monthly.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="text-center">${(result.total_Monthly.inc_percent_proposed>0?number_format(result.total_Monthly.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Monthly.inc_amount_proposed>0?number_format(result.total_Monthly.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.new_basic_wage_proposed>0?number_format(result.total_Monthly.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Monthly.new_salary_wage_month>0?number_format(result.total_Monthly.new_salary_wage_month,2):'0.00')}</td>
                                </tr>
                            `;
                    
                            Daily += `
                                <tr class="align-middle">
                                    <td class="fw-bold">Daily</td>
                                    <td class="text-end">${(result.total_Daily.current_salary_wage>0?number_format(result.total_Daily.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.L800_avg_wage_mwa>0?number_format(result.total_Daily.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.salary_wage_calculation>0?number_format(result.total_Daily.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.current_salary_wage_month>0?number_format(result.total_Daily.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center">${(result.total_Daily.company_suggested_percent>0?number_format(result.total_Daily.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Daily.company_suggested_amount>0?number_format(result.total_Daily.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.company_suggested_new_basic>0?number_format(result.total_Daily.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="text-center">${(result.total_Daily.inc_percent_proposed>0?number_format(result.total_Daily.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Daily.inc_amount_proposed>0?number_format(result.total_Daily.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.new_basic_wage_proposed>0?number_format(result.total_Daily.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily.new_salary_wage_month>0?number_format(result.total_Daily.new_salary_wage_month,2):'0.00')}</td>
                                </tr>
                            `;

                            All += `
                                <tr class="align-middle">
                                    <td class="fw-bold">Total Monthly+Daily</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.current_salary_wage>0?number_format(result.total_Daily_Monthly.current_salary_wage,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.L800_avg_wage_mwa>0?number_format(result.total_Daily_Monthly.L800_avg_wage_mwa,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.salary_wage_calculation>0?number_format(result.total_Daily_Monthly.salary_wage_calculation,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.current_salary_wage_month>0?number_format(result.total_Daily_Monthly.current_salary_wage_month,2):'0.00')}</td>
                                    <td class="text-center">${(result.total_Daily_Monthly.company_suggested_percent>0?number_format(result.total_Daily_Monthly.company_suggested_percent,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.company_suggested_amount>0?number_format(result.total_Daily_Monthly.company_suggested_amount,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.company_suggested_new_basic>0?number_format(result.total_Daily_Monthly.company_suggested_new_basic,2):'0.00')}</td>
                                    <td></td>
                                    <td class="text-center">${(result.total_Daily_Monthly.inc_percent_proposed>0?number_format(result.total_Daily_Monthly.inc_percent_proposed,2):'0.00')}%</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.inc_amount_proposed>0?number_format(result.total_Daily_Monthly.inc_amount_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.new_basic_wage_proposed>0?number_format(result.total_Daily_Monthly.new_basic_wage_proposed,2):'0.00')}</td>
                                    <td class="text-end">${(result.total_Daily_Monthly.new_salary_wage_month>0?number_format(result.total_Daily_Monthly.new_salary_wage_month,2):'0.00')}</td>
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
                            $('.Overall_daily_percent').html(number_format2(cal_daily,3)+'%');
                            $('.Overall_monthly_percent').html(number_format2(cal_month,3)+'%');
                            var cal_all = parseFloat(cal_daily)+parseFloat(cal_month);
                            $('.Overall_Dailymonthly_percent').html(number_format2(cal_all,3)+'%');
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
                            $('#editG').modal('hide');
                        }
                    });
                }
            }
        }
        function change_percent_select(){
            if($('#edit_percent_select').val() == ""){
                Swal.fire({
                    title: "กรุณาระบุ %",
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
                }
            });
        }
        function checknumber(ele,id,text){
            var vchar = String.fromCharCode(event.keyCode);
            if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
            ele.onKeyPress=vchar;
        }
        function change_position_p(){
            var change_position_employee_id = $('#change_position_employee_id').val();
            var change_position_new = $('#change_position_new').val();
            var change_position_remark = $('#change_position_remark').val();
            var change_position_final_id = $('#change_position_final_id').val();
            var id_gmgr = $('#id_gmgr'+change_position_final_id).val();
            // alert(id_gmgr);
            if($('#change_position_old').val() == "0"){
                Swal.fire({
                    title: "Please Select Current position",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
                if($('#change_position_new').val() == "0"){
                    Swal.fire({
                        title: "Please Select New position",
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
                        if(hidden_budget_grade_name[i].value == id_gmgr && id_gmgr != 'P'){
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
                            "change_position_remark":change_position_remark
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
                                    $('.final_by_md_gm_amount'+id).html(result.final_by_md_gm_amount);
                                    $('#update_grade_p').modal('hide');
                                    Swal.fire({
                                        title: "Update Success",
                                        text: "",
                                        icon: "success",
                                        allowOutsideClick: false,
                                    });
                                }
                            });
                        }
                    });
                }
            }
        }
        function printexcel() {
            var search_month_day    = $('#tab2_search_month_day').val();
            var activity_date    = $('#activity_date').val();
            if(activity_date == ""){
                Swal.fire({
                    title: "Please Select Activity Date",
                    text: "",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            }else{
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/update_status_pa") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "search_month_day":search_month_day
                            },
                            success: function (result) { 
                                window.location.href = "{{ url(Request::segment(1).'/orisoft_excel') }}/"+search_month_day+","+activity_date;
                                destroy_table2();
                            }
                        });
                    }
                });
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////
        function get_eva(){
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
                },
                success: function (result) { 
                    console.log(result.data);
                    var html = `<option value="all">All</option>`;
                    result.data.forEach(element => {
                        html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_en}</option>`;
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
                    "search_year":$('#search_year').val()
                },
                success: function (result) { 
                    if(result.data.length > 1){
                        var html = `<option value="all">All</option>`;
                    }else{
                        var html = ``;
                    }
                    result.data.forEach(element => {
                        html += `<option value="${element.division_code}">${element.division_code} - ${element.division_description}</option>`;
                    });
                    $('#search_division').html(html);
                    if(result.data.length > 1){
                        $('#search_division').val('all');
                    }
                    setTimeout(() => {
                        get_department();
                    }, 200);
                }
            });
        }
        function get_department(){
            if($('#search_division').val() == 'all'){
                var html = `<option value="all">All</option>`;
                $('#search_department').html(html);
                var html2 = `<option value="all">All</option>`;
                $('#search_section').html(html2);
                $('#search_department').val('all');
                $('#search_section').val('all');
                get_section();
            }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_department_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        if(result.data.length > 1){
                            var html = `<option value="all">All</option>`;
                        }else{
                            var html = ``;
                        }
                        result.data.forEach(element => {
                            html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                        });
                        $('#search_department').html(html);
                        if(result.data.length > 1){
                            $('#search_department').val('all');
                        }
                        setTimeout(() => {
                            get_section();
                        }, 200);
                    }
                });
            }
        }
        function get_section(){
            if($('#search_department').val() == 'all'){
                var html = `<option value="all">All</option>`;
                $('#search_section').html(html);
                $('#search_section').val('all');
                get_eva();
                destroy_table();
            }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_section_salary") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_division":$('#search_division').val(),
                        "search_department":$('#search_department').val()
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
                        $('#search_section').html(html);
                        if(result.data.length > 1){
                            $('#search_section').val('all');
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
                    "search_status":$('#search_status').val()
                },
                success: function (result) { 
                    $('.check_salary_null').val(parseFloat(result.count));
                    if($('.check_salary_null').val() > 0){
                        // $('.setblinkAll').removeClass('board');
                        // $('.setblink1').addClass('board');
                        Swal.fire({
                            title: "พบข้อมูลบางรายการ ยังไม่ได้อนุมัติ",
                            text: "กรุณาตรวจสอบใหม่อีกครั้ง",
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
                                        "search_status":$('#search_status').val()
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
        function loading(){
            KTApp.showPageLoading();
        }
        function loading_hide(){
            KTApp.hidePageLoading();
        }
    </script>
    @endpush
</x-default-layout>

<style>
    table.dataTable thead > tr > th.sorting{
        padding-right: 8px;
        font-size: 10px;
    }
    table.dataTable.table-striped > tbody > tr > td{
        font-size: 10px;
    }
    .table:not(.table-bordered) > :not(:last-child) > :last-child > * {
        font-size: 10px;
    }
    .table > tbody > tr > td{
        font-size: 10px !important;
    }
    .table > :not(caption) > * > *,table.dataTable > tbody > tr > th, table.dataTable > tbody > tr > td,table.dataTable thead > tr > th.dt-orderable-asc, table.dataTable thead > tr > th.dt-orderable-desc, table.dataTable thead > tr > th.dt-ordering-asc, table.dataTable thead > tr > th.dt-ordering-desc, table.dataTable thead > tr > td.dt-orderable-asc, table.dataTable thead > tr > td.dt-orderable-desc, table.dataTable thead > tr > td.dt-ordering-asc, table.dataTable thead > tr > td.dt-ordering-desc{
        padding:8px 10px;
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
        font-size: 10px !important;
    }
    .buttons-copy,.buttons-csv,.buttons-pdf,.buttons-print{
        display: none !important;
    }
    .dtfh-floatingparent-head{
        top: 5.7em !important;
    }
    .dtfh-floatingparent,.dtfh-floatingparenthead{
        top: 5.7em !important;
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
        font-size: 10px;
    }
    .symbol.symbol-40px .symbol-label {
        width: 30px;
        height: 30px;
    }
</style>