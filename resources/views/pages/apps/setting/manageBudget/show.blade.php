<x-default-layout>

    @section('title')
        {{ __('Set Budget') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.manageBudget.index') }}
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
                            {{ __('Set Budget') }}
                        </span>
                        <input type="text" id="id_budget" value="{{ $id }}" hidden>
                    </h3>
                    <div class="d-flex align-items-center flex-row mb-0">
                        <button type="button" class="btn btn-primary justify-content-end rounded-pill" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
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
                        <div class="d-none" style="position: absolute;left: 0;z-index: 100;">
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
                                    <span class="menu-title">Edit</span>
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
                                    <span class="menu-title">Delete</span>
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
                                    <th>Grade</th>
                                    <th>Budget range</th>
                                    <th>STD%</th>
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
                        <h3 class="modal-title">{{__('Setting Budget')}}</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-12">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Grade name</label>
                                <input type="text" class="form-control" id="grade_name" name="grade_name" placeholder=""/>
                                <input type="text" id="id_action" name="id_action" hidden>
                                <input type="text" id="edit_id_budget" name="edit_id_budget" value="{{ $id }}" hidden>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Budget range (%)</label>
                                <input type="text" class="form-control" id="budget_range_start" name="budget_range_start" placeholder=""/>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput1" class="form-label mb-0">&nbsp;</label>
                                <input type="text" class="form-control" id="budget_range_end" name="budget_range_end" placeholder=""/>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlInput1" class="form-label mb-0">STD (%)</label>
                                <input type="text" class="form-control" id="std" name="std" placeholder=""/>
                            </div>
                        </div>
                    </div>
                        
                    <div class="modal-footer">
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
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
                    "url": "{{ url(Request::segment(1).'/table_budget_rate_getdata') }}/" + $("#id_budget").val(),
                    "type": 'GET',       
                },
                columns : [
                    { data : 'no' },
                    { data : 'grade_name' },
                    { data : 'budget_range_start' },
                    { data : 'std' },
                    { data : 'button' },
                ],
                columnDefs: [ {
                    targets: 4,
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
                    url: "{{ url(Request::segment(1).'/setting/manageBudget/show/fetch') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('#id_action').val(res.id);
                        $('#grade_name').val(res.grade_name);
                        $('#budget_range_start').val(res.budget_range_start);
                        $('#budget_range_end').val(res.budget_range_end);
                        $('#std').val(res.std);
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
                    url: "{{ url(Request::segment(1).'/setting/manageBudget/show/addedit') }}",
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
                            text: "ระบบSaveข้อมูลไม่สำเร็จ",
                            icon: "error",
                            allowOutsideClick: false,
                        });
                    }
                });
            });
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
    </style>
</x-default-layout>
