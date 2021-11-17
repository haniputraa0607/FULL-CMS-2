<?php 
  $step_follow_up = 1;
  if(!empty($result['step'])){
    foreach($result['step'] as $i => $step){
      $step_follow_up = $i + 2; 
    }
  }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Follow Up Data</span>
                </div>
                @if($result['status']=='Process')
                    @if($step_follow_up<8)
                    <a href="#form" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="input-follow-up">
                        @if($step_follow_up == 7) Approved @else Follow Up {{ $step_follow_up }} @endif
                    </a>
                    @endif
                    <a href="#table" class="btn btn-sm yellow" type="button" style="float:right" data-toggle="tab" id="back-follow-up">
                        Back
                    </a>
                @endif
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table">
                        <div class="table-responsive">
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
                                    @if(!empty($result['step']))
                                        @foreach($result['step'] as $i => $step)
                                            @if ($i<=6)
                                            <tr data-id="{{ $step['id_outlet_close_temporary_steps'] }}">
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
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">No Follow Up Yet</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="form">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/close/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_outlet_close_temporary_location" value="{{$result['lokasi']['id_outlet_close_temporary_location']}}">
                                <input type="hidden" name="id_outlet_close_temporary" value="{{$result['lokasi']['id_outlet_close_temporary']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih step" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="@if($step_follow_up<7)Follow Up {{ $step_follow_up }} @else Approved @endif" readonly required/>
                                    </div>
                                </div>
                                @if ($step_follow_up==1)
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai menjadi Partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="start_date" class="datepicker form-control" name="start_date" value="{{ (!empty($result['lokasi']['start_date']) ? date('d F Y', strtotime($result['lokasi']['start_date'])) : '')}}" required>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">End Date <span class="required" aria-required="true">*</span><br><span class="required" aria-required="true">( must be more than 3 years )</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Berakhir menjadi Partner" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input type="text" id="end_date" class="datepicker form-control" name="end_date" value="{{ (!empty($result['lokasi']['end_date']) ? date('d F Y', strtotime($result['lokasi']['end_date'])) : '')}}" required>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id_location" value="{{$result['lokasi']['id_location']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama Calon Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow-name-location" name="nameLocation" value="{{ old('nameLocation') ?? $result['lokasi']['name']}}" placeholder="Enter location name here" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Address Calon Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="addressLocation" id="follow-address-location" class="form-control" placeholder="Enter location name here" required>{{ old('addressLocation') ?? $result['lokasi']['address']}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Mall <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Mall Calon Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="mall" id="follow-mall" class="form-control" placeholder="Enter location mall here" required>{{ old('mall') ?? $result['lokasi']['mall']}}</textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kota Calon Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_cityLocation" id="follow-id_cityLocation" required>
                                            <option value="" selected disabled>Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city['id_city']}}" @if(old('id_cityLocation')) @if(old('id_cityLocation') == $city['id_city']) selected @endif @else @if($result['lokasi']['id_city'] == $city['id_city']) selected @endif @endif>{{$city['city_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Brand <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Brand Calon Lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_brand" id="follow-id_brand" required>
                                            <option value="" selected disabled>Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand['id_brand']}}" @if(old('id_brand')) @if(old('id_brand') == $brand['id_brand']) selected @endif @else @if($result['lokasi']['id_brand'] == $brand['id_brand']) selected @endif @endif>{{$brand['name_brand']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Large <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan luas lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="location_large" name="location_large" placeholder="Enter location large here" value="{{ old('location_large')?? $result['lokasi']['location_large'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Rental Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan harga sewa" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="rental_price" name="rental_price" placeholder="Enter rental price here" value="{{ old('rental_price')?? $result['lokasi']['rental_price'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Service Charge <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan biaya servis" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="service_charge" name="service_charge" placeholder="Enter service charge here" value="{{ old('service_charge')?? $result['lokasi']['service_charge'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Promotion Levy <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan promosi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="promotion_levy" name="promotion_levy" placeholder="Enter promotion levy here"  value="{{ old('promotion_levy')?? $result['lokasi']['promotion_levy'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Contractor Price <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan biaya renovasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="renovation_cost" name="renovation_cost" placeholder="Enter renovation cost here" value="{{ old('renovation_cost')?? $result['lokasi']['renovation_cost'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Partnership Fee <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan pembayaran kerja sama" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="partnership_fee" name="partnership_fee" placeholder="Enter partnership fee here" value="{{ old('partnership_fee')?? $result['lokasi']['partnership_fee'] }}" required/>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Income <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan pemasukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="income" name="income" placeholder="Enter income here" value="{{ old('income')?? $result['lokasi']['income'] }}" required/>
                                    </div>
                                </div>    
                                @endif
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan note" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required>{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Import Attachment
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukan file" data-container="body"></i><br>
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
                                            @if($result['status']=='Process') <a class="btn red sweetalert-reject" data-id="{{ $result['id_outlet_close_temporary'] }}" >Reject</a> @endif
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
</div>