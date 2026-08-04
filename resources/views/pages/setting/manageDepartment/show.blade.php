<x-default-layout>

    @section('title')
        {{ __('Set %Increase by Dept.') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.manageDepartment.index') }}
    @endsection

    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
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
                            {{ __('Set %Increase by Dept.') }}
                        </span>
                        <input type="text" id="id_get" value="{{ $id }}" hidden>
                    </h3>
                    <div class="d-flex align-items-center flex-row mb-0">
                        <form action="{{ url(Request::segment(1).'/import_increase_percent') }}" method="post" enctype="multipart/form-data" id="importForm_increase_percent">
                        @csrf
                            <button type="button" class="btn btn-primary rounded-pill " onclick="$('#excelFile_increase_percent').click();" style="margin-right:10px;">
                                <i class="bi bi-download fs-5"></i>
                                {{ __('Upload Data') }}
                            </button>
                            <input type="file" class="d-none" name="excelFile_increase_percent" id="excelFile_increase_percent" accept=".xlsx, .xls" onchange="submitForm_increase_percent()">
                        </form>
                        <button type="button" class="btn btn-primary justify-content-end rounded-pill" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="resetdata();">
                            <i class="bi bi-plus fs-5"></i>{{__('Add')}}
                        </button>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    
                    <div class="table-responsive" style="position: relative;">
                        <!--begin::Menu wrapper-->
                        <div style="position: absolute;left: 0;z-index: 100;display:none;">
                            <!--begin::Toggle-->
                            <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                Action
                                <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                            </button>
                            <!--end::Toggle-->

                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="editForm.php" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-notepad-edit fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">แก้ไข</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-check-circle fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">Active</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-trash fs-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </span>
                                    <span class="menu-title">ลบ</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Dropdown wrapper-->
                        <table id="kt_datatable_dom_positioning" class="table table-striped gy-2 gs-5 rounded">
                            <thead class="table-light">
                                <tr class="fw-bold fs-6 text-gray-800 px-7 text-center">
                                    <th>{{__('No.')}}</th>
                                    <th>Division</th>
                                    <th>Department</th>
                                    <th>Section</th>
                                    <th>% Daily</th>
                                    <th>% Monthly</th>
                                    <th>{{__('Approved by')}} 1 <br>(Dept. Manager)</th>
                                    <th>{{__('Approved by')}} 2</th>
                                    <th>{{__('Approved by')}} 3</th>
                                    <!-- <th>Active</th> -->
                                    <th>{{__('Action')}}</th>
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

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addedit_action">
                    <div class="modal-header">
                        <h3 class="modal-title">{{__('Setting %')}}</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-4">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Div</label>
                                <select class="form-select form-select-solid" id="division_code" name="division_code" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                    @foreach ($division as $key => $val)
                                        <option value="{{ $val->division_code }}">{{ $val->division_code }} - {{ $val->division_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Dept</label>
                                <select class="form-select form-select-solid" id="department_code" name="department_code" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                    @foreach ($department as $key => $val)
                                        <option value="{{ $val->department_code }}">{{ $val->department_code }} - {{ $val->department_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Sect</label>
                                <select class="form-select form-select-solid" id="section_code" name="section_code" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                    @foreach ($section as $key => $val)
                                        <option value="{{ $val->section_code }}">{{ $val->section_code }} - {{ $val->section_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput1" class="form-label mb-0">% Daily </label>
                                <input type="text" class="form-control" id="percent_daily" name="percent_daily" placeholder="% Daily"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput1" class="form-label mb-0">% Monthly</label>
                                <input type="text" class="form-control" id="percent_monthly" name="percent_monthly" placeholder="% Monthly"/>
                            </div>
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Approved by')}} 1</label>
                                <select class="form-select form-select-solid" id="approve_by1" name="approve_by1" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                    @foreach ($approve_pa_score_by as $key => $val)
                                        <option value="{{ $val->employee_no }}">{{ $val->employee_no }} - {{ $val->employee_name_en }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Approved by')}} 2</label>
                                <select class="form-select form-select-solid" id="approve_by2" name="approve_by2" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                   <option value="000002">000002 - Joseph Lo.</option>
                                   <option value="000026">000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                   <option value="013591">013591 - TANAWAT ATICHAT</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Approved by')}} 3</label>
                                <select class="form-select form-select-solid" id="approve_by3" name="approve_by3" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                   <option value="0">{{ __('Select') }}</option>
                                   <option value="000002">000002 - Joseph Lo.</option>
                                   <option value="000026">000026 - KOMKRIT VONGKAVIVATHANAKUL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    <div class="modal-footer">
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                            <input type="text" id="id_action" name="id_action" hidden>
                            <input type="text" id="edit_id" name="edit_id" value="{{ $id }}" hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    @push('scripts')
        <script type="text/javascript">
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
                    "url": "{{ url(Request::segment(1).'/table_department_getdata') }}/" + $("#id_get").val(),
                    "type": 'GET',       
                },
                columns : [
                    { data : 'no' },
                    { data : 'div' },
                    { data : 'dept' },
                    { data : 'sec' },
                    { data : 'percent_daily' },
                    { data : 'percent_monthly' },
                    { data : 'approve' },
                    { data : 'approve2' },
                    { data : 'approve3' },
                    // { data : 'status_active' },
                    { data : 'button' },
                ],
                columnDefs: [ {
                    targets: 9,
                    render: function(data, type, row) {
                        if(row.id > 0){
                            return `<button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="fetch_action(${row.id})">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>`;
                        }else{
                            return '';
                        }
                    }
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
            function fetch_action(id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/setting/manageDepartment/show/fetch') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        $('#id_action').val(res.id);
                        $('#division_code').val(res.division_code);
                        $('#select2-division_code-container').text(res.division_code+' - '+res.division_description);
                        $('#department_code').val(res.department_code);
                        $('#select2-department_code-container').text(res.department_code+' - '+res.department_description);
                        $('#section_code').val(res.section_code);
                        $('#select2-section_code-container').text(res.section_code+' - '+res.section_description);
                        $('#percent_daily').val(res.percent_daily);
                        $('#percent_monthly').val(res.percent_monthly);
                        if(res.approve_by1){
                            $('#approve_by1').val(res.approve_by1);
                            $('#select2-approve_by1-container').text(res.approve_by1+' - '+res.employee_local_name_en);
                        }
                        if(res.approve_by2){
                            $('#approve_by2').val(res.approve_by2);
                            if(res.approve_by2 == "000002"){
                                var employee_local_name_en2 = "Joseph Lo.";
                                $('#select2-approve_by2-container').text(res.approve_by2+' - '+employee_local_name_en2);
                            }else if(res.approve_by2 == "000026"){
                                var employee_local_name_en2 = "KOMKRIT VONGKAVIVATHANAKUL";
                                $('#select2-approve_by2-container').text(res.approve_by2+' - '+employee_local_name_en2);
                            }else if(res.approve_by2 == "013591"){
                                var employee_local_name_en2 = "TANAWAT ATICHAT";
                                $('#select2-approve_by2-container').text(res.approve_by2+' - '+employee_local_name_en2);
                            }
                        }
                        if(res.approve_by3){
                            $('#approve_by3').val(res.approve_by3);
                            if(res.approve_by3 == "000002"){
                                var employee_local_name_en3 = "Joseph Lo.";
                                $('#select2-approve_by3-container').text(res.approve_by3+' - '+employee_local_name_en3);
                            }else if(res.approve_by3 == "000026"){
                                var employee_local_name_en3 = "KOMKRIT VONGKAVIVATHANAKUL";
                                $('#select2-approve_by3-container').text(res.approve_by3+' - '+employee_local_name_en3);
                            }
                        }
                    },
                    error: function(res) {
                        console.log("error");
                        console.log(res);
                    }
                });
            }
            $("#addedit_action").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: "{{ url(Request::segment(1).'/setting/manageDepartment/show/addedit') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            let timerInterval;
                            Swal.fire({
                                icon: 'success',
                                title: "Success",
                                html: "Saved Successfully",
                                text: "Saved Successfully",
                                timer: 2000,
                                timerProgressBar: true,
                                allowOutsideClick: false,
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
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function(response) {
                        console.log("error");
                        console.log(response);
                        Swal.fire({
                            title: "ไม่สำเร็จ",
                            text: "ระบบบันทึกข้อมูลไม่สำเร็จ",
                            icon: "error",
                            allowOutsideClick: false,
                        });
                    }
                });
            });
            function change_active(e,id){
                var status_active = '0';
                if($(e).prop('checked') == true){
                    status_active = '1';
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/department_action_change_active") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":$(e).attr('data-id'),
                        "status_active":status_active
                    },
                    success: function (result) { 
                        
                    }
                });
            }
            function resetdata(){
                $('#id_action').val('');
                $('#division_code').val('0');
                $('#department_code').val('0');
                $('#section_code').val('0');
                $('#percent_daily').val('');
                $('#percent_monthly').val('');
                $('#approve_by1').val('0');
                $('#approve_by2').val('0');
                $('#approve_by3').val('0');
                $('#select2-division_code-container').text('Select');
                $('#select2-department_code-container').text('Select');
                $('#select2-section_code-container').text('Select');
                $('#select2-approve_by1-container').text('Select');
                $('#select2-approve_by2-container').text('Select');
                $('#select2-approve_by3-container').text('Select');
            }
            function submitForm_increase_percent() {
                document.getElementById('importForm_increase_percent').submit();
                //  loading();
                Swal.fire({
                    title: "กำลังอัพโหลดไฟล์",
                    html: "กรุณารอจนกว่าระบบจะ Refresh",
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },

                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log("I was closed by the timer");
                        // loading_hide();
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
    <style>
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
    </style>
</x-default-layout>
