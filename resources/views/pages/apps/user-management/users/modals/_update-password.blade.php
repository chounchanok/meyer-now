
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
    
    function check_current_password(){
        console.log($('#get_user_id').val());
        $.ajax({
            type: 'POST',
            url: '{{ url(Request::segment(1)."/check_current_password") }}',
            dataType: 'json',
            data : { 
                "_token": "{{ csrf_token() }}",
                "user_id":$('#get_user_id').val(),
                "current_password":$('#current_password').val()
            },
            success: function (result) {
                if($('#current_password').val() == ''){
                    Swal.fire({
                        title: "Current password is required",
                        text: "",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                }else{
                    if(result.check == false){
                        Swal.fire({
                            title: "Current password ไม่ถูกต้อง",
                            text: "",
                            icon: "warning",
                            allowOutsideClick: false,
                        });
                    }else{
                        if($('#new_password').val() == ''){
                            Swal.fire({
                                title: "The password is required",
                                text: "",
                                icon: "warning",
                                allowOutsideClick: false,
                            });
                        }else{
                            if($('#confirm_password').val() == ''){
                                Swal.fire({
                                    title: "The password confirmation is required",
                                    text: "",
                                    icon: "warning",
                                    allowOutsideClick: false,
                                });
                            }else{
                                if($('#new_password').val() != $('#confirm_password').val()){
                                    Swal.fire({
                                        title: "The password and its confirm are not the same",
                                        text: "",
                                        icon: "warning",
                                        allowOutsideClick: false,
                                    });
                                }else{
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
                                                url: '{{ url(Request::segment(1)."/change_password") }}',
                                                dataType: 'json',
                                                data : { 
                                                    "_token": "{{ csrf_token() }}",
                                                    "user_id":$('#get_user_id').val(),
                                                    "new_password":$('#new_password').val()
                                                },
                                                success: function (result) {
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