<?php 
    $contract = false;
    $prog = false;
    $first_party = null;
    $second_party = null;
    $nominal = null;
    $note = null;
    $attachment = null;
    $next_contract = false;
    if($result['progres']=='Contract'){
        $contract = true;
    }
    if ($result['project_contract']!=null){
        $id_projects_contract = $result['project_contract']['id_projects_contract'];
        $first_party = $result['project_contract']['first_party'];
        $second_party = $result['project_contract']['second_party'];
        $nominal = "Rp " . number_format($result['project_contract']['nominal'],2,',','.') ;
        $note = $result['project_contract']['note'];
        $attachment = $result['project_contract']['attachment'];
        $created_at = $result['project_contract']['updated_at'];
        if($result['project_contract']['status']=='Process'){
           $next_contract = true;
        }
        
    }
?>
<script>
  $(document).ready(function () {

        $("input[data-type='currency']").on({
            keyup: function() {
              formatCurrency($(this));
            },
            blur: function() { 
              formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
          // format number 1000000 to 1,234,567
          return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
          // appends $ to value, validates decimal side
          // and puts cursor back in right position.

          // get input value
          var input_val = input.val();

          // don't validate empty input
          if (input_val === "") { return; }

          // original length
          var original_len = input_val.length;

          // initial caret position 
          var caret_pos = input.prop("selectionStart");

          // check for decimal
          if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);


            // join number by .
            input_val = left_side ;

          } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            
          }

          // send updated string to input
          input.val(input_val);

          // put caret back in the right position
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
        }
    })



    var SweetAlertSubmitContract = function() {
            return {
                init: function() {
                    $(".sweetalert-contract-submit").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        var pathname = window.location.pathname; 
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        var data = {
                                    '_token' : '{{csrf_token()}}',
                                    'id_project':{{$result['id_project']}}
                                        };
                        $(this).click(function() { swal({
                                    title: "Submit data?",
                                    text: "Check your data before submit!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, submit it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#conract_form').submit();
                                });
                        })
                    })
                }
            }
        }();
        jQuery(document).ready(function() {
            SweetAlertSubmitContract.init()
        });
    </script>
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Contract</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div id="form_survey">
                        <form class="form-horizontal" id="conract_form" role="form" action="{{url('project/create/contract')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_project" value="{{$result['id_project']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Pihak 1<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 1" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif type="text" id="first_party" name="first_party" value="{{$first_party}} " required/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Pihak 2<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pihak 2" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif id="second_party" name="second_party" value="{{$second_party}} " required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Nominal<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nominal" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" placeholder="Rp 1,000,000.00" data-type="currency"  type="text" id="nominal" name="nominal"  value="{{$nominal}}"  @if($result['status']!='Process') disabled @elseif($result['progres']!='Contract') disabled @endif   required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note</label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" @if($result['status']!='Process' ) disabled @elseif($result['progres']!='Contract') disabled @endif class="form-control" placeholder="Enter note here">{{$note}}</textarea>
                                    </div>
                                </div>
                                @if($result['status']=='Process' && $result['progres']=='Contract')
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment<br>
                                        <span class="required" aria-required="true"> (PDF max 2 mb) </span></label>
                                    <div class="col-md-5">
                                        <div class="fileinput fileinput-new text-left" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                            <span class="fileinput-new"> Select file </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" class="file" name="import_file">
                                                        </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(@$attachment!=null)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Link Download file<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <br>
                                        <a target="_blank" target='blank' href="{{ $attachment }}"><i class="fa fa-download" style="font-size:48px"></i></a>
                                    </div>
                                </div>
                                @endif
                                @if ($contract==true&&$result['status']=='Process') 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a class="btn blue sweetalert-contract-submit">Submit</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>