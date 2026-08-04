<x-auth-layout>
    @php

    @endphp
    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ url('mil/dashboard') }}" action="{{ url('mil/login') }}">
        @csrf
        <!--begin::Heading-->
        <div class="mb-5">
            <div class="radio-tile-group">
                <div class="input-container">
                    <input id="th" class="radio-button" type="radio" name="radio" {{ App::isLocale('th') ? 'checked' : '' }} />
                    <div class="radio-tile">
                        <div class="icon walk-icon">
                            <img class="w-15px h-15px rounded-1 ms-2" src="{{ image('flags/thailand.svg') }}" alt="" /></span>
                        </div>
                        <label for="th" class="radio-tile-label" onclick="window.location='./locale/th'">{{ __('Thai') }}</label>
                    </div>
                </div>

                <div class="input-container">
                    <input id="en" class="radio-button" type="radio" name="radio" {{ App::isLocale('en') ? 'checked' : '' }} />
                    <div class="radio-tile">
                        <div class="icon bike-icon">
                            <img class="w-15px h-15px rounded-1 ms-2" src="{{ image('flags/united-states.svg') }}" alt="" /></span>
                        </div>
                        <label for="en" class="radio-tile-label" onclick="window.location='./locale/en'">{{ __('English') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bold mb-3">
                {{ __('Welcome') }},
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-normal fs-6">
                {{ __('Sign in to your account') }}
            </div>
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group--->
        <div class="fv-row mb-3">
            <!--begin::Email-->
            <div class="d-flex align-items-center position-relative">
                <i class="ki-duotone ki-user fs-2 position-absolute ms-5">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="text" class="form-control ps-15" placeholder="{{ __('Username') }}" name="orisoft_code" value="">
            </div>
            <!--end::Email-->
        </div>

        <!--end::Input group--->
        <div class="fv-row mb-5">
            <!--begin::Password-->
            <div class="d-flex align-items-center position-relative">
                <i class="ki-duotone ki-key fs-2 position-absolute ms-5">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="password" class="form-control ps-15" placeholder="{{ __('Password') }}" name="password" value="">
            </div>
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <!--end::Input group--->
        <div class="fv-row mb-5">
            <!--begin::Password-->
            <div class="d-flex align-items-center position-relative">
                <i class="ki-duotone ki-element-8 fs-2 position-absolute ms-5">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <select class="form-select ps-15" name="meyer" onChange="select_change()" id="form_action">
                    <option value="mil">MIL</option>
                    <option value="mtl">MTL</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <!--end::Password-->
        </div>
        <!--end::Input group--->

        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>

            <!--begin::Link-->
            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_password_reset_form" class="link-primary">
                {{ __('headreset1') }} ?
            </a>
            <!--end::Link-->
        </div>

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                @include('partials/general/_button-indicator', ['label' => __('Sign in')])
            </button>
        </div>
        <!--end::Submit button-->

    </form>

    <div class="modal fade" id="kt_password_reset_form" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">{{ __('headreset1') }}</h2>
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
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">
                                    {{ __('headreset1') }} ?
                                </h1>
                                <!--end::Title-->

                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('headreset2') }}
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->

                            <!--begin::Input group--->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" class="form-control bg-transparent" value=""/>
                                <!--end::Email-->
                            </div>

                            <!--begin::Actions-->
                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="button" id="kt_password_reset_submit" class="btn btn-success me-4" onclick="reset_password_login();">
                                    @include('partials/general/_button-indicator', ['label' => 'Submit'])
                                </button>

                                <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
                            </div>
                            <!--end::Actions-->
                        <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <!--end::Form-->
    <script>
        function select_change() {
            var z = document.getElementById("form_action").selectedIndex;
            var action = document.getElementsByTagName("option")[z].value;
            document.getElementById("kt_sign_in_form").action = action + "/login";
            document.getElementById("kt_sign_in_form").setAttribute("data-kt-redirect-url", action + "/dashboard");
        }
        function reset_password_login(){
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
                        type: 'GET',
                        url: '{{ url("reset_password_login") }}',
                        dataType: 'json',
                        data : { 
                            "_token": "{{ csrf_token() }}",
                            "email":$('#email').val(),
                            "form_action":$('#form_action').val(),
                        },
                        success: function (result) { 
                            console.log(result);
                            if(result.status == 500){
                                Swal.fire({
                                    title: "{{ __('reset1') }}",
                                    text: "",
                                    icon: "error",
                                    allowOutsideClick: false,
                                });
                            }else{
                                Swal.fire({
                                    title: "{{ __('reset2') }}",
                                    text: "{{ __('reset3') }}",
                                    icon: "success",
                                    allowOutsideClick: false,
                                });
                            }
                            
                        }
                    });
                }
            });
        }
    </script>

</x-auth-layout>
