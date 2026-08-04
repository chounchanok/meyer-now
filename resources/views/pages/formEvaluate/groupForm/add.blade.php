<x-default-layout>

    @section('title')
        {{($id!=""?__('Edit'):__('Create'))}} {{__('Form')}}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('formEvaluate.groupForm.addpage') }}
    @endsection

    <!--begin::Row-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
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
                        {{($id!=""?__('Edit'):__('Create'))}} {{__('Form')}}
                    </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Assessment form name (Thai):</label>
                            <input type="text" class="form-control" id="form_th" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Assessment form name  (English):</label>
                            <input type="text" class="form-control" id="form_en" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Year of use')}}:</label>
                            <input type="text" class="form-control" id="form_year_use_start" placeholder="ex.2024" maxlength="4" OnKeyPress="return checknumber(this)"/>
                            <input type="hidden" class="form-control" id="form_year_use_end" placeholder="ex.2024" maxlength="4"/>
                        </div>
                        <!-- <div class="col-sm-3">
                            <label for="exampleFormControlInput1" class="form-label mb-0">&nbsp;</label>
                            <input type="text" class="form-control" id="form_year_use_end" placeholder="ex.2024" maxlength="4"/>
                        </div> -->
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Reference form')}}:</label>
                            <select class="form-select" id="form_ref" name="form_ref">
                                <option value="F1">F1</option>
                                <option value="F2">F2</option>
                                <option value="F3">F3</option>
                                <option value="F4">F4</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="form_ref" placeholder=""/> -->
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Evaluation type')}}:</label>
                            <input type="text" class="form-control" id="form_type" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Code')}}:</label>
                            <div class="row gx-3">
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"id="code1" placeholder=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="code2" placeholder=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="code3" placeholder=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="code4" placeholder=""/>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="code5" placeholder=""/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline d-flex-start">
                                <input class="form-check-input mr-1" type="checkbox" value="1" id="criteria_weight_status" />
                                <label class="d-flex-center" for="criteria_weight_status">
                                Criteria Attendance (Weight = <input type="text" class="form-control mr-1 ml-1" id="criteria_weight" placeholder="" style="width: 70px;height: 34px;text-align:center;" OnKeyPress="return checknumber_dot(this)"/>)
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline d-flex-start">
                                <input class="form-check-input mr-1" type="checkbox" value="1" id="compliance_weight_status" />
                                <label class="d-flex-center" for="compliance_weight_status">
                                Compliance (Weight = <input type="text" class="form-control mr-1 ml-1" id="compliance_weight" placeholder="" style="width: 70px;height: 34px;text-align:center;" OnKeyPress="return checknumber_dot(this)"/>)
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--begin::Menu wrapper-->
                    <div class="mt-10">
                        <span class="mr-1" style="font-size: 16px;font-weight:bold;">{{__('Manage score levels')}}</span>
                        <button type="button" class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="adddata1();">
                            <i class="bi bi-plus"></i>
                            {{__('Add')}} 
                        </button>
                        <!--begin::Toggle-->
                        <!-- <button type="button" class="btn btn-light-primary rotate mb-3 py-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
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

                        </div> -->
                    </div>
                    <!--end::Dropdown wrapper-->
                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning" class="table table-striped gy-2 gs-5 rounded">
                            <thead class="table-light">
                                <tr class="fw-bold fs-6 text-gray-800 px-7 text-center">
                                    <th>{{__('No.')}}</th>
                                    <th>{{__('score')}}</th>
                                    <th>{{__('Level title')}}</th>
                                    <th>{{__('Level title en')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-10">
                        <span class="mr-1" style="font-size: 16px;font-weight:bold;">{{__('List of evaluation topics')}}</span>
                        <button type="button" class="btn btn-primary rounded-pill mb-3" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="adddata2();">
                            <i class="bi bi-plus"></i>
                            {{__('Add')}}
                        </button>
                    </div>
                    <!--end::Dropdown wrapper-->
                    <div class="table-responsive">
                        <table id="kt_datatable_dom_positioning2" class="table table-striped gy-2 gs-5 rounded">
                            <thead class="table-light">
                                <tr class="fw-bold fs-6 text-gray-800 px-7 text-center">
                                    <th>{{__('No.')}}</th>
                                    <th>{{__('Title')}}(Thai)</th>
                                    <th>{{__('Title')}}(English)</th>
                                    <th>Weight</th>
                                    <th>{{__('Score level description')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="reset" class="btn btn-outline btn-outline-dark rounded-pill" onclick="resetpage();">Reset</button>
                        <button type="button" class="btn btn-success rounded-pill" onclick="group_form_addedit();"><i class="bi bi-floppy fs-5"></i>Save</button>
                        <input type="hidden" id="group_form_id" value="{{$id}}">
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row card-body hover-scroll-overlay-y">
                        <div class="col-sm-6 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Starting score <span class="color-red">*</span></label>
                            <input type="text" class="form-control" id="score_start" placeholder="" value="" OnKeyPress="return checknumber(this)"/>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Final score <span class="color-red">*</span></label>
                            <input type="text" class="form-control" id="score_end" placeholder="" value="" OnKeyPress="return checknumber(this)"/>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Score level name(Thai) <span class="color-red">*</span></label>
                            <input type="text" class="form-control" id="score_level_th" placeholder="" value=""/>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Level title(English) <span class="color-red">*</span></label>
                            <input type="text" class="form-control" id="score_level_en" placeholder="" value=""/>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="group_form_score_level_addedit();">Save</button>
                    <input type="hidden" id="group_form_score_level_id" value="">
                    <input type="hidden" id="group_form_score_level_count" value="0">
                    <input type="hidden" id="group_form_score_level_type" value="add">
                    <input type="hidden" id="group_form_score_level_edit_row" value="0">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title detail_text">{{__('Add')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row card-body hover-scroll-overlay-y">
                        <div class="col-sm-12 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Choose a topic: <span class="color-red">*</span></label>
                            <select class="form-select" id="evaluation_criteria_id">
                                <option value="0">{{ __('Select') }}</option>
                                @foreach($evaluation_criteria as $val)    
                                    <option value="{{ $val->id }}">{{ $val->title_th }}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Weight: <span class="color-red">*</span></label>
                            <input type="text" class="form-control" id="topic_weight" placeholder="" value="" OnKeyPress="return checknumber_dot(this)"/>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <h6 class="fw-semibold">{{__('Score level description')}}</h6>
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Above Standard')}}(8-10): <span class="color-red">*</span></label>
                            <textarea class="form-control" id="detail_high_th" rows="2"></textarea>
                            <textarea class="form-control" id="detail_high_en" rows="2"></textarea>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Standard')}}(4-7): <span class="color-red">*</span></label>
                            <textarea class="form-control" id="detail_medium_th" rows="2"></textarea>
                            <textarea class="form-control" id="detail_medium_en" rows="2"></textarea>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Below Standard')}}(1-3): <span class="color-red">*</span></label>
                            <textarea class="form-control" id="detail_low_th" rows="2"></textarea>
                            <textarea class="form-control" id="detail_low_en" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer hide_footer" style="display:flex;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="group_form_topic_addedit();">Save</button>
                    <input type="hidden" id="group_form_topic_id" value="">
                    <input type="hidden" id="group_form_topic_count" value="0">
                    <input type="hidden" id="group_form_topic_type" value="add">
                    <input type="hidden" id="group_form_topic_edit_row" value="0">
                </div>
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
                <form class="row g-3">
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Choose a topic:</label>
                        <select class="form-select">
                            <option>team work</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Weight:</label>
                        <input type="text" class="form-control" placeholder="" value="0.5" OnKeyPress="return checknumber_dot(this)"/>
                    </div>
                    <div class="col-sm-12">
                        <h6 class="fw-semibold">Score level description</h6>
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Above Standard')}}(8-10):</label>
                        <textarea class="form-control" rows="2">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</textarea>
                        <textarea class="form-control" rows="2">Expert in all facets of the job, can teach others how to do</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Standard')}}(4-7):</label>
                        <textarea class="form-control" rows="2">มีความรู้เพียงพอที่่จะปฏิบัติงานได้</textarea>
                        <textarea class="form-control" rows="2">Has sufficient knowledge of how to do the job</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Below Standard(1-3):</label>
                        <textarea class="form-control" rows="2">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</textarea>
                        <textarea class="form-control" rows="2">Needs furture coaching/training on how to do his/her job</textarea>
                    </div>
                </form>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">ปิด</button>
                <!--end::Dismiss button-->
                <button type="button" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::add modal-->
    <!--begin::edit modal-->
    <div
        id="editList_content"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#editList"
        data-kt-drawer-close="#editList_close"
        data-kt-drawer-width="400px"
        >
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
            <form class="row g-3">
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Choose a topic:</label>
                        <select class="form-select">
                            <option>การทำงานเป็นทีม</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Weight:</label>
                        <input type="text" class="form-control" placeholder="" value="0.5" OnKeyPress="return checknumber_dot(this)"/>
                    </div>
                    <div class="col-sm-12">
                        <h6 class="fw-semibold">Score level description</h6>
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Above Standard')}}(8-10):</label>
                        <textarea class="form-control" rows="2">มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</textarea>
                        <textarea class="form-control" rows="2">Expert in all facets of the job, can teach others how to do</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Standard')}}(4-7):</label>
                        <textarea class="form-control" rows="2">มีความรู้เพียงพอที่่จะปฏิบัติงานได้</textarea>
                        <textarea class="form-control" rows="2">Has sufficient knowledge of how to do the job</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Below Standard(1-3):</label>
                        <textarea class="form-control" rows="2">ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</textarea>
                        <textarea class="form-control" rows="2">Needs furture coaching/training on how to do his/her job</textarea>
                    </div>
                </form>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">ปิด</button>
                <!--end::Dismiss button-->
                <button type="button" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::edit modal-->
    <!--begin::edit modal-->
    <div
        id="descScore_content"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-toggle="#descScore"
        data-kt-drawer-close="#descScore_close"
        data-kt-drawer-width="400px"
        >
        <div class="card rounded-0 w-100">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 lh-1">Score level description</a>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="descScore_close">
                    <i class="ki-outline ki-cross fs-1"></i>              
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
            <form class="row g-3">
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Choose a topic:</label>
                        <select class="form-select" disabled>
                            <option>การทำงานเป็นทีม</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <h6 class="fw-semibold">Score level description</h6>
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Above Standard')}}(8-10):</label>
                        <textarea class="form-control" rows="2" disabled>มีความชำนาญในงานทุกด้าน สามารถสอนการปฏิบัติงานให้ผู้อื่นได้</textarea>
                        <textarea class="form-control" rows="2" disabled>Expert in all facets of the job, can teach others how to do</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">{{__('Standard')}}(4-7):</label>
                        <textarea class="form-control" rows="2" disabled>มีความรู้เพียงพอที่่จะปฏิบัติงานได้</textarea>
                        <textarea class="form-control" rows="2" disabled>Has sufficient knowledge of how to do the job</textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="exampleFormControlInput1" class="form-label mb-0">Below Standard(1-3):</label>
                        <textarea class="form-control" rows="2" disabled>ต้องฝึกอบรมเพิ่มเติมเกี่ยวกับการปฏิบัติงาน</textarea>
                        <textarea class="form-control" rows="2" disabled>Needs furture coaching/training on how to do his/her job</textarea>
                    </div>
                </form>
            </div>
            <!--end::Card body-->

            <!--begin::Card footer-->
            <div class="card-footer text-end">
                <!--begin::Dismiss button-->
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">ปิด</button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::edit modal-->
    @push('scripts')
        <script type="text/javascript">
            // loading();
            // setTimeout(function() {
            //     KTApp.hidePageLoading();
            //     if($('#group_form_id').val() != ""){
            //         geteditdata($('#group_form_id').val());
            //     }   
            // }, 3000);
            if($('#group_form_id').val() != ""){
                geteditdata($('#group_form_id').val());
            }  
            // $("#kt_datatable_dom_positioning").DataTable({
            //     "language": {
            //         "lengthMenu": "Show _MENU_",
            //     },
            //     "dom":
            //         "<'row'" +
            //         "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            //         "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            //         ">" +

            //         "<'table-responsive'tr>" +

            //         "<'row'" +
            //         "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            //         "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            //         ">"
            // });
            // $("#kt_datatable_dom_positioning2").DataTable({
            //     "language": {
            //         "lengthMenu": "Show _MENU_",
            //     },
            //     "dom":
            //         "<'row'" +
            //         "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            //         "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            //         ">" +

            //         "<'table-responsive'tr>" +

            //         "<'row'" +
            //         "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            //         "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            //         ">"
            // });
            function adddata1(){
                $('#group_form_score_level_id').val('');
                $('#score_start').val('');
                $('#score_end').val('');
                $('#score_level_th').val('');
                $('#score_level_en').val('');
                $("#group_form_score_level_type").val('add')
            }
            function adddata2(){
                $('#group_form_topic_id').val('');
                $('#evaluation_criteria_id').val('0');
                $('#topic_weight').val('');
                $('#detail_high_th').val('');
                $('#detail_high_en').val('');
                $('#detail_medium_th').val('');
                $('#detail_medium_en').val('');
                $('#detail_low_th').val('');
                $('#detail_low_en').val('');
                $("#group_form_topic_type").val('add');
                $('#evaluation_criteria_id').attr('disabled',false);
                $('#topic_weight').attr('disabled',false);
                $('#detail_high_th').attr('disabled',false);
                $('#detail_high_en').attr('disabled',false);
                $('#detail_medium_th').attr('disabled',false);
                $('#detail_medium_en').attr('disabled',false);
                $('#detail_low_th').attr('disabled',false);
                $('#detail_low_en').attr('disabled',false);
                $('.detail_text').text('Add');
                $('.hide_footer').css('display','flex');
            }
            function group_form_score_level_addedit(){
                var group_form_score_level_type = $("#group_form_score_level_type").val();
                var group_form_score_level_edit_row = $("#group_form_score_level_edit_row").val();
                var group_form_score_level_count = $("#group_form_score_level_count").val();
                var group_form_score_level_id = $('#group_form_score_level_id').val();
                var score_start = $('#score_start').val();
                var score_end = $('#score_end').val();
                var score_level_th = $('#score_level_th').val();
                var score_level_en = $('#score_level_en').val();
                if(score_start == ""){
                    Swal.fire({
                        title: "ไม่สำเร็จ",
                        text: "กรุณาระบุStarting score",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    if(score_end == ""){
                        Swal.fire({
                            title: "ไม่สำเร็จ",
                            text: "กรุณาระบุFinal score",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }else{
                        if(score_level_th == ""){
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "กรุณาระบุScore level name(Thai)",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        }else{
                            if(score_level_en == ""){
                                Swal.fire({
                                    title: "ไม่สำเร็จ",
                                    text: "กรุณาระบุ Level title(English)",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }else{
                                if(group_form_score_level_type == "add"){
                                    group_form_score_level_count++;
                                    var html = `
                                        <tr class="del1_count${group_form_score_level_count}">
                                            <td class="text-center num1_">${group_form_score_level_count}</td>
                                            <td class="text-center">${score_start} - ${score_end}</td>
                                            <td class="text-center">${score_level_th}</td>
                                            <td class="text-center">${score_level_en}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="editdata1('${group_form_score_level_count}');">
                                                    <i class="ki-solid ki-pencil fs-5"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata1('${group_form_score_level_count}');">
                                                    <i class="ki-solid ki-tablet-delete "></i>
                                                </button>
                                                <input type="hidden" class="hidden_group_form_score_level_id" id="hidden_group_form_score_level_id${group_form_score_level_count}" name="group_form_score_level_id[]" value="${group_form_score_level_id}">
                                                <input type="hidden" class="hidden_score_start" id="hidden_score_start${group_form_score_level_count}" name="score_start[]" value="${score_start}">
                                                <input type="hidden" class="hidden_score_end" id="hidden_score_end${group_form_score_level_count}" name="score_end[]" value="${score_end}">
                                                <input type="hidden" class="hidden_score_level_th" id="hidden_score_level_th${group_form_score_level_count}" name="score_level_th[]" value="${score_level_th}">
                                                <input type="hidden" class="hidden_score_level_en" id="hidden_score_level_en${group_form_score_level_count}" name="score_level_en[]" value="${score_level_en}">
                                            </td>
                                        </tr>
                                    `;
                                    $('#kt_datatable_dom_positioning tbody').append(html);
                                    $('#group_form_score_level_count').val(group_form_score_level_count);
                                    var countdata = 1;
                                    $('.num1_').each(function(i, obj) {
                                        $(this).text(countdata);
                                        countdata++;
                                    });
                                }else{
                                    var html = `
                                            <td class="text-center num1_">${group_form_score_level_edit_row}</td>
                                            <td class="text-center">${score_start} - ${score_end}</td>
                                            <td class="text-center">${score_level_th}</td>
                                            <td class="text-center">${score_level_en}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="editdata1('${group_form_score_level_edit_row}');">
                                                    <i class="ki-solid ki-pencil fs-5"></i>
                                                </button>
                                                <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata1('${group_form_score_level_edit_row}');">
                                                    <i class="ki-solid ki-tablet-delete "></i>
                                                </button>
                                                <input type="hidden" class="hidden_group_form_score_level_id" id="hidden_group_form_score_level_id${group_form_score_level_edit_row}" name="group_form_score_level_id[]" value="${group_form_score_level_id}">
                                                <input type="hidden" class="hidden_score_start" id="hidden_score_start${group_form_score_level_edit_row}" name="score_start[]" value="${score_start}">
                                                <input type="hidden" class="hidden_score_end" id="hidden_score_end${group_form_score_level_edit_row}" name="score_end[]" value="${score_end}">
                                                <input type="hidden" class="hidden_score_level_th" id="hidden_score_level_th${group_form_score_level_edit_row}" name="score_level_th[]" value="${score_level_th}">
                                                <input type="hidden" class="hidden_score_level_en" id="hidden_score_level_en${group_form_score_level_edit_row}" name="score_level_en[]" value="${score_level_en}">
                                            </td>
                                    `;
                                    $('.del1_count'+group_form_score_level_edit_row).html(html);
                                }
                            }
                        }
                    }
                }
                // $('#kt_datatable_dom_positioning').DataTable().destroy();
                // $('#kt_datatable_dom_positioning').find('tbody').append(html);
                // $('#kt_datatable_dom_positioning').DataTable().draw();
            }
            function group_form_topic_addedit(){
                var group_form_topic_type = $("#group_form_topic_type").val();
                var group_form_topic_edit_row = $("#group_form_topic_edit_row").val();
                var group_form_topic_count = $("#group_form_topic_count").val();
                var group_form_topic_id = $('#group_form_topic_id').val();
                var evaluation_criteria_id = $('#evaluation_criteria_id').val();
                var topic_weight = $('#topic_weight').val();
                var detail_high_th = $('#detail_high_th').val();
                var detail_high_en = $('#detail_high_en').val();
                var detail_medium_th = $('#detail_medium_th').val();
                var detail_medium_en = $('#detail_medium_en').val();
                var detail_low_th = $('#detail_low_th').val();
                var detail_low_en = $('#detail_low_en').val();
                if(evaluation_criteria_id == "0"){
                    Swal.fire({
                        title: "ไม่สำเร็จ",
                        text: "กรุณาChoose a topic",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    if(topic_weight == ""){
                        Swal.fire({
                            title: "ไม่สำเร็จ",
                            text: "กรุณาระบุWeight",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }else{
                        if(detail_high_th == "" || detail_high_en == ""){
                            Swal.fire({
                                title: "ไม่สำเร็จ",
                                text: "กรุณาระบุคำอธิบาย 8-10",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        }else{
                            if(detail_medium_th == "" || detail_medium_en == ""){
                                Swal.fire({
                                    title: "ไม่สำเร็จ",
                                    text: "กรุณาระบุคำอธิบาย 4-7",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }else{
                                if(detail_low_th == "" || detail_low_en == ""){
                                    Swal.fire({
                                        title: "ไม่สำเร็จ",
                                        text: "กรุณาระบุคำอธิบาย 1-3",
                                        icon: "warning",
                                        allowOutsideClick: false,
                                    });
                                }else{
                                    if(group_form_topic_type == "add"){
                                        group_form_topic_count++;
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ url(Request::segment(1)."/criteria_get_evaluation_criteria") }}',
                                            dataType: 'json',
                                            data : { 
                                                "_token": "{{ csrf_token() }}",
                                                id:evaluation_criteria_id
                                            },
                                            success: function (result) { 
                                                var html = `
                                                    <tr class="del2_count${group_form_topic_count}">
                                                        <td class="text-center num2_">${group_form_topic_count}</td>
                                                        <td>${result.title_th}</td>
                                                        <td>${result.title_en}</td>
                                                        <td class="text-center">${topic_weight}</td>
                                                        <td class="text-center">
                                                             <button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="detaildata2('${group_form_topic_count}');">
                                                                <i class="ki-solid ki-information-2 fs-4 text-primary"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="editdata2('${group_form_topic_count}');">
                                                                <i class="ki-solid ki-pencil fs-5"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata2('${group_form_topic_count}');">
                                                                <i class="ki-solid ki-tablet-delete "></i>
                                                            </button>
                                                            <input type="hidden" class="hidden_group_form_topic_id" id="hidden_group_form_topic_id${group_form_topic_count}" name="group_form_topic_id[]" value="${group_form_topic_id}">
                                                            <input type="hidden" class="hidden_evaluation_criteria_id" id="hidden_evaluation_criteria_id${group_form_topic_count}" name="evaluation_criteria_id[]" value="${evaluation_criteria_id}">
                                                            <input type="hidden" class="hidden_topic_weight" id="hidden_topic_weight${group_form_topic_count}" name="topic_weight[]" value="${topic_weight}">
                                                            <input type="hidden" class="hidden_detail_high_th" id="hidden_detail_high_th${group_form_topic_count}" name="detail_high_th[]" value="${detail_high_th}">
                                                            <input type="hidden" class="hidden_detail_high_en" id="hidden_detail_high_en${group_form_topic_count}" name="detail_high_en[]" value="${detail_high_en}">
                                                            <input type="hidden" class="hidden_detail_medium_th" id="hidden_detail_medium_th${group_form_topic_count}" name="detail_medium_th[]" value="${detail_medium_th}">
                                                            <input type="hidden" class="hidden_detail_medium_en" id="hidden_detail_medium_en${group_form_topic_count}" name="detail_medium_en[]" value="${detail_medium_en}">
                                                            <input type="hidden" class="hidden_detail_low_th" id="hidden_detail_low_th${group_form_topic_count}" name="detail_low_th[]" value="${detail_low_th}">
                                                            <input type="hidden" class="hidden_detail_low_en" id="hidden_detail_low_en${group_form_topic_count}" name="detail_low_en[]" value="${detail_low_en}">
                                                        </td>
                                                    </tr>
                                                `;
                                                $('#kt_datatable_dom_positioning2 tbody').append(html);
                                                $('#group_form_topic_count').val(group_form_topic_count);
                                                var countdata = 1;
                                                $('.num2_').each(function(i, obj) {
                                                    $(this).text(countdata);
                                                    countdata++;
                                                });
                                            }
                                        });
                                    }else{
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ url(Request::segment(1)."/criteria_get_evaluation_criteria") }}',
                                            dataType: 'json',
                                            data : { 
                                                "_token": "{{ csrf_token() }}",
                                                id:evaluation_criteria_id
                                            },
                                            success: function (result) { 
                                                var html = `
                                                        <td class="text-center num2_">${group_form_topic_edit_row}</td>
                                                        <td>${result.title_th}</td>
                                                        <td>${result.title_en}</td>
                                                        <td class="text-center">${topic_weight}</td>
                                                        <td class="text-center">
                                                             <button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="detaildata2('${group_form_topic_edit_row}');">
                                                                <i class="ki-solid ki-information-2 fs-4 text-primary"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="editdata2('${group_form_topic_edit_row}');">
                                                                <i class="ki-solid ki-pencil fs-5"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata2('${group_form_topic_edit_row}');">
                                                                <i class="ki-solid ki-tablet-delete "></i>
                                                            </button>
                                                            <input type="hidden" class="hidden_group_form_topic_id" id="hidden_group_form_topic_id${group_form_topic_edit_row}" name="group_form_topic_id[]" value="${group_form_topic_id}">
                                                            <input type="hidden" class="hidden_evaluation_criteria_id" id="hidden_evaluation_criteria_id${group_form_topic_edit_row}" name="evaluation_criteria_id[]" value="${evaluation_criteria_id}">
                                                            <input type="hidden" class="hidden_topic_weight" id="hidden_topic_weight${group_form_topic_edit_row}" name="topic_weight[]" value="${topic_weight}">
                                                            <input type="hidden" class="hidden_detail_high_th" id="hidden_detail_high_th${group_form_topic_edit_row}" name="detail_high_th[]" value="${detail_high_th}">
                                                            <input type="hidden" class="hidden_detail_high_en" id="hidden_detail_high_en${group_form_topic_edit_row}" name="detail_high_en[]" value="${detail_high_en}">
                                                            <input type="hidden" class="hidden_detail_medium_th" id="hidden_detail_medium_th${group_form_topic_edit_row}" name="detail_medium_th[]" value="${detail_medium_th}">
                                                            <input type="hidden" class="hidden_detail_medium_en" id="hidden_detail_medium_en${group_form_topic_edit_row}" name="detail_medium_en[]" value="${detail_medium_en}">
                                                            <input type="hidden" class="hidden_detail_low_th" id="hidden_detail_low_th${group_form_topic_edit_row}" name="detail_low_th[]" value="${detail_low_th}">
                                                            <input type="hidden" class="hidden_detail_low_en" id="hidden_detail_low_en${group_form_topic_edit_row}" name="detail_low_en[]" value="${detail_low_en}">
                                                        </td>
                                                `;
                                                $('.del2_count'+group_form_topic_edit_row).html(html);
                                            }
                                        });
                                    }
                                }
                            }
                        }
                    }
                }
            }
            function group_form_addedit(){
                var list_score = [];
                var list_topic = [];

                var hidden_group_form_score_level_id = $('.hidden_group_form_score_level_id'); 
                var hidden_score_start = $('.hidden_score_start'); 
                var hidden_score_end = $('.hidden_score_end'); 
                var hidden_score_level_th = $('.hidden_score_level_th'); 
                var hidden_score_level_en = $('.hidden_score_level_en'); 
                for(var i = 0;i < hidden_score_start.length;i++){
                    list_score.push({
                        group_form_score_level_id:hidden_group_form_score_level_id[i].value,
                        score_start:hidden_score_start[i].value,
                        score_end:hidden_score_end[i].value,
                        score_level_th:hidden_score_level_th[i].value,
                        score_level_en:hidden_score_level_en[i].value
                    });
                }

                var hidden_group_form_topic_id = $('.hidden_group_form_topic_id'); 
                var hidden_evaluation_criteria_id = $('.hidden_evaluation_criteria_id'); 
                var hidden_topic_weight = $('.hidden_topic_weight'); 
                var hidden_detail_high_th = $('.hidden_detail_high_th'); 
                var hidden_detail_high_en = $('.hidden_detail_high_en'); 
                var hidden_detail_medium_th = $('.hidden_detail_medium_th'); 
                var hidden_detail_medium_en = $('.hidden_detail_medium_en'); 
                var hidden_detail_low_th = $('.hidden_detail_low_th'); 
                var hidden_detail_low_en = $('.hidden_detail_low_en');  
                for(var i = 0;i < hidden_evaluation_criteria_id.length;i++){
                    list_topic.push({
                        group_form_topic_id:hidden_group_form_topic_id[i].value,
                        evaluation_criteria_id:hidden_evaluation_criteria_id[i].value,
                        topic_weight:hidden_topic_weight[i].value,
                        detail_high_th:hidden_detail_high_th[i].value,
                        detail_high_en:hidden_detail_high_en[i].value,
                        detail_medium_th:hidden_detail_medium_th[i].value,
                        detail_medium_en:hidden_detail_medium_en[i].value,
                        detail_low_th:hidden_detail_low_th[i].value,
                        detail_low_en:hidden_detail_low_en[i].value
                    });
                }
                var form = {
                    "_token": "{{ csrf_token() }}",
                    id:$('#group_form_id').val(),
                    form_th:$('#form_th').val(),
                    form_en:$('#form_en').val(),
                    form_type:$('#form_type').val(),
                    form_year_use_start:$('#form_year_use_start').val(),
                    form_year_use_end:$('#form_year_use_end').val(),
                    form_ref:$('#form_ref').val(),
                    code1:$('#code1').val(),
                    code2:$('#code2').val(),
                    code3:$('#code3').val(),
                    code4:$('#code4').val(),
                    code5:$('#code5').val(),
                    criteria_weight_status:($('#criteria_weight_status').is(':checked')==true?'1':'0'),
                    criteria_weight:$('#criteria_weight').val(),
                    compliance_weight_status:($('#compliance_weight_status').is(':checked')==true?'1':'0'),
                    compliance_weight:$('#compliance_weight').val(),
                    list_score:list_score,
                    list_topic:list_topic,
                }
                console.log(form);
                if(
                    form.form_th == "" || 
                    form.form_en == "" || 
                    form.form_type == "" || 
                    form.form_year_use_start == "" || 
                    form.form_year_use_end == "" || 
                    form.code1 == "" || 
                    form.code2 == "" || 
                    form.code3 == "" || 
                    form.code4 == "" || 
                    form.code5 == "" || 
                    form.list_score.length == 0 || 
                    form.list_topic.length == 0 ){
                    Swal.fire({
                        title: "ไม่สำเร็จ",
                        text: "กรุณาระบุข้อมูลให้ครบถ้วน",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    if(
                        (form.criteria_weight_status == "1" && 
                        form.criteria_weight == "") || 
                        (form.compliance_weight_status == "1" && 
                        form.compliance_weight == "")){
                        Swal.fire({
                            title: "ไม่สำเร็จ",
                            text: "กรุณาระบุ Weight",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/group_form_addedit") }}',
                            dataType: 'json',
                            data : form,
                            success: function (result) { 
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
                                        window.location.href = "{{ url(Request::segment(1).'/formEvaluate/groupForm') }}";
                                        // window.location.href="/formEvaluate/groupForm";
                                        // window.location.reload();
                                    }
                                });
                            }
                        });
                    }
                }
            }
            function editdata1(count){  
                var group_form_score_level_id   = $('#hidden_group_form_score_level_id'+count).val();
                var score_start                 = $('#hidden_score_start'+count).val();
                var score_end                   = $('#hidden_score_end'+count).val();
                var score_level_th              = $('#hidden_score_level_th'+count).val();
                var score_level_en              = $('#hidden_score_level_en'+count).val();
                $('#group_form_score_level_id').val(group_form_score_level_id);
                $('#score_start').val(score_start);
                $('#score_end').val(score_end);
                $('#score_level_th').val(score_level_th);
                $('#score_level_en').val(score_level_en);
                $('#group_form_score_level_type').val('edit');
                $('#group_form_score_level_edit_row').val(count);
            }
            function deldata1(count){
                $('.del1_count'+count).remove();
                var countdata = 1;
                $('.num1_').each(function(i, obj) {
                    $(this).text(countdata);
                    countdata++;
                });
            }
            function editdata2(count){
                var group_form_topic_id   = $('#hidden_group_form_topic_id'+count).val();
                var evaluation_criteria_id      = $('#hidden_evaluation_criteria_id'+count).val();
                var topic_weight                = $('#hidden_topic_weight'+count).val();
                var detail_high_th              = $('#hidden_detail_high_th'+count).val();
                var detail_high_en              = $('#hidden_detail_high_en'+count).val();
                var detail_medium_th            = $('#hidden_detail_medium_th'+count).val();
                var detail_medium_en            = $('#hidden_detail_medium_en'+count).val();
                var detail_low_th               = $('#hidden_detail_low_th'+count).val();
                var detail_low_en               = $('#hidden_detail_low_en'+count).val();
                $('#group_form_topic_id').val(group_form_topic_id);
                $('#evaluation_criteria_id').val(evaluation_criteria_id);
                $('#topic_weight').val(topic_weight);
                $('#detail_high_th').val(detail_high_th);
                $('#detail_high_en').val(detail_high_en);
                $('#detail_medium_th').val(detail_medium_th);
                $('#detail_medium_en').val(detail_medium_en);
                $('#detail_low_th').val(detail_low_th);
                $('#detail_low_en').val(detail_low_en);
                $('#group_form_topic_type').val('edit');
                $('#group_form_topic_edit_row').val(count);
                $('#evaluation_criteria_id').attr('disabled',false);
                $('#topic_weight').attr('disabled',false);
                $('#detail_high_th').attr('disabled',false);
                $('#detail_high_en').attr('disabled',false);
                $('#detail_medium_th').attr('disabled',false);
                $('#detail_medium_en').attr('disabled',false);
                $('#detail_low_th').attr('disabled',false);
                $('#detail_low_en').attr('disabled',false);
                $('.detail_text').text('แก้ไขรายการ');
                $('.hide_footer').css('display','flex');
            }
            function detaildata2(count){
                var evaluation_criteria_id      = $('#hidden_evaluation_criteria_id'+count).val();
                var topic_weight                = $('#hidden_topic_weight'+count).val();
                var detail_high_th              = $('#hidden_detail_high_th'+count).val();
                var detail_high_en              = $('#hidden_detail_high_en'+count).val();
                var detail_medium_th            = $('#hidden_detail_medium_th'+count).val();
                var detail_medium_en            = $('#hidden_detail_medium_en'+count).val();
                var detail_low_th               = $('#hidden_detail_low_th'+count).val();
                var detail_low_en               = $('#hidden_detail_low_en'+count).val();
                $('#evaluation_criteria_id').val(evaluation_criteria_id);
                $('#topic_weight').val(topic_weight);
                $('#detail_high_th').val(detail_high_th);
                $('#detail_high_en').val(detail_high_en);
                $('#detail_medium_th').val(detail_medium_th);
                $('#detail_medium_en').val(detail_medium_en);
                $('#detail_low_th').val(detail_low_th);
                $('#detail_low_en').val(detail_low_en);
                $('#group_form_topic_type').val('edit');
                $('#group_form_topic_edit_row').val(count);
                $('#evaluation_criteria_id').attr('disabled',true);
                $('#topic_weight').attr('disabled',true);
                $('#detail_high_th').attr('disabled',true);
                $('#detail_high_en').attr('disabled',true);
                $('#detail_medium_th').attr('disabled',true);
                $('#detail_medium_en').attr('disabled',true);
                $('#detail_low_th').attr('disabled',true);
                $('#detail_low_en').attr('disabled',true);
                $('.detail_text').text('Score level description');
                $('.hide_footer').css('display','none');
            }
            function deldata2(count){
                $('.del2_count'+count).remove();
                var countdata = 1;
                $('.num2_').each(function(i, obj) {
                    $(this).text(countdata);
                    countdata++;
                });
            }
            function resetpage(){
                window.location.reload();
            }
            function geteditdata(id){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/get_edit_data") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        id:id,
                    },
                    success: function (result) { 
                        console.log(result.name);
                        $('#form_th').val(result.group_form.form_th);
                        $('#form_en').val(result.group_form.form_en);
                        $('#form_type').val(result.group_form.form_type);
                        $('#form_year_use_start').val(result.group_form.form_year_use_start);
                        $('#form_year_use_end').val(result.group_form.form_year_use_end);
                        $('#form_ref').val(result.group_form.form_ref);
                        $('#code1').val(result.group_form.code1);
                        $('#code2').val(result.group_form.code2);
                        $('#code3').val(result.group_form.code3);
                        $('#code4').val(result.group_form.code4);
                        $('#code5').val(result.group_form.code5);
                        if(result.group_form.criteria_weight_status == 1){
                            $('#criteria_weight_status').prop('checked',true);
                        }else{
                            $('#criteria_weight_status').prop('checked',false);
                        }
                        if(result.group_form.compliance_weight_status == 1){
                            $('#compliance_weight_status').prop('checked',true);
                        }else{
                            $('#compliance_weight_status').prop('checked',false);
                        }
                        // $('#criteria_weight_status').val(result.group_form.criteria_weight_status);
                        $('#criteria_weight').val(result.group_form.criteria_weight);
                        // $('#compliance_weight_status').val(result.group_form.compliance_weight_status);
                        $('#compliance_weight').val(result.group_form.compliance_weight);

                        if(result.group_form_score_level.length > 0){
                            var group_form_score_level_count = 0;
                            $.each(result.group_form_score_level, function (key, value) {
                                group_form_score_level_count++;
                                    var html = `
                                        <tr class="del1_count${group_form_score_level_count}">
                                            <td class="text-center num1_">${group_form_score_level_count}</td>
                                            <td class="text-center">${value.score_start} - ${value.score_end}</td>
                                            <td class="text-center">${value.score_level_th}</td>
                                            <td class="text-center">${value.score_level_en}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="editdata1('${group_form_score_level_count}');">
                                                    <i class="ki-solid ki-pencil fs-5"></i>
                                                </button>
                                                
                                                <input type="hidden" class="hidden_group_form_score_level_id" id="hidden_group_form_score_level_id${group_form_score_level_count}" name="group_form_score_level_id[]" value="${value.id}">
                                                <input type="hidden" class="hidden_score_start" id="hidden_score_start${group_form_score_level_count}" name="score_start[]" value="${value.score_start}">
                                                <input type="hidden" class="hidden_score_end" id="hidden_score_end${group_form_score_level_count}" name="score_end[]" value="${value.score_end}">
                                                <input type="hidden" class="hidden_score_level_th" id="hidden_score_level_th${group_form_score_level_count}" name="score_level_th[]" value="${value.score_level_th}">
                                                <input type="hidden" class="hidden_score_level_en" id="hidden_score_level_en${group_form_score_level_count}" name="score_level_en[]" value="${value.score_level_en}">
                                            </td>
                                        </tr>
                                    `;
                                    // <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata1('${group_form_score_level_count}');">
                                    //     <i class="ki-solid ki-tablet-delete "></i>
                                    // </button>
                                    $('#kt_datatable_dom_positioning tbody').append(html);
                            });
                            $('#group_form_score_level_count').val(result.group_form_score_level.length);
                        }
                        if(result.group_form_topic.length > 0){
                            var group_form_topic_count = 0;
                            $.each(result.group_form_topic, function (key, value) {
                                group_form_topic_count++;
                                var html = `
                                    <tr class="del2_count${group_form_topic_count}">
                                        <td class="text-center num2_">${group_form_topic_count}</td>
                                        <td>${value.evaluation_criteria_title_th}</td>
                                        <td>${value.evaluation_criteria_title_en}</td>
                                        <td class="text-center">${value.topic_weight}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="detaildata2('${group_form_topic_count}');">
                                                <i class="ki-solid ki-information-2 fs-4 text-primary"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_2" onclick="editdata2('${group_form_topic_count}');">
                                                <i class="ki-solid ki-pencil fs-5"></i>
                                            </button>
                                            
                                            <input type="hidden" class="hidden_group_form_topic_id" id="hidden_group_form_topic_id${group_form_topic_count}" name="group_form_topic_id[]" value="${value.id}">
                                            <input type="hidden" class="hidden_evaluation_criteria_id" id="hidden_evaluation_criteria_id${group_form_topic_count}" name="evaluation_criteria_id[]" value="${value.evaluation_criteria_id}">
                                            <input type="hidden" class="hidden_topic_weight" id="hidden_topic_weight${group_form_topic_count}" name="topic_weight[]" value="${value.topic_weight}">
                                            <input type="hidden" class="hidden_detail_high_th" id="hidden_detail_high_th${group_form_topic_count}" name="detail_high_th[]" value="${value.detail_high_th}">
                                            <input type="hidden" class="hidden_detail_high_en" id="hidden_detail_high_en${group_form_topic_count}" name="detail_high_en[]" value="${value.detail_high_en}">
                                            <input type="hidden" class="hidden_detail_medium_th" id="hidden_detail_medium_th${group_form_topic_count}" name="detail_medium_th[]" value="${value.detail_medium_th}">
                                            <input type="hidden" class="hidden_detail_medium_en" id="hidden_detail_medium_en${group_form_topic_count}" name="detail_medium_en[]" value="${value.detail_medium_en}">
                                            <input type="hidden" class="hidden_detail_low_th" id="hidden_detail_low_th${group_form_topic_count}" name="detail_low_th[]" value="${value.detail_low_th}">
                                            <input type="hidden" class="hidden_detail_low_en" id="hidden_detail_low_en${group_form_topic_count}" name="detail_low_en[]" value="${value.detail_low_en}">
                                        </td>
                                    </tr>
                                `;
                                // <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="deldata2('${group_form_topic_count}');">
                                //     <i class="ki-solid ki-tablet-delete "></i>
                                // </button>
                                $('#kt_datatable_dom_positioning2 tbody').append(html);
                            });
                            $('#group_form_topic_count').val(result.group_form_topic.length);
                        }
                    }
                });
            }
            function checknumber(ele){
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar<'0' || vchar>'9')) return false;
                ele.onKeyPress=vchar;
            }
            function checknumber_dot(ele){
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
                ele.onKeyPress=vchar;
            }
        </script>
    @endpush
    <script>
        function loading(){
            KTApp.showPageLoading();
        }
        function loading_hide(){
            KTApp.hidePageLoading();
        }
    </script>
    <style>
        .d-flex-start{
            display: flex !important;
            align-items: center;
            justify-content: start;
        }
        .d-flex-center{
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        .mr-1{
            margin-right: 10px;
        }
        .ml-1{
            margin-left: 10px;
        }
        .color-red{
            color: red;
        }
    </style>
</x-default-layout>
