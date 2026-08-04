<x-default-layout>

    @section('title')
        {{ __('Create PA Form Groups') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('formEvaluate.groupForm.index') }}
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
                            {{ __('Create PA Form Groups') }}
                        </span>
                    </h3>
                    <!--end::Title-->
                    <div class="d-flex align-items-center flex-row mb-0">
                        @can('create pa form groups')
                        <a href="{{ route('meyer.addpage') }}" class="btn btn-primary justify-content-end rounded-pill"><i class="bi bi-plus fs-5"></i>{{__('Create Form')}}</a>
                        @endcan
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Search')}}</label>
                            <input type="text" class="form-control" id="searchText" placeholder="Form..." onkeyup="search_data();" />
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{ __('Search Year') }}</label>
                            <select class="form-select" data-control="select2" id="form_year_use_start" onchange="search_data();">
                                @if (count($year) > 0)
                                    @foreach ($year as $y)
                                        <option value="{{ $y->form_year_use_start }}">{{ $y->form_year_use_start }}</option>
                                    @endforeach
                                @else
                                    <option value="no">No Data</option>
                                @endif
                            </select>
                        </div>
                        <!-- <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Date')}}</label>
                            <input type="date" class="form-control" id="serach_created" placeholder="" onchange="search_data();" />
                        </div> -->
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Status')}}</label>
                            <select class="form-select" id="serach_status" onchange="search_data();">
                                <option value="">-Select-</option>
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            <button type="button" class="btn btn-primary rounded-pill" onclick="search_data();">
                                <i class="bi bi-search"></i>
                                {{__('Search')}}
                            </button>
                        </div>
                    </div>
                    <p>{{__('Note')}}:
                        <span class="badge badge-square badge-warning"><i class="ki-solid ki-pencil text-white"></i></span>
                        {{__('Edit')}} /
                        <span class="badge badge-square badge-info"><i class="ki-solid ki-copy text-white"></i></span>
                        {{__('Duplicate')}}
                    </p>

                    <div class="table-responsive" style="position: relative;">
                        <!--begin::Menu wrapper-->
                        <!-- <div style="position: absolute;left: 0;z-index: 100;">
                            <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                Action
                                <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="editForm.php" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-notepad-edit fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">แก้ไข</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-check-circle fs-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">Active</span>
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-trash fs-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </span>
                                    <span class="menu-title">ลบ</span>
                                    </a>
                                </div>
                            </div>
                        </div> -->
                        <!--end::Dropdown wrapper-->
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th class="align-middle text-center">{{__('No.')}}</th>
                                    <th class="text-center">{{__('Form name')}}</th>
                                    <th class="text-center">{{__('Create Date')}}</th>
                                    <th class="text-center">{{__('Year of use')}}</th>
                                    <th class="text-center">{{__('Revise')}}</th>
                                    <th class="text-center">{{__('Reference form')}}</th>
                                    <th class="text-center">{{__('Status')}}</th>
                                    <th class="text-center" style="min-width:100px;">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @if (!empty($datarow))
@php
    $no = 1;
@endphp
                                @foreach ($datarow as $key => $item)
<tr>
                                    <td class="text-center">{{ $no }}.</td>
                                    <td>{{ $item->form_th }}</td>
                                    <td class="text-center">{{ $item->created }}</td>
                                    <td class="text-center">{{ $item->form_year_use_start }} - {{ $item->form_year_use_end }}</td>
                                    <td class="text-center">{{ $item->revise }}</td>
                                    <td class="text-center">{{ $item->form_ref }}</td>
                                    <td>
                                        <div style="display: flex;align-items: center;justify-content: center;">
                                            <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                                <input class="form-check-input h-30px w-50px" type="checkbox" value="" id="flexSwitchDefault"/>
                                            </div>
                                            <div class="flex-center-new" style="border-radius: 4px;background: #E8FFF3;width: 74px;height: 15px;">
                                                <span style="color: #50CD89;">Active</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="groupForm/{{ $item->id }}/edit"  type="button">
                                            <img src="{{ image('icons/edit.svg') }}" class="pointer">
                                        </a>
                                    </td>
                                </tr>
                                
                                @php
                                    $no++;
                                @endphp
@endforeach
@endif -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->
    <!--begin::add modal-->
    <div id="addList_content" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#addList" data-kt-drawer-close="#addList_close" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Add</a>
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
                <div>
                    <div class="mb-3">
                        <label class="form-label">หัวข้อ(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title(English)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::add modal-->
    <!--begin::edit modal-->
    <div id="editList_content" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#editList" data-kt-drawer-close="#editList_close" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">แก้ไขรายการ</a>
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
                <div>
                    <div class="mb-3">
                        <label class="form-label">หัวข้อ(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title(English)</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::edit modal-->

    @push('scripts')
        <script type="text/javascript">
            var table = $("#kt_datatable_dom_positioning").DataTable({
                "lengthMenu": [
                    [100, 500, 1000, "All"],
                    [100, 500, 1000, "All"]
                ],
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
                "ajax": {
                    "url": "{{ url(Request::segment(1) . '/table_groupform_getdata') }}",
                    "type": 'POST',
                    "data": {
                        "_token": "{{ csrf_token() }}",
                        "searchText": $('#searchText').val(),
                        "serach_created": $('#serach_created').val(),
                        "serach_status": $('#serach_status').val()
                    },
                },
                columns: [{
                        data: 'no',
                        className: "text-center"
                    },
                    {
                        data: 'form_th',
                        className: "text-center"
                    },
                    {
                        data: 'create_date',
                        className: "text-center"
                    },
                    {
                        data: 'form_year_use_start',
                        className: "text-center"
                    },
                    {
                        data: 'revise',
                        className: "text-center"
                    },
                    {
                        data: 'form_ref',
                        className: "text-center"
                    },
                    {
                        data: 'status',
                        className: "text-center"
                    },
                    {
                        data: 'id',
                        className: "text-center"
                    }
                ],
                columnDefs: [{
                    targets: 6,
                    render: function(data, type, row) {
                        @can('active pa form groups')
                            return `
                                <div style="display: flex;align-items: center;justify-content: center;">
                                    <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                        <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault${row.id}" ${(row.status==1?'checked="checked"':"")}" onchange="changeactive('${row.id}');"/>
                                    </div>
                                    <div class="flex-center-new" style="border-radius: 4px;background: #E8FFF3;width: 74px;height: 15px;">
                                        <span style="color: #50CD89;">Active</span>
                                    </div>
                                </div>`;
                        @else
                            return `
                                <div style="display: flex;align-items: center;justify-content: center;">
                                    <div class="flex-center-new" style="border-radius: 4px;background: #E8FFF3;width: 74px;height: 15px;">
                                        <span style="color: #50CD89;">Active</span>
                                    </div>
                                </div>`;
                        @endcan
                    }
                }, {
                    targets: 7,
                    render: function(data, type, row) {
                        @can('edit pa form groups')
                        return `<a href="groupForm/${row.id}/edit"  type="button">
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-icon btn-info text-dark btn-xs me-1" onclick="copy_data(${row.id});" title="คัดลอก">
                                    <i class="ki-solid ki-copy fs-5"></i>
                                </button>
                                `;
                        @endcan
                        

                    }
                }],
                "language": {
                    "lengthMenu": "Show _MENU_",
                },
                "dom": "<'row'" +
                    "<'col-sm-6'l>" +
                    "<'col-sm-6'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5'i>" +
                    "<'col-sm-12 col-md-7'p>" +

                    ">"
            });
            // "dom":
            //         "<'row'" +
            //         "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
            //         ">" +

            //         "<'table-responsive'tr>" +

            //         "<'row'" +
            //         "<'col-sm-12 col-md-3 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            //         "<'col-sm-10 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            //         "<'col-sm-2 col-md-2 d-flex align-items-center justify-content-center justify-content-md-end'l>" +
            //         ">"
            function search_data() {
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                search_group();
            }

            function search_group() {
                $('#kt_datatable_dom_positioning').DataTable({
                    "lengthMenu": [
                        [100, 500, 1000, "All"],
                        [100, 500, 1000, "All"]
                    ],
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
                    "ajax": {
                        "url": "{{ url(Request::segment(1) . '/table_groupform_getdata') }}",
                        "type": 'POST',
                        "data": {
                            "_token": "{{ csrf_token() }}",
                            "searchText": $('#searchText').val(),
                            "form_year_use_start": $('#form_year_use_start').val(),
                            "serach_status": $('#serach_status').val()
                        },
                    },
                    columns: [{
                            data: 'no',
                            className: "text-center"
                        },
                        {
                            data: 'form_th',
                            className: "text-center"
                        },
                        {
                            data: 'create_date',
                            className: "text-center"
                        },
                        {
                            data: 'form_year_use_start',
                            className: "text-center"
                        },
                        {
                            data: 'revise',
                            className: "text-center"
                        },
                        {
                            data: 'form_ref',
                            className: "text-center"
                        },
                        {
                            data: 'status',
                            className: "text-center"
                        },
                        {
                            data: 'id',
                            className: "text-center"
                        },
                    ],
                    columnDefs: [{
                        targets: 6,
                        render: function(data, type, row) {
                            return `<div style="display: flex;align-items: center;justify-content: center;">
                                        <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                            <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault${row.id}" checked="${row.status==1?true:false}" onchange="changeactive('${row.id}');"/>
                                        </div>
                                        <div class="flex-center-new" style="border-radius: 4px;background: #E8FFF3;width: 74px;height: 15px;">
                                            <span style="color: #50CD89;">Active</span>
                                        </div>
                                    </div>`;

                        }
                    }, {
                        targets: 7,
                        render: function(data, type, row) {
                            return `<a href="groupForm/${row.id}/edit"  type="button">
                                        <img src="{{ image('icons/edit.svg') }}" class="pointer">
                                    </a>`;

                        }
                    }],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom": "<'row'" +
                        "<'col-sm-6'l>" +
                        "<'col-sm-6'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5'i>" +
                        "<'col-sm-12 col-md-7'p>" +

                        ">"
                });
            }

            function changeactive(id) {
                console.log(id);
                var status = ($('#flexSwitchDefault' + id).is(':checked') == true ? '1' : '0');
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Save'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1) . '/group_form_changeactive') }}',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                                status: status
                            },
                            success: function(result) {
                                if (result.data[0].status == 200) {
                                    let timerInterval;
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Success",
                                        html: "I will close in <b></b> milliseconds.",
                                        timer: 2000,
                                        timerProgressBar: true,
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
                                } else {
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        if (status == 0) {
                            $('#flexSwitchDefault' + id).prop('checked', true);
                        } else {
                            $('#flexSwitchDefault' + id).prop('checked', false);
                        }
                    }
                });

            }

            function copy_data(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1) . '/copy_data') }}',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id
                            },
                            success: function(result) {
                                console.log(result.status);
                                if (result.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Success",
                                        html: "I will close in <b></b> milliseconds.",
                                        timer: 1000,
                                        timerProgressBar: true,
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
