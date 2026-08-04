<x-default-layout>

    @section('title')
        {{ __('Employee Data Management') }} {{__('Year')}} {{ $manage->year }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.manageEmployee.index') }}
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
                            {{ __('Employee Data Management') }} {{__('Year')}} {{ $manage->year }}
                        </span>
                        <input type="text" name="year" id="year" value="{{ $manage->year }}" hidden>
                    </h3>
                    <!-- <div class="d-flex align-items-center flex-row mb-0">
                        <button type="button" class="btn btn-primary justify-content-end rounded-pill">

                            <i class="bi bi-plus fs-5"></i>Add
                        </button>
                    </div> -->
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Search')}}</label>
                            <input type="text" class="form-control myLike" name="searchText" id="searchText"
                                placeholder="Name, Code" >
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Position</label>
                            <select class="form-select myLike" id="search_position" name="search_position" data-control="select2">
                                <option value="all">-Select-</option>
                                @foreach ($position as $pos)
                                    <option value="{{ $pos->position_code }}">{{ $pos->position_code }}
                                        {{ $pos->position_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                            <select class="form-select myLike" id="search_division" name="search_division" data-control="select2">
                                <option value="all">-Select-</option>
                                @foreach ($division as $div)
                                    <option value="{{ $div->division_code }}">{{ $div->division_code }}
                                        {{ $div->division_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                            <select class="form-select myLike" id="search_department" name="search_department" data-control="select2">
                                <option value="all">-Select-</option>
                                @foreach ($department as $dep)
                                    <option value="{{ $dep->department_code }}">{{ $dep->department_code }}
                                        {{ $dep->department_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                            <select class="form-select myLike" id="search_section" name="search_section" data-control="select2">
                                <option value="all">-Select-</option>
                                @foreach ($section as $sec)
                                    <option value="{{ $sec->section_code }}">{{ $sec->section_code }}
                                        {{ $sec->section_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Grade</label>
                            <select class="form-select myLike" id="search_grade" name="search_grade" data-control="select2">
                                <option value="all">-Select-</option>
                                @foreach ($grade as $sec)
                                    <option value="{{ $sec->grade_code }}">{{ $sec->grade_code }}
                                        {{ $sec->grade_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                        </div>
                    </div>
                    <hr class="border-gray-400">
                    <!-- <p>หมายเหตุ: 
                        <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                        Approved / 
                        <span class="badge badge-square badge-warning"><i class="ki-solid ki-arrows-loop text-white"></i></span>
                        Transferred /
                        <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                        Resigned
                    </p> -->
                    <p>หมายเหตุ: 
                        <span class="badge badge-square badge-success"><i class="ki-solid ki-check-circle text-white"></i></span>
                        Passed / 
                        <span class="badge badge-square badge-warning"><i class="ki-solid ki-arrows-loop text-white"></i></span>
                        Transferred /
                        <span class="badge badge-square badge-danger"><i class="ki-solid ki-cross-circle text-white"></i></span>
                        Resigned
                    </p>
                    <div class="table-responsive" style="position: relative;">
                        <!--begin::Menu wrapper-->
                        <div style="position: absolute;left: 0;z-index: 100;display:none;">
                            <!--begin::Toggle-->
                            <button type="button" class="btn btn-light-primary rotate mb-3 py-2"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                data-kt-menu-offset="0px, 0px">
                                Action
                                <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                            </button>
                            <!--end::Toggle-->

                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="editForm.php" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-notepad-edit fs-3 text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">แก้ไข</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Active</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-trash fs-3 text-primary"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span><span class="path4"></span><span
                                                    class="path5"></span></i>
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
                                    <th>{{__('Emp. no.')}}</th>
                                    <th>{{__('Emp. Name')}}</th>
                                    <th>Department</th>
                                    <th>Div.</th>
                                    <th>Dept.</th>
                                    <th>Sect.</th>
                                    <th>{{__('Status')}}</th>
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
                <div class="modal-header">
                    <h3 class="modal-title">Transfer</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="edit_employee" class="row g-3 mb-3">
                    <div class="modal-body">
                        @csrf
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Emp. Name')}} (TH)</label>
                            <input type="text" class="form-control" name="employee_name" placeholder="" id="employee_name" disabled/>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Emp. Name')}} (EN)</label>
                            <input type="text" class="form-control" name="employee_name_en" placeholder="" id="employee_name_en" disabled/>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Div</label>
                            <select class="form-select form-select-solid" id="division" name="division" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">

                                @foreach ($division as $div)
                                    <option value="{{ $div->division_code }}">{{ $div->division_code }}
                                        {{ $div->division_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Dept</label>
                            <select class="form-select form-select-solid" id="department" name="department" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                @foreach ($department as $dep)
                                    <option value="{{ $dep->department_code }}">{{ $dep->department_code }}
                                        {{ $dep->department_description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Sect</label>
                            <select class="form-select form-select-solid" id="section" name="section" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Select an option">
                                @foreach ($section as $sec)
                                    <option value="{{ $sec->section_code }}">{{ $sec->section_code }}
                                        {{ $sec->section_description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-pill"><i
                                    class="bi bi-floppy fs-5"></i>Confirm</button>
                            <input type="hidden" id="id_employee" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script type="text/javascript">
            let year = $('#year').val();

            $(function() {
                otable = $("#kt_datatable_dom_positioning").DataTable({
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
                        url: "{{ url(Request::segment(1).'/table_employee_getdata') }}/" + year,
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
                        {
                            data: 'no'
                        },
                        {
                            data: 'code'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'position'
                        },
                        {
                            data: 'div'
                        },
                        {
                            data: 'dept'
                        },
                        {
                            data: 'sec'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'edit'
                        },
                    ],
                    columnDefs: [{
                        targets: 8,
                        render: function(data, type, row) {
                            @can('edit employee')
                                if (row.edit != '') {
                                    return `<button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" onclick="fetchEmployee(${row.edit})">
                                                <i class="ki-solid ki-arrows-loop text-white"></i>
                                            </button>
                                            ${(row.employee_status_description != 'Resigned'?
                                                `
                                                    <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="resignEmployee(${row.edit})">
                                                        <i class="ki-solid ki-cross-circle text-white"></i>
                                                    </button>
                                                `:``)}
                                            `;
                                } else {
                                    return ``;
                                }
                            @else
                                return ``;
                            @endcan
                        }
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
                $('#searchText').on('keyup', function(e) {
                    otable.draw();
                });
                $('#search_department').on('change', function(e) {
                    otable.draw();
                });
                $('#search_division').on('change', function(e) {
                    otable.draw();
                });
                $('#search_position').on('change', function(e) {
                    otable.draw();
                });
                $('#search_section').on('change', function(e) {
                    otable.draw();
                });
                $('#search_grade').on('change', function(e) {
                    otable.draw();
                });
            });


            function fetchEmployee(id) {
                $('#kt_modal_1').modal('show');
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/get/employee') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        console.log(res);
                        $('#id_employee').val(id);
                        $('#employee_name').val(res.employee_local_name_th);
                        $('#employee_name_en').val(res.employee_local_name_en);

                        $('#department').val(res.department_code);
                        if(res.department_code_transferred != null){
                            $('#department').val(res.department_code_transferred);
                        }
                        $('#division').val(res.division_code);
                        if(res.division_code_transferred != null){
                            $('#division').val(res.division_code_transferred);
                        }
                        $('#section').val(res.section_code);
                        if(res.section_code_transferred != null){
                            $('#section').val(res.section_code_transferred);
                        }
                        $('#select2-division-container').html(res.division_code+" "+res.division_description);
                        $('#select2-division-container').attr('title',res.division_code+" "+res.division_description);
                        if(res.division_code_transferred != null){
                            $('#select2-division-container').html(res.division_code_transferred+" "+res.division_code_transferred_description);
                            $('#select2-division-container').attr('title',res.division_code_transferred+" "+res.division_code_transferred_description);
                        }
                        $('#select2-department-container').html(res.department_code+" "+res.department_description);
                        $('#select2-department-container').attr('title',res.department_code+" "+res.department_description);
                        if(res.department_code_transferred != null){
                            $('#select2-department-container').html(res.department_code_transferred+" "+res.department_code_transferred_description);
                            $('#select2-department-container').attr('title',res.department_code_transferred+" "+res.department_code_transferred_description);
                        }
                        $('#select2-section-container').html(res.section_code+" "+res.section_description);
                        $('#select2-section-container').attr('title',res.section_code+" "+res.section_description);
                        if(res.section_code_transferred != null){
                            $('#select2-section-container').html(res.section_code_transferred+" "+res.section_code_transferred_description);
                            $('#select2-section-container').attr('title',res.section_code_transferred+" "+res.section_code_transferred_description);
                        }
                        
                        // $('#department').val((res.department_code_transferred?res.department_code_transferred:res.department_code));
                        // $('#division').val((res.division_code_transferred?res.division_code_transferred:res.division_code));
                        // $('#section').val((res.section_code_transferred?res.section_code_transferred:res.section_code));
                        // $('#select2-division-container').html((res.division_code_transferred?res.division_code_transferred:res.division_code)+" "+res.division_description);
                        // $('#select2-department-container').html((res.department_code_transferred?res.department_code_transferred:res.department_code)+" "+res.department_description);
                        // $('#select2-section-container').html((res.section_code_transferred?res.section_code_transferred:res.section_code)+" "+res.section_description);
                        // $('#select2-division-container').attr('title',(res.division_code_transferred?res.division_code_transferred:res.division_code)+" "+res.division_description);
                        // $('#select2-department-container').attr('title',(res.department_code_transferred?res.department_code_transferred:res.department_code)+" "+res.department_description);
                        // $('#select2-section-container').attr('title',(res.section_code_transferred?res.section_code_transferred:res.section_code)+" "+res.section_description);
                    },
                    error: function(res) {
                        console.log("error");
                        console.log(res);
                    }
                });
            }
            $("#edit_employee").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
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
                            method: 'POST',
                            url: "{{ url(Request::segment(1).'/edit/employee') }}/" + $('#id_employee').val(),
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Success",
                                        html: "Saved Successfully",
                                        timer: 1000,
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
                                    icon: 'error',
                                    title: "ไม่สำเร็จ",
                                    html: "ระบบบันทึกข้อมูลไม่สำเร็จ",
                                    timer: 1000,
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
                                        
                                    }
                                });
                            }
                        });

                    }
                });
            });
            function resignEmployee(id){
                Swal.fire({
                    title: 'confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/resignEmployee") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                "id":id
                            },
                            success: function (result) { 
                                $('.set_status'+id).html('Resign');
                                $('.set_status'+id).removeClass('badge-light');
                                $('.set_status'+id).removeClass('badge-light-success');
                                $('.set_status'+id).addClass('badge-light-danger');
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody {
            border-left: 0px solid #ddd !important
        }
    </style>
</x-default-layout>
