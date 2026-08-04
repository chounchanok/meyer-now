<x-default-layout>

    @section('title')
        {{ __('Task Status Tracking') }} โดย HR
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('pa.follow.hr') }}
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
                            {{ __('Task Status Tracking') }}
                            <span class="card-label fw-bold text-gray-800" style="color: #7F8388;font-size: 12px;">
                                By HR
                            </span>
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                   <div class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Search Year')}}</label>
                            <select class="myLike form-select" id="year" name="year" onchange="search_data();">
                                <option value="">-Select-</option>
                                @if ($year != null)
                                    @foreach ($year as $val)
                                        @php
                                            
                                                $checkYear = date('Y');
                                            
                                        @endphp
                                        @if($val->rec_year == $checkYear)
                                            <option value="{{ $val->rec_year }}" selected> {{ $val->rec_year }}</option>
                                        @else
                                            <option value="{{ $val->rec_year }}"> {{ $val->rec_year }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Task</label>
                            <select class="form-select" data-control="select2" id="search_task" onchange="search_data();">
                                <!-- <option value="0">-Select-</option> -->
                                @foreach ($pa_timeline_action as $key => $val)
                                    @if($key == 0)
                                        <option value="{{ $val->id }}" selected>{{ $val->action_name }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ $val->action_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3" style="display:none;">
                            <label for="exampleFormControlInput1" class="form-label mb-0">โรงงาน</label>
                            <select class="form-select" data-control="select2" id="search_factory" onchange="search_data();">
                                @foreach ($factory as $key => $val)
                                    @if($key == 0)
                                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                            <select class="form-select" data-control="select2" id="search_department" onchange="search_data();">
                                <!-- <option value="0">-Select-</option> -->
                                @foreach ($department as $key => $val)
                                    @if($key == 0)
                                        <option value="{{ $val->department_code }}" selected>{{ $val->department_code }} {{ $val->department_description }}</option>
                                    @else
                                        <option value="{{ $val->department_code }}">{{ $val->department_code }} {{ $val->department_description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            <button type="button" class="btn btn-primary rounded-pill" onclick="search_data();">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div> -->
                    </div>
                    <div class="d-flex align-items-center flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-black">{{__('Progress')}}</span>
                            <span class="fw-bold fs-6 link-info progressbar_total">0%</span>
                        </div>

                        <div class="h-15px mx-3 w-100 bg-light mb-3">
                            <div class="bg-purple rounded h-15px progressbar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th>{{__('No.')}}</th>
                                    <th>{{__('Emp. no.')}}</th>
                                    <th>{{__('Emp. Name')}}</th>
                                    <!-- <th>โรงงาน</th> -->
                                    <th>Department</th>
                                    <th>{{__('Form')}}</th>
                                    <th>{{__('Evaluator')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <!-- <th>แจ้งเตือน</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->


    @push('scripts')
        <script type="text/javascript">
            // ,{
            //     targets: 8,
            //     render: function (data, type, row) {
            //         return `<label class="form-check form-switch d-flex justify-content-center" style="margin-right:10px;">
            //                     <input class="form-check-input" type="checkbox" value="1" checked="checked"/>
            //                 </label>`;
            //     }
            // } 
            $("#kt_datatable_dom_positioning").DataTable({
                "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                searchDelay: 500,
                processing: true,
                scrollY: true,
                scrollX: true,
                scrollCollapse: true,
                "ajax": {
                    "url": "{{ url(Request::segment(1).'/table_hr_getdata') }}",
                    "type": 'POST',
                    "data" : { 
                        "_token": "{{ csrf_token() }}",
                        "year":$('#year').val(),
                        "search_task":$('#search_task').val(),
                        "search_factory":$('#search_factory').val(),
                        "search_department":$('#search_department').val()
                    },
                },
                columns : [
                    { data : 'no' },
                    { data : 'employee_code' },
                    { data : 'name' },
                    // { data : 'factory' },
                    { data : 'department' },
                    { data : 'form' },
                    { data : 'evaluator' },
                    { data : 'status' }
                ],
                columnDefs: [ {
                    targets: 1,
                    render: function (data, type, row) {
                        return `<span>${row.employee_code}</span>`;
                    }
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
            count_progress();
            function search_data(){
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                search_group();
            }
            function search_group(){
                $('#kt_datatable_dom_positioning').DataTable( {
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    "ajax": {
                        "url": "{{ url(Request::segment(1).'/table_hr_getdata') }}",
                        "type": 'POST',
                        "data" : { 
                            "_token": "{{ csrf_token() }}",
                            "year":$('#year').val(),
                            "search_task":$('#search_task').val(),
                            "search_factory":$('#search_factory').val(),
                            "search_department":$('#search_department').val()
                        },
                    },
                    columns : [
                        { data : 'no' },
                        { data : 'employee_code' },
                        { data : 'name' },
                        // { data : 'factory' },
                        { data : 'department' },
                        { data : 'form' },
                        { data : 'evaluator' },
                        { data : 'status' },
                    ],
                    columnDefs: [ {
                        targets: 1,
                        render: function (data, type, row) {
                            // <img src="{{ image('pa/info.svg') }}">
                            return `<span>${row.employee_code}</span>`;
                        }
                    } ],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-2 d-flex align-items-center justify-content-start'f>" +
                        "<'col-sm-10 d-flex align-items-center justify-content-end'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
                        ">"
                } );
                count_progress();
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
            function count_progress(){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/count_progress") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "search_department":$('#search_department').val(),
                        "search_task":$('#search_task').val()
                    },
                    success: function (result) { 
                        var cal = (parseFloat(result.approve)/parseFloat(result.all))*100;
                        $('.progressbar').attr('aria-valuenow',number_format2(result.sum_progress,2));
                        $('.progressbar').css('width',number_format2(result.sum_progress,2)+'%');
                        $('.progressbar_total').text(number_format2(result.sum_progress,2)+'%');
                    }
                });
            }
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
    </style>
</x-default-layout>
