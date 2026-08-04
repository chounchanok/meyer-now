<x-default-layout>

    @section('title')
        {{ __('PA Timeline History') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('pa.timeline.index') }}
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
                            {{ __('PA Timeline History') }}
                        </span>
                    </h3>
                    <!--end::Title-->
                    <div class="d-flex align-items-center flex-row mb-0">
                        <a>
                            <button type="button" class="btn btn-primary justify-content-end rounded-pill" onclick="add_timeline()"><i
                                    class="bi bi-plus fs-5"></i>Add</button>
                            {{-- <button type="button" class="btn btn-primary justify-content-end rounded-pill" onclick="add()"><i
                                    class="bi bi-plus fs-5"></i>Group</button> --}}
                        </a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <form class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Search</label>
                            <select class="myLike form-select" id="year" name="year">
                                <option value="">-Select-</option>
                                @if ($timeline != null)
                                    @foreach ($timeline as $time)
                                        <option value="{{ $time->year }}"> ปี {{ $time->year }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Date</label>
                            <input type="date" class="form-control" placeholder="" />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                            <select class="form-select">
                                <option>-Select-</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>
                    </form>

                    <table id="kt_datatable_dom_positioning"
                        class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>No.</th>
                                <th>Topic</th>
                                <th>Create Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="">

                        </tbody>
                    </table>
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
    <!--begin::add modal-->
    <div id="addList_content" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#addList" data-kt-drawer-close="#addList_close" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Add</a>
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
                <form>
                    <div class="mb-3">
                        <label class="form-label">หัวข้อ(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title(English)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </form>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                    data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button type="button" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::add modal-->
    <!--begin::edit modal-->
    <div id="editList_content" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#editList" data-kt-drawer-close="#editList_close" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#"
                            class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">แก้ไขรายการ</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="editList_close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <form>
                    <div class="mb-3">
                        <label class="form-label">หัวข้อ(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title(English)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </form>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                    data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button type="button" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::edit modal-->

    @push('scripts')
        <script type="text/javascript">
            let fullUrl = '{{ url()->current() }}';

            $(function() {
                otable = $("#kt_datatable_dom_positioning").DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    ajax: {
                        url: "{{ url(Request::segment(1).'/table_timeline_getdata') }}",
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
                    columns: [{
                            data: 'no'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'year'
                        },
                        {
                            data: 'button'
                        },
                    ],
                    columnDefs: [{
                        targets: 2,
                        createdCell: function(td, cellData, rowData, row, col) {

                        }
                    }],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom": "<'row'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
                        ">"
                });
                $('#year').on('change', function(e) {
                    otable.draw();
                });

            });

            function add_timeline() {
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/table_timeline_getdata') }}",
                    // url: fullUrl + '/add',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            Swal.fire({
                                title: "Success",
                                text: "Saved Successfully",
                                icon: "success",
                                allowOutsideClick: false,
                            });
                            window.location.reload();
                        } else if (response.status == 409) {
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "ปีนี้มี Form อยู่แล้ว",
                                icon: "error",
                                allowOutsideClick: false,
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
            }

            function add() {
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/pa/make/group') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            Swal.fire({
                                title: "Success",
                                text: "Saved Successfully",
                                icon: "success",
                                allowOutsideClick: false,
                            });
                            window.location.reload();
                        } else if (response.status == 409) {
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "ปีนี้มี Form อยู่แล้ว",
                                icon: "error",
                                allowOutsideClick: false,
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
            }
        </script>
    @endpush
    <style>
        div.dataTables_scrollBody {
            border-left: 0px solid #ddd !important
        }
    </style>
</x-default-layout>
