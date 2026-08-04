<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            @php
                $percent_department_count = DB::table('tb_percent_department_action')
                ->leftJoin('tb_percent_department','tb_percent_department.id','=','tb_percent_department_action.percent_department_id')
                ->where('tb_percent_department.year','like','%'.date('Y').'%')
                ->where('tb_percent_department_action.approve_by2', Auth::user()->orisoft_code )
                ->count();
            @endphp
            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item pt-5">
                <!--begin:Menu content-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7 " style="color:white !important;">PAGES:Zoom </span>
                    <button type="button" onclick="zoomIn()">+</button>
                    <button type="button" onclick="zoomOut()">-</button>
                    <button type="button" onclick="zoomReset()">
                        <i class="ki-duotone ki-arrows-circle" style="color:black;">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        </i>
                    </button>
                    <!-- <select class="form-select" id="search_yearx" name="search_yearx" data-placeholder="-เลือกปี-" onchange="set_session(this.value);">
                        @php
                            $search_yearx = DB::table('tb_employee_final_score')
                            ->select('tb_employee_final_score.rec_year')
                            ->groupBy('tb_employee_final_score.rec_year')->orderBy('tb_employee_final_score.rec_year', 'DESC')->get();
                            $search_year_check = session('search_year');
                        @endphp
                        @if(!empty($search_yearx))
                        @foreach ($search_yearx as $key => $val)
                        <option value="{{$val->rec_year}}" {{($search_year_check==$val->rec_year?'selected':'')}}>{{$val->rec_year}}</option>
                        @endforeach
                        @endif
                    </select> -->
                </div>
                <!--end:Menu content-->
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item PA timeline-->
            @canany(['view pa timeline history', 'view task status tracking'])
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('meyer.pa.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('calendar', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('PA timeline') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    @can('view pa timeline history')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.pa.timeline.*') ? 'active' : '' }}" href="{{ route('meyer.pa.timeline.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('PA Timeline History') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view task status tracking')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.pa.follow.*') ? 'active' : '' }}" href="{{ route('meyer.pa.follow.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Task Status Tracking') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            @endcanany
            <!--end:Menu item-->

            <!--begin:Menu item ฟอร์มประเมิน-->
            @canany(['view evaluation criteria', 'view pa form groups'])
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('meyer.formEvaluate.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('element-12', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('PA Form') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    @can('view evaluation criteria')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.formEvaluate.criteria.*') ? 'active' : '' }}" href="{{ route('meyer.formEvaluate.criteria.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Create Evaluation Criteria') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view pa form groups')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.formEvaluate.groupForm.*') ? 'active' : '' }}" href="{{ route('meyer.formEvaluate.groupForm.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Create PA Form Groups') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            @endcanany
            <!--end:Menu item-->
            


            

            <!--begin:Menu item ตั้งค่า-->
            @canany(['view upload evaluators', 'view set budget', 'view set pa grades', 'view set increase', 'view employee'])
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('meyer.setting.*') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('gear', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Settings') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    @can('view upload evaluators')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.uploadFile.*') ? 'active' : '' }}" href="{{ route('meyer.setting.uploadFile.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Upload Evaluators and Attendance Data') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view set budget')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.manageBudget.*') ? 'active' : '' }}" href="{{ route('meyer.setting.manageBudget.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Set Budget') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view set pa grades')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.manageGrade.*') ? 'active' : '' }}" href="{{ route('meyer.setting.manageGrade.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Set PA Grades') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view set increase')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.manageDepartment.*') ? 'active' : '' }}" href="{{ route('meyer.setting.manageDepartment.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Set %Increase by Dept.') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    @can('view employee')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.manageEmployee.*') ? 'active' : '' }}" href="{{ route('meyer.setting.manageEmployee.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Employee Data Management') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan

                    @can('view employee')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setting.maintain.*') ? 'active' : '' }}" href="{{ route('meyer.setting.maintain.index') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Maintain Employee') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->







                    <!--begin:Menu item-->
                    @canany(['view users', 'view roles', 'view permissions'])
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('meyer.user-management.*') ? 'here show' : '' }}">
                            <!--begin:Menu link-->
                            <span class="menu-link">
                                <span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
                                <span class="menu-title" style="color:white !important;">{{ __('User Management') }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion">
                                <!--begin:Menu item-->
                                @can('view users')
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('meyer.user-management.users.*') ? 'active' : '' }}" href="{{ route('meyer.user-management.users.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title" style="color:white !important;">Users</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                @can('view roles')
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('meyer.user-management.roles.*') ? 'active' : '' }}" href="{{ route('meyer.user-management.roles.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title" style="color:white !important;">{{ __('Roles') }}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                @can('view permissions')
                                    <div class="menu-item">
                                        <!--begin:Menu link-->
                                        <a class="menu-link {{ request()->routeIs('meyer.user-management.permissions.*') ? 'active' : '' }}" href="{{ route('meyer.user-management.permissions.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title" style="color:white !important;">{{ __('Permissions') }}</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                    @endcanany
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            @endcanany
            <!--end:Menu item-->

            

            

            <!--begin:Menu item กำหนดการประเมิน-->
            @canany(['view review evaluate employees', 'view set evaluators pa form'])
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <span class="menu-link ">
                    <span class="menu-icon">{!! getIcon('notepad-edit', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Evaluation Schedule') }}</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item ตรวจสอบรายชื่อพนักงานผู้ถูกประเมิน-->
                    @can('view review evaluate employees')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.ListEvaluator') ? 'active' : '' }}" href="{{ route('meyer.ListEvaluator') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Review Lists of Evaluated Employees') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                    <!--begin:Menu item กำหนดผู้ประเมิน และฟอร์มการประเมิน-->
                    @can('view set evaluators pa form')
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->routeIs('meyer.setEvaluator') ? 'active' : '' }}" href="{{ route('meyer.setEvaluator') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title" style="color:white !important;">{{ __('Set Evaluators and PA Forms') }}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    @endcan
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            @endcanany
            <!--end:Menu item-->

            <!--begin:Menu item ประเมินผลพนักงาน-->
            @can('view evaluate employees')
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.evaluate') ? 'active' : '' }}" href="{{ route('meyer.evaluate') }}">
                    <span class="menu-icon">{!! getIcon('profile-user', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Evaluate employees') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            <!--end:Menu item-->

            

            <!--begin:Menu item ทบทวนและอนุมัติผลการประเมิน-->
            @can('view review pa results')
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.evaluateReview') ? 'active' : '' }}" href="{{ route('meyer.evaluateReview') }}">
                    <span class="menu-icon">{!! getIcon('profile-user', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Review and Approve PA Results') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            <!--end:Menu item-->

            <!--begin:Menu item ตัดเกรด -->
            @can('view pa grading')
            <div class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.paGrading') ? 'active' : '' }}" href="{{ route('meyer.paGrading') }}">
                    <span class="menu-icon">{!! getIcon('flag', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('PA Grading') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            <!--end:Menu item-->

            <!--begin:Menu item ประเมินการปรับขึ้นเงินเดือน-->
            @can('view salary increase')
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.salary') ? 'active' : '' }}" href="{{ route('meyer.salary') }}">
                    <span class="menu-icon">{!! getIcon('wallet', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Salary Increase') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            <!--end:Menu item-->

            <!--begin:Menu item ทบทวนและอนุมัติการปรับขึ้นเงินเดือน-->
            @can('view review salary')
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.salaryReview') ? 'active' : '' }}" href="{{ route('meyer.salaryReview') }}">
                    <span class="menu-icon">{!! getIcon('wallet', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Review and Approve Salary Increase') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            @if($percent_department_count > 0 && Auth::user()->orisoft_code != "000002" && Auth::user()->orisoft_code != "000026")
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.salaryReview') ? 'active' : '' }}" href="{{ route('meyer.salaryReview') }}">
                    <span class="menu-icon">{!! getIcon('wallet', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Review and Approve Salary Increase') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endif
            <!--end:Menu item-->

            <!--begin:Menu item ข้อมูลขึ้นเงินเดือน -->
            @can('view approve salary')
            <div class="menu-item menu-accordion ">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.approveSalary') ? 'active' : '' }}" href="{{ route('meyer.approveSalary') }}">
                    <span class="menu-icon">{!! getIcon('wallet', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Approved Salary') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
            <!--end:Menu item-->

            @can('view dashboards')
            <div class="menu-item menu-accordion {{ request()->routeIs('meyer.dashboard') ? 'here show' : '' }}">
                <!--begin:Menu link-->
                <a class="menu-link {{ request()->routeIs('meyer.dashboard') ? 'active' : '' }}" href="{{ route('meyer.dashboard') }}">
                    <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                    <span class="menu-title" style="color:white !important;">{{ __('Dashboards') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            @endcan
        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script type="text/javascript">
    let zoom_set = localStorage.getItem("zoom_set",1);
    console.log('zoom_set = '+zoom_set);
    let zoomLevel = parseFloat((zoom_set && zoom_set != NaN?zoom_set:1));
    $('body').css('zoom',zoomLevel);
    console.log('zoomLevel = '+zoomLevel);
    function zoomIn() {
        let zoom_set = localStorage.getItem("zoom_set",1);
        let zoomLevel = parseFloat((zoom_set && zoom_set != NaN?zoom_set:1));
        
        zoomLevel += parseFloat(0.1);
        document.body.style.zoom = zoomLevel;
        localStorage.setItem("zoom_set", zoomLevel);
        console.log('zoomIn = '+localStorage.getItem("zoom_set"));
        $('body').css('zoom',zoomLevel);
    }

    function zoomOut() {
        let zoom_set = localStorage.getItem("zoom_set",1);
        let zoomLevel = parseFloat((zoom_set && zoom_set != NaN?zoom_set:1));

        zoomLevel -= parseFloat(0.1);
        document.body.style.zoom = zoomLevel;
        localStorage.setItem("zoom_set", zoomLevel);
        console.log('zoomOut = '+localStorage.getItem("zoom_set"));
        $('body').css('zoom',zoomLevel);
    }
    function zoomReset() {
        let zoomLevel = parseFloat(1);
        document.body.style.zoom = zoomLevel;
        localStorage.setItem("zoom_set", zoomLevel);
        console.log('zoomReset = '+localStorage.getItem("zoom_set"));
        $('body').css('zoom',zoomLevel);
    }
    // jQuery(function() {
    //     jQuery.ajax({
    //         type: 'POST',
    //         url: '{{ url(Request::segment(1)."/check_set_session") }}',
    //         dataType: 'json',
    //         data : { 
    //             "_token": "{{ csrf_token() }}"
    //         },
    //         success: function (result) { 
                
    //         }
    //     });
    // });
    // function set_session(val){
    //     jQuery.ajax({
    //         type: 'POST',
    //         url: '{{ url(Request::segment(1)."/set_session") }}',
    //         dataType: 'json',
    //         data : { 
    //             "_token": "{{ csrf_token() }}",
    //             "search_year":val
    //         },
    //         success: function (result) { 
    //             window.location.reload();
    //         }
    //     });
    // }
</script>

<style>
	.ki-duotone, .ki-outline, .ki-solid{
		color: #ffffff;
	}
    .buttons-excel {
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-primary-inverse) !important;
        border-color: var(--bs-primary) !important;
        background-color: var(--bs-primary) !important;
    }
</style>