<x-default-layout>

    @section('title')
        {{ __('PA Timeline Setting') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
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
                            {{ __('PA Timeline Setting') }}
                        </span>
                        <input type="hidden" id="segment" value="{{trans(request()->segment(1))}}">
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <form class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{ __('Search Year') }}</label>
                            <select class="form-select myLike" data-control="select2" id="search_year" name="id" onchange="destroy_table();">
                                @if (count($year) > 0)
                                    @foreach ($year as $y)
                                        <option value="{{ $y->id }}">{{ $y->year }}</option>
                                    @endforeach
                                @else
                                    <option value="no">No Data</option>
                                @endif



                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            @can('create pa timeline history')
                            <button type="button" class="btn btn-primary justify-content-end rounded-pill"
                                onclick="add_timeline()"><i class="bi bi-plus fs-5"></i>{{ __('Add Year') }} </button>
                            @endcan
                        </div>
                        <div class="col-sm-6" style="text-align: right;">
                            <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                            @can('create pa timeline history')
                            <button type="button" class="btn btn-warning justify-content-end rounded-pill" id="addListx" onclick="fetch_actionx(0)">
                                <i class="ki-solid ki-pencil fs-5"></i> เพิ่มรายการ
                            </button>
                            @endcan
                        </div>
                        
                        
                    </form>
                    <!--begin::Menu wrapper-->
                    <div>
                        <!--begin::Toggle-->
                        {{-- <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            Action
                            <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                        </button> --}}
                        <!--end::Toggle-->

                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" id="addList">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-notepad-edit fs-3 text-primary"><span
                                                class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="menu-title">Add</span>
                                </a>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Dropdown wrapper-->

                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning"
                            class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    @can('create pa timeline history')
                                    <th style="text-align:center;">{{ __('Edit')}}</th>
                                    <th style="text-align:center;">{{ __('Status')}}</th>
                                    @endcan
                                    <th>{{ __('No.')}}</th>
                                    <th>{{ __('Topic')}}</th>
                                    <th style="min-width:100px;">{{ __('Timeline Plan')}}</th>
                                    <th style="min-width:100px;">{{ __('Timeline Actual')}}</th>
                                    <th>HR</th>
                                    <th>Manager</th>
                                    @if(trans(request()->segment(1)) != 'mtl')
                                    <th>Komkrit DM</th>
                                    @endif
                                    <th>K.Joe GM</th>
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
    <div id="addList_content" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#addList" data-kt-drawer-close="#addList_close" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <span href="#" class="fs-4 fw-bold text-gray-900 me-1 lh-1">Action
                            item</span>
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
                <form id="edit_action">
                    <div class="mb-3">
                        <label class="form-label">{{ __('No.')}}</label>
                        <input type="text" name="id_action" id="id_action" hidden>
                        <input type="text" class="form-control" placeholder="Review Evaluator Lists" name="title"
                            id="action_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Timeline Plan')}}</label>
                        <input type="date" id="start_date" name="start_date" class="form-control mb-4"
                            placeholder="" />
                        <input type="date" id="end_date" name="end_date" class="form-control mb-4 "
                            placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Timeline Actual')}}</label>
                        <input type="date" id="start_date_real" name="start_date_real" class="form-control mb-4"
                            placeholder="" />
                        <input type="date" id="end_date_real" name="end_date_real" class="form-control mb-4 "
                            placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Person in charge:</label><br>
                        <div style="display: flex;align-items: center;justify-content: start;">
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="hr"
                                    id="HR" />
                                <label class="form-check-label me-4" for="HR">
                                    HR
                                </label>
                            </div>
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="manager"
                                    id="Manager" />
                                <label class="form-check-label me-4" for="Manager">
                                    Manager
                                </label>
                            </div>
                        </div>
                        <div style="display: flex;align-items: center;justify-content: start;">
                            @if(trans(request()->segment(1)) != 'mtl')
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="dm"
                                    id="dm" />
                                <label class="form-check-label me-4" for="dm">
                                    Komkrit DM
                                </label>
                            </div>
                            @endif
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="gm"
                                    id="gm" />
                                <label class="form-check-label me-4" for="gm">
                                    K.Joe GM
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">HR <span class="show_count_hr" style="color:blue;"></span></label>
                        <select class="form-select" id="hr_select" name="hr_select[]" data-dropdown-parent="#addList_content" data-control="select2" data-close-on-select="false" data-placeholder="Show an option" data-allow-clear="true" multiple="multiple" onchange="count_hr();">
                            <option value="0">{{ __('Show an option') }}</option>
                            @if (count($data_hr) > 0)
                                @foreach ($data_hr as $y)
                                    <option value="{{ $y->employee_no }}">{{ $y->employee_no }} {{ $y->employee_name_en }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Manager <span class="show_count_manager" style="color:blue;"></span></label>
                        <select class="form-select" id="manager_select" name="manager_select[]" data-dropdown-parent="#addList_content" data-control="select2" data-close-on-select="false" data-placeholder="Show an option" data-allow-clear="true" multiple="multiple" onchange="count_manager();">
                            <option value="0">{{ __('Show an option') }}</option>
                            @if (count($data_manager) > 0)
                                @foreach ($data_manager as $y)
                                    <option value="{{ $y->employee_no }}">{{ $y->employee_no }} {{ $y->employee_name_en }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                    data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button type="submit" class="btn btn-success rounded-pill"><i
                        class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            </form>
            <!--end::Card footer-->
        </div>
    </div>

    <!--begin::add modal-->
    <div id="addList_contentx" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#addListx" data-kt-drawer-close="#addList_closex" data-kt-drawer-width="400px">
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <span href="#" class="fs-4 fw-bold text-gray-900 me-1 lh-1">Add</span>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="addList_closex">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <form id="add_action">
                    <div class="mb-3">
                        <label class="form-label">{{ __('No.')}}</label>
                        <input type="text" name="add_id_action" id="add_id_action" hidden>
                        <input type="text" class="form-control" placeholder="Review Evaluator Lists" name="add_title"
                            id="add_action_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Timeline Plan')}}</label>
                        <input type="date" id="start_date" name="add_start_date" class="form-control mb-4"
                            placeholder="" />
                        <input type="date" id="end_date" name="add_end_date" class="form-control mb-4 "
                            placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Timeline Actual')}}</label>
                        <input type="date" id="start_date_real" name="add_start_date_real" class="form-control mb-4"
                            placeholder="" />
                        <input type="date" id="end_date_real" name="add_end_date_real" class="form-control mb-4 "
                            placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Person in charge:</label><br>
                        <div style="display: flex;align-items: center;justify-content: start;">
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="add_hr"
                                    id="add_HR" />
                                <label class="form-check-label me-4" for="add_HR">
                                    HR
                                </label>
                            </div>
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="add_manager"
                                    id="add_Manager" />
                                <label class="form-check-label me-4" for="add_Manager">
                                    Manager
                                </label>
                            </div>
                        </div>
                        <div style="display: flex;align-items: center;justify-content: start;">
                            @if(trans(request()->segment(1)) != 'mtl')
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="add_dm"
                                    id="add_dm" />
                                <label class="form-check-label me-4" for="add_dm">
                                    Komkrit DM
                                </label>
                            </div>
                            @endif
                            <div class="form-check mt-5">
                                <input class="form-check-input me-4" type="checkbox" value="active" name="add_gm"
                                    id="add_gm" />
                                <label class="form-check-label me-4" for="add_gm">
                                    K.Joe GM
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">HR <span class="add_show_count_hr" style="color:blue;"></span></label>
                        <select class="form-select" id="add_hr_select" name="add_hr_select[]" data-dropdown-parent="#addList_contentx" data-control="select2" data-close-on-select="false" data-placeholder="Show an option" data-allow-clear="true" multiple="multiple" onchange="add_count_hr();">
                            <option value="0">{{ __('Show an option') }}</option>
                            @if (count($data_hr) > 0)
                                @foreach ($data_hr as $y)
                                    <option value="{{ $y->employee_no }}">{{ $y->employee_no }} {{ $y->employee_name_en }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Manager <span class="add_show_count_manager" style="color:blue;"></span></label>
                        <select class="form-select" id="add_manager_select" name="add_manager_select[]" data-dropdown-parent="#addList_contentx" data-control="select2" data-close-on-select="false" data-placeholder="Show an option" data-allow-clear="true" multiple="multiple" onchange="add_count_manager();">
                            <option value="0">{{ __('Show an option') }}</option>
                            @if (count($data_manager) > 0)
                                @foreach ($data_manager as $y)
                                    <option value="{{ $y->employee_no }}">{{ $y->employee_no }} {{ $y->employee_name_en }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill"
                    data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button type="submit" class="btn btn-success rounded-pill"><i
                        class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            </form>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::add modal-->

    @push('scripts')
        <script type="text/javascript">
            let id = $("#id_pa_timeline").val()
            
            $(function() {
                @can('create pa timeline history')
                    if($('#segment').val() != "mtl"){
                        var co = [
                            {
                                data: 'checkbox'
                            },
                            {
                                data: 'status'
                            },
                            {
                                data: 'no'
                            },
                            {
                                data: 'topic',
                            },
                            {
                                data: 'timeline_plan'
                            },
                            {
                                data: 'timeline_real'
                            },
                            {
                                data: 'hr'
                            },
                            {
                                data: 'manager'
                            },
                            {
                                data: 'dm'
                            },
                            {
                                data: 'gm'
                            }
                        ];
                        var co_def = [{
                            targets: 0,
                            orderable: false,
                            render: function(data, type, row) {
                                if (row.checkbox != 'ไม่มีข้อมูล') {
                                    return `
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" id="addList" onclick="fetch_action(${row.id})">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>`;
                                    // <button href="#" class="menu-link px-3" id="addList" onclick="fetch_action(${row.id})" style="border: none;background-color: #ffffff;">
                                    //     <span class="menu-title"><img src="{{ image('icons/edit.svg') }}" class="pointer"></span>
                                    // </button>
                                } else {
                                    return ``;
                                }

                            }
                        }, {
                            targets: 6,
                            render: function(data, type, row) {
                                if (row.hr == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 7,
                            render: function(data, type, row) {
                                if (row.manager == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 8,
                            render: function(data, type, row) {
                                if (row.dm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 9,
                            render: function(data, type, row) {
                                if (row.gm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }];
                    }else{
                        var co = [
                            {
                                data: 'checkbox'
                            },
                            {
                                data: 'status'
                            },
                            {
                                data: 'no'
                            },
                            {
                                data: 'topic',
                            },
                            {
                                data: 'timeline_plan'
                            },
                            {
                                data: 'timeline_real'
                            },
                            {
                                data: 'hr'
                            },
                            {
                                data: 'manager'
                            },
                            {
                                data: 'gm'
                            }
                        ];
                        var co_def = [{
                            targets: 0,
                            orderable: false,
                            render: function(data, type, row) {
                                if (row.checkbox != 'ไม่มีข้อมูล') {
                                    return `
                                    <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" id="addList" onclick="fetch_action(${row.id})">
                                        <i class="ki-solid ki-pencil fs-5"></i>
                                    </button>`;
                                    // <button href="#" class="menu-link px-3" id="addList" onclick="fetch_action(${row.id})" style="border: none;background-color: #ffffff;">
                                    //     <span class="menu-title"><img src="{{ image('icons/edit.svg') }}" class="pointer"></span>
                                    // </button>
                                } else {
                                    return ``;
                                }

                            }
                        }, {
                            targets: 6,
                            render: function(data, type, row) {
                                if (row.hr == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 7,
                            render: function(data, type, row) {
                                if (row.manager == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 8,
                            render: function(data, type, row) {
                                if (row.gm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }];
                    }
                    
                @else
                    if($('#segment').val() != "mtl"){
                        var co = [
                            {
                                data: 'no'
                            },
                            {
                                data: 'topic',
                            },
                            {
                                data: 'timeline_plan'
                            },
                            {
                                data: 'timeline_real'
                            },
                            {
                                data: 'hr'
                            },
                            {
                                data: 'manager'
                            },
                            {
                                data: 'dm'
                            },
                            {
                                data: 'gm'
                            }
                        ];
                        var co_def = [{
                            targets: 4,
                            render: function(data, type, row) {
                                if (row.hr == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 5,
                            render: function(data, type, row) {
                                if (row.manager == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 6,
                            render: function(data, type, row) {
                                if (row.dm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 7,
                            render: function(data, type, row) {
                                if (row.gm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }];
                    }else{
                        var co = [
                            {
                                data: 'no'
                            },
                            {
                                data: 'topic',
                            },
                            {
                                data: 'timeline_plan'
                            },
                            {
                                data: 'timeline_real'
                            },
                            {
                                data: 'hr'
                            },
                            {
                                data: 'manager'
                            },
                            {
                                data: 'gm'
                            }
                        ];
                        var co_def = [{
                            targets: 4,
                            render: function(data, type, row) {
                                if (row.hr == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 5,
                            render: function(data, type, row) {
                                if (row.manager == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }, {
                            targets: 6,
                            render: function(data, type, row) {
                                if (row.gm == 'active') {
                                    return `<img src="{{ image('pa/check.svg') }}">`;
                                } else {
                                    return ``;
                                }
                            }
                        }];
                    }
                    
                @endcan
                
                otable = $("#kt_datatable_dom_positioning").DataTable({

                    fixedColumns: {
                        left: 2
                    },
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    scrollY: true,
                    scrollX: true,
                    scrollCollapse: true,
                    ajax: {
                        url: "{{ url(Request::segment(1).'/table_config_timeline_getdata') }}",
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
                            if($('#search_year').val().length > 0){
                                d.search_year = $('#search_year option:selected').text();
                            }   
                            console.log(d);
                            oData = d
                        },

                    },
                    columns: co,
                    columnDefs: co_def,
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
                $('#id').on('change', function(e) {
                    otable.draw();
                });

            });
            function destroy_table(){
                $('#kt_datatable_dom_positioning').DataTable().destroy();
                setTimeout(() => {
                    search_data();
                }, 200);
            }
            function search_data(){

                @can('create pa timeline history')
                    var co = [
                        {
                            data: 'checkbox'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'no'
                        },
                        {
                            data: 'topic',
                        },
                        {
                            data: 'timeline_plan'
                        },
                        {
                            data: 'timeline_real'
                        },
                        {
                            data: 'hr'
                        },
                        {
                            data: 'manager'
                        },
                        {
                            data: 'dm'
                        },
                        {
                            data: 'gm'
                        }
                    ];
                    var co_def = [{
                        targets: 0,
                        orderable: false,
                        render: function(data, type, row) {
                            if (row.checkbox != 'ไม่มีข้อมูล') {
                                return `
                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" id="addList" onclick="fetch_action(${row.id})">
                                    <i class="ki-solid ki-pencil fs-5"></i>
                                </button>`;
                                // <button href="#" class="menu-link px-3" id="addList" onclick="fetch_action(${row.id})" style="border: none;background-color: #ffffff;">
                                //     <span class="menu-title"><img src="{{ image('icons/edit.svg') }}" class="pointer"></span>
                                // </button>
                            } else {
                                return ``;
                            }

                        }
                    }, {
                        targets: 6,
                        render: function(data, type, row) {
                            if (row.hr == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 7,
                        render: function(data, type, row) {
                            if (row.manager == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 8,
                        render: function(data, type, row) {
                            if (row.dm == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 9,
                        render: function(data, type, row) {
                            if (row.gm == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }];
                @else
                    var co = [
                        {
                            data: 'no'
                        },
                        {
                            data: 'topic',
                        },
                        {
                            data: 'timeline_plan'
                        },
                        {
                            data: 'timeline_real'
                        },
                        {
                            data: 'hr'
                        },
                        {
                            data: 'manager'
                        },
                        {
                            data: 'dm'
                        },
                        {
                            data: 'gm'
                        }
                    ];
                    var co_def = [{
                        targets: 4,
                        render: function(data, type, row) {
                            if (row.hr == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 5,
                        render: function(data, type, row) {
                            if (row.manager == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 6,
                        render: function(data, type, row) {
                            if (row.dm == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }, {
                        targets: 7,
                        render: function(data, type, row) {
                            if (row.gm == 'active') {
                                return `<img src="{{ image('pa/check.svg') }}">`;
                            } else {
                                return ``;
                            }
                        }
                    }];
                @endcan
                otable = $("#kt_datatable_dom_positioning").DataTable({

                fixedColumns: {
                    left: 2
                },
                "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                searchDelay: 500,
                processing: true,
                serverSide: true,
                scrollY: true,
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    url: "{{ url(Request::segment(1).'/table_config_timeline_getdata') }}",
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
                        if($('#search_year').val().length > 0){
                            d.search_year = $('#search_year option:selected').text();
                        }  
                        console.log(d);
                        oData = d
                    },

                },
                columns: co,
                columnDefs: co_def,
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
                $('#id').on('change', function(e) {
                    otable.draw();
                });
            }
            function fetch_actionx(id) {
                $('#add_id_action').val('');
                $('#add_action_name').val('');

                $('#add_hr_select').val([]);
                $('.add_show_count_hr').html('');
                $('#add_manager_select').val([]);
                $('.add_show_count_manager').html('');
                $('#add_start_date').val('');
                $('#add_end_date').val('');
                $('#add_start_date_real').val('');
                $('#add_end_date_real').val('');
                $('#add_HR').prop('checked', false);
                $('#add_Manager').prop('checked', false);
                $('#add_dm').prop('checked', false);
                $('#add_gm').prop('checked', false);
                
            }
            function fetch_action(id) {
                $('#id_action').val('');
                $('#action_name').val('');

                $('#hr_select').val([]);
                $('.show_count_hr').html('');
                // $('#select2-hr_select-container').html('Show');
                // $('#select2-hr_select-container').attr('title','Show');
                $('#manager_select').val([]);
                $('.show_count_manager').html('');
                // $('#select2-manager_select-container').html('Select');
                // $('#select2-manager_select-container').attr('title','Select');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#start_date_real').val('');
                $('#end_date_real').val('');
                $('#HR').prop('checked', false);
                $('#Manager').prop('checked', false);
                $('#dm').prop('checked', false);
                $('#gm').prop('checked', false);
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/pa/timeline/config_timeline/fetch') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        $('#id_action').val(res.id);
                        $('#action_name').val(res.action_name);

                        if(res.hr_select){
                            if(res.hr_select.length != 0){
                                var split1 = res.hr_select.split(',');
                                console.log('split1 = '+split1.length);
                                $('#hr_select').val(split1);
                                $('.show_count_hr').html('+'+split1.length);
                                // $('#select2-hr_select-container').html(res.hr_select+' '+res.hr_select_des);
                                // $('#select2-hr_select-container').attr('title',res.hr_select+' '+res.hr_select_des);
                            }else{
                                $('#hr_select').val([]);
                                $('.show_count_hr').html('');
                                // $('#select2-hr_select-container').html('Show');
                                // $('#select2-hr_select-container').attr('title','Show');
                            }
                        }else{
                            $('#hr_select').val([]);
                            $('.show_count_hr').html('');
                            // $('#select2-hr_select-container').html('Show');
                            // $('#select2-hr_select-container').attr('title','Show');
                        }
                        if(res.manager_select){
                            if(res.manager_select.length != 0){
                                var split2 = res.manager_select.split(',');
                                console.log('split2 = '+split2.length);
                                $('#manager_select').val(split2);
                                $('.show_count_manager').html('+'+split2.length);
                                // $('#select2-manager_select-container').html(res.manager_select+' '+res.manager_select_des);
                                // $('#select2-manager_select-container').attr('title',res.manager_select+' '+res.manager_select_des);
                            }else{
                                $('#manager_select').val([]);
                                $('.show_count_manager').html('');
                                // $('#select2-manager_select-container').html('Show');
                                // $('#select2-manager_select-container').attr('title','Show');
                            }
                        }else{
                            $('#manager_select').val([]);
                            $('.show_count_manager').html('');
                            // $('#select2-manager_select-container').html('Show');
                            // $('#select2-manager_select-container').attr('title','Show');
                        }

                        
                        if (res.start_date != null) {
                            $('#start_date').val(res.start_date);
                        }
                        if (res.end_date != null) {
                            $('#end_date').val(res.end_date);
                        }
                        if (res.start_date_real != null) {
                            $('#start_date_real').val(res.start_date_real);
                        }
                        if (res.end_date_real != null) {
                            $('#end_date_real').val(res.end_date_real);
                        }
                        if (res.hr == 'active') {
                            $('#HR').prop('checked', true);
                        } else {
                            $('#HR').prop('checked', false);
                        }
                        if (res.manager == 'active') {
                            $('#Manager').prop('checked', true);
                        } else {
                            $('#Manager').prop('checked', false);
                        }
                        if (res.dm == 'active') {
                            $('#dm').prop('checked', true);
                        } else {
                            $('#dm').prop('checked', false);
                        }
                        if (res.gm == 'active') {
                            $('#gm').prop('checked', true);
                        } else {
                            $('#gm').prop('checked', false);
                        }
                    },
                    error: function(res) {
                        console.log("error");
                        console.log(res);
                    }
                });
            }
            $("#add_action").submit(function(e) {
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
                            url: "{{ url(Request::segment(1).'/pa/timeline/config_timeline/addedit') }}",
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
                                        title: "Success",
                                        text: "Save successful",
                                        icon: "success",
                                        allowOutsideClick: false,
                                    });
                                    window.location.reload();
                                }
                            },
                            error: function(response) {
                                console.log("error");
                                console.log(response);
                                Swal.fire({
                                    title: "Warning",
                                    text: "Failed to save data",
                                    icon: "error",
                                    allowOutsideClick: false,
                                });
                            }
                        });

                    }
                });
            });
            $("#edit_action").submit(function(e) {
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
                            url: "{{ url(Request::segment(1).'/pa/timeline/config_timeline/edit') }}",
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
                                        title: "Success",
                                        text: "Save successful",
                                        icon: "success",
                                        allowOutsideClick: false,
                                    });
                                    window.location.reload();
                                }
                            },
                            error: function(response) {
                                console.log("error");
                                console.log(response);
                                Swal.fire({
                                    title: "Warning",
                                    text: "Failed to save data",
                                    icon: "error",
                                    allowOutsideClick: false,
                                });
                            }
                        });

                    }
                });
            });

            function add_timeline() {
                $.ajax({
                    type: 'POST',
                    url: "{{ url(Request::segment(1).'/pa/timeline/add') }}",
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
                                title: "warning",
                                text: "There is a form available for this year",
                                icon: "error",
                                allowOutsideClick: false,
                            });
                        }
                    },
                    error: function(response) {
                        console.log("error");
                        console.log(response);
                        Swal.fire({
                            title: "warning",
                            text: "Failed to save data",
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
                                title: "warning",
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
                            title: "warning",
                            text: "Failed to save data",
                            icon: "error",
                            allowOutsideClick: false,
                        });
                    }
                });
            }
            function count_hr(){
                var hr_select = $('#hr_select').val();
                console.log('show_count_hr = '+hr_select.length);
                if(hr_select.length != 0){
                    $('.show_count_hr').html('+'+hr_select.length);
                }else{
                    $('.show_count_hr').html('');
                }
            }
            function add_count_hr(){
                var hr_select = $('#add_hr_select').val();
                console.log('add_show_count_hr = '+hr_select.length);
                if(hr_select.length != 0){
                    $('.add_show_count_hr').html('+'+hr_select.length);
                }else{
                    $('.add_show_count_hr').html('');
                }
            }
            function count_manager(){
                var manager_select = $('#manager_select').val();
                console.log('show_count_manager = '+manager_select.length);
                if(manager_select.length != 0){
                    $('.show_count_manager').html('+'+manager_select.length);
                }else{
                    $('.show_count_manager').html('');
                }
            }
            function add_count_manager(){
                var manager_select = $('#add_manager_select').val();
                console.log('add_show_count_manager = '+manager_select.length);
                if(manager_select.length != 0){
                    $('.add_show_count_manager').html('+'+manager_select.length);
                }else{
                    $('.add_show_count_manager').html('');
                }
            }
            function changeactive(id){
                console.log(id);
                var status = ($('#flexSwitchDefault'+id).is(':checked')==true?'1':'0');
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
                            url: '{{ url(Request::segment(1)."/timeline_changeactive") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                id:id,
                                status:status
                            },
                            success: function (result) { 
                                let timerInterval;
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
                                        destroy_table();
                                        // window.location.reload();
                                    }
                                });
                            }
                        });
                    }else{
                        if(status == 0){
                            $('#flexSwitchDefault'+id).prop('checked',true);
                        }else{
                            $('#flexSwitchDefault'+id).prop('checked',false);
                        }
                    }
                });
                
            }
        </script>
        <style>
            div.dataTables_scrollBody {
                border-left: 0px solid #ddd !important
            }

            .overflow{
                white-space: nowrap;
                width: 500px;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    @endpush

</x-default-layout>
