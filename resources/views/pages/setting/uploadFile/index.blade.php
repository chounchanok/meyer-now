<x-default-layout>

    @section('title')
        {{ __('Upload Data') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.uploadFile.index') }}
    @endsection

    <!--begin::Row-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-12" style="display:none;">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            อัพโหลดข้อมูลพนักงาน
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- data-bs-toggle="modal" data-bs-target="#uploadFileAtdModal" -->
                    <form action="{{ url(Request::segment(1).'/import_employee') }}" method="post" enctype="multipart/form-data" id="importForm">
                    @csrf
                        <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_employee').click();">
                            <i class="bi bi-download fs-5"></i>
                            {{ __('Upload Data') }}
                        </button>
                        
                        <input type="file" class="d-none" name="excelFile_employee" id="excelFile_employee" accept=".xlsx, .xls" onchange="submitForm()">
                    </form>
                    <table id="kt_datatable_dom_positioning" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>No.</th>
                                <th>Import Date</th>
                                <th>File name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($files))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($files as $key => $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="uploadFile/{{ $item->id_file }}/detail">
                                        <button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" >
                                            <i class="ki-solid ki-eye fs-5 text-info"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        <div class="col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            {{__('Upload Attendance Data & Salary')}}
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- data-bs-toggle="modal" data-bs-target="#uploadFileAtdModal" -->
                    @can('upload upload evaluators')
                    <form action="{{ url(Request::segment(1).'/import_employee_attendance') }}" method="post" enctype="multipart/form-data" id="importForm_attendance">
                    @csrf
                        <div style="display: flex;align-items: center;justify-content: space-between;">
                            <div>
                                <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_employee_attendance').click();">
                                    <i class="bi bi-upload fs-5"></i>
                                    {{ __('Upload Data') }}
                                </button>
                                <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="export_excel();">
                                    <i class="bi bi-download fs-5"></i>
                                    Export Excel
                                </button>
                            </div>
                            <a href="{{ url('assets/Template Attendance & Salary upload.xlsx') }}" target="_blank">
                                <button type="button" class="btn btn-primary rounded-pill mb-3">
                                    <i class="bi bi-download fs-5"></i>
                                    Download Template Attendance & Salary
                                </button>
                            </a>
                            <!-- @if(trans(request()->segment(1)) == 'mtl')
                            <a href="{{ url('assets/Template Salary MTL.xlsx') }}" target="_blank">
                                <button type="button" class="btn btn-primary rounded-pill mb-3">
                                    <i class="bi bi-download fs-5"></i>
                                    Download Template Attendance & Salary
                                </button>
                            </a>
                            @endif -->
                        </div>
                        
                        
                        <input type="file" class="d-none" name="excelFile_employee_attendance" id="excelFile_employee_attendance" accept=".xlsx, .xls" onchange="submitForm_attendance()">
                    </form>
                    @endcan
                    <table id="kt_datatable_dom_positioning3" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>{{__('No.')}}</th>
                                <th>{{__('Import Date')}}</th>
                                <th>{{__('File name')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($files3))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($files3 as $key => $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="uploadFile/{{ $item->id }}/detail3">
                                        <button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" >
                                            <i class="ki-solid ki-eye fs-5 text-info"></i>
                                        </button>
                                    </a></td>
                            </tr>
                            
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        <div class="d-none col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            อัพโหลดข้อมูล Score PA
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- data-bs-toggle="modal" data-bs-target="#uploadFileAtdModal" -->
                    <form action="{{ url(Request::segment(1).'/import_employee_score_pa') }}" method="post" enctype="multipart/form-data" id="importForm_score_pa">
                    @csrf
                        <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_employee_score_pa').click();">
                            <i class="bi bi-download fs-5"></i>
                            {{ __('Upload Data') }}
                        </button>
                        <input type="file" class="d-none" name="excelFile_employee_score_pa" id="excelFile_employee_score_pa" accept=".xlsx, .xls" onchange="submitForm_score_pa()">
                    </form>
                    <table id="kt_datatable_dom_positioning4" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>No.</th>
                                <th>Import Date</th>
                                <th>File name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($files4))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($files4 as $key => $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td><a href="uploadFile/{{ $item->id }}/detail4"><button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" >
                                            <i class="ki-solid ki-eye fs-5 text-info"></i>
                                        </button></a></td>
                            </tr>
                            
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        <div class="d-none col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            {{__('Upload Evaluators Data')}}
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- data-bs-toggle="modal" data-bs-target="#uploadFileEvtModal" -->
                    @can('upload upload evaluators')
                    <form action="{{ url(Request::segment(1).'/import_employee_evt') }}" method="post" enctype="multipart/form-data" id="importForm_evt" class="mb-3">
                    @csrf
                        <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_employee_evt').click();">
                            <i class="bi bi-download fs-5"></i>
                            {{ __('Upload Data') }}
                        </button>
                        <button type="button" class="btn btn-light-info rounded-pill mb-3" onclick="printexcel()" style="float: right;border: 1px solid var(--bs-info);">
                            <i class="ki-solid ki-file-up fs-3 me-1"></i>
                            Export
                        </button>
                        <input type="file" class="d-none" name="excelFile_employee_evt" id="excelFile_employee_evt" accept=".xlsx, .xls" onchange="submitForm_evt()">
                    </form>
                    @endcan
                    <table id="kt_datatable_dom_positioning2" class="table table-striped gy-2 gs-5 rounded">
                        <thead class="table-light">
                            <tr class="fw-bold fs-6 text-gray-800 px-7">
                                <th>{{__('No.')}}</th>
                                <th>{{__('Import Date')}}</th>
                                <th>{{__('File name')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($files2))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($files2 as $key => $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td><a href="uploadFile/{{ $item->id }}/detail2"><button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" >
                                            <i class="ki-solid ki-eye fs-5 text-info"></i>
                                        </button></a></td>
                            </tr>
                            
                            @php 
                                $no++;
                            @endphp 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        
        <div class="d-none col-md-12">
            <div class="card h-xl-100">
                <!--begin::Header-->
                <div class="card-header">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="card-label fw-bold text-gray-800">
                            อัพโหลดข้อมูล PA ปีก่อนหน้า
                        </span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!-- data-bs-toggle="modal" data-bs-target="#uploadFileAtdModal" -->
                    <form action="{{ url(Request::segment(1).'/import_user') }}" method="post" enctype="multipart/form-data" id="importForm_user">
                    @csrf
                        <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_user').click();">
                            <i class="bi bi-download fs-5"></i>
                            {{ __('Upload Data') }}
                        </button>
                        <input type="file" class="d-none" name="excelFile_user" id="excelFile_user" accept=".xlsx, .xls" onchange="submitForm_user()">
                    </form>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        @if($orisoft_code)
            @if($orisoft_code == "000060" || $orisoft_code == "019492" || $orisoft_code == "990002")
            <div class="d-none col-md-12" >
                <div class="card h-xl-100">
                    <!--begin::Header-->
                    <div class="card-header">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-center flex-row mb-0">
                            <i class="ki-duotone ki-gear fs-1 text-primary me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="card-label fw-bold text-gray-800">
                                อัพโหลดข้อมูล Salary
                            </span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        <!-- data-bs-toggle="modal" data-bs-target="#uploadFileAtdModal" -->
                        <form action="{{ url(Request::segment(1).'/import_employee_salary') }}" method="post" enctype="multipart/form-data" id="importForm_salary">
                        @csrf
                            <div style="display: flex;align-items: center;justify-content: space-between;">
                                <button type="button" class="btn btn-primary rounded-pill mb-3" onclick="$('#excelFile_employee_salary').click();">
                                    <i class="bi bi-download fs-5"></i>
                                    {{ __('Upload Data') }}
                                </button>
                                <a href="{{ url('assets/Template Salary updated.xlsx') }}" target="_blank">
                                    <button type="button" class="btn btn-primary rounded-pill mb-3">
                                        <i class="bi bi-download fs-5"></i>
                                        Download Template Salary
                                    </button>
                                </a>
                            </div>
                            <input type="file" class="d-none" name="excelFile_employee_salary" id="excelFile_employee_salary" accept=".xlsx, .xls" onchange="submitForm_salary()">
                        </form>
                        <table id="kt_datatable_dom_positioning4" class="table table-striped gy-2 gs-5 rounded">
                            <thead class="table-light">
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th>No.</th>
                                    <th>Import Date</th>
                                    <th>File name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($files5))
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($files5 as $key => $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><a href="uploadFile/{{ $item->id }}/detail5"><button type="button" class="btn btn-icon btn-secondary text-dark btn-xs me-1" >
                                                <i class="ki-solid ki-eye fs-5 text-info"></i>
                                            </button></a></td>
                                </tr>
                                
                                @php 
                                    $no++;
                                @endphp 
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>
            @endif
        @endif
        
    </div>
    <!--end::Row-->
    <!--begin::Modal - Upload File attendance-->
    <div class="modal fade" id="uploadFileAtdModal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                {{-- <form class="form" action="none" id="kt_modal_upload_form"> --}}
                    <form action="{{ url(Request::segment(1).'/import_employee') }}" method="post" enctype="multipart/form-data" id="importForm">  @csrf
                    <!--begin::Modal header-->
                    <div class="modal-header py-5">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold mb-0">{{ __('Upload Data') }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1">
                            </i>close
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body pt-10 pb-15 px-lg-8">
                        <!--begin::Input group-->

                        <div class="form-group">
                            <!--begin::Dropzone-->
                            <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-4">

                                        <input type="file" name="excelFile_employee" id="excelFile_employee" accept=".xlsx, .xls" onchange="submitForm()">
                                        {{-- <a class="dropzone-select btn btn-sm btn-primary me-2">แนบไฟล์</a> --}}
                                        <a class="dropzone-upload btn btn-sm btn-light-primary me-2">อัพโหลดไฟล์ทั้งหมด</a>
                                        <a class="dropzone-remove-all btn btn-sm btn-light-danger">ลบทั้งหมด</a>

                                    </div>
                                    <!--end::Controls-->
                                    <!--begin::Items-->
                                    <div class="dropzone-items wm-200px">
                                        <div class="dropzone-item p-5" style="">
                                            <!--begin::File-->
                                            <div class="dropzone-file">
                                                <div class="dropzone-filename text-dark"
                                                    title="some_image_file_name.jpg">
                                                    <span data-dz-name="">some_image_file_name.jpg</span>
                                                    <strong>(<span data-dz-size="">340kb</span>)</strong>
                                                </div>
                                                <div class="dropzone-error mt-0" data-dz-errormessage=""></div>
                                            </div>
                                            <!--end::File-->
                                            <!--begin::Progress-->
                                            <div class="dropzone-progress">
                                                <div class="progress bg-gray-300">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                        aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"
                                                        data-dz-uploadprogress=""></div>
                                                </div>
                                            </div>
                                            <!--end::Progress-->
                                            <!--begin::Toolbar-->
                                            <div class="dropzone-toolbar">
                                                <span class="dropzone-start">
                                                    <i class="ki-duotone ki-to-right fs-1"></i>
                                                </span>
                                                <span class="dropzone-cancel" data-dz-remove=""
                                                    style="display: none;">
                                                    <i class="ki-duotone ki-cross fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                                <span class="dropzone-delete" data-dz-remove="">
                                                    <i class="ki-duotone ki-cross fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                    </div>
                                    <!--end::Items-->
                                </div>
                                <!--end::Dropzone-->
                                <!--begin::Hint-->
                                <span class="form-text fs-6 text-muted">Max file size is 1MB per file.</span>
                                <!--end::Hint-->
                            </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Modal body-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Upload File attendance-->
    <!--begin::Modal - Upload File evaluator-->
    <div class="modal fade" id="uploadFileEvtModal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="none" id="kt_modal_upload_form">
                    <!--begin::Modal header-->
                    <div class="modal-header py-5">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold mb-0">{{ __('Upload Data') }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1">
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body pt-10 pb-15 px-lg-8">
                        <!--begin::Input group-->
                        <div class="form-group">
                            <!--begin::Dropzone-->
                            <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                                <!--begin::Controls-->
                                <div class="dropzone-panel mb-4">
                                    <a class="dropzone-select btn btn-sm btn-primary me-2">แนบไฟล์</a>
                                    <a class="dropzone-upload btn btn-sm btn-light-primary me-2">อัพโหลดไฟล์ทั้งหมด</a>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-danger">ลบทั้งหมด</a>
                                </div>
                                <!--end::Controls-->
                                <!--begin::Items-->
                                <div class="dropzone-items wm-200px">
                                    <div class="dropzone-item p-5" style="display:none">
                                        <!--begin::File-->
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename text-dark" title="some_image_file_name.jpg">
                                                <span data-dz-name="">some_image_file_name.jpg</span>
                                                <strong>(
                                                    <span data-dz-size="">340kb</span>)</strong>
                                            </div>
                                            <div class="dropzone-error mt-0" data-dz-errormessage=""></div>
                                        </div>
                                        <!--end::File-->
                                        <!--begin::Progress-->
                                        <div class="dropzone-progress">
                                            <div class="progress bg-gray-300">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"
                                                    data-dz-uploadprogress=""></div>
                                            </div>
                                        </div>
                                        <!--end::Progress-->
                                        <!--begin::Toolbar-->
                                        <div class="dropzone-toolbar">
                                            <span class="dropzone-start">
                                                <i class="ki-duotone ki-to-right fs-1"></i>
                                            </span>
                                            <span class="dropzone-cancel" data-dz-remove="" style="display: none;">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="dropzone-delete" data-dz-remove="">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Dropzone-->
                            <!--begin::Hint-->
                            <span class="form-text fs-6 text-muted">Max file size is 1MB per file.</span>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Modal body-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Upload File evaluator-->
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                // loading();
                // setTimeout(function() {
                //     KTApp.hidePageLoading();
                // }, 3000);
                $('#kt_datatable_dom_positioning').DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-6'l>" +
                        "<'col-sm-6'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5'i>" +
                        "<'col-sm-12 col-md-7'p>" +
                        
                        ">"
                });
                $('#kt_datatable_dom_positioning2').DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-6'l>" +
                        "<'col-sm-6'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5'i>" +
                        "<'col-sm-12 col-md-7'p>" +
                        
                        ">"
                });
                $('#kt_datatable_dom_positioning3').DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-6'l>" +
                        "<'col-sm-6'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5'i>" +
                        "<'col-sm-12 col-md-7'p>" +
                        
                        ">"
                });
                $('#kt_datatable_dom_positioning4').DataTable({
                    "lengthMenu": [[100, 500, 1000,"All"], [100, 500, 1000, "All"]],
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom":
                        "<'row'" +
                        "<'col-sm-6'l>" +
                        "<'col-sm-6'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-12 col-md-5'i>" +
                        "<'col-sm-12 col-md-7'p>" +
                        
                        ">"
                });
            });
        </script>
    @endpush
    <script>
        function submitForm() {
            document.getElementById('importForm').submit();
            // var formData = new FormData($("#importForm")[0]);
            // console.log(formData)
            // if (document.getElementById("excelFile_employee").files.length == 0) {
            //     console.log("no files selected");
            // }
            // $('#importForm').submit();
            $('#uploadFileAtdModal').modal('hide')
            // loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function submitForm_evt() {
             document.getElementById('importForm_evt').submit();
            //  loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },

            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function submitForm_attendance() {
             document.getElementById('importForm_attendance').submit();
            //  loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },

            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function submitForm_score_pa() {
             document.getElementById('importForm_score_pa').submit();
            //  loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },

            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function submitForm_salary() {
             document.getElementById('importForm_salary').submit();
            //  loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },

            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function submitForm_user() {
             document.getElementById('importForm_user').submit();
            //  loading();
            Swal.fire({
                title: "กำลังอัพโหลดไฟล์",
                html: "กรุณารอจนกว่าระบบจะ Refresh",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },

            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                    // loading_hide();
                }
            });
        }
        function printexcel(){
            window.location.href = "{{ url(Request::segment(1).'/eva_excel') }}";
        }
        function loading(){
            KTApp.showPageLoading();
        }
        function loading_hide(){
            KTApp.hidePageLoading();
        }
        async function export_excel() {
            try {
                const inputValue = new Date().getFullYear() - 1;
                const { value: year } = await Swal.fire({
                title: "ระบุปี ค.ศ. เช่น 2024",
                input: "text",
                inputValue,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                    return "You need to write something!";
                    }
                }
                });
                if (year) {
                    await Swal.fire(`กรุณารอจนกว่าจะโหลดข้อมูลเสร็จ`);
                    window.location.href = `{{ url(Request::segment(1).'/export_excel_attendance/') }}?year=${year}`;
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    </script>
</x-default-layout>
