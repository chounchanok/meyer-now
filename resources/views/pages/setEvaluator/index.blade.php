<x-default-layout>

    @section('title')
    {{ __('Set Evaluators and PA Forms') }}
    @endsection

    

    <link rel="stylesheet" href="../assets/plugins/custom/datatables/dataTables.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedHeader.dataTables.css">
    <link rel="stylesheet" href="../assets/plugins/custom/datatables/fixedColumns.dataTables.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedHeader.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedHeader.dataTables.js"></script>
    <script src="../assets/plugins/custom/datatables/dataTables.fixedColumns.js"></script>
    <script src="../assets/plugins/custom/datatables/fixedColumns.dataTables.js"></script>

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <!-- <div class="card-header">
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-pencil fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Set Evaluators and PA Forms') }}
                    </span>
                    </h3>

                </div> -->
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    <div class=" d-md-block">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Year')}}</label>
                                <select class="form-select" data-control="select2" id="search_year" data-placeholder="-Choose-" onchange="destroy_table()">
                                   <@foreach ($year as $key => $val)
                                        @php
                                            $substr = substr($val->rec_year,0,4);
                                        @endphp
                                        <option value="{{ $substr }}">{{ $substr }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Search')}}</label>
                                <input type="text" class="form-control myLike" name="searchText" id="searchText" placeholder="Name, Code" >
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Position</label>
                                <select class="form-select myLike" data-control="select2" id="search_position" name="search_position" data-placeholder="-Choose-">
                                   <option value="all">All</option>
                                    @foreach ($position as $key => $val)
                                        <option value="{{ $val->position_code }}">{{ $val->position_code }} - {{ $val->position_description }}</option>
                                    @endforeach   
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                <select class="form-select myLike" data-control="select2" id="search_division" name="search_division" data-placeholder="-Choose-" onchange="get_department();">
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                <select class="form-select myLike" data-control="select2" id="search_department" name="search_department" data-placeholder="-Choose-" onchange="get_section();">
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                <select class="form-select myLike" data-control="select2" id="search_section" name="search_section" data-placeholder="-Choose-" onchange="get_eva_list();">
                                   
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluator')}}</label>
                                <select class="form-select myLike" data-control="select2" id="search_employee_no" name="search_employee_no" data-placeholder="-Choose-" onchange="destroy_table();">
                                    
                                </select>
                            </div>

                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Status')}}</label>
                                <select class="form-select myLike" data-control="select2" id="search_status" name="search_status" data-placeholder="-Select-">
                                    <option value="all">All</option>
                                    <option value="1">In progress</option>
                                    <option value="3">Approved</option>
                                </select>
                            </div>
                            <!-- <div class="col-4 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label>
                                <button type="button" class="btn btn-primary rounded-pill" onclick="destroy_table()">
                                    <i class="ki-outline ki-magnifier"></i>
                                    Search
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <div class="d-black d-md-none" style="display:none;">
                        <div>
                            <div class="collapse" id="collapseSearchMobile">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Position</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Division</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Department</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Evaluator</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            
                                        </select>
                                    </div>

                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            <option>In progress</option>
                                            <option>Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ki-outline ki-magnifier"></i>
                                Search
                            </button>
                        </div>
                    </div>
                    <hr class="border-gray-400">

                    <!-- tableDesktop -->
                    <div class=" position-relative">
                        <!--begin::Toggle-->
                        @can('edit set evaluators pa form')
                        <div style="position:absolute;top:0;left:0;z-index:99;">
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 pointer" onclick="assign_evaluator();">
                                        <a class="menu-link px-3">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">{{__('Designated as an evaluator')}}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#setFModal'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-pencil fs-3 text-warning"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">{{__('Specify form')}}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#specifyEModal'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-pencil fs-3 text-warning"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">{{__('Specify Evaluator s name')}}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Transfered</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-exit-right fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Resigned</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::Menu-->
                            </div>
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-primary rotate mb-3 p-2" onclick="export_excel_set_evaluate();">
                                    Export Excel
                                    <i class="bi-file-earmark-excel fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                            </div>
                        </div>
                        @endcan
                        <!--end::Dropdown wrapper-->

                        
                        
                        <div class="table-responsive">
                        <!-- style="text-wrap:nowrap" -->
                            <table id="kt_datatable_dom_positioning" class="table table-striped rounded" >
                                <thead class="table-light">
                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                        <th style="width:50px"><input type="checkbox" name="select-all" id="select-all"></th>
                                        <th>{{__('Emp. no.')}}</th>
                                        <th>{{__('Emp. Name')}}</th>
                                        <th>Position</th>
                                        <th>Div.</th>
                                        <th>Dept.</th>
                                        <th>Section</th>
                                        <th>{{__('Evaluator')}}</th>
                                        <th>{{__('Evaluator name')}}</th>
                                        <th style="width:50px">{{__('Form')}}</th>
                                        <th>{{__('Status')}}</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    <div class="tableMobile" style="display:none;">
                        <div class="d-inline-flex">
                                <button type="button" class="btn btn-light-primary rotate mb-3 p-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                    Action
                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                </button>
                                <!--end::Toggle-->

                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle='modal' data-bs-target='#approveModal'>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Approved</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <div class="separator mt-3 opacity-75"></div>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Transfered</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3" style="display:none;">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-exit-right fs-3 text-dark">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">Resigned</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::Menu-->
                            </div>
                        <div class="overflow-y overflow-auto" style="height:50vh">
                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                        Emp no.: 123456789 <button type='button' class='btn btn-icon btn-light btn-xs me-1' id='infoModal'><i class='ki-outline ki-information-2 fs-5'></i></button>
                                    </label>
                                </div>
                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="row gx-2">
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Div.:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Dept:<br></span>xxxx</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-black"><span class="small text-gray-800">Sect:<br></span>xxxx</p>
                                    </div>
                                </div>
                                <p class="mb-1 text-black"><span class="small text-gray-800">สถานะ: </span><span class="badge badge-light-warning">Status</span></p>
                                <p class="mb-1 text-black"><span class="small text-gray-800">Department: </span>ปปปปปปปปปปปป</p>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="ki-solid ki-check-circle fs-2"></i>
                                        Approve
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm me-2 px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                        <i class="ki-solid ki-arrows-loop fs-2"></i>
                                        Transfered
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#resignModal">
                                        <i class="ki-solid ki-cross-circle fs-2"></i>
                                        Resigned
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="text-center pt-3">
                        <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                    </div> -->
                    
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->

    <!--begin::approve modal-->
    <div class="modal fade" tabindex="-1" id="approveModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Confirm approval</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body text-center">
                    <h1 class="ki-solid ki-check-circle text-success fs-5r"></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::approve modal-->
    <!--begin::edit modal-->
    <div class="modal fade" tabindex="-1" id="editModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Adjust grade</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success  rounded-pill btn-sm">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::edit modal-->
    <!--begin::transfered modal-->
    <div class="modal fade" tabindex="-1" id="transferModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Transfered</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Employee name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Div.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Dept.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Sect.</label>
                            <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                <option></option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::transfered modal-->
    <!--begin::Resigned modal-->
    <div class="modal fade" tabindex="-1" id="resignModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Resigned</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Employee name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Effective Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Resigned modal-->
    <!--begin::set form modal-->
    <div class="modal fade" tabindex="-1" id="setFModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{__('Specify form')}}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Form')}}</label>
                            <select class="form-select" id="specify_form_select" data-control="select2" data-placeholder="-Choose-">
                                <option value="F1">F1</option>
                                <option value="F2">F2</option>
                                <option value="F3">F3</option>
                                <option value="F4">F4</option> 
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal" onclick="specify_form();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::set form modal-->
    <!--begin::specify eva name modal-->
    <div class="modal fade" tabindex="-1" id="specifyEModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">{{__('Specify the evaluator s name')}}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="row g-3 mb-3">
                        <div class="col-12 col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluator')}}</label>
                            <select class="form-select" data-control="select2" id="specify_eva_code" name="specify_eva_code" data-dropdown-parent="#specifyEModal" data-placeholder="-Choose-">
                                
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success rounded-pill" data-bs-dismiss="modal" onclick="specify_eva_name();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::specify eva name modal-->
@push('scripts')
<script type="text/javascript">
$(function() {
    get_division();
    get_form_list();
     
});
function destroy_table(){
    $('#kt_datatable_dom_positioning').DataTable().destroy();
    setTimeout(() => {
        search_data();
        // get_eva();
    }, 200);
}
function search_data(){
    otable = $("#kt_datatable_dom_positioning").DataTable({
        // layout: {
        //     topStart: {
        //         buttons: ['excel']
        //     }
        // },
        fixedHeader: {
            header: true,
        },
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
            url: "{{ url(Request::segment(1).'/table_setE_getdata') }}",
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
                    d.search_year = $('#search_year').val();
                }  
                console.log(d);
                oData = d
            },
        },
        columns: [
            { data: 'id' },
            { data: 'code' },
            { data: 'name' },
            { data: 'position' },
            { data: 'div' },
            { data: 'dept' },
            { data: 'sect' },
            { data: 'eva' },
            { data: 'evaN' },
            { data: 'form' },
            { data: 'status' },
        ],
        columnDefs: [ {
            "targets": 0,
            "orderable": false
        },{
            "targets": 7,
            "orderable": false
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
    // otable.colReorder.order([0, 1, 2, 3, 4, 5], true);
        // Add event listener for opening and closing details
    otable.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = otable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
        }
    });
    $('#searchText').on('change', function(e) {
        otable.draw();
    });
    $('#search_position').on('change', function(e) {
        otable.draw();
    });
    // $('#search_division').on('change', function(e) {
    //     get_department();
    //     // otable.draw();
    // });
    // $('#search_department').on('change', function(e) {
    //     get_section();
    //     // otable.draw();
    // });
    // $('#search_section').on('change', function(e) {
    //     otable.draw();
    // });
    // $('#search_employee_no').on('change', function(e) {
    //     otable.draw();
    // });
    $('#search_status').on('change', function(e) {
        otable.draw();
    });
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.checkbox-select').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.checkbox-select').each(function() {
                this.checked = false;                       
            });
        }
    });
}
function change_eva(e,id){
    var status = ($('#flexSwitchCheckDefault'+$(e).val()).is(':checked')==true?'1':'0');
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save'
        }).then((result) => {
        if (result.isConfirmed) {
            var evaluator_active = '0';
            if($(e).prop('checked') == true){
                evaluator_active = '1';
            }
            console.log($(e).val());
            console.log($(e).attr('data-id'));
            $.ajax({
                type: 'POST',
                url: '{{ url(Request::segment(1)."/change_eva") }}',
                dataType: 'json',
                data : { 
                    "_token": "{{ csrf_token() }}",
                    "orisoft_no":$(e).val(),
                    "id":$(e).attr('data-id'),
                    "evaluator_active":evaluator_active,
                    "search_division":$('#search_division').val(),
                    "search_department":$('#search_department').val(),
                    "section_code":$('#search_section').val(),
                    "search_year":$('#search_year').val(),
                },
                success: function (result) { 
                    console.log(result.data);
                    Swal.fire({
                        title: "Update Success",
                        text: "",
                        icon: "success",
                        allowOutsideClick: false,
                    });
                    get_eva();
                    // var html = `<option value="all">All</option>`;
                    // result.evaluator.forEach(element => {
                    //     html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_en}</option>`;
                    // });
                    // $('#search_employee_no').html(html);
                    // $('#specify_eva_code').html(html);
                    // $('.checkbox-select').each(function() {
                    //     if(this.checked == true){
                    //         $('.set_status'+this.value).html('Approved');
                    //         $('.set_status'+this.value).removeClass('badge-light-warning');
                    //         $('.set_status'+this.value).removeClass('badge-light-danger');
                    //         $('.set_status'+this.value).addClass('badge-light-success');
                    //     }                
                    // });
                }
            });
        }else{
            if(status == 0){
                $('#flexSwitchCheckDefault'+$(e).val()).prop('checked',true);
            }else{
                $('#flexSwitchCheckDefault'+$(e).val()).prop('checked',false);
            }
        }
    });






    
}
function assign_evaluator(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            getCheckbox.push(this.value);
        }                
    });
    if(getCheckbox.length == 0){
        Swal.fire({
            title: "{{ __('Please Select Employee') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
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
                    url: '{{ url(Request::segment(1)."/assign_evaluator") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "orisoft_no":getCheckbox,
                        "search_division":$('#search_division').val(),
                        "search_department":$('#search_department').val(),
                        "section_code":$('#search_section').val(),
                        "search_year":$('#search_year').val(),
                    },
                    success: function (result) {
                        Swal.fire({
                            title: "Update Success",
                            text: "",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                        destroy_table();
                        get_eva();
                        console.log(result.data);
                        // var html = `<option value="all">All</option>`;
                        // result.evaluator.forEach(element => {
                        //     html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_en}</option>`;
                        // });
                        // $('#search_employee_no').html(html);
                        // $('#specify_eva_code').html(html);
                        // window.location.reload();
                    }
                });
            }
        });
        
    }
}
function specify_form(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            getCheckbox.push({
                code:this.value,
                id:$(this).attr('data-id')
            });
        }             
        console.log($(this).attr('data-id'));   
    });
    if(getCheckbox.length == 0){
        Swal.fire({
            title: "{{ __('Please Select Employee') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/specify_form") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "orisoft_no":getCheckbox,
                "specify_form_select":$('#specify_form_select').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                destroy_table();
                // window.location.reload();
            }
        });
    }
}
function specify_eva_name(){
    var getCheckbox = [];
    $('.checkbox-select').each(function() {
        if(this.checked == true){
            getCheckbox.push({
                code:this.value,
                id:$(this).attr('data-id')
            });
        }                
    });
    if(getCheckbox.length == 0){
        Swal.fire({
            title: "{{ __('Please Select Employee') }}",
            text: "",
            icon: "warning",
            allowOutsideClick: false,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/specify_eva_name") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "orisoft_no":getCheckbox,
                "specify_eva_code":$('#specify_eva_code').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                
                Swal.fire({
                    title: "Update Success",
                    text: "",
                    icon: "success",
                    allowOutsideClick: false,
                });
                destroy_table();
                // window.location.reload();
            }
        });
    }
}
function get_eva(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_eva_review") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_division":$('#search_division').val(),
            "search_department":$('#search_department').val(),
            "section_code":$('#search_section').val(),
            "search_month_day":'all',
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            console.log(result.data);
            if(result.data.length > 1){
                var html = `<option value="all">All</option>`;
            }else{
                var html = `<option value="all">All</option>`;
            }
            result.data.forEach(element => {
                if($("#isLocale").val() == '1'){
                    html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_en}</option>`;
                }else{  
                    html += `<option value="${element.employee_no}">${element.employee_no} - ${element.employee_local_name_th}</option>`;
                }
                
            });
            $('#search_employee_no').html(html);
            $('#specify_eva_code').html(html);
        }
    });
}
////////////////////////////////////////////////////////////////////////////////////////////////
function get_form_list(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_form_list") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            var html = ``;
            result.data.forEach(element => {
                if($("#isLocale").val() == '1'){
                    html += `<option value="${element.form_ref}">${element.form_ref} - ${element.form_en}</option>`;
                }else{
                    html += `<option value="${element.form_ref}">${element.form_ref} - ${element.form_th}</option>`;
                }
            });
            $('#specify_form_select').html(html);
        }
    });
}
function get_division(){
    $.ajax({
        type: 'POST',
        url: '{{ url(Request::segment(1)."/get_division") }}',
        dataType: 'json',
        data : { 
            "_token": "{{ csrf_token() }}",
            "pagenow":"1",
            "search_year":$('#search_year').val(),
        },
        success: function (result) { 
            if(result.data.length > 1){
                var html = `<option value="all">All</option>`;
            }else{
                var html = ``;
            }
            result.data.forEach(element => {
                html += `<option value="${element.division_code}">${element.division_code}</option>`;
                // - ${element.division_description}
            });
            $('#search_division').html(html);
            if(result.data.length > 1){
                $('#search_division').val('all');
            }
            setTimeout(() => {
                get_department();
            }, 200);
        }
    });
}
function get_department(){
    if($('#search_division').val() == 'all'){
        var html = `<option value="all">All</option>`;
        $('#search_department').html(html);
        var html2 = `<option value="all">All</option>`;
        $('#search_section').html(html2);
        $('#search_department').val('all');
        $('#search_section').val('all');
        get_section();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_department") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                if(result.data.length > 1){
                    var html = `<option value="all">All</option>`;
                }else{
                    var html = ``;
                }
                result.data.forEach(element => {
                    html += `<option value="${element.department_code}">${element.department_code} - ${element.department_description}</option>`;
                });
                $('#search_department').html(html);
                if(result.data.length > 1){
                    $('#search_department').val('all');
                }
                setTimeout(() => {
                    get_section();
                }, 200);
            }
        });
    }
}
function get_section(){
    if($('#search_department').val() == 'all'){
        var html = `<option value="all">All</option>`;
        $('#search_section').html(html);
        $('#search_section').val('all');
        get_eva();
        destroy_table();
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/get_section") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "search_division":$('#search_division').val(),
                "search_department":$('#search_department').val(),
                "search_year":$('#search_year').val(),
            },
            success: function (result) { 
                if(result.data.length > 1){
                    var html = `<option value="all">All</option>`;
                }else{
                    var html = ``;
                }
                result.data.forEach(element => {
                    html += `<option value="${element.section_code}">${element.section_code} - ${element.section_description}</option>`;
                });
                $('#search_section').html(html);
                if(result.data.length > 1){
                    $('#search_section').val('all');
                    get_eva();
                }else{
                    get_eva();
                }
                setTimeout(() => {
                    destroy_table();
                }, 200);
            }
        });
    }
}
function get_eva_list(){
    get_eva();
    destroy_table();
}
function export_excel_set_evaluate(){
    var searchText = $('#searchText').val();
    var search_position = $('#search_position').val();
    var search_division = $('#search_division').val();
    var search_department = $('#search_department').val();
    var search_section = $('#search_section').val();
    var search_employee_no = $('#search_employee_no').val();
    var search_status = $('#search_status').val();
    var search_year = $('#search_year').val();
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Export'
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url(Request::segment(1).'/export_excel_set_evaluate/') }}"+"?searchText="+searchText+"&search_position="+search_position+"&search_division="+search_division+"&search_department="+search_department+"&search_section="+search_section+"&search_employee_no="+search_employee_no+"&search_status="+search_status+"&search_year="+search_year;
        }
    });
}
////////////////////////////////////////////////////////////////////////////////////////////////

</script>

@endpush
</x-default-layout>
<style>
    body{
        font-size: 14px !important;
    }
    .form-label {
        font-size: 14px !important;
    }
    .buttons-copy,.buttons-csv,.buttons-pdf,.buttons-print{
        display: none !important;
    }
    table.dataTable {
        font-size: 14px;
    }
    .table th, .table:not(.table-bordered) th ,.d-inline-flex,.d-inline-flex button,.sec_active,.rounded-pill{
        font-size: 14px !important;
    }
    .buttons-excel span{
        font-size: 14px !important;
    }
    .dtfh-floatingparent-head{
        top: 3.5em !important;
    }
    .dtfh-floatingparent,.dtfh-floatingparenthead{
        top: 3.5em !important;
        border: 1px solid;
        z-index: 9;
    }
</style>