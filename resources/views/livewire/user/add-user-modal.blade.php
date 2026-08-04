<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add User</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="name" id="user_name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" />
                            <!--end::Input-->
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Employee Code</label>
                            <!--end::Label-->

                            <input type="text" wire:model.defer="orisoft_code" id="orisoft_code" name="orisoft_code" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Code" />



                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" wire:model.defer="email" id="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" {{ $this->edit_mode ? '' : '' }} />
                            <!--end::Input-->
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-5">Role</label>
                            <!--end::Label-->
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <!--begin::Roles-->
                            <div class="row">
                                @foreach ($roles as $r)
                                    <!--begin::Input row-->
                                    <div class="col-6 mb-5">
                                        <!--begin::Radio-->
                                        <div class="form-check form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input me-3" id="kt_modal_update_role_option_{{ $r->id }}" wire:model.defer="role" type="checkbox" value="{{ $r->name }}" />
                                            <!--end::Input-->
                                            <!--begin::Label-->
                                            <label class="form-check-label" for="kt_modal_update_role_option_{{ $r->id }}">
                                                <div class="fw-bold text-gray-800">
                                                    {{ ucwords($r->name) }}
                                                </div>
                                                <div class="text-gray-600">
                                                    {{ $r->detail }}
                                                </div>
                                            </label>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Radio-->
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Roles-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
                        <button type="button" class="btn btn-primary attrcheckadd" data-kt-users-modal-action="submit" onclick="checkadd();">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
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
    function checkadd() {
        if ($('#user_name').val() == "") {
            Swal.fire({
                title: "กรุณาระบุชื่อพนักงาน",
                icon: "warning",
                allowOutsideClick: false,
            });
        } else {
            if ($('#orisoft_code').val() == "") {
                Swal.fire({
                    title: "กรุณาระบุรหัสพนักงาน",
                    icon: "warning",
                    allowOutsideClick: false,
                });
            } else {
                if ($('#email').val() == "") {
                    Swal.fire({
                        title: "กรุณาระบุอีเมล หากไม่มีอีเมล ให้ใส่เมล์ผู้ที่ตำแหน่งสูงกว่า",
                        icon: "warning",
                        allowOutsideClick: false,
                    });
                } else {
                    if ($('.hidden_user_id2').val() == "") {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url(Request::segment(1) . '/check_user') }}',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "name": $('#user_name').val(),
                                "orisoft_code": $('#orisoft_code').val(),
                                "email": $('#email').val()
                            },
                            success: function(result) {
                                if (result.count > 0) {
                                    Swal.fire({
                                        title: "มีข้อมูลในระบบแล้ว ไม่สามารถสร้างได้",
                                        icon: "warning",
                                        allowOutsideClick: false,
                                    });
                                } else {
                                    $('.attrcheckadd').removeAttr('onclick');
                                    $('.attrcheckadd').attr('type', 'submit');
                                    $('.attrcheckadd').click();
                                }
                            }
                        });
                    } else {
                        $('.attrcheckadd').removeAttr('onclick');
                        $('.attrcheckadd').attr('type', 'submit');
                        $('.attrcheckadd').click();
                    }
                }
            }
        }
    }
</script>
