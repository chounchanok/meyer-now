<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if (Auth::user()->profile_photo_url)
                    <img alt="Logo" src="{{ Auth::user()->profile_photo_url }}" />
                @else
                    <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <!-- <div class="menu-item px-5">
        <a href="#" class="menu-link px-5">{{ __('My Profile') }}</a>
    </div> -->
    <!--end::Menu item-->
    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->
    <!--begin::Menu item-->
    <div class="menu-item px-5" style="display:none;" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">{{ __('Mode') }}
                <span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!} {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
        </a>
        @include('partials/theme-mode/__menu')
    </div>
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">{{ __('Language') }}
                <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ App::isLocale('th') ? 'ไทย' : 'English' }}
                    <img class="w-15px h-15px rounded-1 ms-2" src="{{ App::isLocale('en') ? image('flags/united-states.svg') : image('flags/thailand.svg') }}" alt="" /></span>
            </span>
        </a>
        <!--begin::Menu sub-->
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ url('/' . \Request::segment(1) . '/locale/th') }}" class="menu-link d-flex px-5 {{ App::isLocale('th') ? 'active' : '' }}">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/thailand.svg') }}" alt="" />
                    </span>
                    ไทย</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="{{ url('/' . \Request::segment(1) . '/locale/en') }}" class="menu-link d-flex px-5 {{ App::isLocale('en') ? 'active' : '' }}">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/united-states.svg') }}" alt="" />
                    </span>
                    English</a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu sub-->
    </div>

    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">User Manuals (PDF)</span>
        </a>
        <!--begin::Menu sub-->
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            <?php 
                $datauserEVNoEmail = DB::table('users')
                ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
                ->first();
                $datauserMG = 0;
                if($datauserEVNoEmail->email){
                    $datauserMG = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '6')
                            ->orWhere('users_model_has_roles.role_id', '8');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    
                    $datauserEV = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะผู้ใช้ที่ล็อกอิน
                    ->where('users_model_has_roles.role_id', '8') // role_id = 8
                    ->where('users_model_has_roles.role_id', '!=', '6') // role_id != 6
                    ->count();
                }else{
                    $datauserEV = 1;
                }
                $datauserHR = DB::table('users')
                ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
                ->whereIn('users_model_has_roles.role_id', [3, 4, 5]) // ตรวจสอบ role_id ว่าตรงกับ 3, 4 หรือ 5
                ->count();

                

                

                $datauserGMDM = DB::table('users')
                ->leftJoin('users_model_has_roles','users_model_has_roles.model_id','=','users.id')
                ->where('role_id','7')
                ->where('id',Auth::user()->id)->count();
                if($datauserHR > 0){
                    $url = url('assets/User-Manuals-(HR).pdf');
                }else{
                    if($datauserGMDM > 0){
                        if(App::isLocale('th')){
                            $url = url('assets/User-Manuals-(GM-DM).pdf');
                        }else{
                            $url = url('assets/User-Manuals-(GM-DM) - EN.pdf');
                        }
                    }else{
                        if($datauserMG > 0){
                            $url = url('assets/User-Manuals-(Manager).pdf');
                        }else{
                            $url = url('assets/User-Manuals-(Evaluator).pdf');
                        }
                    }
                }

                $datauserAdmin = DB::table('users')
                ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                ->where(function ($query) {
                    $query->where('users_model_has_roles.role_id', '2');
                })
                ->where('users.id', Auth::user()->id)
                ->count();
                if($datauserAdmin > 0){
                    $datauserHRManager = 1;
                    $datauserHRAssistant = 1;
                    $datauserG2PS = 1;
                    $datauserDeptManager = 1;
                    $datauserTopManagement = 1;
                    $datauserEvaluator = 1;
                }else{
                    $datauserHRManager = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '3');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    $datauserHRAssistant = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '4');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    $datauserG2PS = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '5');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    $datauserDeptManager = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '6');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    $datauserTopManagement = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '7');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                    $datauserEvaluator = DB::table('users')
                    ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                    ->where(function ($query) {
                        $query->where('users_model_has_roles.role_id', '8');
                    })
                    ->where('users.id', Auth::user()->id)
                    ->count();
                }
            ?>
            @if($datauserAdmin > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Admin).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - Admin</a>
                </div>
            @endif
            @if($datauserHRManager > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR Manager).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - HR Manager</a>
                </div>
            @endif
            @if($datauserHRAssistant > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR Assistant).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - HR Assistant</a>
                </div>
            @endif
            @if($datauserG2PS > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR G2PS).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - HR-G2PS</a>
                </div>
            @endif
            @if($datauserDeptManager > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Manager).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - Dept.Manager</a>
                </div>
            @endif
            @if($datauserTopManagement > 0)
                @if(App::isLocale('th'))
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(GM-DM).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - Top Management</a>
                </div>
                @else
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(GM-DM) - EN.pdf') }}" target="_blank" class="menu-link px-5">User Manuals - Top Management</a>
                </div>
                @endif
            @endif
            @if($datauserEvaluator > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Evaluator).pdf') }}" target="_blank" class="menu-link px-5">User Manuals - Evaluator</a>
                </div>
            @endif
        </div>
        <!--end::Menu sub-->
    </div>









    <?php 
        $datauserEVNoEmail = DB::table('users')
        ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
        ->first();
        $datauserMG = 0;
        if($datauserEVNoEmail->email){
            $datauserMG = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '6')
                    ->orWhere('users_model_has_roles.role_id', '8');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            
            $datauserEV = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะผู้ใช้ที่ล็อกอิน
            ->where('users_model_has_roles.role_id', '8') // role_id = 8
            ->where('users_model_has_roles.role_id', '!=', '6') // role_id != 6
            ->count();
        }else{
            $datauserEV = 1;
        }
        $datauserHR = DB::table('users')
        ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
        ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
        ->whereIn('users_model_has_roles.role_id', [3, 4, 5]) // ตรวจสอบ role_id ว่าตรงกับ 3, 4 หรือ 5
        ->count();

        

        

        $datauserGMDM = DB::table('users')
        ->leftJoin('users_model_has_roles','users_model_has_roles.model_id','=','users.id')
        ->where('role_id','7')
        ->where('id',Auth::user()->id)->count();
        if($datauserHR > 0){
            $url = url('assets/User-Manuals-(HR).pdf');
        }else{
            if($datauserGMDM > 0){
                if(App::isLocale('th')){
                    $url = url('assets/User-Manuals-(GM-DM).pdf');
                }else{
                    $url = url('assets/User-Manuals-(GM-DM) - EN.pdf');
                }
            }else{
                if($datauserMG > 0){
                    $url = url('assets/User-Manuals-(Manager).pdf');
                }else{
                    $url = url('assets/User-Manuals-(Evaluator).pdf');
                }
            }
        }

        $datauserAdmin = DB::table('users')
        ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
        ->where(function ($query) {
            $query->where('users_model_has_roles.role_id', '2');
        })
        ->where('users.id', Auth::user()->id)
        ->count();
        if($datauserAdmin > 0){
            $datauserHRManager = 1;
            $datauserHRAssistant = 1;
            $datauserG2PS = 1;
            $datauserDeptManager = 1;
            $datauserTopManagement = 1;
            $datauserEvaluator = 1;
        }else{
            $datauserHRManager = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '3');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            $datauserHRAssistant = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '4');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            $datauserG2PS = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '5');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            $datauserDeptManager = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '6');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            $datauserTopManagement = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '7');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
            $datauserEvaluator = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('users_model_has_roles.role_id', '8');
            })
            ->where('users.id', Auth::user()->id)
            ->count();
        }
    ?>
    @if($datauserAdmin > 0)
    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">User Manuals (Word)</span>
        </a>
        <!--begin::Menu sub-->
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            @if($datauserAdmin > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Admin).docx') }}" target="_blank" class="menu-link px-5">User Manuals - Admin</a>
                </div>
            @endif
            @if($datauserHRManager > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR Manager).docx') }}" target="_blank" class="menu-link px-5">User Manuals - HR Manager</a>
                </div>
            @endif
            @if($datauserHRAssistant > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR Assistant).docx') }}" target="_blank" class="menu-link px-5">User Manuals - HR Assistant</a>
                </div>
            @endif
            @if($datauserG2PS > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(HR G2PS).docx') }}" target="_blank" class="menu-link px-5">User Manuals - HR-G2PS</a>
                </div>
            @endif
            @if($datauserDeptManager > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Manager).docx') }}" target="_blank" class="menu-link px-5">User Manuals - Dept.Manager</a>
                </div>
            @endif
            @if($datauserTopManagement > 0)
                @if(App::isLocale('th'))
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(GM-DM).docx') }}" target="_blank" class="menu-link px-5">User Manuals - Top Management</a>
                </div>
                @else
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(GM-DM) - EN.docx') }}" target="_blank" class="menu-link px-5">User Manuals - Top Management</a>
                </div>
                @endif
            @endif
            @if($datauserEvaluator > 0)
                <div class="menu-item px-3">
                    <a href="{{ url('assets/User-Manuals-(Evaluator).docx') }}" target="_blank" class="menu-link px-5">User Manuals - Evaluator</a>
                </div>
            @endif
        </div>
        <!--end::Menu sub-->
    </div>
    @endif
    <!--end::Menu item-->
    <!-- <div class="menu-item px-5 my-1">
        <?php 
            $datauserEVNoEmail = DB::table('users')
            ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
            ->first();
            $datauserMG = 0;
            if($datauserEVNoEmail->email){
                $datauserMG = DB::table('users')
                ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                ->where(function ($query) {
                    $query->where('users_model_has_roles.role_id', '6')
                        ->orWhere('users_model_has_roles.role_id', '8');
                })
                ->where('users.id', Auth::user()->id)
                ->count();
                
                $datauserEV = DB::table('users')
                ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
                ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะผู้ใช้ที่ล็อกอิน
                ->where('users_model_has_roles.role_id', '8') // role_id = 8
                ->where('users_model_has_roles.role_id', '!=', '6') // role_id != 6
                ->count();
            }else{
                $datauserEV = 1;
            }
            $datauserHR = DB::table('users')
            ->leftJoin('users_model_has_roles', 'users_model_has_roles.model_id', '=', 'users.id')
            ->where('users.id', Auth::user()->id) // ตรวจสอบเฉพาะ user ที่ล็อกอิน
            ->whereIn('users_model_has_roles.role_id', [3, 4, 5]) // ตรวจสอบ role_id ว่าตรงกับ 3, 4 หรือ 5
            ->count();

            

            

            $datauserGMDM = DB::table('users')
            ->leftJoin('users_model_has_roles','users_model_has_roles.model_id','=','users.id')
            ->where('role_id','7')
            ->where('id',Auth::user()->id)->count();
            if($datauserHR > 0){
                $url = url('assets/User-Manuals-(HR).pdf');
            }else{
                if($datauserGMDM > 0){
                    if(App::isLocale('th')){
                        $url = url('assets/User-Manuals-(GM-DM).pdf');
                    }else{
                        $url = url('assets/User-Manuals-(GM-DM) - EN.pdf');
                    }
                }else{
                    if($datauserMG > 0){
                        $url = url('assets/User-Manuals-(Manager).pdf');
                    }else{
                        $url = url('assets/User-Manuals-(Evaluator).pdf');
                    }
                }
            }
        ?>
        <a href="{{ $url }}" target="_blank" class="menu-link px-5">User Manuals</a>
    </div> -->
    <!--begin::Menu item-->
    <div class="menu-item px-5 my-1">
        <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#kt_modal_update_password" onclick="setcss();">{{ __('Change Password') }}</a>
    </div>
    
    <!--end::Menu item-->
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('meyer.logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true">
            {{ __('Sign Out') }}
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->

<div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Update Password</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_update_password_form" class="form" action="#">
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10">
                        <label class="required form-label fs-6 mb-2">Current Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="current_password" name="current_password" autocomplete="off" />
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <!--begin::Wrapper-->
                        <div class="mb-1">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold fs-6 mb-2">New Password</label>
                            <!--end::Label-->
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="new_password" name="new_password" autocomplete="off" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    <i class="ki-duotone ki-eye d-none fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--end::Meter-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Hint-->
                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-10">
                        <label class="form-label fw-semibold fs-6 mb-2">Confirm New Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="confirm_password" name="confirm_password" autocomplete="off" />
                    </div>
                    <!--end::Input group=-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                        <button type="button" class="btn btn-primary" onclick="check_current_password();">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<script>
    function setcss() {
        $('.modal-backdrop').css('position', 'unset');
    }

    function check_current_password() {
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1) . '/check_current_password_header') }}',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                "current_password": $('#current_password').val()
            },
            success: function(result) {
                if ($('#current_password').val() == '') {
                    Swal.fire({
                        title: "Current password is required",
                        text: "",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                } else {
                    if (result.check == false) {
                        Swal.fire({
                            title: "Current password ไม่ถูกต้อง",
                            text: "",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    } else {
                        if ($('#new_password').val() == '') {
                            Swal.fire({
                                title: "The password is required",
                                text: "",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        } else {
                            if ($('#confirm_password').val() == '') {
                                Swal.fire({
                                    title: "The password confirmation is required",
                                    text: "",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            } else {
                                if ($('#new_password').val() != $('#confirm_password').val()) {
                                    Swal.fire({
                                        title: "The password and its confirm are not the same",
                                        text: "",
                                        icon: "warning",
                                        allowOutsideClick: false,
                                    });
                                } else {
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
                                                url: '{{ url(Request::segment(1) . '/change_password_header') }}',
                                                dataType: 'json',
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    "new_password": $('#new_password').val()
                                                },
                                                success: function(result) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: "Success",
                                                        html: "I will close in <b></b> milliseconds.",
                                                        timer: 1500,
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
                            }
                        }
                    }
                }
            }
        });
    }
</script>
