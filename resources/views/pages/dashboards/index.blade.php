<x-default-layout>

    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-12">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <div class="accordion accordion-icon-collapse mb-3 " id="kt_accordion_3" style="padding: 0px 20px;">
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
                            </div>
                        </div>
                        <div id="kt_accordion_3_item_2" class="collapse fs-6" data-bs-parent="#kt_accordion_3">
                            <div class="d-md-block">
                                <div class="row g-3 mb-3" style="font-size: 14px;">
                                    
                                    
                                    <div class="col-12 col-sm-3" style="font-size: 14px;">
                                        <label
                                            style="font-size: 14px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Division</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_division" name="search_division[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_department();">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-3" style="font-size: 14px;">
                                        <label
                                            style="font-size: 14px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Department</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_department" name="search_department[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_section();">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-3" style="font-size: 14px;">
                                        <label
                                            style="font-size: 14px;"
                                            for="exampleFormControlInput1"
                                            class="form-label mb-0"
                                            >Section</label
                                        >
                                        <select class="form-select myLike" data-control="select2" id="search_section" name="search_section[]" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="destroy_table();">
                                        
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-3" style="font-size: 14px;">
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
                        </div>
                    </div>
                </div>
                
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">SUMMARY PA GRADING(TOTAL PERSON & %EACH GRADE)</span>
                        @php
                            
                                $checkYear = date('Y');
                                $segment = trans(request()->segment(1));
                        @endphp
                        <input type="hidden" id="segment" value="{{$segment}}">
                        <input type="hidden" id="nowyear" value="{{$checkYear}}">
                        <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
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
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        
        <!--end::Col-->
    </div>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-12">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">SUMMARY BY DIVISION</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>Div.</th>
                                <!-- <th>Dept.</th>
                                <th>Sec.</th> -->
                                <th>Total no. of staff</th>
                                <th>Total Sum of current B.Salary/Wage (THB/Mth)</th>
                                <th>Total Sum of New B.Salary/Wage (THB/Mth)</th>
                                <th>Total %Increase</th>
                            </tr>
                        </thead>
                    </table>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
    </div>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">SALARY ADJUSTMENT</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning2" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th colspan="3">Count of grade</th>
                                <th colspan="9">Grade proposed by Mgr.</th>
                                <th rowspan="2">TotalPersons</th>
                            </tr>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>Div.</th>
                                <th>Dept.</th>
                                <th>Sec.</th>
                                <th>P</th>
                                <th>AR</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>U</th>
                                <th>CD</th>
                            </tr>
                        </thead>
                    </table>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
        <div class="col-xxl-6">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">SALARY ADJUSTMENT <span class="card-label fw-bold text-dark" style="font-size: 10px;">% Split per Quota</span></span>
                        
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning3" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th colspan="4" style="color: #F35421;">% Split per Quota</th>
                                <th class="showgradeP"></th>
                                <th class="showgradeAR"></th>
                                <th class="showgradeA"></th>
                                <th class="showgradeB"></th>
                                <th class="showgradeC"></th>
                                <th class="showgradeD"></th>
                                <th class="showgradeE"></th>
                                <th class="showgradeU"></th>
                                <th></th>
                            </tr>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th colspan="3">Count of grade</th>
                                <th colspan="9">Grade proposed by Mgr.</th>
                                <th rowspan="2">TotalPersons</th>
                            </tr>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>Div.</th>
                                <th>Dept.</th>
                                <th>Sec.</th>
                                <th>P</th>
                                <th>AR</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>U</th>
                                <th>CD</th>
                            </tr>
                        </thead>
                    </table>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
    </div>

    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-xxl-6">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">TOTAL PERSONs</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning4" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7 text-center align-middle">
                                <th></th>
                                <th class="bell_total_all2" style="border: 1px solid #F5F5F5;background: #FFCF52;">0</th>
                                <th>%</th>
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
                                <td>{{$val->grade_name}}</td>
                                <td class="total_theoretical_Level{{$val->grade_name}}"></td>
                                <td class="total_adjust_Level{{$val->grade_name}}"></td>
                            </tr>
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
        <div class="col-xxl-6">
            <div class="card card-flush overflow-hidden h-lg-100">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">ALL L600 - L800</span>
                        
                    </h3>
                </div>
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning5" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th colspan="3"></th>
                                <th colspan="2">Daily</th>
                                <th colspan="2">Monthly</th>
                            </tr>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>Div.</th>
                                <th>Dept.</th>
                                <th>Sec.</th>
                                <th>% Overall increment - Actual</th>
                                <th>Approved Budget</th>
                                <th>% Overall increment - Actual</th>
                                <th>Approved Budget</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-xxl-6" style="display:none;">
            <!--begin::Chart widget 36-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">ALL L600 - L800</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="table-responsive" style="padding: 10px;">
                    <table id="kt_datatable_dom_positioning4" class="table table-striped rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th style="border-radius: 10px;border: 1px solid #E8FFF3;background: #E8FFF3;">0.00%</th>
                                <th style="color: #50CD89;">% Overall increment - Actual </th>
                            </tr>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th style="border-radius: 10px;border: 1px solid #FFF8DD;background: #FFF8DD;">0.00%</th>
                                <th style="color: #F1416C;">Approved Budget </th>
                            </tr>
                        </thead>
                    </table>

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 36-->
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('scripts')
<script>
    $(function() {
        get_division_first();
        // $.ajax({
        //     type: 'POST',
        //     url: '{{ url(Request::segment(1)."/check_row") }}',
        //     dataType: 'json',
        //     data : { 
        //         "_token": "{{ csrf_token() }}",
        //         "user_id":$('#user_id').val()
        //     },
        //     success: function (result) {
                
        //     }
        // });
        // bell_curve_detail();
        // var otable = $("#kt_datatable_dom_positioning").DataTable({
            
        //     searchDelay: 500,
        //     processing: true,
        //     serverSide: true,
        //     scrollY: true,
        //     scrollX: true,
        //     scrollCollapse: true,
        //     info: false,
        //     // "ordering": false,
        //     // "searching": false,
        //     // "paging": false,
        //     ajax: {
        //         url: "{{ url(Request::segment(1).'/get_summary_by_division') }}",
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
        //             // console.log(d);
        //             if($('#search_division').val().length > 0){
        //                 d.search_division = $('#search_division').val();
        //             }   
        //             if($('#search_department').val().length > 0){
        //                 d.search_department = $('#search_department').val();
        //             }   
        //             if($('#search_section').val().length > 0){
        //                 d.search_section = $('#search_section').val();
        //             }   
        //             if($('#search_year').val().length > 0){
        //                 d.search_year = $('#search_year').val();
        //             }  
        //             d.pagenow = '1';
        //             oData = d
        //         },
        //     },
        //     columns: [
        //         { data: 'division_code' },
        //         // { data: 'dept' },
        //         // { data: 'sect' },
        //         { data: 'Total1' },
        //         { data: 'Total2' },
        //         { data: 'Total3' },
        //         { data: 'Total4' },
        //     ],
        //     columnDefs: [],
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
        // var otable2 = $("#kt_datatable_dom_positioning2").DataTable({
            
        //     searchDelay: 500,
        //     processing: true,
        //     serverSide: true,
        //     scrollY: true,
        //     scrollX: true,
        //     scrollCollapse: true,
        //     info: false,
        //     // "ordering": false,
        //     // "searching": false,
        //     // "paging": false,
        //     ajax: {
        //         url: "{{ url(Request::segment(1).'/get_salary_adjust') }}",
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
        //             // console.log(d);
        //             if($('#search_division').val().length > 0){
        //                 d.search_division = $('#search_division').val();
        //             }   
        //             if($('#search_department').val().length > 0){
        //                 d.search_department = $('#search_department').val();
        //             }   
        //             if($('#search_section').val().length > 0){
        //                 d.search_section = $('#search_section').val();
        //             }   
        //             if($('#search_year').val().length > 0){
        //                 d.search_year = $('#search_year').val();
        //             }  
        //             d.pagenow = '1';
        //             oData = d
        //         },
        //     },
        //     columns: [
        //         { data: 'division_code' },
        //         { data: 'department_code' },
        //         { data: 'section_code' },
        //         { data: 'P' },
        //         { data: 'AR' },
        //         { data: 'A' },
        //         { data: 'B' },
        //         { data: 'C' },
        //         { data: 'D' },
        //         { data: 'E' },
        //         { data: 'U' },
        //         { data: 'CD' },
        //         { data: 'Total' },
        //     ],
        //     columnDefs: [],
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
        // var otable3 = $("#kt_datatable_dom_positioning3").DataTable({
            
        //     searchDelay: 500,
        //     processing: true,
        //     serverSide: true,
        //     scrollY: true,
        //     scrollX: true,
        //     scrollCollapse: true,
        //     info: false,
        //     // "ordering": false,
        //     // "searching": false,
        //     // "paging": false,
        //     ajax: {
        //         url: "{{ url(Request::segment(1).'/get_salary_adjust_split') }}",
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
        //             // console.log(d);
        //             if($('#search_division').val().length > 0){
        //                 d.search_division = $('#search_division').val();
        //             }   
        //             if($('#search_department').val().length > 0){
        //                 d.search_department = $('#search_department').val();
        //             }   
        //             if($('#search_section').val().length > 0){
        //                 d.search_section = $('#search_section').val();
        //             }   
        //             if($('#search_year').val().length > 0){
        //                 d.search_year = $('#search_year').val();
        //             }  
        //             d.pagenow = '1';
        //             oData = d
        //         },
        //     },
        //     columns: [
        //         { data: 'division_code' },
        //         { data: 'department_code' },
        //         { data: 'section_code' },
        //         { data: 'P' },
        //         { data: 'AR' },
        //         { data: 'A' },
        //         { data: 'B' },
        //         { data: 'C' },
        //         { data: 'D' },
        //         { data: 'E' },
        //         { data: 'U' },
        //         { data: 'CD' },
        //         { data: 'Total' },
        //     ],
        //     columnDefs: [],
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
        // var otable5 = $("#kt_datatable_dom_positioning5").DataTable({
            
        //     searchDelay: 500,
        //     processing: true,
        //     serverSide: true,
        //     scrollY: true,
        //     scrollX: true,
        //     scrollCollapse: true,
        //     info: false,
        //     // "ordering": false,
        //     // "searching": false,
        //     // "paging": false,
        //     ajax: {
        //         url: "{{ url(Request::segment(1).'/get_approved_budget') }}",
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
        //             // console.log(d);
        //             if($('#search_division').val().length > 0){
        //                 d.search_division = $('#search_division').val();
        //             }   
        //             if($('#search_department').val().length > 0){
        //                 d.search_department = $('#search_department').val();
        //             }   
        //             if($('#search_section').val().length > 0){
        //                 d.search_section = $('#search_section').val();
        //             }   
        //             if($('#search_year').val().length > 0){
        //                 d.search_year = $('#search_year').val();
        //             }  
        //             d.pagenow = '1';
        //             oData = d
        //         },
        //     },
        //     columns: [
        //         { data: 'division_code' },
        //         { data: 'department_code' },
        //         { data: 'section_code' },
        //         { data: 'Total' },
        //         { data: 'percent_daily' },
        //         { data: 'Total2' },
        //         { data: 'percent_monthly' },
        //     ],
        //     columnDefs: [],
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
        // get_salary_adjust();
    });
    function destroy_table_first(){
        loading();
        // bell_curve_detail();
        // $(".chartreport #myChart").remove();
        // $(".chartreport").append('<canvas id="myChart"></canvas>');
        // var grapharea = document.getElementById("myChart").getContext("2d");
        // var myChart = new Chart(grapharea);
        // myChart.destroy();

        // $(".chartreport2 #myChart2").remove();
        // $(".chartreport2").append('<canvas id="myChart2"></canvas>');
        // var grapharea2 = document.getElementById("myChart2").getContext("2d");
        // var myChart2 = new Chart(grapharea2);
        // myChart2.destroy();
        setTimeout(() => {
            $('#kt_datatable_dom_positioning').DataTable().destroy();
            $('#kt_datatable_dom_positioning2').DataTable().destroy();
            $('#kt_datatable_dom_positioning3').DataTable().destroy();
            $('#kt_datatable_dom_positioning5').DataTable().destroy();
            search_data();
        }, 200);
    }
    function destroy_table(){
        loading();
        bell_curve_detail();
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
        setTimeout(() => {
            $('#kt_datatable_dom_positioning').DataTable().destroy();
            $('#kt_datatable_dom_positioning2').DataTable().destroy();
            $('#kt_datatable_dom_positioning3').DataTable().destroy();
            $('#kt_datatable_dom_positioning5').DataTable().destroy();
            search_data();
        }, 200);
    }
    function search_data(){
        bell_curve_detail();
        var otable = $("#kt_datatable_dom_positioning").DataTable({
            
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            info: false,
            // "ordering": false,
            // "searching": false,
            // "paging": false,
            ajax: {
                url: "{{ url(Request::segment(1).'/get_summary_by_division') }}",
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
                    if($('#search_year').val().length > 0){
                        d.search_year = $('#search_year').val();
                    }  
                    d.pagenow = '1';
                    oData = d
                },
            },
            columns: [
                { data: 'division_code' },
                // { data: 'dept' },
                // { data: 'sect' },
                { data: 'Total1' },
                { data: 'Total2' },
                { data: 'Total3' },
                { data: 'Total4' },
            ],
            columnDefs: [],
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
        var otable2 = $("#kt_datatable_dom_positioning2").DataTable({
            
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            info: false,
            // "ordering": false,
            // "searching": false,
            // "paging": false,
            ajax: {
                url: "{{ url(Request::segment(1).'/get_salary_adjust') }}",
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
                    if($('#search_year').val().length > 0){
                        d.search_year = $('#search_year').val();
                    }  
                    d.pagenow = '1';
                    oData = d
                },
            },
            columns: [
                { data: 'division_code' },
                { data: 'department_code' },
                { data: 'section_code' },
                { data: 'P' },
                { data: 'AR' },
                { data: 'A' },
                { data: 'B' },
                { data: 'C' },
                { data: 'D' },
                { data: 'E' },
                { data: 'U' },
                { data: 'CD' },
                { data: 'Total' },
            ],
            columnDefs: [],
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
        var otable3 = $("#kt_datatable_dom_positioning3").DataTable({
            
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            info: false,
            // "ordering": false,
            // "searching": false,
            // "paging": false,
            ajax: {
                url: "{{ url(Request::segment(1).'/get_salary_adjust_split') }}",
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
                    if($('#search_year').val().length > 0){
                        d.search_year = $('#search_year').val();
                    }  
                    d.pagenow = '1';
                    oData = d
                },
            },
            columns: [
                { data: 'division_code' },
                { data: 'department_code' },
                { data: 'section_code' },
                { data: 'P' },
                { data: 'AR' },
                { data: 'A' },
                { data: 'B' },
                { data: 'C' },
                { data: 'D' },
                { data: 'E' },
                { data: 'U' },
                { data: 'CD' },
                { data: 'Total' },
            ],
            columnDefs: [],
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
        var otable5 = $("#kt_datatable_dom_positioning5").DataTable({
            
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollY: true,
            scrollX: true,
            scrollCollapse: true,
            info: false,
            // "ordering": false,
            // "searching": false,
            // "paging": false,
            ajax: {
                url: "{{ url(Request::segment(1).'/get_approved_budget') }}",
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
                    if($('#search_year').val().length > 0){
                        d.search_year = $('#search_year').val();
                    }  
                    d.pagenow = '1';
                    oData = d
                },
            },
            columns: [
                { data: 'division_code' },
                { data: 'department_code' },
                { data: 'section_code' },
                { data: 'Total' },
                { data: 'percent_daily' },
                { data: 'Total2' },
                { data: 'percent_monthly' },
            ],
            columnDefs: [],
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
        loading_hide();
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
    function bell_curve_detail(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/chart_pa_grade") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":($('#search_division').val().length > 0?$('#search_division').val():[]),
                "search_department":($('#search_department').val().length > 0?$('#search_department').val():[]),
                "search_section":($('#search_section').val().length > 0?$('#search_section').val():[]),
                "search_year":($('#search_year').val().length > 0?$('#search_year').val():'')
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
                                }],
                            },
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: $('#search_year').val()+' PA Grade '+text_chart,
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

                        $('.showgradeP').html(number_format2(sumQuotaP,1)+'%');
                        $('.showgradeAR').html(number_format2(sumQuotaAR,1)+'%');
                        $('.showgradeA').html(number_format2(sumQuotaA,1)+'%');
                        $('.showgradeB').html(number_format2(sumQuotaB,1)+'%');
                        $('.showgradeC').html(number_format2(sumQuotaC,1)+'%');
                        $('.showgradeD').html(number_format2(sumQuotaD,1)+'%');
                        $('.showgradeE').html(number_format2(sumQuotaE,1)+'%');
                        $('.showgradeU').html(number_format2(sumQuotaU,1)+'%');
                        $('.showgradeCD').html(number_format2(sumQuotaCD,1)+'%');


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
                                    label: $('#search_year').val()+' PA Grade',
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
                                        text: $('#search_year').val()+' PA Grade '+text_chart+' (% Split each Grade)',
                                        color: 'blue',
                                        font: {
                                            weight: 'bold',
                                            size: 12
                                        }
                                    },
                                    datalabels: {
                                        // Position of the labels 
                                        // (start, end, center, etc.)
                                        anchor: 'start',
                                        // Alignment of the labels 
                                        // (start, end, center, etc.)
                                        align: 'end',
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

                        $('.bell_total_all2').html(number_format2(countNoNull,1));
                        $('.total_theoretical_LevelAR').html(number_format2(countAR,1));
                        $('.total_theoretical_LevelP').html(number_format2(countP,1));
                        $('.total_theoretical_LevelA').html(number_format2(countA,1));
                        $('.total_theoretical_LevelB').html(number_format2(countB,1));
                        $('.total_theoretical_LevelC').html(number_format2(countC,1));
                        $('.total_theoretical_LevelD').html(number_format2(countD,1));
                        $('.total_theoretical_LevelE').html(number_format2(countE,1));
                        $('.total_theoretical_LevelU').html(number_format2(countU,1));
                        $('.total_theoretical_LevelCD').html(number_format2(countCD,1));

                        $('.total_adjust_LevelAR').html(number_format2(sumAR,1));
                        $('.total_adjust_LevelP').html(number_format2(sumP,1));
                        $('.total_adjust_LevelA').html(number_format2(sumA,1));
                        $('.total_adjust_LevelB').html(number_format2(sumB,1));
                        $('.total_adjust_LevelC').html(number_format2(sumC,1));
                        $('.total_adjust_LevelD').html(number_format2(sumD,1));
                        $('.total_adjust_LevelE').html(number_format2(sumE,1));
                        $('.total_adjust_LevelU').html(number_format2(sumU,1));
                        $('.total_adjust_LevelCD').html(number_format2(sumCD,1));
                    }
                }
            }
        });
    }
    function get_salary_adjust(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_salary_adjust") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}"
            },
            success: function (result) {
                
            }
        });
    }
    function get_salary_adjust_split(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_salary_adjust_split") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}"
            },
            success: function (result) {
                
            }
        });
    }
    function download1(){
        var a = document.getElementById('download_chart1');
        a.href = $('#hide_download_chart1').val();
        a.download = $('#search_year').val()+' PA Grade (L600 - L800).png';
        a.click();
    }
    function download2(){
        var a = document.getElementById('download_chart2');
        a.href = $('#hide_download_chart2').val();
        a.download = $('#search_year').val()+' PA Grade L600 - L800 (% Split each Grade).png';
        a.click();
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
                var html = ``;
                result.data.forEach(element => {
                    html += `<option value="${element.division_code}">${element.division_code}</option>`;
                });
                $('#search_division').html(html);
                setTimeout(() => {
                    get_department_first();
                }, 200);
            }
        });
    }
    function get_department_first(){
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
                var html = ``;
                result.data.forEach(element => {
                    html += `<option value="${element.department_code}">${element.department_code}</option>`;
                });
                $('#search_department').html(html);
                setTimeout(() => {
                    get_section_first();
                }, 200);
            }
        });
    }
    function get_section_first(){
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
                var html = ``;
                result.data.forEach(element => {
                    html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                });
                $('#search_section').html(html);
                setTimeout(() => {
                    destroy_table_first();
                }, 200);
            }
        });
    }
    function get_department(){
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
                var html = ``;
                result.data.forEach(element => {
                    html += `<option value="${element.department_code}">${element.department_code}</option>`;
                });
                $('#search_department').html(html);
                setTimeout(() => {
                    get_section();
                }, 200);
            }
        });
    }
    function get_section(){
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_section_salary") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_year":($('#search_year').val().length > 0?$('#search_year').val():'')
            },
            success: function (result) { 
                var html = ``;
                result.data.forEach(element => {
                    html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                });
                $('#search_section').html(html);
                setTimeout(() => {
                    destroy_table();
                }, 200);
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
#kt_datatable_dom_positioning2 td{
    padding:0px !important;
}
#kt_datatable_dom_positioning3 td{
    padding:0px !important;
}
</style>