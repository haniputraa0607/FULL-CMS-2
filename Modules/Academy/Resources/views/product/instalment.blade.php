@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function (target) {
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename=' + name + '&_token=' + token,
                            url: "{{url('summernote/picture/delete/product')}}",
                            success: function (data) {
                            }
                        });
                    }
                }
            });
        });

        var i = {{count($result)}};
        var arrStepInstalment = <?php echo $arr_step_instalment?>;
        function addInstalment() {
            var  totalInstalment = $('#total_instalment').val();
            if(totalInstalment == ""){
                swal("Error!", "Please input total instalment.", "error")
                return true;
            }

            if(arrStepInstalment.indexOf(totalInstalment) >= 0){
                swal("Error!", "Step instalment already exist", "error");
                return true;
            }

            var html = '';
            html += '<div id="instalment_child_'+i+'">';
            html += '<h4><b>Instalment '+totalInstalment+'x</b></h4>';
            html+= '<hr>';
            html += '<div style="text-align: right"><a class="btn btn-danger" onclick="deleteInstalment('+i+','+totalInstalment+')">Delete </a></div><br>'+
                    '<div class="form-group">'+
                    '<label for="multiple" class="control-label col-md-3">Description'+
                    '</label>'+
                    '<div class="col-md-8">'+
                    '<div class="input-icon right">'+
                    '<textarea name="data['+i+'][description]" class="form-control summernote"></textarea>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            for(j=1;j<=totalInstalment;j++){
                html += '<div class="form-group">'+
                    '<label for="multiple" class="control-label col-md-3">Step '+j+'</label>'+
                    '<div class="col-md-3">'+
                    '<div class="input-group">'+
                    '<span class="input-group-addon">'+
                    'minimum'+
                    '</span>'+
                    '<input name="data['+i+'][step]['+j+']" maxlength="2" class="form-control" required>'+
                    '<span class="input-group-addon">'+
                    '%'+
                    '</span>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
            }
            html += '<input type="hidden" name="data['+i+'][total_instalment]" value="'+totalInstalment+'">';
            html += '</div>';
            html += '<br>';

            arrStepInstalment.push(totalInstalment);
            $("#instalment").append(html);
            $('.summernote').summernote({
                placeholder: 'Product Description',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function (target) {
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename=' + name + '&_token=' + token,
                            url: "{{url('summernote/picture/delete/product')}}",
                            success: function (data) {
                            }
                        });
                    }
                }
            });
            i++;
        }

        function deleteInstalment(id, totalInstalment) {
            const index = arrStepInstalment.indexOf(totalInstalment.toString());
            if (index >= 0) {
                arrStepInstalment.splice(index, 1);
            }
            $('#instalment_child_' + id).empty();
        }
        
        function submit() {
            var check = arrStepInstalment.length;

            if(check > 0){
                if ($('form#form')[0].checkValidity()) {
                    $('form#form').submit();
                }else{
                    swal("Blank Input", "Please fill blank input", "warning")
                }
            }else{
                swal("Error!", "Please input one or more setting instalment", "error")
            }
        }
    </script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <input class="form-control" placeholder="Total Instalment" id="total_instalment">
                        <span class="input-group-addon">
                        <b>x</b>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-primary" onclick="addInstalment()">&nbsp;<i class="fa fa-plus-circle"></i> Add </a>
                </div>
            </div>
            <br>
            <form class="form-horizontal" id="form" role="form" action="{{url('product-academy/setting/instalment')}}" method="post">
                <div class="form-body">
                    <div id="instalment">
                        @if(!empty($result))
                            @foreach($result as $key=>$dt)
                                <div id="instalment_child_{{$key}}">
                                    <h4><b>Instalment {{$dt['total_instalment']}}x</b></h4>
                                    <hr>
                                    <div style="text-align: right"><a class="btn btn-danger" onclick="deleteInstalment('{{$key}}', '{{$dt['total_instalment']}}')">Delete </a></div><br>
                                    <div class="form-group">
                                        <label for="multiple" class="control-label col-md-3">Description
                                        </label>
                                        <div class="col-md-8">
                                            <div class="input-icon right">
                                                <textarea name="data[{{$key}}][description]" class="form-control summernote">{{$dt['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($dt['step'] as $step=>$value)
                                    <div class="form-group">
                                        <label for="multiple" class="control-label col-md-3">Step {{$step}}</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">minimum
                                                </span>
                                                <input name="data[{{$key}}][step][{{$step}}]" maxlength="2" class="form-control" value="{{$value}}" required>
                                                <span class="input-group-addon">
                                                    %
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <input type="hidden" name="data[{{$key}}][total_instalment]" value="{{$dt['total_instalment']}}">
                                </div>
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <a onclick="submit()" class="btn blue">Submit</a>
                </div>
            </form>
        </div>
    </div>
@endsection
