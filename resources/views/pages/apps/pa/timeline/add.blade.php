<x-default-layout>

    @section('title')
        สร้างฟอร์ม
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
                        สร้างฟอร์ม
                    </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <form class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">ชื่อฟอร์มแบบประเมิน (ไทย):</label>
                            <input type="text" class="form-control" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">Assessment form name  (English):</label>
                            <input type="text" class="form-control" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">ประเภทส่วนประเมิน:</label>
                            <input type="text" class="form-control" placeholder=""/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label mb-0">รหัส:</label>
                            <div class="row gx-3">
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder=""/>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder=""/>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder=""/>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" placeholder=""/>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill">
                                <i class="bi bi-search"></i>
                                Search
                            </button>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                                <label class="form-check-label" for="flexCheckChecked">
                                Criteria Attendance
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                                <label class="form-check-label" for="flexCheckChecked">
                                Compliance
                                </label>
                            </div>
                        </div>
                    </form>
                    <!--begin::Menu wrapper-->
                    <div>
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
                    <div class="table-responsive">
                    <table id="kt_datatable_dom_positioning" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7 text-center">
                                <th></th>
                                <th>No.</th>
                                <th>ชื่อฟอร์ม</th>
                                <th>วันที่สร้าง</th>
                                <th>ปีที่ใช้</th>
                                <th>Revise</th>
                                <th>ฟอร์มอ้างอิง</th>
                                <th>Active</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td class="text-center">1</td>
                                <td>F1</td>
                                <td>วว/ดด/ปปปป</td>
                                <td>ปปปป - ปปปป</td>
                                <td class="text-center">0</td>
                                <td class="text-center">-</td>
                                <td class="text-center">
                                <label class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" value="1" checked="checked"/>
                                </label>
                                </td>
                                <td class="text-center"><span class="badge badge-light-success">Active</span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center">2</td>
                                <td>F2</td>
                                <td>วว/ดด/ปปปป</td>
                                <td>ปปปป - ปปปป</td>
                                <td class="text-center">0</td>
                                <td class="text-center">-</td>
                                <td class="">
                                <label class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </label>
                                </td>
                                <td class="text-center"><span class="badge badge-light-danger">Not Active</span></td>
                            </tr>
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
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Close</button>
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
                <button type="button" class="btn btn-outline btn-outline-dark  rounded-pill" data-kt-drawer-dismiss="true">Close</button>
                <!--end::Dismiss button-->
                <button type="button" class="btn btn-success rounded-pill"><i class="bi bi-floppy fs-5"></i>Save</button>
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::edit modal-->

    <script>
        $("#kt_datatable_dom_positioning").DataTable({
            "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
	"language": {
		"lengthMenu": "Show _MENU_",
	},
	"dom":
		"<'row'" +
		"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
		"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
		">" +

		"<'table-responsive'tr>" +

		"<'row'" +
		"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
		"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
		">"
});
    </script>
</x-default-layout>
