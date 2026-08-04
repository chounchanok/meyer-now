<x-default-layout>

    @section('title')
        {{ __('Review and Approve PA Results') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('evaluate.index') }}
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-profile-user fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                        {{ __('Review and Approve PA Results') }}
                    </span>
                    </h3>
                    <!--end::Title-->

                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Menu wrapper-->
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-2">
                            <div class="card shadow-none rounded-3 p-3">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-light">
                                        <i class="ki-outline ki-profile-user fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">All employees</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">32</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="card shadow-none rounded-3 p-3 bg-light-secondary">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-secondary">
                                        <i class="ki-outline ki-loading fs-2 text-black"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Wait for approval</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">17</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="card shadow-none rounded-3 p-3 bg-light-danger">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-danger">
                                        <i class="ki-outline ki-cross-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Reject</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">5</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="card shadow-none rounded-3 p-3 bg-light-success">
                                <div class="d-flex flex-stack">  
                                    <div class="symbol symbol-40px me-4">
                                        <div class="symbol-label fs-2 fw-semibold bg-success">
                                        <i class="ki-outline ki-check-circle fs-2 text-white"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">                   
                                        <div class="flex-grow-1 me-2">
                                            <p class="text-gray-800 small fw-normal mb-0">Approved</p>
                                            <h4 class="text-black fw-bold d-block text-end mb-0">10</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <form class="row g-3 mb-3">
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
                            <!-- <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                <select class="form-select" data-control="select2" data-placeholder="-Select-">
                                    
                                </select>
                            </div> -->
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Evaluator</label>
                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Complaince score</label>
                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    <option>Below Standard</option>
                                    <option>Standard</option>
                                    <option>Above Standard</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Attendance score</label>
                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    <option>Below Standard</option>
                                    <option>Standard</option>
                                    <option>Above Standard</option>
                                </select>
                            </div>

                            <div class="col-8 col-sm-2">
                                <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    
                                </select>
                            </div>
                            <div class="col-4 col-sm-2">
                                <!-- <label for="exampleFormControlInput1" class="form-label w-100 mb-0">&nbsp;</label> -->
                                <button type="button" class="btn btn-primary rounded-pill">
                                    <i class="ki-outline ki-magnifier"></i>
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="d-black d-md-none">
                        <form>
                            <div class="collapse" id="collapseSearchMobile">
                                <div class="row g-3">
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
                                    <!-- <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Section</label>
                                        <select class="form-select">
                                            <option>-Select-</option>
                                        </select>
                                    </div> -->
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Evaluator</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Complaince score</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            <option>Below Standard</option>
                                            <option>Standard</option>
                                            <option>Above Standard</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Attendance score</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                            <option>Below Standard</option>
                                            <option>Standard</option>
                                            <option>Above Standard</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label for="exampleFormControlInput1" class="form-label mb-0">Status</label>
                                        <select class="form-select" data-control="select2" data-placeholder="-Choose-">
                                    
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill my-3" data-bs-toggle="collapse" data-bs-target="#collapseSearchMobile" aria-expanded="false" aria-controls="collapseExample">
                                <i class="ki-outline ki-magnifier"></i>
                                Search
                            </button>
                        </form>
                    </div>
                    <hr class="border-gray-400">
                    <!--begin::Nav tab-->
                    <ul class="nav nav-pills nav-pills-custom mb-3">
                        <!--begin::Item-->
                        <li class="nav-item mb-3 me-2 me-lg-3">
                            <!--begin::Link-->
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3 active" id="tab_link_1" data-bs-toggle="pill" href="#tab_1">
                                <!--begin::Title-->
                                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Sect01</span>
                                <span class="nav-text text-gray-600 fw-normal fs-6 lh-1">(20)</span>
                                <!--end::Title-->
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                <!--end::Bullet-->
                            </a>
                            <!--end::Link-->
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mb-3 me-2 me-lg-3">
                            <!--begin::Link-->
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3" id="tab_link_2" data-bs-toggle="pill" href="#tab_2">
                                <!--begin::Title-->
                                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Sect02</span>
                                <span class="nav-text text-gray-600 fw-normal fs-6 lh-1">(10)</span>
                                <!--end::Title-->
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                <!--end::Bullet-->
                            </a>
                            <!--end::Link-->
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="nav-item mb-3 me-2 me-lg-3">
                            <!--begin::Link-->
                            <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3" id="tab_link_3" data-bs-toggle="pill" href="#tab_3">
                                 <!--begin::Title-->
                                 <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Sect03</span>
                                <span class="nav-text text-gray-600 fw-normal fs-6 lh-1">(2)</span>
                                <!--end::Title-->
                                <!--begin::Bullet-->
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                <!--end::Bullet-->
                            </a>
                            <!--end::Link-->
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Nav-->
                    <!--begin::Tab Content-->
                    <div class="tab-content">
                        <!--begin::Tap pane-->
                        <div class="tab-pane fade show active" id="tab_1">
                            <div class="title-sect">
                                <span>Sect01 <small class="fw-normal">(20)</small></span>
                            </div>
                            <!--begin::Nav tab-->
                            <ul class="nav nav-pills nav-pills-custom mb-3">
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden pt-3 pb-3 active" id="tabF_link_1" data-bs-toggle="pill" href="#tabF_1">
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F1
                                            <small class="fw-normal">(10)</small>
                                        </span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3" id="tabF_link_2" data-bs-toggle="pill" href="#tabF_2">
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F2
                                            <small class="fw-normal">(6)</small>
                                        </span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-2 me-lg-3">
                                    <!--begin::Link-->
                                    <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-80px pt-3 pb-3" id="tabF_link_3" data-bs-toggle="pill" href="#tabF_3">
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 d-flex align-items-center">
                                            <i class="ki-outline ki-questionnaire-tablet fs-2 me-1"></i>
                                            F3
                                            <small class="fw-normal">(4)</small>
                                        </span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </a>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Nav-->

                            
                            
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade show active" id="tabF_1">
                                    
                                    <!-- <div class="mb-4">
                                        Toggle column: 
                                        <a class="toggle-vis" data-column="1">Emp. no.</a> - 
                                        <a class="toggle-vis" data-column="2">Name</a> - 
                                        <a class="toggle-vis" data-column="3">Position</a> - 
                                        <a class="toggle-vis" data-column="4">Date joined</a> - 
                                        <a class="toggle-vis" data-column="5">Service days</a> - 
                                        <a class="toggle-vis" data-column="6">Evaluator</a>
                                    </div> -->
                                    <div class="d-none d-md-block">
                                        <h4 class="mb-2 title1">1.Knowledge in job <span class="fw-normal text-gray-700">(x1)</span></h4>
                                        <h6 class="mb-0 ps-4 title2">Above Standard <span class="fw-normal">(8-10)</span></h6>
                                        <p class="ps-4 title3">Expert in all facets of the job, can tech others how to do</p>
                                        <h6 class="mb-0 ps-4 title4">Standard <span class="fw-normal">(4-7)</span></h6>
                                        <p class="ps-4 title5">Has sufficient knowledge of how to do the job</p>
                                        <h6 class="mb-0 ps-4 title6">Below Standard <span class="fw-normal">(1-3)</span></h6>
                                        <p class="ps-4 title7">Needs further coaching / training on how to do his/her job</p>
                                    </div>
                                    <div class="tableDesktop position-relative">
                                        <!--begin::Toggle-->

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
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" id="editList">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                        <span class="menu-title">Approved</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" id="editList">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-cross-circle fs-3 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                        <span class="menu-title">Rejected</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <div class="separator mt-3 opacity-75"></div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">Transferred</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
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
                                                <button type="button" class="btn btn-light rotate mb-3 p-2 ps-3 rounded-pill" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                                                    Display
                                                    <i class="ki-duotone ki-down fs-3 rotate-180 ms-3 me-0"></i>
                                                </button>
                                                <!--end::Toggle-->

                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-2" data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="1"> Emp. no.
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="2"> Name - Surname
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="3"> Position
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="4"> Date joined
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="5"> Service days
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="6"> Evaluator
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <div class="checkbox p-2">
                                                            <label>
                                                            <input checked type="checkbox" class="toggle-vis" data-column="17"> Remark
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--end::Menu item-->

                                                </div>
                                                <!--end::Menu-->
                                            </div>
                                        </div>
                                        <!--end::Dropdown wrapper-->

                                        
                                        
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped rounded" style="text-wrap:nowrap">
                                                <thead class="table-light">
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <th rowspan="2"><input type="checkbox"></th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Emp. no.</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Name-Surname</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Position</th>
                                                        <th rowspan="2" style="width:200px">Date joined</th>
                                                        <th rowspan="2">Service days</th>
                                                        <th rowspan="2" style="text-wrap:nowrap">Evaluator</th>
                                                        <th colspan="9" class="text-center">Criteria</th>
                                                        <th rowspan="2" >Total</th>
                                                        <th rowspan="2">Remark</th>
                                                        <th rowspan="2">Status</th>
                                                        <th rowspan="2">Action</th>
                                                    </tr>
                                                    <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                        <th class="text-center">1</th>
                                                        <th class="text-center">2</th>
                                                        <th class="text-center">3</th>
                                                        <th class="text-center">4</th>
                                                        <th class="text-center">5</th>
                                                        <th class="text-center">6</th>
                                                        <th class="text-center">7</th>
                                                        <th class="text-center">8</th>
                                                        <th class="text-center">9</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="tableMobile">
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
                                                        <a href="#" class="menu-link px-3" id="editList">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-check-circle fs-3 text-success"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                        <span class="menu-title">Approved</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" id="editList">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-cross-circle fs-3 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                        <span class="menu-title">Rejected</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <div class="separator mt-3 opacity-75"></div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#transferModal">
                                                        <span class="menu-icon">
                                                            <i class="ki-duotone ki-arrows-loop fs-3 text-dark">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            </i>
                                                        </span>
                                                        <span class="menu-title">Transferred</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
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
                                                        Emp no.: 123456789
                                                    </label>
                                                </div>
                                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>11-JUL-1994</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Service days:<br></span>365</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class=""><span class="small text-gray-800">สถานะ:<br></span><span class="badge badge-light-danger">Reject</span></p>
                                                    </div>
                                                </div>
                                                <div class="QForm"> 
                                                    <h5 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h5>
                                                    <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>
                                                    <p class="ps-4">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>
                                                    <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                                    <p class="ps-4">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>
                                                    <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                                    <p class="ps-4">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>
                                                </div>
                                                <h5 class="mb-2 text-black">Criteria</h5>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(1);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(2);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(3);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option selected>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(4);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option selected>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(5);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option selected>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(6);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(7);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>
                                                    </div>
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Total score:<br></span><span class="h1 text-black fw-bold">82.5</span></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Evaluator:<br></span><span class="h2 text-black fw-bold">John doe</span></p>
                                                    </div>
                                                </div>
                                                <p class="text-danger"><span class="small text-gray-800">Note:<br></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                                        Emp no.: 123456789
                                                    </label>
                                                </div>
                                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>11-JUL-1994</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Service days:<br></span>365</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class=""><span class="small text-gray-800">สถานะ:<br></span><span class="badge badge-light-danger">Reject</span></p>
                                                    </div>
                                                </div>
                                                <div class="QForm"> 
                                                    <h5 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h5>
                                                    <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>
                                                    <p class="ps-4">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>
                                                    <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                                    <p class="ps-4">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>
                                                    <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                                    <p class="ps-4">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>
                                                </div>
                                                <h5 class="mb-2 text-black">Criteria</h5>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(1);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(2);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(3);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option selected>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(4);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option selected>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(5);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option selected>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(6);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(7);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>
                                                    </div>
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Total score:<br></span><span class="h1 text-black fw-bold">82.5</span></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Evaluator:<br></span><span class="h2 text-black fw-bold">John doe</span></p>
                                                    </div>
                                                </div>
                                                <p class="text-danger"><span class="small text-gray-800">Note:<br></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                                        Emp no.: 123456789
                                                    </label>
                                                </div>
                                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>11-JUL-1994</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Service days:<br></span>365</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class=""><span class="small text-gray-800">สถานะ:<br></span><span class="badge badge-light-danger">Reject</span></p>
                                                    </div>
                                                </div>
                                                <div class="QForm"> 
                                                    <h5 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h5>
                                                    <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>
                                                    <p class="ps-4">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>
                                                    <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                                    <p class="ps-4">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>
                                                    <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                                    <p class="ps-4">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>
                                                </div>
                                                <h5 class="mb-2 text-black">Criteria</h5>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(1);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(2);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(3);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option selected>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(4);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option selected>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(5);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option selected>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(6);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(7);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>
                                                    </div>
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Total score:<br></span><span class="h1 text-black fw-bold">82.5</span></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Evaluator:<br></span><span class="h2 text-black fw-bold">John doe</span></p>
                                                    </div>
                                                </div>
                                                <p class="text-danger"><span class="small text-gray-800">Note:<br></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                                        Emp no.: 123456789
                                                    </label>
                                                </div>
                                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>11-JUL-1994</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Service days:<br></span>365</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class=""><span class="small text-gray-800">สถานะ:<br></span><span class="badge badge-light-danger">Reject</span></p>
                                                    </div>
                                                </div>
                                                <div class="QForm"> 
                                                    <h5 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h5>
                                                    <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>
                                                    <p class="ps-4">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>
                                                    <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                                    <p class="ps-4">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>
                                                    <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                                    <p class="ps-4">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>
                                                </div>
                                                <h5 class="mb-2 text-black">Criteria</h5>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(1);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(2);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(3);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option selected>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(4);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option selected>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(5);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option selected>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(6);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(7);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>
                                                    </div>
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Total score:<br></span><span class="h1 text-black fw-bold">82.5</span></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Evaluator:<br></span><span class="h2 text-black fw-bold">John doe</span></p>
                                                    </div>
                                                </div>
                                                <p class="text-danger"><span class="small text-gray-800">Note:<br></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card p-5 shadow-none border-gray-300 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input h-20px w-20px" type="checkbox" value="" id="flexCheckDefault" />
                                                    <label class="form-check-label text-dark" for="flexCheckDefault">
                                                        Emp no.: 123456789
                                                    </label>
                                                </div>
                                                <p class="mb-0 fw-bold text-dark fs-4">จันทรัตว์ ชัยชนา</p>
                                                <p class="mb-1 text-black"><span class="small text-gray-800">ตำแหน่ง: </span>ปปปปปปปปปปปป</p>
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Date joined:<br></span>11-JUL-1994</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-black"><span class="small text-gray-800">Service days:<br></span>365</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class=""><span class="small text-gray-800">สถานะ:<br></span><span class="badge badge-light-danger">Reject</span></p>
                                                    </div>
                                                </div>
                                                <div class="QForm"> 
                                                    <h5 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h5>
                                                    <h6 class="mb-0 ps-4">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>
                                                    <p class="ps-4">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>
                                                    <h6 class="mb-0 ps-4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>
                                                    <p class="ps-4">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>
                                                    <h6 class="mb-0 ps-4">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>
                                                    <p class="ps-4">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>
                                                </div>
                                                <h5 class="mb-2 text-black">Criteria</h5>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">1.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(1);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">2.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(2);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option selected>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">3.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(3);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option selected>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">4.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(4);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option selected>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">5.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(5);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option selected>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">6.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(6);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">7.</label>
                                                        <select class="form-select form-select-sm" onclick="gettitle(7);">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option selected>6</option>
                                                            <option>7</option>
                                                            <option>8</option>
                                                            <option>9</option>
                                                            <option>10</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">8.</label>
                                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="exampleFormControlInput1" class="form-label mb-0">9.</label>
                                                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>
                                                    </div>
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Total score:<br></span><span class="h1 text-black fw-bold">82.5</span></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-black  mb-2"><span class="small text-gray-800">Evaluator:<br></span><span class="h2 text-black fw-bold">John doe</span></p>
                                                    </div>
                                                </div>
                                                <p class="text-danger"><span class="small text-gray-800">Note:<br></span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                                        <i class="ki-solid ki-check-circle fs-1"></i>
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                        <i class="ki-solid ki-cross-circle fs-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pt-3">
                                    <button class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
                                    </div>
                                </div>
                                <!--end::Tap pane-->
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade" id="tabF_2">
                                    
                                </div>
                                <!--end::Tap pane-->
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade" id="tabF_3">
                                    
                                </div>
                                <!--end::Tap pane-->
                            </div>
                        </div>
                        <!--end::Tap pane-->
                        <!--begin::Tap pane-->
                        <div class="tab-pane fade" id="tab_2">
                            <div class="title-sect">
                                <span>Sect02 <small class="fw-normal">(10)</small></span>
                            </div>
                        </div>
                        <!--end::Tap pane-->
                        <!--begin::Tap pane-->
                        <div class="tab-pane fade" id="tab_3">
                            <div class="title-sect">
                                <span>Sect03 <small class="fw-normal">(2)</small></span>
                            </div>
                        </div>
                        <!--end::Tap pane-->
                    </div>
                    <!--end::Tab Content-->
                    
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->
    <!--begin::Transferred modal-->
    <div class="modal fade" tabindex="-1" id="transferModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Transferred</h3>

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
    <!--end::Transferred modal-->
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

    <!--begin::complain modal-->
    <div class="modal fade" tabindex="-1" id="complainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Compliance with company regulations</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="bg-light-primary">
                            <tr class="text-center">
                                <th colspan="6">Compliance with company regulations</th>
                            </tr>
                            <tr class="text-center">
                                <th>ABT</th>
                                <th>VWAR</th>
                                <th>WWAR</th>
                                <th>ABS</th>
                                <th>OL</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="fw-bold text-primary">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::complain modal-->
    <!--begin::attendance modal-->
    <div class="modal fade" tabindex="-1" id="attendanceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Attendance record</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="bg-light-warning">
                            <tr class="text-center">
                                <th colspan="6">Attendance record</th>
                            </tr>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>PL</th>
                                <th>LATE</th>
                                <th>ABS</th>
                                <th>OL</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>3.6</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td class="fw-bold text-danger">3.6</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer py-3">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::attendance modal-->
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
    <!--begin::reject modal-->
    <div class="modal fade" tabindex="-1" id="rejectModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h3 class="modal-title">Not approved, reevaluated</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-dark ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-solid ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center">
                    <h1 class="ki-solid ki-cross-circle text-danger fs-5r"></h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="modal-footer justify-content-center py-3">
                    <button type="button" class="btn btn-light rounded-pill btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger  rounded-pill btn-sm">Confirm Reject</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::reject modal-->
@push('scripts')
<script type="text/javascript">
    function format(d) {
    // `d` is the original data object for the row
    return (
        '<dl>'+
        ($("#isLocale").val() == '1'?'<h4 class="mb-2 title1">1.Knowledge in job <span class="fw-normal text-gray-700">(x1)</span></h4>'+
        '<h6 class="mb-0 ps-4 title2">Above Standard <span class="fw-normal">(8-10)</span></h6>'+
        '<p class="ps-4 title3">Expert in all facets of the job, can tech others how to do</p>'+
        '<h6 class="mb-0 ps-4 title4">Standard <span class="fw-normal">(4-7)</span></h6>'+
        '<p class="ps-4 title5">Has sufficient knowledge of how to do the job</p>'+
        '<h6 class="mb-0 ps-4 title6">Below Standard <span class="fw-normal">(1-3)</span></h6>'+
        '<p class="ps-4 title7">Needs further coaching / training on how to do his/her job</p>':'<h4 class="mb-2 title1">1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span></h4>'+
        '<h6 class="mb-0 ps-4 title2">สูงกว่ามาตรฐาน <span class="fw-normal">(8-10)</span></h6>'+
        '<p class="ps-4 title3">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</p>'+
        '<h6 class="mb-0 ps-4 title4">มาตรฐาน <span class="fw-normal">(4-7)</span></h6>'+
        '<p class="ps-4 title5">มีความรู้เพียงพอที่จะปฏิบัติงานได้</p>'+
        '<h6 class="mb-0 ps-4 title6">ต่ำกว่ามาตรฐาน <span class="fw-normal">(1-3)</span></h6>'+
        '<p class="ps-4 title7">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</p>')+
        '<table class="table table-bordered bg-white table-sm">'+
            '<thead class="bg-light-primary">'+ 
                '<tr>'+
                    '<th colspan="11" class="text-center fw-bold">Criteria</th>'+
                '</tr>'+
                '<tr>'+
                    '<td class="text-center">1</td>'+
                    '<td class="text-center">2</td>'+
                    '<td class="text-center">3</td>'+
                    '<td class="text-center">4</td>'+
                    '<td class="text-center">5</td>'+
                    '<td class="text-center">6</td>'+
                    '<td class="text-center">7</td>'+
                    '<td class="text-center">8</td>'+
                    '<td class="text-center">9</td>'+
                    '<td class="text-center">Total</td>'+
                '</tr>'+
            '</thead>'+
            '<tbody>'+
                '<tr class="text-center">'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="9" onclick="gettitle(1);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="9" onclick="gettitle(2);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="7" onclick="gettitle(3);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="5" onclick="gettitle(4);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="10" onclick="gettitle(5);"></td>'+
                    '<td ><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="6" onclick="gettitle(6);"></td>'+
                    '<td><input type="number" class="form-control form-control-sm text-center" min="0" max="10" value="6" onclick="gettitle(7);"></td>'+
                    '<td  class="">'+
                        '<button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#complainModal" onclick="gettitle(8);">10</button>'+
                    '</td>'+
                    '<td  class="">'+
                        '<button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#attendanceModal" onclick="gettitle(9);">9</button>'+
                    '</td>'+
                    '<td  class="fw-bold text-black fs-4">82.5</td>'+
                '</tr>'+
            '</tbody>'+
        '<table>'+
        '<p class="text-gray-800 mb-0">Note:</p>'+
        '<p class="mb-0 text-danger">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>'+
        '</dl>'
    );
}

let table = new DataTable('#example', {
    fixedColumns: {
        left: 3
    },
    searchDelay: 500,
    processing: true,
    // serverSide: true,
    // scrollY: true,
    // scrollX: true,
    scrollCollapse: true,
    "ajax": {
        "url": "{{ url(Request::segment(1).'/table_rtest_getdata') }}",
        "type": 'GET',       
    },
    colReorder: true,
    columns: [
        { data: 'id' },
        { data: 'code' },
        { data: 'name' },
        { data: 'position' },
        { data: 'date' },
        { data: 'service' },
        { data: 'evaluator' },
        { data: '1' },
        { data: '2' },
        { data: '3' },
        { data: '4' },
        { data: '5' },
        { data: '6' },
        { data: '7' },
        { data: '8' },
        { data: '9' },
        { data: 'total' },
        { data: 'remark' },
        { data: 'status' },
        { data: 'action' }
    ],
    columnDefs: [ {
        targets: 18,
        orderable: false,
        render: function (data) {
            return `<span class="badge badge-light-danger">Reject</span>`;
        },
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
    table.colReorder.order([0, 1, 2, 3, 4, 5], true);
        // Add event listener for opening and closing details
table.on('click', 'td.dt-control', function (e) {
    let tr = e.target.closest('tr');
    let row = table.row(tr);

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
    }
    else {
        // Open this row
        row.child(format(row.data())).show();
    }
});
function gettitle(id){
    if($("#isLocale").val() == '1'){
        if(id == 1){
            $('.title1').html(`1.Knowledge in job <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`Expert in all facets of the job, can tech others how to do.`);
            $('.title5').html(`Has sufficient knowledge of how to do the job.`);
            $('.title7').html(`Needs further coaching / training on how to do his/her job.`);
        }else if(id == 2){
            $('.title1').html(`2.Quality of Work <span class="fw-normal text-gray-700">(x2)</span>`);
            $('.title3').html(`Your quality of work is always excellent and exceeds expectation.`);
            $('.title5').html(`Your quality of work meets the standard on a consistent basis.`);
            $('.title7').html(`Your quality of work must improve immediately by increasing output, accuracy, speed and/or organization.`);
        }else if(id == 3){
            $('.title1').html(`3.Team Player <span class="fw-normal text-gray-700">(x0.5)</span>`);
            $('.title3').html(`Able to work effectively with others, always welcomed as a team member, open to feedback from others.`);
            $('.title5').html(`Usually able to work effectively with others.`);
            $('.title7').html(`Has problems working with others, or create conflicts, or unable to accept feedback from others.`);
        }else if(id == 4){
            $('.title1').html(`4.Job Attitude <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`Accepts job assignments with enthusiasm and a positive attitude.`);
            $('.title5').html(`Accepts job assignments willingly`);
            $('.title7').html(`Accepts job assignments with poor attitude, or finds excuses to avoid job assignments`);
        }else if(id == 5){
            $('.title1').html(`5.Work in a Safe Way <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`Follows safety rules, always uses safety equipment, advises others to follow, and reports unsafe conditions`);
            $('.title5').html(`Follows safety rules and always uses safety equipment`);
            $('.title7').html(`Does not folloe safety rules, rarely uses safety equipment`);
        }else if(id == 6){
            $('.title1').html(`6.Participation in Company Activities <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`Enthusiastically participates in company activities, including taking leading role(s) if asked`);
            $('.title5').html(`Participates as required in company activities`);
            $('.title7').html(`Exhibitd a negative attitude when joining company activities`);
        }else if(id == 7){
            $('.title1').html(`7.Initiative and Innovation <span class="fw-normal text-gray-700">(x0.5)</span>`);
            $('.title3').html(`Always has suggestions or ideas on how to improve`);
            $('.title5').html(`Occasionallu has suggestions or ideas on how to improve`);
            $('.title7').html(`Rarely has suggestions or ideas on how to improve`);
        }else if(id == 8){
            $('.title1').html(`8.Compliance with Company Regulations <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`Excellent behavior, always follows company rules and regulations and sets a good example for others`);
            $('.title5').html(`Good behavior, follows company rules and regulations`);
            $('.title7').html(`Poor behavior, does not follow company rules and regulations and has bad influence on others`);
        }else{
            $('.title1').html(`9.Attendance <span class="fw-normal text-gray-700">(x2)</span>`);
            $('.title3').html(`0-2 days = 10, 3-4 days = 9, 5-6 days = 8`);
            $('.title5').html(`7-8 days = 7, 9-10 days = 6, 11-12 days = 5, 13-14 days = 4`);
            $('.title7').html(`15-16 days = 3, 17-18 days = 2, 19-20 days = 1`);
        }
    }else{
        if(id == 1){
            $('.title1').html(`1.ความรู้ในงาน <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 2){
            $('.title1').html(`2.คุณภาพงาน <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 3){
            $('.title1').html(`3.การทำงานเป็นทีม <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 4){
            $('.title1').html(`4.ทัศนคติในการทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 5){
            $('.title1').html(`5.ความปลอดภัยในการทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 6){
            $('.title1').html(`6.ความร่วมมือในกิจกรรมของบริษัท <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 7){
            $('.title1').html(`7.ความคิดริเริ่มและสร้างสรรค์ <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else if(id == 8){
            $('.title1').html(`8.การปฏิบัติตามกฎระเบียบของบริษัท <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }else{
            $('.title1').html(`9.สถิติการมาทำงาน <span class="fw-normal text-gray-700">(x1)</span>`);
            $('.title3').html(`มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้`);
            $('.title5').html(`มีความรู้เพียงพอที่จะปฏิบัติงานได้`);
            $('.title7').html(`ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน`);
        }
    }
    
}

// document.querySelectorAll('a.toggle-vis').forEach((el) => {
//     el.addEventListener('click', function (e) {
//         e.preventDefault();
 
//         let columnIdx = e.target.getAttribute('data-column');
//         let column = table.column(columnIdx);
 
//         // Toggle the visibility
//         column.visible(!column.visible());
//     });
// });
$(".toggle-vis").change(function(e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
 
        // Toggle the visibility
        column.visible(!column.visible());
    });

</script>

@endpush
</x-default-layout>
