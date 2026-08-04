<x-default-layout>

    @section('title')
        {{ __('Set %Increase by Dept.') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.manageDepartment.index') }}
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
                        {{ __('Set %Increase by Dept.') }}
                    </span>
                    </h3>
                    <!--end::Title-->
                    <div class="d-flex align-items-center flex-row mb-0">
                        @can('create set increase')
                        <button type="button" class="btn btn-primary justify-content-end rounded-pill" id="addList"><i class="bi bi-plus fs-5"></i>{{__('Add')}}</button>
                        @endcan
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- <form class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Search</label>
                            <input type="text" class="form-control" placeholder="ชื่อฟอร์ม..."/>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">วันที่</label>
                            <input type="date" class="form-control" placeholder=""/>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>
                    </form> -->
                    
                    
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
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th class="align-middle">{{__('No.')}}</th>
                                    <th>{{__('Topic')}}</th>
                                    <th>{{__('Create Date')}}</th>
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
    <!--begin::add modal-->
    <div
        id="addList_content"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#addList"
        data-kt-drawer-close="#addList_close"
        data-kt-drawer-width="400px"
        >
        <div class="card rounded-0 w-100">
            <form id="add_action">
                <!--begin::Card header-->
                <div class="card-header pe-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">{{__('Add')}}</a>
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-light-primary" id="addList_close">
                        <i class="ki-outline ki-cross fs-1"></i>              
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body hover-scroll-overlay-y">
                    <div class="mb-3">
                        <label class="form-label">{{__('Topic')}}</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="" required>
                    </div>
                </div>
                <!--end::Card body-->

                <!--begin::Card footer-->
                <div class="card-footer text-end">
                    <!--begin::Dismiss button-->
                    <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Close</button>
                    <!--end::Dismiss button-->
                    <button type="submit" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                </div>
                <!--end::Card footer-->
            </form>
        </div>
    </div>
    <!--end::add modal-->

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                search_group();
            });

            function search_data(){
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                search_group();
            }
            function search_group(){
                $("#kt_datatable_dom_positioning").DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    "ajax": {
                        "url": "{{ url(Request::segment(1).'/table_alldepartment_getdata') }}",
                        "type": 'POST',  
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "search_name": $('#search_name').val(),
                            "search_date": $('#search_date').val()
                        },
                    },
                    columns : [
                        { data : 'no' },
                        { data : 'title' },
                        { data : 'date' },
                        // { data : 'status_active' },
                        { data : 'button' },
                    ],
                    columnDefs: [],
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
            }
                
            $("#add_action").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    method: 'POST',
                    url: "{{ url(Request::segment(1).'/setting/manageDepartment/add') }}",
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
                        }else{
                            let timerInterval;
                            Swal.fire({
                                icon: 'warning',
                                title: response.message,
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
                                if (result.dismiss === Swal.DismissReason.timer) {}
                            });
                        }
                        $('#title').val('');
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
                    url: '{{ url(Request::segment(1)."/department_change_active") }}',
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
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
    </style>
</x-default-layout>
