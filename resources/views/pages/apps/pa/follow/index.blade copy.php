<x-default-layout>

    @section('title')
        {{ __('Task Status Tracking') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('pa.follow.index') }}
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
                    </span>
                    </h3>
                    <!--end::Title-->

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Year')}}</label>
                            <select class="myLike form-select" id="year" name="year" onchange="search_data();">
                                <option value="">{{__('Select')}}</option>
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
                            <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                            <select class="form-select" data-control="select2" id="search_department" name="search_department" onchange="search_data();">
                                <option value="0">{{__('Select')}}</option>
                                @foreach($department as $val)    
                                    <option value="{{ $val->department_code }}">{{ $val->department_code }} {{ $val->department_description }}</option>
                                @endforeach  
                            </select>
                        </div>
                        <div class="col-sm-6" style="text-align:right;">
                            <a href="follow/hr_page">
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="bi bi-bar-chart-steps"></i>
                                    {{__('Follow up on tasks')}}
                                </button>
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7 check_show_action">
                                    <th rowspan="2" class="align-middle border-bottom border-end">{{__('No.')}}</th>
                                    <th rowspan="2" class="align-middle border-bottom border-end" style="min-width:200px;">Department</th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                    <th class="border-bottom" style="min-width:100px;"></th>
                                </tr>
                                <tr class="fw-bold fs-6 text-gray-800 px-7 check_show_date">
                                    <th class="ps-2" style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                    <th style="min-width:100px;"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- <div class="table-responsive">
                    <table id="kt_datatable_dom_positioning" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th><input type="checkbox"></th>
                                <th>No.</th>
                                <th>หัวข้อ (ภาษาไทย)</th>
                                <th>Title (English)</th>
                                <th>วันที่สร้าง</th>
                            </tr>
                        </thead>
                    </table>
                    </div> -->
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->


    @push('scripts')
        <script type="text/javascript">
            // search_data();
            get_column();
            $('#kt_datatable_dom_positioning').DataTable().destroy();
            setTimeout(() => {
                $("#kt_datatable_dom_positioning").DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    "columnDefs": [{
                        "visible": false,
                        "targets": -1
                    }],
                    "ajax": {
                        "url": "{{ url(Request::segment(1).'/table_follow_getdata') }}/",
                        "type": 'POST',
                        "data" : { 
                            "_token": "{{ csrf_token() }}",
                            "year":$('#year').val(),
                            "search_department":$('#search_department').val()
                        },
                    },
                    columns : [
                        { data : 'no' },
                        { data : 'department_name' },
                        { data : 'percent1' },
                        { data : 'percent2' },
                        { data : 'percent3' },
                        { data : 'percent4' },
                        { data : 'percent5' },
                        { data : 'percent6' },
                        { data : 'percent7' },
                        { data : 'percent8' },
                        { data : 'percent9' },
                        { data : 'percent10' },
                        { data : 'percent11' },
                        { data : 'percent12' },
                        { data : 'percent13' },
                        { data : 'percent14' },
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
            }, 200);
            
            function search_data(){
                get_column();
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                setTimeout(() => {
                    search_group();
                }, 500);
            }
            function search_group(){
                $('#kt_datatable_dom_positioning').DataTable( {
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    "columnDefs": [{
                        "visible": false,
                        "targets": -1
                    }],
                    "ajax": {
                        "url": "{{ url(Request::segment(1).'/table_follow_getdata') }}/",
                        "type": 'POST',
                        "data" : { 
                            "_token": "{{ csrf_token() }}",
                            "year":$('#year').val(),
                            "search_department":$('#search_department').val()
                        },
                    },
                    columns : [
                        { data : 'no' },
                        { data : 'department_name' },
                        { data : 'percent1' },
                        { data : 'percent2' },
                        { data : 'percent3' },
                        { data : 'percent4' },
                        { data : 'percent5' },
                        { data : 'percent6' },
                        { data : 'percent7' },
                        { data : 'percent8' },
                        { data : 'percent9' },
                        { data : 'percent10' },
                        { data : 'percent11' },
                        { data : 'percent12' },
                        { data : 'percent13' },
                        { data : 'percent14' }
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
                } );
            }
            function get_column(){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_column") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (result) { 
                        var html = ``;
                        var html2 = ``;
                        html += `<th rowspan="2" class="align-middle border-bottom border-end" style="min-width:100px;">{{__('No.')}}</th>`;
                        html += `<th rowspan="2" class="align-middle border-bottom border-end" style="min-width:200px;">Department</th>`;
                        for(var i = 0;i < result.length;i++){
                            if(result[i].status == '0'){
                                html += `<th style="min-width:100px;display: none;"></th>`;
                            }else{
                                
                                html += `<th class="border-bottom" style="min-width:100px;position: relative;" onmouseover="getaction(${i},'${result[i].action_name}',1);" onmouseout="getaction(${i},'${result[i].action_name}',0);">
                                            Action${i+1}
                                            <div class="hide__${i}" style="display:none;position: absolute;
                                                        left: 0;
                                                        background: #cacaca;
                                                        padding: 5px;
                                                        z-index: 9999;
                                                        width: 400px;">
                                                        ${result[i].action_name}
                                            </div>
                                        </th>`;
                            }   
                            
                            var resultx = '-';
                            if(result[i].start_date_real){
                                if(result[i].start_date_real == result[i].end_date_real){
                                    const date = new Date(result[i].start_date_real);
                                    const day = date.getDate();
                                    const month = new Intl.DateTimeFormat('en-US', { month: 'short' }).format(date);
                                    const year = date.getFullYear();

                                    resultx = `${day} ${month} ${year}`;
                                }else{
                                    const startDate = new Date(result[i].start_date_real);
                                    const endDate = new Date(result[i].end_date_real);

                                    const startDay = startDate.getDate();
                                    const endDay = endDate.getDate();

                                    const startMonth = new Intl.DateTimeFormat('en-US', { month: 'short' }).format(startDate);
                                    const endMonth = new Intl.DateTimeFormat('en-US', { month: 'short' }).format(endDate);

                                    resultx = `${startDay}-${endDay} ${startMonth} ${startDate.getFullYear()}`;
                                }
                            }
                            
                            console.log(resultx);
                            
                            if(result[i].status == '0'){
                                html2 += `<th style="min-width:100px;display: none;"></th>`;
                            }else{
                                if(i == 0){
                                    html2 += `<th class="ps-2" style="min-width:100px;" >${resultx}</th>`;
                                }else{
                                    html2 += `<th style="min-width:100px;" >${resultx}</th>`;
                                }
                            }
                            
                                 
                        }
                        $('.check_show_action').html(html);
                        $('.check_show_date').html(html2);
                        
                    }
                });
            }
            function getaction(i,action,hover){
                console.log(i);
                console.log(action);
                console.log(hover);
                if(hover == '1'){
                    $('.hide__'+i).css('display','block');
                }else{
                    $('.hide__'+i).css('display','none');
                }   
            }
            // {
            //     targets: 0,
            //     render: function(data, type, row) {
            //         if (row.department_code != '') {
            //             return `<a href="follow/hr_page/${row.department_code}"  type="button">
            //                         <span class="menu-title"><img src="{{ image('icons/edit.svg') }}" class="pointer"></span>
            //                     </a>`;
            //         } else {
            //             return ``;
            //         }

            //     }
            // }
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
        table.dataTable > thead > tr > td:not(.sorting_disabled), table.dataTable > thead > tr > th:not(.sorting_disabled) {
            border: 1px solid #c2c2c2;
            background: #F5F5F5;
            border-radius: 0px;
            text-align: center;
            padding: 13px;
        }
        table.dataTable.table-striped > tbody > tr:nth-of-type(2n+1) > * {
            text-align: center;
            padding: 13px;
        }
        .table.gs-7 th:first-child, .table.gs-7 td:first-child , .table-striped > tbody > tr:nth-of-type(even) > *,.table.gs-7 th:last-child, .table.gs-7 td:last-child{
            text-align: center;
            padding: 13px;
        }
        .dataTables_scrollBody .check_show_action{
            display: none;
        }
    </style>
</x-default-layout>
