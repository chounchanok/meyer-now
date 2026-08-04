<div class="form-check form-switch form-check-custom form-check-solid me-xxl-8">
    <input class="form-check-input h-30px w-50px" type="checkbox" value="1" id="flexSwitchDefault{{$user->id}}" {{($user->active=='1'?'checked="checked"':'')}} onchange="changeactiveuser({{$user->id}});"/>
</div>
<script>
    function changeactiveuser(id){
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
                    url: '{{ url(Request::segment(1)."/changeactiveuser") }}',
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
                                // destroy_table();
                                // window.location.reload();
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