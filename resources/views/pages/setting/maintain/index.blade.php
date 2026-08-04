<x-default-layout>

    @section('title')
        {{ __('Maintain Employee') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.maintain.index') }}
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
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            {{__('Maintain Employee')}}
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="row g-3 mb-3" style="display: flex;align-items: center;justify-content: center;">
                        <div class="col-12 col-sm-2" style="display: flex;align-items: center;justify-content: space-between;gap: 10px;">
                            <select class="form-select" data-control="select2" id="search_year" data-placeholder="-Choose-" onchange="search_year()">
                                <@foreach ($year as $key => $val)
                                    @php
                                        $substr = substr($val->rec_year,0,4);
                                    @endphp
                                    <option value="{{ $substr }}">{{ $substr }}</option>
                                @endforeach   
                            </select>
                            <button type="button" class="btn btn-success rounded-pill" onclick="submit_to_manager();" style="min-width: 150px;"><i class="bi bi-floppy fs-5"></i>Submit</button>
                            <button type="button" class="btn btn-success rounded-pill" onclick="sendmail_manager();" style="min-width: 150px;"><i class="bi bi-floppy fs-5"></i>Send Email</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning" class="table table-striped rounded" style="text-wrap:nowrap">
                            <thead class="table-light">
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th style="font-size: 14px !important;">Top_Management</th>
                                    <th style="background-color: yellow;font-size: 14px !important;">DIV_CODE</th>
                                    <th style="background-color: yellow;font-size: 14px !important;">DIV_DESCRIPTION</th>
                                    <th style="background-color: yellow;font-size: 14px !important;">DEPT_CODE</th>
                                    <th style="background-color: yellow;font-size: 14px !important;">DEPT_DESCRIPTION</th>
                                    <th style="font-size: 14px !important;">Dept_Manager</th>
                                    <th style="background-color: #92fff7;font-size: 14px !important;">SECT_CODE</th>
                                    <th style="background-color: #92fff7;font-size: 14px !important;">SECT_DESCRIPTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($division))
                                @foreach ($division as $key => $item)
                                <tr>
                                    <td style="font-size: 14px !important;">
                                        @if(!empty($item['tb_department']))
                                            @foreach ($item['tb_department'] as $key2 => $item2)
                                                @if(!empty($item2['tb_section']))
                                                    @foreach ($item2['tb_section'] as $key3 => $item3)
                                                        @if(trans(request()->segment(1)) == 'manager')
                                                            @if($item3['section_code'] == 'G1EO')
                                                            <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                <select class="form-select" data-control="select2" id="search_topmanagement{{$item['division_code']}}" name="search_topmanagement" data-placeholder="-Choose-" style="margin:0px;" onchange="set_top(this.value,'{{$item3['section_code']}}');">
                                                                    <option value="000002" selected>000002 - KAI CHIU JOSEPH LO</option>
                                                                    <option value="000042" >000042 - VINCENT CHI SENG CHENG</option>
                                                                </select>
                                                            </div>
                                                            @endif
                                                        @endif
                                                        @foreach ($topmanagement2 as $key4 => $item4)
                                                            @if($item3['section_code'] == $item4->section_code)
                                                            
                                                                <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                    <select class="form-select" data-control="select2" id="search_topmanagement{{$item['division_code']}}" name="search_topmanagement" data-placeholder="-Choose-" style="margin:0px;" onchange="set_top(this.value,'{{$item4->section_code}}');">
                                                                        @if(trans(request()->segment(1)) == 'manager')
                                                                            @if($item4->approve_by2 == '000002')
                                                                                <option value="000002" selected>000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000042">000042 - VINCENT CHI SENG CHENG</option>
                                                                            @elseif($item4->approve_by2 == '000042')
                                                                                <option value="000002">000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000042" selected>000042 - VINCENT CHI SENG CHENG</option>
                                                                            @else
                                                                                <option value="000002">000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000026">000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                                                                <option value="{{$item4->approve_by2}}" selected>{{$item4->approve_by2}} - {{$item4->top_name}}</option>
                                                                            @endif
                                                                        @else
                                                                            @if($item4->approve_by2 == '000002')
                                                                                <option value="000002" selected>000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000026">000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                                                            @elseif($item4->approve_by2 == '000026')
                                                                                <option value="000002">000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000026" selected>000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                                                            @else
                                                                                <option value="000002">000002 - KAI CHIU JOSEPH LO</option>
                                                                                <option value="000026">000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                                                                <option value="{{$item4->approve_by2}}" selected>{{$item4->approve_by2}} - {{$item4->top_name}}</option>
                                                                            @endif
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                       
                                    </td>
                                    <td style="background-color: yellow;font-size: 14px !important;">{{$item['division_code']}}</td>
                                    <td style="background-color: yellow;font-size: 14px !important;">{{$item['division_description']}}</td>
                                    <td style="background-color: yellow;font-size: 14px !important;">
                                        @if(!empty($item['tb_department']))
                                            @foreach ($item['tb_department'] as $key2 => $item2)
                                                @php
                                                    $hei = count($item2['tb_section'])*43.59;
                                                @endphp
                                                @if($item2['department_code'] == 'G300')
                                                    <div class="">
                                                        <div class="col-12 form-control" style="font-size: 14px !important;border:none;height: 90px;border-radius: 0px;">
                                                            {{$item2['department_code']}}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="">
                                                        <div class="col-12 form-control" style="font-size: 14px !important;height:{{$hei}}px;border:none;border-radius: 0px;">
                                                            {{$item2['department_code']}}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="background-color: yellow;font-size: 14px !important;">
                                        @if(!empty($item['tb_department']))
                                            @foreach ($item['tb_department'] as $key2 => $item2)
                                                @php
                                                    $hei = count($item2['tb_section'])*43.59;
                                                @endphp
                                                @if($item2['department_code'] == 'G300')
                                                    <div class="">
                                                        <div class="col-12 form-control" style="font-size: 14px !important;border:none;height: 90px;border-radius: 0px;">
                                                            {{$item2['department_description']}}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="">
                                                        <div class="col-12 form-control" style="font-size: 14px !important;height:{{$hei}}px;border:none;border-radius: 0px;">
                                                            {{$item2['department_description']}}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="font-size: 14px !important;">
                                        <div style="width: 250px !important;" >
                                            @if(!empty($item['tb_department']))
                                                @foreach ($item['tb_department'] as $key2 => $item2)
                                                @php
                                                    $hei = count($item2['tb_section'])*43.59;
                                                @endphp
                                                <div class="col-12" style="height:{{$hei}}px;">
                                                    @if($item2['department_code'] == 'G300')
                                                    <div class="col-12">
                                                        <select class="form-select" data-control="select2" id="search_evaluatorG3AC" name="search_evaluator" data-placeholder="-Choose-" style="margin:0px;" onchange="setvalue(this.value,'{{$item2['department_code']}}','{{$item['division_code']}}','G3AC');">
                                                            <!-- <option value="all">Select - G3AC</option> -->
                                                            @foreach ($item2['evaluatorG3AC'] as $key => $val)
                                                                @if($val->employee_no == $item2['G3AC'])
                                                                    <option value="{{ $val->employee_no }}" selected>{{ $val->employee_no }} - {{ $val->employee_name_en }}</option>
                                                                @else
                                                                    <option value="{{ $val->employee_no }}">{{ $val->employee_no }} - {{ $val->employee_name_en }}</option>
                                                                @endif
                                                            @endforeach   
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                    </div>
                                                    @if(trans(request()->segment(1)) == 'manager')
                                                        <select class="form-select" data-control="select2" id="search_evaluatorG3TC" name="search_evaluator" data-placeholder="-Choose-" style="margin:0px;" onchange="setvalue(this.value,'{{$item2['department_code']}}','{{$item['division_code']}}','G3TC');">
                                                            <option value="000023">000023 - SIU KAI KWOK</option>  
                                                        </select>
                                                    @else
                                                        <select class="form-select" data-control="select2" id="search_evaluatorG3TC" name="search_evaluator" data-placeholder="-Choose-" style="margin:0px;" onchange="setvalue(this.value,'{{$item2['department_code']}}','{{$item['division_code']}}','G3TC');">
                                                            @foreach ($item2['evaluatorG3TC'] as $key => $val)
                                                                @if($val->employee_no == $item2['G3TC'])
                                                                    <option value="{{ $val->employee_no }}" selected>{{ $val->employee_no }} - {{ $val->employee_name_en }}</option>
                                                                @else
                                                                    <option value="{{ $val->employee_no }}">{{ $val->employee_no }} - {{ $val->employee_name_en }}</option>
                                                                @endif
                                                            @endforeach   
                                                        </select>
                                                    @endif
                                                    </div>
                                                    @else
                                                    <select class="form-select" data-control="select2" id="search_evaluator{{$item2['department_code']}}" name="search_evaluator" data-placeholder="-Choose-" style="margin:0px;" onchange="setvalue(this.value,'{{$item2['department_code']}}','{{$item['division_code']}}','');">
                                                        <!-- <option value="all">Select</option> -->
                                                        @foreach ($item2['evaluator'] as $key => $val)
                                                            @if($val['employee_no'] == $item2['dept'])
                                                                <option value="{{ $val['employee_no'] }}" selected>{{ $val['employee_no'] }} - {{ $val['employee_name_en'] }}</option>
                                                            @else
                                                                <option value="{{ $val['employee_no'] }}">{{ $val['employee_no'] }} - {{ $val['employee_name_en'] }}</option>
                                                            @endif
                                                        @endforeach   
                                                    </select>
                                                    @endif
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td style="background-color: #92fff7;font-size: 14px !important;">
                                        @if(!empty($item['tb_department']))
                                            @foreach ($item['tb_department'] as $key2 => $item2)
                                                @if(!empty($item2['tb_section']))
                                                    @foreach ($item2['tb_section'] as $key3 => $item3)
                                                        @if($item2['department_code'] == 'G300')
                                                            <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                {{$item3['section_code']}}
                                                            </div>
                                                        @else
                                                            <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                {{$item3['section_code']}}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="background-color: #92fff7;font-size: 14px !important;">
                                        @if(!empty($item['tb_department']))
                                            @foreach ($item['tb_department'] as $key2 => $item2)
                                                @if(!empty($item2['tb_section']))
                                                    @foreach ($item2['tb_section'] as $key3 => $item3)
                                                        @if($item2['department_code'] == 'G300')
                                                            <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                {{$item3['section_description']}}
                                                            </div>
                                                        @else
                                                            <div class="col-12 form-control" style="font-size: 14px !important;border: none;height:43.59px;border-radius: 0px;">
                                                                {{$item3['section_description']}}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                // Swal.fire({
                //     title: "อยู่ระหว่างการปรับปรุง",
                //     text: "",
                //     icon: "warning",
                //     allowOutsideClick: false,
                // });
            });
        </script>
    @endpush
    <script>
        function submit_to_manager(){
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
                        url: '{{ url(Request::segment(1)."/update_manager") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            'search_year':$('#search_year').val()
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
            });
        }
        function sendmail_manager(val,section_code){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/sendmail_manager") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    'search_year':$('#search_year').val()
                },
                success: function (result) { 
                    Swal.fire({
                        title: "Send Email Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                }
            });
        }
        function set_top(val,section_code){
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/set_top") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "code":val,
                    "section_code":section_code
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
        function search_year(){
            window.location.href="{{ url(Request::segment(1)) }}/setting/maintain/"+$('#search_year').val()+'/show';
        }
        function setvalue(val,department,division,section){
            // var section_code = '';
            // var department_code = '';
            // if(section != ""){
            //     if(section == "G3AC"){
            //         department_code = 'G300';
            //         section_code = 'G3AC';
            //     }else{
            //         department_code = 'G300';
            //         section_code = 'G3TC';
            //     }
            // }else{
            //     department_code = department;
            //     section_code = 'all';
            // }
            // console.log(val);
            // console.log(department_code);
            // console.log(section_code);
            // $.ajax({
            //     type: 'POST',
            //     url: '{{ url(Request::segment(1)."/setmanager") }}',
            //     dataType: 'json',
            //     data : { 
            //         "_token": "{{ csrf_token() }}",
            //         "code":val,
            //         "department_code":department_code,
            //         "section_code":section_code
            //     },
            //     success: function (result) { 
                    
            //     }
            // });
        }
        function loading(){
            KTApp.showPageLoading();
        }
        function loading_hide(){
            KTApp.hidePageLoading();
        }
    </script>
</x-default-layout>
