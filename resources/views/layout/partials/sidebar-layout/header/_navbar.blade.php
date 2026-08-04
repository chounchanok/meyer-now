<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">

    <!--begin::theme light/dark setting-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu toggle-->
        <!-- <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-night-day theme-light-show fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span></i> <i class="ki-duotone ki-moon theme-dark-show fs-1"><span class="path1"></span><span class="path2"></span></i></a> -->
        <!--begin::Menu toggle-->

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-78px, 74px);" data-popper-placement="bottom-end">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2 active" data-kt-element="mode" data-kt-value="light">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span></i> </span>
                    <span class="menu-title">
                        Light
                    </span>
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span class="path2"></span></i> </span>
                    <span class="menu-title">
                        Dark
                    </span>
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="ki-duotone ki-screen fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> </span>
                    <span class="menu-title">
                        System
                    </span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->

    </div>
    <!--end::theme light/dark setting-->

    <!--begin::language-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu toggle-->
        <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <span class="symbol symbol-20px">
                <img class="rounded-1" src="{{ App::isLocale('en') ? image('flags/united-states.svg') : image('flags/thailand.svg') }}" alt="" />
            </span>
        </a>
        <input type="hidden" id="isLocale" value="{{ App::isLocale('en') }}">
        <!--begin::Menu toggle-->

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-78px, 74px);" data-popper-placement="bottom-end">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="{{ url('/' . \Request::segment(1) . '/locale/th') }}" class="menu-link px-3 py-2 {{ App::isLocale('th') ? 'active' : '' }}" data-kt-element="mode" data-kt-value="light">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/thailand.svg') }}" alt="" />
                    </span>
                    ไทย
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="{{ url('/' . \Request::segment(1) . '/locale/en') }}" class="menu-link px-3 py-2 {{ App::isLocale('en') ? 'active' : '' }}" data-kt-element="mode" data-kt-value="dark">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ image('flags/united-states.svg') }}" alt="" />
                    </span>
                    English
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    <!--end::language-->


    <!--begin::User menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if (Auth::user()->profile_photo_url)
                <img src="{{ \Auth::user()->profile_photo_url }}" class="rounded-3" alt="user" />
            @else
                <div class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
        </div>
        @include('partials/menus/_user-account-menu')
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->

    <!--begin::Aside toggle-->
    <!--end::Header menu toggle-->
</div>
<!--end::Navbar-->
