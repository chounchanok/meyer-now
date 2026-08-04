<x-default-layout>

    @section('title')
        {{ __('Review and Approve Salary Increase') }}
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
                        <i class="ki-duotone ki-wallet fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Review and Approve Salary Increase') }}
                    </span>
                    </h3>
                    <!--end::Title-->

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    <div class="d-none d-md-block">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-2">
                                <label
                                    for="exampleFormControlInput1"
                                    class="form-label mb-0"
                                    >Division</label
                                >
                                <select class="form-select myLike" data-control="select2" id="search_division" name="search_division" data-placeholder="-Choose-">
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
                                <select class="form-select myLike" data-control="select2" id="search_department" name="search_department" data-placeholder="-Choose-">
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
                                <select class="form-select myLike" data-control="select2" id="search_section" name="search_section" data-placeholder="-Choose-">
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
                                <select class="form-select myLike" data-control="select2" id="search_month_day" name="search_month_day" data-placeholder="-Select-">
                                    <option value="2">Monthly</option>
                                    <option value="1" selected>Daily</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-2">
                                <label
                                    for="exampleFormControlInput1"
                                    class="form-label mb-0"
                                    >Grade</label
                                >
                                <select class="form-select myLike" data-control="select2" id="search_grade" name="search_grade" data-placeholder="-Select-">
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

                            <div class="col-12 col-sm-2">
                                <label
                                    for="exampleFormControlInput1"
                                    class="form-label mb-0"
                                    >Status</label
                                >
                                <select class="form-select myLike" data-control="select2" id="search_status" name="search_status" data-placeholder="-Select-">
                                    <option value="all">All employees</option>
                                    <option value="1">In progress</option>
                                    <option value="2">Reject</option>
                                    <option value="3">Finished</option>
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
                                        <label
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Status</label
                                        >
                                        <select class="form-select" data-control="select2" data-placeholder="-Select-">
                                            <option value="all">All employees</option>
                                            <option value="1">In progress</option>
                                            <option value="2">Reject</option>
                                            <option value="3">Finished</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ki-outline ki-magnifier"></i>
                                Search
                            </button> -->
                        </div>
                    </div>
                    <!-- info desktop table-->
                    <div class="row g-3 mb-3 d-none d-md-flex">
                        <div class="col-md-6 col-xl-3">
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
                        <div class="col-md-6 col-xl-3">
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
                                    </tr> -->
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3">
                            <div class="card shadow-none rounded-3 mb-3">
                                <div class="card-header py-2 min-h-30px bg-light-dark">
                                    <p class="card-title fw-bold mb-0 mt-0">Daily - L800</p>
                                    @php
                                        if(date('Y-m') <= (date('Y').'-2')){
                                            $previousYear = date('Y', strtotime('-1 year'));
                                        }else{
                                            $previousYear = date('Y');
                                        }
                                    @endphp
                                </div>
                                <div class="card-body py-3">
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-sm-auto">
                                            <b>% Overall Increment - Actual</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-success text-center py-2 mb-0">0.000%</h1>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-sm-auto">
                                            <b>Approved Budget {{$previousYear}}</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-warning text-danger text-center py-2 mb-0">0.000%</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 mb-3">
                                <div class="card-header py-2 min-h-30px bg-light-dark">
                                    <p class="card-title fw-bold mb-0 mt-0">Monthly (L600 - L700)</p>
                                </div>
                                <div class="card-body py-3">
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-sm-auto">
                                            <b>% Overall Increment - Actual</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-success text-center py-2 mb-0">0.000%</h1>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-sm-auto">
                                            <b>Approved Budget {{$previousYear}}</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-warning text-danger text-center py-2 mb-0">0.000%</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card shadow-none rounded-3 mb-3">
                                <div class="card-header py-2 min-h-30px bg-light-dark">
                                    <p class="card-title fw-bold mb-0 mt-0">Daily+Monthly</p>
                                </div>
                                <div class="card-body py-3">
                                    <div class="row justify-content-between mb-2">
                                        <div class="col-sm-auto">
                                            <b>% Overall Increment - Actual</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-success text-center py-2 mb-0 Overall_monthly_percent">0.000%</h1>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-sm-auto">
                                            
                                            <b>Approved Budget {{$previousYear}}</b>
                                        </div>
                                        <div class="col-sm-auto text-end">
                                            <h1 class="badge badge-light-warning text-danger text-center py-2 mb-0 percent_department_monthly_percent">0.000%</h1>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-6 col-xl-2">
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
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_employee">{{$data_all}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 bg-light-secondary mb-2">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-secondary">
                                        <i class="ki-outline ki-loading fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Wait for approval</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_inprogress">{{$data_in}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 bg-light-danger mb-2">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-danger">
                                        <i class="ki-outline ki-cross-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Reject</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_reject">{{$data_reject}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none rounded-3 p-3 bg-light-success">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-success">
                                        <i class="ki-outline ki-check-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Approved</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0 all_finish"> {{$data_finish}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- info mobile table-->
                    <div class="row g-3 mb-3 d-flex d-md-none" style="display:none;">
                        <div class="col-6">
                            <div class="card shadow-none rounded-3 p-3">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-light">
                                        <i class="ki-outline ki-profile-user fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">All employees</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">32</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-none rounded-3 p-3 bg-light-secondary">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-secondary">
                                        <i class="ki-outline ki-loading fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Wait for approval</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">17</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-none rounded-3 p-3 bg-light-danger">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-danger">
                                        <i class="ki-outline ki-cross-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Reject</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">5</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-none rounded-3 p-3 bg-light-success">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-success">
                                        <i class="ki-outline ki-check-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Approved</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">10</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-outline btn-active-light p-2" id="bellcurveModal">
                                <div class="d-flex flex-column">  
                                    <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                                        <div class="symbol-label fs-2 fw-semibold bg-light-info">
                                        <i class="ki-solid ki-star fs-2 text-info"></i>
                                        </div>
                                    </div>
                                    <b >Bell curve info.</b>
                                </div>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-outline btn-active-light p-2" id="budgetGModal">
                                <div class="d-flex flex-column">  
                                    <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                                        <div class="symbol-label fs-2 fw-semibold bg-light">
                                        %
                                        </div>
                                    </div>
                                    <b >Budget range G.</b>
                                </div>
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-outline btn-active-light p-2" id="approveBudgetModal">
                                <div class="d-flex flex-column">  
                                    <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                                        <div class="symbol-label fs-2 fw-semibold bg-light-success">
                                        <i class="ki-solid ki-wallet fs-2 text-success"></i>
                                        </div>
                                    </div>
                                    <b >Approve Budget</b>
                                </div>
                            </button>
                        </div>
                    </div>

                    <p>Note: 
                        <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                        Approved / 
                        <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                        Reject
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
                                    <!-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#editG"  onclick="reset_edit_grade();">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-notepad-edit fs-3 text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Edit grade</span>
                                        </a>
                                    </div> -->
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#editPct" onclick="reset_edit_percent();">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-notepad-edit fs-3 text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Edit %</span>
                                        </a>
                                    </div> -->
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#approveModal_all">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Approved</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#rejectModal_all">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-cross-circle fs-3 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Rejected</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Transferred</span>
                                        </a>
                                    </div> -->
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <!-- <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-exit-right fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Resigned</span>
                                        </a>
                                    </div> -->
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
                                    <div class="menu-item menu-sub-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">Employee info</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="3"> Position
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="4"> Group
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="5"> Date joined
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="6"> Service days
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item attendance-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">Attendance</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="7"> SL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="8"> PL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="9"> Late(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="10"> Late(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="11"> Absent(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="12"> Absent(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="13"> OL
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="14"> Total days
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item warning-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">Warning record</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="15"> Verbal(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="16"> Written(Times)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="17"> Suspension(days)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    
                                    <!--begin::Menu item PA old-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">PA year before</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="18"> PA 2020
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="19"> PA 2021
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="20"> PA 2022
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item PA current-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">PA Current</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="21"> Form
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="22"> Evaluator 2023
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="23"> Approvedl score
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="24"> Theoretical level
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="25"> Adjust level
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
                                            <input checked type="checkbox" class="toggle-vis" data-column="26"> Current B.Salary/Wage
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item Theory salary-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">Theory salary</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="27"> L800 AVG. wage of min. wage adj.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="28"> B.salary/wage for calc
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="29"> Current B.salary/wage(THB/mth)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="30"> Company suggested(%)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="31"> Company suggested(Amount)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="32"> Company suggested New basic
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item Manager salary-->
                                    <div class="menu-item menu-link-indention menu-accordion" data-kt-menu-trigger="click">
                                        <!--begin::Menu link-->
                                        <a href="#" class="menu-link py-3">
                                            <span class="menu-title">Manager salary</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--end::Menu link-->

                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-accordion pt-3">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="33"> Grade by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="34"> Inc% proposed by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="35"> Inc. amount proposed by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="36"> New basic/wage by mgr.
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="37"> New B.Salary/wage(THB/Mth)
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="38"> Final by DM/GM
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="checkbox p-2">
                                                    <label>
                                                    <input checked type="checkbox" class="toggle-vis" data-column="39"> Remark
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
                            <table id="kt_datatable_dom_positioning" class="table table-striped rounded">
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th rowspan="2">
                                            <input type="checkbox" name="select-all" id="select-all">
                                        </th>
                                        <th rowspan="2" style="min-width:100px;width:100px;">Emp. no.</th>
                                        <th rowspan="2">Name-Surname</th>
                                        <th rowspan="2">Position</th>
                                        <th rowspan="2">Group</th>
                                        <th rowspan="2">Join date</th>
                                        <th rowspan="2">Service period(days)</th>
                                        <th colspan="8" class="text-center bg-light-dark">Attendance</th>
                                        <th colspan="3" class="text-center bg-light-danger">Warning record</th>
                                        @php
                                            $previousYear3 = date('Y', strtotime('-3 year'));
                                            $previousYear2 = date('Y', strtotime('-2 year'));
                                            $previousYear1 = date('Y', strtotime('-1 year'));
                                            if(date('Y-m') <= (date('Y').'-2')){
                                                $previousYear = date('Y', strtotime('-1 year'));
                                            }else{
                                                $previousYear = date('Y');
                                            }
                                        @endphp
                                        <th rowspan="2">PA {{$previousYear3}}</th>
                                        <th rowspan="2">PA {{$previousYear2}}</th>
                                        <th rowspan="2">PA {{$previousYear1}}</th>
                                        <th rowspan="2">Form</th>
                                        <th rowspan="2">Evaluator {{$previousYear}}</th>
                                        <th rowspan="2">Approved score</th>
                                        <th rowspan="2">Theoretical Level</th>
                                        <th rowspan="2">Adjust Level</th>
                                        <th rowspan="2">Current B.Salary/Wage</th>
                                        <th rowspan="2">L800 AVG. Wage of Min.Wage Adjusted</th>
                                        <th rowspan="2">B.Salary/Wage for Calculation</th>
                                        <th rowspan="2">Current B.Salary/Wage (THB/Mth)</th>
                                        <th rowspan="2">Company Suggested (%)</th>
                                        <th rowspan="2">Company Suggestged (Amount)</th>
                                        <th rowspan="2">Company Suggestged New Basic</th>
                                        <th rowspan="2">Grade by Mgr.</th>
                                        <th rowspan="2">Inc. % Proposed by Mgr.</th>
                                        <th rowspan="2">Inc. Amount Proposed by Mgr.</th>
                                        <th rowspan="2">New Basic/Wage Proposed by Mgr.</th>
                                        <th rowspan="2">New B.Salary/Wage (THB/Mth)</th>
                                        <th rowspan="2">Final by DM/GM (Amount)</th>
                                        <th rowspan="2">Remark(P,AR,U)</th>
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2" style="min-width:100px;">Action</th>
                                    </tr>
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th class="text-center bg-light-dark">SL</th>
                                        <th class="text-center bg-light-dark">PL<br><span class="small">(Unpaid)</span></th>
                                        <th class="text-center bg-light-dark">LATE<br><span class="small">(Times)</span></th>
                                        <th class="text-center bg-light-dark">LATE<br><span class="small">(Days)</span></th>
                                        <th class="text-center bg-light-dark">Absent<br><span class="small">(Times)</span></th>
                                        <th class="text-center bg-light-dark">Absent<br><span class="small">(Days)</span></th>
                                        <th class="text-center bg-light-dark">OL</th>
                                        <th class="text-center bg-light-dark">Total days</th>
                                        <th class="bg-light-danger text-center">Verbal<br><span class="small">(Times)</span></th>
                                        <th class="bg-light-danger text-center">Written<br><span class="small">(Times)</span></th>
                                        <th class="bg-light-danger text-center">Suspension<br><span class="small">(Days)</span></th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    <div class="tableMobile" style="display:none;">
                        <div class="row gx-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="editList">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Approved</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="editList">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-cross-circle fs-3 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Rejected</span>
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
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <div class="col-4">Search:</div>
                                    <div class="col-8"><input type="text" class="form-control form-control-sm"></div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-y overflow-auto" style="height:50vh">
                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                        Emp no.: 123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-1">จันทรัตว์ ชัยชนา</p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-2">
                                        <thead class="bg-light-dark">
                                            <tr class="text-center">
                                                <th colspan="8">Attendance</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>SL</th>
                                                <th>PL<p class="small mb-0 fw-normal">(Unpaid)</p></th>
                                                <th>LATE<p class="small mb-0 fw-normal">(Times)</p></th>
                                                <th>LATE<p class="small mb-0 fw-normal">(Days)</p></th>
                                                <th>Absent<p class="small mb-0 fw-normal">(Times)</p></th>
                                                <th>Absent<p class="small mb-0 fw-normal">(Days)</p></th>
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
                                <table class="table table-sm table-bordered mb-2">
                                    <thead class="bg-light-danger">
                                        <tr class="text-center">
                                            <th colspan="3">Warning record</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Verbal<p class="small mb-0 fw-normal">(Times)</p></th>
                                            <th>Written<p class="small mb-0 fw-normal">(Times)</p></th>
                                            <th>Suspension<p class="small mb-0 fw-normal">(Days)</p></th>
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
                                            <span class="small text-gray-800">PA2020:<br></span>
                                            <h1 class='badge gradeP w-100 text-center fs-3 d-block py-2 mb-0'>P</h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800">PA2021:<br></span>
                                            <h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800">PA2022:<br></span>
                                            <h1 class='badge gradeB w-100 text-center fs-3 d-block py-2 mb-0'>B</h1>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Form: </span><span class="fs-4 text-black fw-semibold">F2</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Evaluator: </span><span class="fs-4 text-black fw-semibold">xxxxxxxxxxx</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Approved score: </span><span class="fs-4 text-black fw-semibold">93.0</span></p>
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800">Theoretical G.:<br></span>
                                            <h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-black">
                                            <span class="small text-gray-800">Adjust G.:<br></span>
                                            <h1 class='badge gradeA w-100 text-center fs-3 d-block py-2 mb-0'>A</h1>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                                <p class="mb-3">
                                    <span class="small text-gray-800">Current B. Salary/Wage: </span><br>
                                    <span class="fs-4 text-black fw-semibold">15,070.00</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">L800 AVG. Wage of Min.Wage Adjusted: </span><br>
                                    <span class="fs-4 text-black fw-semibold">-</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">B.Salary/Wage for Calculation: </span><br>
                                    <span class="fs-4 text-black fw-semibold">15,070.00</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Current B.Salary/Wage(THB/Mth): </span><br>
                                    <span class="fs-4 text-black fw-semibold">15,070.00</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Company Suggested(%): </span><br>
                                    <span class="fs-4 text-black fw-semibold">6.00%</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Company Suggestged (Amount): </span><br>
                                    <span class="fs-4 text-black fw-semibold">904.20</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Company Suggestged New Basic: </span><br>
                                    <span class="fs-4 text-black fw-semibold">15,907.00</span>
                                </p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Grade by Mgr.: </span></p>
                                <select class='form-select form-select-sm selectG gradeC mb-2' onchange='change_class(this);'>
                                    <option class='' value='AR'>AR</option>
                                    <option class='gradeP' value='P'>P</option>
                                    <option class='gradeA' value='A'>A</option>
                                    <option class='gradeB' value='B'>B</option>
                                    <option class='gradeC' value='C' selected>C</option>
                                    <option class='gradeD' value='D'>D</option>
                                    <option class='gradeE' value='E'>E</option>
                                    <option class='' value='U'>U</option>
                                    <option class='' value='CD'>CD</option>
                                </select>
                                <span class='small fw-bold'>A &#62; <span class='text-primary'>C</span></span>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Inc. % Proposed by Mgr.:  </span></p>
                                <div class="row gx-2 mb-3 align-items-center">
                                    <div class="col-10">
                                    <input type='text' class='form-control form-control-sm bg-light-warning' value='3.00'>
                                    </div>
                                    <div class="col-2">
                                        %
                                    </div>
                                    <div class="col-12"><span class='small fw-bold'>6.00% &#62; <span class='text-primary'>3.00%</span></span></div>
                                </div>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Inc. Amount Proposed by Mgr.:  </span><br>
                                    <span class="fs-4 text-black fw-semibold">452.10</span>
                                </p>
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">New Basic/Wage Proposed by Mgr.: </span><br>
                                    <span class="fs-4 text-black fw-semibold">15,520.00</span>
                                </p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">New B.Salary/Wage (THB/Mth):  </span></p>
                                <p class="fw-bold text-primary fs-4">15520.00</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Final by DM/GM (Amount):  </span></p>
                                <p class="fw-bold text-success fs-4">15520.00</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Remark(P,AR,U):  </span></p>
                                <input type="text" class="form-control mb-3" value="">
                                <p class="mb-3 text-black">
                                    <span class="small text-gray-800">Status: </span><span class="badge badge-light-danger">Reject</span>
                                </p>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                        Reject
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- <div class="text-center pt-3">
                    <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                    </div> -->
                    <!--table summary-->
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
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Bell curve info.</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="bellcurve_close">
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
                                <th>47</th>
                                <th class="table-success">47</th>
                            </tr>
                        </tfoot>
                    </table>
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
                </div>
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
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Approve Budget</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="approveB_close">
                    <i class="ki-outline ki-cross fs-1"></i>              
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="card shadow-none rounded-3 mb-3">
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
                                    class="badge badge-light-success text-center py-2 mb-0"
                                >
                                    2.710%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget 2023</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0"
                                >
                                    3.000%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none rounded-3 mb-3">
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
                                    class="badge badge-light-success text-center py-2 mb-0"
                                >
                                    3.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget 2023</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0"
                                >
                                    3.260%
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-none rounded-3 mb-3">
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
                                    class="badge badge-light-success text-center py-2 mb-0"
                                >
                                    3.000%
                                </h1>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">
                                <b>Approved Budget 2023</b>
                            </div>
                            <div class="col-sm-auto text-end">
                                <h1
                                    class="badge badge-light-warning text-danger text-center py-2 mb-0"
                                >
                                    3.260%
                                </h1>
                            </div>
                        </div>
                    </div>
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
    <!--end::approve budget modal-->
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
                    <button type="button" class="btn btn-outline btn-outline-dark rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="approveModal_update();">Confirm</button>
                    <input type="hidden" id="approveModal_id" value="">
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
                    <h3 class="modal-title">{{ __('Confirm reject salary') }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                    <h1 class="ki-solid ki-cross-circle text-danger fs-5r"></h1>
                    <p>{{ __('Confirm reject salary') }} ?</p>
                    </div>
                    <!-- <p class="fw-bold mb-2">Additional detail:</p>
                    <textarea class="form-control" rows="3"></textarea> -->
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-outline btn-outline-dark rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="rejectModal_update();">Confirm Reject</button>
                    <input type="hidden" id="rejectModal_id" value="">
                </div>
            </div>
        </div>
    </div>
    <!--end::reject modal-->
    <!--begin::edit grade modal-->
    <div class="modal fade" tabindex="-1" id="editG">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit grade</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="change_percent_select();">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="approveModal_all">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm approval') }}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
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
    <div class="modal fade" tabindex="-1" id="rejectModal_all">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{ __('Confirm reject salary') }}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                    <h1 class="ki-solid ki-cross-circle text-danger fs-5r"></h1>
                    <p>{{ __('Confirm reject salary') }} ?</p>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger  rounded-pill btn-sm" data-bs-dismiss="modal" onclick="rejectModal_update_all();">Confirm Reject</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script type="text/javascript">
    $(function() {
        var otable = $("#kt_datatable_dom_positioning").DataTable({
            fixedColumns: {
                left: 3,
            },
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
                url: "{{ url(Request::segment(1).'/table_rsalary_getdata') }}",
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
                { data: "id" },
                { data: "code" },
                { data: "name" },
                { data: "position" },
                { data: "group" },
                { data: "joindate" },
                { data: "serviced" },
                { data: "sl" },
                { data: "pl" },
                { data: "latet" },
                { data: "lated" },
                { data: "abst" },
                { data: "absd" },
                { data: "ol" },
                { data: "totald" },
                { data: "verbal" },
                { data: "written" },
                { data: "susd" },
                { data: "pa2020" },
                { data: "pa2021" },
                { data: "pa2022" },
                { data: "form" },
                { data: "evaluator" },
                { data: "total" },
                { data: "theoryg" },
                { data: "adjustg" },
                { data: "current" },
                { data: "l800avg" },
                { data: "bsalaryw" },
                { data: "cbsalaryw" },
                { data: "comsugpct" },
                { data: "comsugamt" },
                { data: "companynewb" },
                { data: "gmgr" },
                { data: "incpctmgr" },
                { data: "incamount" },
                { data: "newbwage" },
                { data: "newbsalary" },
                { data: "finaldmgm" },
                { data: "remark" },
                { data: "status" },
                { data: "action" },
            ],
            columnDefs: [ {
                "targets": 0,
                "orderable": false
            },{
                "targets": 7,
                "orderable": false
            },{
                "targets": 7,
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
        $('#search_division').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_department').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_section').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_month_day').on('change', function(e) {
            if($('#search_month_day').val() == '1'){
                $('.hide_Daily').css('display','');
                $('.hide_Monthly').css('display','none');
            }else{
                $('.hide_Daily').css('display','none');
                $('.hide_Monthly').css('display','');
            }
            otable.draw();
            all_detail();
        });
        $('#search_grade').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_status').on('change', function(e) {
            otable.draw();
            all_detail();
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
        evaluate_get_all();
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
        $('#kt_datatable_dom_positioning').DataTable().destroy();
        setTimeout(() => {
            search_data();
        }, 200);
    }
    function search_data(){
        var otable = $("#kt_datatable_dom_positioning").DataTable({
            fixedColumns: {
                left: 3,
            },
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
                url: "{{ url(Request::segment(1).'/table_rsalary_getdata') }}",
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
                { data: "id" },
                { data: "code" },
                { data: "name" },
                { data: "position" },
                { data: "group" },
                { data: "joindate" },
                { data: "serviced" },
                { data: "sl" },
                { data: "pl" },
                { data: "latet" },
                { data: "lated" },
                { data: "abst" },
                { data: "absd" },
                { data: "ol" },
                { data: "totald" },
                { data: "verbal" },
                { data: "written" },
                { data: "susd" },
                { data: "pa2020" },
                { data: "pa2021" },
                { data: "pa2022" },
                { data: "form" },
                { data: "evaluator" },
                { data: "total" },
                { data: "theoryg" },
                { data: "adjustg" },
                { data: "current" },
                { data: "l800avg" },
                { data: "bsalaryw" },
                { data: "cbsalaryw" },
                { data: "comsugpct" },
                { data: "comsugamt" },
                { data: "companynewb" },
                { data: "gmgr" },
                { data: "incpctmgr" },
                { data: "incamount" },
                { data: "newbwage" },
                { data: "newbsalary" },
                { data: "finaldmgm" },
                { data: "remark" },
                { data: "status" },
                { data: "action" },
            ],
            columnDefs: [ {
                "targets": 0,
                "orderable": false
            },{
                "targets": 7,
                "orderable": false
            },{
                "targets": 7,
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
        $('#search_division').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_department').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_section').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_month_day').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_grade').on('change', function(e) {
            otable.draw();
            all_detail();
        });
        $('#search_status').on('change', function(e) {
            otable.draw();
            all_detail();
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
    function change_class(e,i,id,employee_id) {
        var hidden_budget_grade_name = $('.hidden_budget_grade_name'); 
        var hidden_budget_std = $('.hidden_budget_std'); 
        console.log(id);
        for(var i = 0;i < hidden_budget_std.length;i++){
            if(hidden_budget_grade_name[i].value == e.value){
                $('#percent_proposed'+id).val(hidden_budget_std[i].value);
                $('.percent_proposed'+id).html(hidden_budget_std[i].value+'%');
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
                        // destroy_table();
                    }
                });
            }
        }
    }
    function change_class_input(e,i,id,edit_by_dmgm) {
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
                "edit_by_dmgm":edit_by_dmgm
            },
            success: function (result) {
                $('.grade_proposed_old'+id).html(result.grade_proposed_old+' &#62; ');
                $('.percent_proposed_old'+id).html(result.percent_proposed_old+'% &#62; ');
                $('.amount_proposed'+id).html(result.amount_proposed);
                $('.salary_new'+id).html(result.salary_new);
                $('.salary_month_new'+id).html(result.salary_month_new);
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
                
            }
        });
    }
    function all_detail(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/all_detail") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_section":$('#search_section').val(),
                "search_month_day":$('#search_month_day').val(),
                "search_grade":$('#search_grade').val(),
                "search_status":$('#search_status').val()
            },
            success: function (result) {
                if(result){
                    if(result.percent_department){
                        var percent_daily = result.percent_department.percent_daily;
                        var percent_monthly = result.percent_department.percent_monthly;
                        $('.percent_department_daily_percent').html((percent_daily>0?number_format2(percent_daily,3)+'%':''));
                        $('.percent_department_monthly_percent').html((percent_monthly>0?number_format2(percent_monthly,3)+'%':''));
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

                        var cal_daily = (parseFloat(sum_salary_new)/parseFloat(sum_salary_old)-1)*100;
                        var cal_month = (parseFloat(sum_salary_month_new)/parseFloat(sum_salary_month_old)-1)*100;
                        if($('#search_month_day').val() == '1'){
                            $('.Overall_daily_percent').html(number_format2(cal_daily,3)+'%');
                        }else{
                            $('.Overall_monthly_percent').html(number_format2(cal_month,3)+'%');
                        }   
                    }      
                    if(result.footer){
                        var html = ``;
                        var Monthly = ``;
                        var Daily = ``;
                        var All = ``;
                        $.each(result.footer, function (key, value) {	
                            if(value.total_type == '1'){
                                Monthly += `
                                    <tr class="align-middle">
                                        <td class="fw-bold">Monthly</td>
                                        <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                                        <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                                        <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                                        <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                                        <td class="text-center">${value.company_suggested_percent}%</td>
                                        <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                                        <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                                        <td></td>
                                        <td class="text-center">${value.inc_percent_proposed}%</td>
                                        <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                                    </tr>
                                `;
                            }
                            if(value.total_type == '0'){
                                Daily += `
                                    <tr class="align-middle">
                                        <td class="fw-bold">Daily</td>
                                        <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                                        <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                                        <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                                        <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                                        <td class="text-center">${value.company_suggested_percent}%</td>
                                        <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                                        <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                                        <td></td>
                                        <td class="text-center">${value.inc_percent_proposed}%</td>
                                        <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                                    </tr>
                                `;
                            }
                            if(value.total_type == '2'){
                                All += `
                                    <tr class="align-middle">
                                        <td class="fw-bold">Total Monthly+Daily</td>
                                        <td class="text-end">${(value.current_salary_wage>0?number_format(value.current_salary_wage,2):'')}</td>
                                        <td class="text-end">${(value.L800_avg_wage_mwa>0?number_format(value.L800_avg_wage_mwa,2):'')}</td>
                                        <td class="text-end">${(value.salary_wage_calculation>0?number_format(value.salary_wage_calculation,2):'')}</td>
                                        <td class="text-end">${(value.current_salary_wage_month>0?number_format(value.current_salary_wage_month,2):'')}</td>
                                        <td class="text-center">${value.company_suggested_percent}%</td>
                                        <td class="text-end">${(value.company_suggested_amount>0?number_format(value.company_suggested_amount,2):'')}</td>
                                        <td class="text-end">${(value.company_suggested_new_basic>0?number_format(value.company_suggested_new_basic,2):'')}</td>
                                        <td></td>
                                        <td class="text-center">${value.inc_percent_proposed}%</td>
                                        <td class="text-end">${(value.inc_amount_proposed>0?number_format(value.inc_amount_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_basic_wage_proposed>0?number_format(value.new_basic_wage_proposed,2):'')}</td>
                                        <td class="text-end">${(value.new_salary_wage_month>0?number_format(value.new_salary_wage_month,2):'')}</td>
                                    </tr>
                                `;
                            }
                        })
                        html = Monthly+Daily+All;
                        $('.data_footer').html(html);
                    } 
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
                        $('.total_theoretical_LevelA').html(sumA);
                        $('.total_theoretical_LevelB').html(sumB);
                        $('.total_theoretical_LevelC').html(sumC);
                        $('.total_theoretical_LevelD').html(sumD);
                        $('.total_theoretical_LevelE').html(sumE);
                    }
                }
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
                    destroy_table();
                    $('#editG').modal('hide');
                }
            });
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
                    destroy_table();
                    $('#editG').modal('hide');
                }
            });
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
    function set_approveModal_id(id){
        $('#approveModal_id').val(id);
    }
    function set_rejectModal_id(id){
        $('#rejectModal_id').val(id);
    }
    function evaluate_get_all(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/approve_salary_get_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
            },
            success: function (result) { 
                $('.all_employee').text(result.data);
                $('.all_inprogress').text(result.data1);
                $('.all_finish').text(result.data2);
                $('.all_reject').text(result.data3);
                
            }
        });
    }
    function approveModal_update(){
        var approveModal_id = $('#approveModal_id').val();
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/approve_salary") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":approveModal_id,
                "status_salary":"1"
            },
            success: function (result) { 
                $('.set_status'+approveModal_id).html('Approved');
                $('.set_status'+approveModal_id).removeClass('badge-light');
                $('.set_status'+approveModal_id).removeClass('badge-light-danger');
                $('.set_status'+approveModal_id).addClass('badge-light-success');
                evaluate_get_all();
            }
        });
    }
    function rejectModal_update(){
        var rejectModal_id = $('#rejectModal_id').val();
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/approve_salary") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":rejectModal_id,
                "status_salary":"2"
            },
            success: function (result) { 
                $('.set_status'+rejectModal_id).html('Reject');
                $('.set_status'+rejectModal_id).removeClass('badge-light');
                $('.set_status'+rejectModal_id).removeClass('badge-light-success');
                $('.set_status'+rejectModal_id).addClass('badge-light-danger');
                evaluate_get_all();
            }
        });
    }
    function approveModal_update_all(){
        var getCheckbox = [];
        $('.checkbox-select').each(function() {
            if(this.checked == true){
                getCheckbox.push(this.value);
            }                
        });
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/approve_salary_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":getCheckbox,
                "status_salary":"1"
            },
            success: function (result) { 
                $('.checkbox-select').each(function() {
                    if(this.checked == true){
                        $('.set_status'+this.value).html('Approved');
                        $('.set_status'+this.value).removeClass('badge-light');
                        $('.set_status'+this.value).removeClass('badge-light-danger');
                        $('.set_status'+this.value).addClass('badge-light-success');
                        
                    }                
                });
                evaluate_get_all();
            }
        });
    }
    function rejectModal_update_all(){
        var getCheckbox = [];
        $('.checkbox-select').each(function() {
            if(this.checked == true){
                getCheckbox.push(this.value);
            }                
        });
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/approve_salary_all") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":getCheckbox,
                "status_salary":"2"
            },
            success: function (result) { 
                $('.checkbox-select').each(function() {
                    if(this.checked == true){
                        $('.set_status'+this.value).html('Reject');
                        $('.set_status'+this.value).removeClass('badge-light');
                        $('.set_status'+this.value).removeClass('badge-light-success');
                        $('.set_status'+this.value).addClass('badge-light-danger');
                        
                    }                
                });
                evaluate_get_all();
            }
        });
    }
    function update_final_by_md_gm_amount(id){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/update_final_by_md_gm_amount") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "id":id,
                "final_by_md_gm_amount":$('#final_by_md_gm_amount'+id).val()
            },
            success: function (result) {
                
            }
        });
    }
    function checknumber(id){
        var input = document.getElementById("final_by_md_gm_amount"+id);
        input.onkeydown = function(e) {
            if (48 > e.which || e.which > 57) {
                if (e.which != 190) {
                    console.log(e.which);
                    if ( e.key.length === 1 ) e.preventDefault();
                }
            }
        };
    }
</script>
@endpush
</x-default-layout>
