<x-default-layout>

    @section('title')
        {{ __('User Management') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.index') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" id="mySearchInput" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
                <input type="hidden" class="hidden_user_id2" value="">
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <!--begin::Add user-->
                        <button type="button" class="btn btn-primary" style="margin-right:10px;" onclick="printexcel()">
                            Export Excel
                        </button>
                        @can('create users')
                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user" id="bt_modal_add_user">
                            {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            {{__('Add User')}}
                        </button> -->
                        @endcan
                        <!--end::Add user-->
                        @can('create users')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_new_user">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            {{__('Add User')}}
                        </button>
                        @endcan
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Modal-->
                    <livewire:user.add-user-modal></livewire:user.add-user-modal>
                    <!--end::Modal-->
                </div>
            
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>


        <div class="modal fade" tabindex="-1" id="add_new_user">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addedituser_action">
                        <div class="modal-header">
                            <h3 class="modal-title">Add User</h3>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Full Name (TH) <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="name_th" name="name_th"/>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Full Name (EN) <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="name_en" name="name"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Employee Code <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="add_orisoft_code" name="orisoft_code" placeholder=""/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Email <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="add_email" name="email"/>
                                </div>
                                
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Division code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="division_code" name="division_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_department();" data-dropdown-parent="#add_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($division as $r)
                                        <option value="{{ $r->division_code }}">{{ $r->division_code }} - {{ $r->division_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Department code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="department_code" name="department_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_section();" data-dropdown-parent="#add_new_user">
                                        <option value="0">เลือก</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Section code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="section_code" name="section_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple"  data-dropdown-parent="#add_new_user">
                                        <option value="0">เลือก</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Position code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="position_code" name="position_code" data-dropdown-parent="#add_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($position as $r)
                                        <option value="{{ $r->position_code }}">{{ $r->position_code }} - {{ $r->position_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Grade code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="grade_code" name="grade_code" data-dropdown-parent="#add_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($grade_code as $r)
                                        <option value="{{ $r->grade_code }}">{{ $r->grade_code }} - {{ $r->grade_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        @foreach ($roles as $r)
                                            <!--begin::Input row-->
                                            <div class="col-6 mb-5">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input me-3" id="kt_modal_update_role_option_{{ $r->id }}" name="role[]" type="checkbox" value="{{ $r->name }}" />
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="form-check-label" for="kt_modal_update_role_option_{{ $r->id }}">
                                                        <div class="fw-bold text-gray-800">
                                                            {{ ucwords($r->name) }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            {{ $r->detail }}
                                                        </div>
                                                    </label>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="modal-footer">
                            <div class="card-footer text-end">
                                <input type="hidden" id="search_year" value="{{date('Y')}}">
                                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="edit_new_user">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="edituser_action">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit User</h3>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Full Name (TH) <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="edit_name_th" name="edit_name_th"/>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Full Name (EN) <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="edit_name_en" name="edit_name"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Employee Code <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="edit_orisoft_code" name="orisoft_code" placeholder="" readonly/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Email </label>
                                    <input type="text" class="form-control" id="edit_email" name="email"/>
                                </div>
                                
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Division code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="edit_division_code" name="edit_division_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_department_edit();" data-dropdown-parent="#edit_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($division as $r)
                                        <option value="{{ $r->division_code }}">{{ $r->division_code }} - {{ $r->division_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Department code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="edit_department_code" name="edit_department_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple" onchange="get_section_edit();" data-dropdown-parent="#edit_new_user">
                                        <option value="0">เลือก</option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="" class="form-label mb-0">Section code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="edit_section_code" name="edit_section_code" data-close-on-select="false" data-placeholder="All" data-allow-clear="true" multiple="multiple"  data-dropdown-parent="#edit_new_user">
                                        <option value="0">เลือก</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Position code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="edit_position_code" name="edit_position_code" data-dropdown-parent="#edit_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($position as $r)
                                        <option value="{{ $r->position_code }}">{{ $r->position_code }} - {{ $r->position_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label mb-0">Grade code <span style="color:red;">*</span></label>
                                    <select class="form-select" data-control="select2" id="edit_grade_code" name="edit_grade_code" data-dropdown-parent="#edit_new_user">
                                        <option value="0">เลือก</option>
                                        @foreach ($grade_code as $r)
                                        <option value="{{ $r->grade_code }}">{{ $r->grade_code }} - {{ $r->grade_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        @foreach ($roles as $r)
                                            <!--begin::Input row-->
                                            <div class="col-6 mb-5">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input me-3 roleall" id="edit_kt_modal_update_role_option_{{ $r->id }}" name="edit_role[]" type="checkbox" value="{{ $r->name }}" />
                                                    <!--end::Input-->
                                                    <!--begin::Label-->
                                                    <label class="form-check-label" for="edit_kt_modal_update_role_option_{{ $r->id }}">
                                                        <div class="fw-bold text-gray-800">
                                                            {{ ucwords($r->name) }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            {{ $r->detail }}
                                                        </div>
                                                    </label>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Radio-->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="modal-footer">
                            <div class="card-footer text-end">
                                <input type="hidden" id="search_year" value="{{date('Y')}}">
                                <input type="hidden" id="edit_id" value="">
                                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            function printexcel(){
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ url(Request::segment(1).'/user_excel') }}/";
                    }
                });
            }
            document.getElementById('mySearchInput').addEventListener('keyup', function() {
                window.LaravelDataTables['users-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:load', function() {
                Livewire.on('success', function() {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
            });


            $("#addedituser_action").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var roles = $("input[name='role[]']:checked").map(function(){
                    return $(this).val();
                }).get();
                // console.log(roles.length);
                // return false;
                if($('#name_th').val() == '' || 
                $('#name_en').val() == '' || 
                $('#add_orisoft_code').val() == '' || 
                $('#add_email').val() == '' || 
                $('#position_code').val() == '0' || 
                $('#grade_code').val() == '0' || 
                roles.length == 0 || 
                $('#division_code').val().length == 0 || 
                $('#department_code').val().length == 0 || 
                $('#section_code').val().length == 0){
                    Swal.fire({
                        title: "กรุณาระบุข้อมูลให้ครบถ้วน",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    
                    $.ajax({
                        method: 'POST',
                        url: "{{ url(Request::segment(1).'/setting/user/show/addedit') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "name_th":$('#name_th').val(),
                            "name":$('#name_en').val(),
                            "orisoft_code":$('#add_orisoft_code').val(),
                            "email":$('#add_email').val(),
                            "division_code":$('#division_code').val(),
                            "department_code":$('#department_code').val(),
                            "section_code":$('#section_code').val(),
                            "position_code":$('#position_code').val(),
                            "grade_code":$('#grade_code').val(),
                            "role":roles
                        },
                        // data: formData,
                        // cache: false,
                        // contentType: false,
                        // processData: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200) {
                                Swal.fire({
                                    title: "Saved Successfully",
                                    icon: "success",
                                    allowOutsideClick: false,
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }else{
                                Swal.fire({
                                    title: "ไม่พบข้อมูล กรุณาติดต่อผู้ดูแลระบบ",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }
                        },
                        error: function(response) {
                            console.log("error");
                            console.log(response);
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "ระบบSaveข้อมูลไม่สำเร็จ",
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
                
            });
            $("#edituser_action").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var roles = $("input[name='edit_role[]']:checked").map(function(){
                    return $(this).val();
                }).get();
                console.log($('#edit_name_th').val());
                console.log($('#edit_name_en').val());
                console.log($('#edit_orisoft_code').val());
                console.log($('#edit_position_code').val());
                console.log($('#edit_grade_code').val());
                console.log(roles);
                console.log($('#edit_division_code').val());
                console.log($('#edit_department_code').val());
                console.log($('#edit_section_code').val());
                // return false;
                if($('#edit_name_th').val() == '' || 
                $('#edit_name_en').val() == '' || 
                $('#edit_orisoft_code').val() == '' || 
                $('#edit_position_code').val() == '0' || 
                $('#edit_grade_code').val() == '0' || 
                roles.length == 0 || 
                $('#edit_division_code').val().length == 0 || 
                $('#edit_department_code').val().length == 0 || 
                $('#edit_section_code').val().length == 0){
                    Swal.fire({
                        title: "กรุณาระบุข้อมูลให้ครบถ้วน",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    
                    $.ajax({
                        method: 'POST',
                        url: "{{ url(Request::segment(1).'/setting/user/show/editdata') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "id":$('#edit_id').val(),
                            "name_th":$('#edit_name_th').val(),
                            "name":$('#edit_name_en').val(),
                            "orisoft_code":$('#edit_orisoft_code').val(),
                            "email":$('#edit_email').val(),
                            "division_code":$('#edit_division_code').val(),
                            "department_code":$('#edit_department_code').val(),
                            "section_code":$('#edit_section_code').val(),
                            "position_code":$('#edit_position_code').val(),
                            "grade_code":$('#edit_grade_code').val(),
                            "role":roles
                        },
                        // data: formData,
                        // cache: false,
                        // contentType: false,
                        // processData: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200) {
                                Swal.fire({
                                    title: "Saved Successfully",
                                    icon: "success",
                                    allowOutsideClick: false,
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }else{
                                Swal.fire({
                                    title: "มีข้อมูลในระบบแล้ว ไม่สามารถสร้างได้",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }
                        },
                        error: function(response) {
                            console.log("error");
                            console.log(response);
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "ระบบSaveข้อมูลไม่สำเร็จ",
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        }
                    });
                }
                
            });

            function get_department(){
                if($('#division_code').val().length == 0){
                    var html = ``;
                    var html2 = ``;
                    $('#department_code').val([]);
                    $('#section_code').val([]);
                    get_section();
                }else{
                    $.ajax({
                        type: 'POST',
                        url: '{{ url(Request::segment(1)."/get_department_pa_grade") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "search_division":$('#division_code').val(),
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
                            $('#department_code').html(html);
                            if(result.data.length > 1){
                                $('#department_code').val([]);
                            }
                            setTimeout(() => {
                                get_section();
                            }, 200);
                        }
                    });
                }
            }
            function get_section(){
                if($('#department_code').val().length == 0){
                    var html = ``;
                    $('#section_code').val([]);
                }else{
                    $.ajax({
                        type: 'POST',
                        url: '{{ url(Request::segment(1)."/get_section_user") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "search_division":$('#division_code').val(),
                            "search_department":$('#department_code').val(),
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
                            $('#section_code').html(html);
                        }
                    });
                }
            }

            function get_department_edit(department_code,section_code){
                if($('#edit_division_code').val().length == 0){
                    var html = ``;
                    var html2 = ``;
                    $('#edit_department_code').val([]);
                    $('#edit_section_code').val([]);
                    get_section();
                }else{
                    $.ajax({
                        type: 'POST',
                        url: '{{ url(Request::segment(1)."/get_department_pa_grade") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "search_division":$('#edit_division_code').val(),
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
                            $('#edit_department_code').html(html);
                            if(result.data.length > 1){
                                $('#edit_department_code').val([]);
                            }
                            if(department_code){
                                setTimeout(() => {
                                    const selectedValues = department_code.split(',');
                                    $('#edit_department_code').val(selectedValues).trigger('change');
                                    get_section_edit(section_code);
                                }, 200);
                                
                                
                            }
                            // setTimeout(() => {
                            //     get_section();
                            // }, 200);
                        }
                    });
                }
            }
            function get_section_edit(section_code){
                if($('#edit_department_code').val().length == 0){
                    var html = ``;
                    $('#edit_section_code').val([]);
                }else{
                    $.ajax({
                        type: 'POST',
                        url: '{{ url(Request::segment(1)."/get_section_user") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "search_division":$('#edit_division_code').val(),
                            "search_department":$('#edit_department_code').val(),
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
                            $('#edit_section_code').html(html);
                            if(section_code){
                                const selectedValues = section_code.split(',');
                                $('#edit_section_code').val(selectedValues).trigger('change');
                            }
                        }
                    });
                }
            }
            function get_user_data(id){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_user_data") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":id,
                        "search_year":$('#search_year').val()
                    },
                    success: function (result) { 
                        $('#edit_id').val(result.data.id);

                        $('#edit_name_th').val(result.manager.employee_name_th);
                        $('#edit_name_en').val(result.manager.employee_name_en);
                        $('#edit_orisoft_code').val(result.data.orisoft_code);
                        $('#edit_email').val(result.data.email);

                        // $('#edit_position_code').val(result.manager.position_code);
                        // $('#edit_grade_code').val(result.manager.grade_code);
                        $('#edit_position_code').val(result.manager.position_code).trigger('change');
                        $('#edit_grade_code').val(result.manager.grade_code).trigger('change');
                        // $('#edit_division_code').val(result.data.id);
                        // $('#edit_department_code').val(result.data.id);
                        // $('#edit_section_code').val(result.data.id);

                        if(result.manager.division_code){
                            const selectedValues = result.manager.division_code.split(',');
                            $('#edit_division_code').val(selectedValues).trigger('change');
                            get_department_edit(result.manager.department_code,result.manager.section_code);
                        }
                        
                        
                        $('.roleall').prop('checked',false);
                        if(result.role.length > 0){
                            $.each(result.role, function (key, value) {	
                                $('#edit_kt_modal_update_role_option_'+value.role_id).click();
                            });
                        }
                        
                    }
                });
            }
        </script>
    @endpush

</x-default-layout>
