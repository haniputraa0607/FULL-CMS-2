<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        var SweetAlertDeleteDocument = function() {
            return {
                init: function() {
                    $(".sweetalert-document-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_outlet_change_ownership_document':id
                                        };
                                        
                                            console.log(data)
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this document?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('businessdev/partners/outlet/change/lampiran/delete')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Document has been deleted.", "success")
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
        $(document).ready(function() {
            SweetAlertDeleteDocument.init();
        });
    </script>
<div class="portlet-body form">
    <div style="white-space: nowrap;">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                <thead>
                <tr>
                    <th class="text-nowrap text-center">No</th>
                    <th class="text-nowrap text-center">Title</th>
                    <th class="text-nowrap text-center">Note</th>
                    <th class="text-nowrap text-center">Created At</th>
                    <th class="text-nowrap text-center">Attachment</th>
                    @if($result['status']=="Process")
                    <th class="text-nowrap text-center">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody style="text-align:center">
                        @php $i = 1;
                        @endphp
                        @foreach($lampiran as $value)
                            <tr data-id="{{ $value['id_outlet_change_ownership_document'] }}">
                                <td>{{$i}}</td>
                                <td>{{$value['title']}}</td>
                                <td>{{$value['note']}}</td>
                                <td>{{date('d F Y', strtotime($value['created_at']))}}</td>
                                <td>
                                    @if(isset($value['attachment']))
                                                    <a target="_blank" href="{{ $value['attachment'] }}">Link Download</a>
                                                    @else
                                                    No Attachment
                                                    @endif
                                </td>
                                @if($result['status']=="Process")
                                <td>
                                    <a class="btn btn-sm red sweetalert-document-delete btn-primary" data-id="{{ $value['id_outlet_change_ownership_document'] }}" data-name="{{$value['title']}}"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                                @endif
                            </tr>
                         @php $i++;
                        @endphp
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>