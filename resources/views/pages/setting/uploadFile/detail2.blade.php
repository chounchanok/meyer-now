<x-default-layout>

    @section('title')
        {{__('History Import')}}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('setting.uploadFile.detail2') }}
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
                    <h3 class="card-title align-items-center flex-row mb-0">
                        <img src="{{ image('icons/icon-attendance.svg') }}" class="pointer">
                        <span class="card-label fw-bold text-gray-800">
                            {{__('History Import')}}
                        </span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <div class="table-responsive" style="position: relative;">
                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 rounded">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                    <th>Employee no</th>
                                    <th>EMPLOYEE LOCAL NAME</th>
                                    <th>Approved PA Score Final by No</th>
                                    <th>Approved PA Score Final by Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($datarow))
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($datarow as $key => $item)
                            <tr>
                                <td>{{ $item->employee_no }}</td>
                                <td>{{ $item->name1 }}</td>
                                <td>{{ $item->approve_pa_score_by }}</td>
                                <td>{{ $item->name2 }}</td>
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
    @push('scripts')
    <script type="text/javascript">
            $(document).ready(function() {
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
            });
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
