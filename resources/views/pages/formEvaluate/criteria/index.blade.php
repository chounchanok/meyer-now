<x-default-layout>

    @section('title')
        {{ __('Create Evaluation Criteria') }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('formEvaluate.criteria.index') }}
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
                        {{ __('Create Evaluation Criteria') }}
                    </span>
                    </h3>
                    <!--end::Title-->
                    <div class="d-flex align-items-center flex-row mb-0">
                    @can('create evaluation criteria')
                    <button type="button" class="btn btn-primary justify-content-end rounded-pill" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="adddata();"><i class="bi bi-plus fs-5"></i>Add Title</button>
                    @endcan
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">

                    <div class="table-responsive" style="position: relative;">
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th class="align-middle">{{__('No.')}}</th>
                                    <th>{{__('Title')}} (Thai)</th>
                                    <th>{{__('Title')}} (English)</th>
                                    <th>{{__('Create Date')}}</th>
                                    <th class="text-center">{{__('Status')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($datarow))
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($datarow as $key => $item)
                                <tr>
                                    <td>{{ $no }}.</td>
                                    <td>{{ $item->title_th }}</td>
                                    <td>{{ $item->title_en }}</td>
                                    <td>{{ $item->created }}</td>
                                    <td>
                                        <div style="display: flex;align-items: center;justify-content: center;">
                                            <div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
                                                @php 
                                                    $check = '';
                                                    $checkActive = 'InActive';
                                                    $checkbgcolor = 'background-color: #FFF5F8;';
                                                    $checkcolor = 'color: #F1416C;';
                                                    if($item->criteria_active==1){
                                                        $check = 'checked="checked"';
                                                        $checkActive = 'Active';
                                                        $checkbgcolor = 'background-color: #E8FFF3;';
                                                        $checkcolor = 'color: #50CD89;';
                                                    }
                                                @endphp
                                                <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault{{ $item->id }}" {{$check}}  onchange="changeactive('{{ $item->id }}');"/>
                                            </div>
                                            <div class="flex-center-new " style="border-radius: 4px;width: 74px;height: 15px;{{$checkbgcolor}}">
                                                <span style="{{$checkcolor}}">{{$checkActive}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @can('edit evaluation criteria')
                                        <button type="button" class="btn btn-icon btn-warning text-dark btn-xs me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="criteria_getdata('{{$item->id}}')">
                                            <i class="ki-solid ki-pencil fs-5"></i>
                                        </button>
                                        @endcan
                                        <!-- <button type="button" class="btn btn-icon btn-danger text-dark btn-xs me-1" onclick="criteria_del('{{$item->id}}')">
                                            <i class="ki-solid ki-tablet-delete "></i>
                                        </button> -->
                                        <!-- <img src="{{ image('icons/edit.svg') }}" class="pointer" data-bs-toggle="modal" data-bs-target="#kt_modal_1" onclick="criteria_getdata('{{$item->id}}')">
                                        <img src="{{ image('icons/icon-del.svg') }}" class="pointer" onclick="criteria_del('{{$item->id}}')"> -->
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
                </div>
                <!--end: Card Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Title</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="card-body hover-scroll-overlay-y">
                        <div class="mb-3">
                            <label class="form-label">Title (Thai)</label>
                            <input type="text" class="form-control" id="title_th" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title (English)</label>
                            <input type="text" class="form-control" id="title_en" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="criteria_addedit();">Save</button>
                    <input type="hidden" id="criteria_id" value="">
                </div>
            </div>
        </div>
    </div>

    <!--begin::add modal-->
    
    <!--end::add modal-->

    @push('scripts')
        <script type="text/javascript">
            loading();
            setTimeout(function() {
                KTApp.hidePageLoading();
            }, 3000);
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
            function adddata(){
                $('#criteria_id').val('');
                $('#title_th').val('');
                $('#title_en').val('');
            }
            function criteria_addedit(){
                if($('#title_th').val() == ''){
                    Swal.fire(
                    'warning!',
                        'หัวข้อ (ภาษาไทย) is required!',
                        'warning'
                    );
                }else{
                    if($('#title_en').val() == ''){
                        Swal.fire(
                        'warning!',
                            'Title (English) is required!',
                            'warning'
                        );
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1)."/criteria_addedit") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                id:$('#criteria_id').val(),
                                title_th:$('#title_th').val(),
                                title_en:$('#title_en').val()
                            },
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
                                        window.location.reload();
                                    }
                                });
                            }
                        });
                    }
                }
            }
            function criteria_getdata(id){
                $.ajax({
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/criteria_getdata") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        id:id
                    },
                    success: function (result) { 
                        $('#criteria_id').val(result.id);
                        $('#title_th').val(result.title_th);
                        $('#title_en').val(result.title_en);
                        $('#addList').click();
                    }
                });
            }
            function criteria_del(id){
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
                            url: '{{ url(Request::segment(1)."/criteria_del") }}',
                            dataType: 'json',
                            data : { 
                                "_token": "{{ csrf_token() }}",
                                id:id
                            },
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
                                        window.location.reload();
                                    }
                                }); 
                            }
                        });
                    }
                });
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
                            url: '{{ url(Request::segment(1)."/criteria_changeactive") }}',
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
                                        window.location.reload();
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
        div.dataTables_scrollBody{
            border-left:0px solid #ddd !important
        }
    </style>
</x-default-layout>
