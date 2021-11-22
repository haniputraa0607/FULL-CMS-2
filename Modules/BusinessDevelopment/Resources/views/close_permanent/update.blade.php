<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        var SweetAlertReject = function() {
            return {
                init: function() {
                    $(".sweetalert-reject").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_partners_close_permanent':{{$result['id_partners_close_permanent']}}
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure want to reject?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/close-permanent/reject')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Reject Success.", "success")
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to delete.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        var SweetAlertSuccess = function() {
            return {
                init: function() {
                    $(".sweetalert-success").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        @if(!empty($result['close_date']))
                            let status = "Close";
                        @else
                            let status = "Start";
                        @endif
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_partners_close_permanent':{{$result['id_partners_close_permanent']}},
                            'status':status
                            };
                            console.log(data)
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure want to accept data?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, accept it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/close-permanent/success')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Success!", "Success.", "success")
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed.", "error")
                                            }
                                            else {
                                                console.log(data)
                                                console.log(response)
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    })
                }
            }
        }();
        $(document).ready(function() {
            SweetAlertReject.init();
            SweetAlertSuccess.init();
        });
    </script>
    <div class="portlet-body form">
                @if(!empty($result['close_date']))
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/close-permanent/update')}}" method="post" enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/close-permanent/updateActive')}}" method="post" enctype="multipart/form-data">
                @endif
                        <div class="form-body">
                            <input class="form-control" type="hidden" id="id_partners_close_permanent" name="id_partners_close_permanent" value="{{$result['id_partners_close_permanent']}}"/>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Judul pengajua" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input @if($result['status']!='Process' ) disabled @endif class="form-control" type="text" id="input-name" name="title" value="{{$result['title']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                @if(!empty($result['close_date']))
                                <label for="example-search-input" class="control-label col-md-4">Submitted Date<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pengajuan tanggal partner beralih ke IXOBOX" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="close_date" @if($result['status']!='Process' ) disabled @endif class="datepicker form-control" name="close_date" value="{{ (!empty($result['close_date']) ? date('d F Y', strtotime($result['close_date'])) : '')}}" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @else
                                <label for="example-search-input" class="control-label col-md-4">Start Date<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pengajuan tanggal partner beralih ke IXOBOX" min='@php date("Y-m-d"); @endphp' data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="close_date" @if($result['status']!='Process' ) disabled @endif class="datepicker form-control" name="start_date" value="{{ (!empty($result['start_date']) ? date('d F Y', strtotime($result['start_date'])) : '')}}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Note
                                    <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk pengajuan ini" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="input-phone" name="note" value="{{$result['note']}}" placeholder="Enter note"  @if($result['status']!='Process' ) disabled @endif />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Status</label>
                                <div class="col-md-5">
                                    <input disabled class="form-control" type="text" id="input-phone" name="status" value="{{$result['status']}}" placeholder="Enter progres"/>
                                </div>
                            </div>
                           
                        </div>
                        @if($result['status']=="Process")
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button type="submit" class="btn blue">Update</button>
                                    @if($button>0)
                                    <a class="btn red sweetalert-reject btn-primary"><i class="fa fa-close"></i> Reject</a>
                                    <a class="btn green sweetalert-success btn-primary"><i class="fa fa-check"></i> Success</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>