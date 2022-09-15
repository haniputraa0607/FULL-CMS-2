<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

    function addNewLink(){
        $('#formNewCustomLink').modal('show');
    }

    function submitModal(){
        var title = $('#custom_link_new_title').val();
        var link = $('#custom_link_new_link').val();
        console.log([title,link]);
        if(title == '' || link == ''){
            toastr.warning('Incompleted Data');
        }else{
            $.ajax({
                type : "POST",
                url : "{{url('employee/recruitment/candidate/detail')}}/"+"{{ $detail['id_employee'] }}/add-custom-link",
                data : {
                    '_token'      : '{{csrf_token()}}',
                    'id_employee' : {{ $detail['id_employee'] }},
                    'title'       : title,
                    'link'        : link,
                },
                success : function(response) {
                    if (response.status == 'success') {
                        var row = `
                            <tr data-id="${response.result.id_employee_custom_link}">
                                <td>${response.result.title}</td>
                                <td>${response.result.link}</td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn" onclick="deleteRule(${response.result.id_employee_custom_link})">&nbsp;<i class="fa fa-trash"></i></a>    
                                </td>
                            </tr>
                        `;

                        $('#div_costum_rule tbody').append(row);
                        toastr.success('Success to add custom link');
                    }else {
                        toastr.warning('Failed to add custom link');
                    }
                    $('#custom_link_new_title').val('');
                    $('#custom_link_new_link').val('http://');
                }
            });
            
            $('#formNewCustomLink').modal('hide');
        }
    }

    function deleteRule(id) {
        $.ajax({
            type : "POST",
            url : "{{url('employee/recruitment/candidate/delete-custom-link')}}/"+id,
            data : {
                '_token' : '{{csrf_token()}}'
            },
            success : function(response) {
                if (response.status == 'success') {
                    toastr.success('Success to delete custom link');
                    $(`#div_costum_rule tr[data-id=${id}]`).remove();
                }else {
                    toastr.warning('Failed to delete custom link');
                }
            }
        });
    }

</script>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark sbold uppercase font-yellow">Custom Link</span>
        </div>
    </div>
    <div class="portlet-body form">
        <div>
            <button class="btn green" type="button" onclick="addNewLink()">Add Custom Link</button>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="div_costum_rule">
                <thead>
                <tr>
                    <th class="text-nowrap text-center col-md-2">Title</th>
                    <th class="text-nowrap text-center col-md-9">Link</th>
                    <th class="text-nowrap text-center col-md-1">Delete</th>
                </tr>
                </thead>
                <tbody>
                    @if (!empty($detail['employee']['custom_links']))
                        @foreach ($detail['employee']['custom_links'] ?? [] as $key => $custom_link)
                            <tr data-id="{{ $custom_link['id_employee_custom_link'] }}">
                                <td>{{$custom_link['title']}}</td>
                                <td style="word-break: break-all; !important">
                                    <a href="{{ $custom_link['link']??'' }}" target="_blank">{{$custom_link['link']}}</a>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-danger btn" onclick="deleteRule({{ $custom_link['id_employee_custom_link'] }})">&nbsp;<i class="fa fa-trash"></i></a>    
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade bd-example-modal-sm" id="formNewCustomLink" tabindex="-1" role="dialog" aria-labelledby="newCustomLink" aria-hidden="true" style="z-index: 20000; !important">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <div class="col-md-5">
                <h4 class="modal-title" id="newCustomLink">Add New Custom Link</h4>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="javascript:submitModal()" method="post" role="form" id="modalCustomLink">
                <div class="form-group">
                    <label for="example-search-input" class="control-label col-md-2">Title <span class="required" aria-required="true">*</span></label>
                    <div class="col-md-5">
                            <input class="form-control" type="text" id="custom_link_new_title" name="title" placeholder="Enter New Title Here" required/>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="example-search-input" class="control-label col-md-2">Link <span class="required" aria-required="true">*</span></label>
                    <div class="col-md-10">
                            <input class="form-control" type="url" id="custom_link_new_link" name="link" placeholder="https://example.com" value="http://" required/>
                    </div>
                </div>    
            <div class="modal-footer form-actions">
                {{ csrf_field() }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn blue" id="submit_new_link">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>