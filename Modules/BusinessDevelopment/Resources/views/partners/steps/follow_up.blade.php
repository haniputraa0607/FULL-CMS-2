<?php 
  $step_follow_up = 1;
  if(!empty($result['partner_step'])){
    foreach($result['partner_step'] as $i => $step){
      $step_follow_up = $i + 2; 
    }
  }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane">
            @if($step_follow_up<8)
            <a href="#form" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                @if($step_follow_up == 7) Approved @else Follow Up {{ $step_follow_up }} @endif
            </a>
            @endif
            <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                Back
            </a>
            <h4 class="font-blue sbold uppercase" style="margin-top: 0px;margin-bottom: 50px;font-size: 24px;">Follow Up Data</h4>
        <div class="table-responsive">
            <div class="tab-content">
                <div class="tab-pane active" id="table">
                    <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">Created At</th>
                            <th class="text-nowrap text-center">Step</th>
                            <th class="text-nowrap text-center">Note</th>
                            <th class="text-nowrap text-center">Attachment</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($result['partner_step']))
                                @foreach($result['partner_step'] as $step)
                                    <tr data-id="{{ $step['id_steps_log'] }}">
                                        <td>{{date('d F Y H:i', strtotime($step['created_at']))}}</td>
                                        <td>{{$step['follow_up']}}</td>
                                        <td>{{$step['note']}}</td>
                                        <td>
                                            @if(isset($step['attachment']))
                                            <a href="{{ $step['attachment'] }}">Link Download Attachment</a>
                                            @else
                                            No Attachment
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" style="text-align: center">No Follow Up Yet</td>
                                </tr>
                            @endif
                            </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="form">
                    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/create-follow-up')}}" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <input type="hidden" name="id_partner" value="{{$result['id_partner']}}">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="follow_up" name="follow_up" value="@if($step_follow_up<7)Follow Up {{ $step_follow_up }} @else Approved @endif" readonly required/>
                                </div>
                            </div>
                            @if ($step_follow_up==1)
                            <input type="hidden" name="id_location" value="{{$result['partner_locations'][0]['id_location']}}">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama Calon Lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="follow-name-location" name="nameLocation" value="{{$result['partner_locations'][0]['name']}}" placeholder="Enter location name here" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Address Calon Lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="addressLocation" id="follow-address-location" class="form-control" placeholder="Enter location name here" required>{{$result['partner_locations'][0]['address']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kota Calon Lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <select class="form-control select2" name="id_cityLocation" id="follow-id_cityLocation" required>
                                        <option value="" selected disabled>Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city['id_city']}}" @if($result['partner_locations'][0]['id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Location Large <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan luas lokasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="location_large" name="location_large" placeholder="Enter location large here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Rental Price <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan harga sewa" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="rental_price" name="rental_price" placeholder="Enter rental price here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Service Charge <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan biaya servis" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="service_charge" name="service_charge" placeholder="Enter service charge here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Promotion Levy <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan promosi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="promotion_levy" name="promotion_levy" placeholder="Enter promotion levy here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Renovation Cost <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan biaya renovasi" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan pembayaran kerja sama" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" required/>
                                </div>
                            </div>    
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan pemasukan" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" id="income" name="income" placeholder="Enter income here" required/>
                                </div>
                            </div>    
                            @endif
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Import Attachment <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i><br>
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
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn blue">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>