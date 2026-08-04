<x-default-layout>

    @section('title')
        Users
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.show', $user) }}
    @endsection

    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Summary-->
                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <input type="hidden" id="get_user_id" value="{{$user->id}}">
                            @if ($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" alt="image" />
                            @else
                                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name) }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->name }}</a>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="mb-9">
                            @foreach ($user->roles as $role)
                                <!--begin::Badge-->
                                <div class="badge badge-lg badge-light-primary d-inline">{{ ucwords($role->name) }}</div>
                                <!--begin::Badge-->
                            @endforeach
                        </div>
                        <!--end::Position-->
                        <!--begin::Info-
                        <!--end::Info-->
                    </div>
                    <!--end::User Info-->
                    <!--end::Summary-->
                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                        {{-- <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">{{__('Edit')}}</a>
                        </span> --}}
                    </div>
                    <!--end::Details toggle-->
                    <div class="separator"></div>
                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">{{__('Account Code')}}</div>
                            <div class="text-gray-600">{{($user->orisoft_code?$user->orisoft_code:'-')}}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">{{__('Email')}}</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{$user->email}}</a>
                            </div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <!-- <div class="fw-bold mt-5">Address</div>
                            <div class="text-gray-600">101 Collin Street,
                                <br />Melbourne 3000 VIC
                                <br />Australia
                            </div> -->
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <!-- <div class="fw-bold mt-5">Language</div>
                            <div class="text-gray-600">English</div> -->
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">{{__('Last Login')}}</div>
                            <div class="text-gray-600">{{($user->last_login_at?$user->last_login_at:'-')}}</div>
                            <!--begin::Details item-->
                        </div>
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->









        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Overview</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                {{-- <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_events_and_logs_tab">Events & Logs</a>
                </li> --}}
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_security" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Profile</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>{{__('Email')}}</td>
                                            <td>{{$user->email}}</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        @php
                                            $check_user_id = Auth::user()->id;
                                        @endphp
                                        @if($user->id == $check_user_id)
                                        <tr>
                                            <td>Password</td>
                                            <td>
                                                <input type="password" class="form-control" value="{{$user->password}}" disabled>
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password" onclick="setcss();">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @if(Auth::user()->orisoft_code == '019492' || Auth::user()->orisoft_code == '000060' || Auth::user()->orisoft_code == '990002')
                                        <tr>
                                            <td>Reset Password</td>
                                            <td>
                                                <input type="hidden" id="hidden_user_id" value="{{$user->id}}">
                                                <button type="button" class="btn btn-success rounded-pill" onclick="reset_password();"><i class="bi bi-floppy fs-5"></i>Reset</button>
                                            </td>
                                            <td class="text-end">
                                                
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Role</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <div class="badge badge-lg badge-light-primary d-inline">{{ ucwords($role->name) }}</div>
                                                @endforeach
                                            </td>
                                            <td class="text-end"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Login Sessions</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Filter-->
                                <button type="button" class="btn btn-sm btn-flex btn-light-primary" id="kt_modal_sign_out_sesions">
                                    <i class="ki-duotone ki-entrance-right fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Sign out all sessions</button>
                                <!--end::Filter-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">Location</th>
                                            <th>Device</th>
                                            <th>IP Address</th>
                                            <th class="min-w-125px">Time</th>
                                            <th class="min-w-70px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>Australia</td>
                                            <td>Chome - Windows</td>
                                            <td>207.20.21.295</td>
                                            <td>23 seconds ago</td>
                                            <td>Current session</td>
                                        </tr>
                                        <tr>
                                            <td>Australia</td>
                                            <td>Safari - iOS</td>
                                            <td>207.15.21.72</td>
                                            <td>3 days ago</td>
                                            <td>
                                                <a href="#" data-kt-users-sign-out="single_user">Sign out</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Australia</td>
                                            <td>Chrome - Windows</td>
                                            <td>207.10.28.325</td>
                                            <td>last week</td>
                                            <td>Expired</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Logs</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-cloud-download fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Download Report</button>
                                <!--end::Button-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body py-0">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="kt_table_users_logs">
                                    <tbody>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-danger">500 ERR</div>
                                            </td>
                                            <td>POST /v1/invoice/in_6877_1633/invalid</td>
                                            <td class="pe-0 text-end min-w-200px">22 Sep 2023, 6:05 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-danger">500 ERR</div>
                                            </td>
                                            <td>POST /v1/invoice/in_6877_1633/invalid</td>
                                            <td class="pe-0 text-end min-w-200px">25 Oct 2023, 11:30 am</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-success">200 OK</div>
                                            </td>
                                            <td>POST /v1/invoices/in_5648_7203/payment</td>
                                            <td class="pe-0 text-end min-w-200px">15 Apr 2023, 6:43 am</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-danger">500 ERR</div>
                                            </td>
                                            <td>POST /v1/invoice/in_6877_1633/invalid</td>
                                            <td class="pe-0 text-end min-w-200px">25 Oct 2023, 8:43 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="min-w-70px">
                                                <div class="badge badge-light-success">200 OK</div>
                                            </td>
                                            <td>POST /v1/invoices/in_1431_5657/payment</td>
                                            <td class="pe-0 text-end min-w-200px">21 Feb 2023, 11:05 am</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Events</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Button-->
                                <button type="button" class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-cloud-download fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Download Report</button>
                                <!--end::Button-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body py-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-semibold gy-5" id="kt_table_customers_events">
                                <tbody>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Melody Macy</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">10 Mar 2023, 5:30 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#SEP-45656</a>status has changed from
                                            <span class="badge badge-light-warning me-1">Pending</span>to
                                            <span class="badge badge-light-info">In Progress</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2023, 5:30 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Max Smith</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#SDK-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">10 Mar 2023, 11:30 am</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Brian Cox</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2023, 11:05 am</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Melody Macy</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2023, 6:43 am</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#LOP-45640</a>has been
                                            <span class="badge badge-light-danger">Declined</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2023, 5:30 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#SEP-45656</a>status has changed from
                                            <span class="badge badge-light-warning me-1">Pending</span>to
                                            <span class="badge badge-light-info">In Progress</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">21 Feb 2023, 8:43 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary me-1">#DER-45645</a>status has changed from
                                            <span class="badge badge-light-info me-1">In Progress</span>to
                                            <span class="badge badge-light-primary">In Transit</span>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">25 Jul 2023, 10:10 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Brian Cox</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#OLP-45690</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2023, 9:23 pm</td>
                                    </tr>
                                    <tr>
                                        <td class="min-w-400px">
                                            <a href="#" class="text-gray-600 text-hover-primary me-1">Melody Macy</a>has made payment to
                                            <a href="#" class="fw-bold text-gray-900 text-hover-primary">#XRS-45670</a>
                                        </td>
                                        <td class="pe-0 text-gray-600 text-end min-w-200px">25 Oct 2023, 11:30 am</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
    <!--begin::Modals-->
    <!--begin::Modal - Update user details-->
    @include('pages.apps/user-management/users/modals/_update-details')
    <!--end::Modal - Update user details-->
    <!--begin::Modal - Add schedule-->
    @include('pages.apps/user-management/users/modals/_add-schedule')
    <!--end::Modal - Add schedule-->
    <!--begin::Modal - Add one time password-->
    @include('pages.apps/user-management/users/modals/_add-one-time-password')
    <!--end::Modal - Add one time password-->
    <!--begin::Modal - Update email-->
    @include('pages.apps/user-management/users/modals/_update-email')
    <!--end::Modal - Update email-->
    <!--begin::Modal - Update password-->
    @include('pages.apps/user-management/users/modals/_update-password')
    <!--end::Modal - Update password-->
    <!--begin::Modal - Update role-->
    @include('pages.apps/user-management/users/modals/_update-role')
    <!--end::Modal - Update role-->
    <!--begin::Modal - Add auth app-->
    @include('pages.apps/user-management/users/modals/_add-auth-app')
    <!--end::Modal - Add auth app-->
    <!--begin::Modal - Add task-->
    @include('pages.apps/user-management/users/modals/_add-task')
    <!--end::Modal - Add task-->
    <!--end::Modals-->
</x-default-layout>
<script>
    function setcss(){
        $('.modal-backdrop').css('position','unset');
    }
    function reset_password(){
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
                    type: 'POST',
                    url: '{{ url(Request::segment(1)."/reset_password") }}',
                    dataType: 'json',
                    data : { 
                        "_token": "{{ csrf_token() }}",
                        "id":$('#hidden_user_id').val(),
                    },
                    success: function (result) { 
                        Swal.fire({
                            title: "Reset Success",
                            text: "",
                            icon: "success",
                            allowOutsideClick: false,
                        });
                    }
                });
            }
        });
    }
</script>