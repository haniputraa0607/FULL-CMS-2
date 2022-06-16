<?php 
    $input = false;
    if(!empty($result['location_step'])){
        foreach($result['location_step'] as $i => $step){
            if($step['follow_up']=='Input Data Location'){
                $input = true;
                $follow_up = $step['follow_up'];
                $note = $step['note'];
                $file = $step['attachment'];
            }
        }
    }
?>

<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">Input Data Location</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane @if($result['status']=='Rejected') active @endif">
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gear"></i>Warning</div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <p>Candidate Partner Rejected </p>
                                @if ($input==false)
                                <a href="#form_input" class="btn btn-sm yellow" type="button" style="float:center" data-toggle="tab" id="input-survey">
                                    Input Data Location
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($result['status']=='Candidate' || $input == true) active @endif" id="form_input">
                        <form class="form-horizontal" role="form" action="{{url('businessdev/locations/create-follow-up')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_location" value="{{$result['id_location']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Step <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Step yang sedang dilakukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow_up" name="follow_up" value="Input Data Location" readonly required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama calon lokasi yang diajukan oleh perusahaan/instansi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow-name-location" name="nameLocation" value="{{ old('nameLocation') ?? $result['name']}}" placeholder="Enter location name here" required {{ $input ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap calon lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="addressLocation" id="follow-address-location" class="form-control" placeholder="Enter location name here" required {{ $input ? 'disabled' : '' }}>{{ old('addressLocation') ?? $result['address']}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Short Addres <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Alamat singakt calon lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <input class="form-control" type="text" id="follow-mall" name="mall" value="{{ old('mall') ?? $result['mall']}}" placeholder="Enter location mall here" required {{ $input ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location City <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Kota/Kabupaten dari calon lokasi" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select class="form-control select2" name="id_cityLocation" id="follow-id_cityLocation" required {{ $input ? 'disabled' : '' }}>
                                            <option value="" selected disabled>Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city['id_city']}}" @if(old('id_cityLocation')) @if(old('id_cityLocation') == $city['id_city']) selected @endif @else @if($result['id_city'] == $city['id_city']) selected @endif @endif>{{$city['city_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Width <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Lebar dari lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control meter" type="text" id="width" name="width" placeholder="Enter location width here" value="{{ old('width') ?  old('width') : $result['width']}}" required {{ $input ? 'disabled' : '' }}/>
                                            <span class="input-group-addon">m</span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Height <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tinggi dari lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control meter" type="text"  data-type="currency" id="height" name="height" placeholder="Enter location height here" value="{{ old('height') ? old('height') : $result['height']}}" required {{ $input ? 'disabled' : '' }}/>
                                            <span class="input-group-addon">m</span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Length <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Panjang dari lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control meter" type="text" id="length" name="length" placeholder="Enter location length here" value="{{ old('length') ?  old('length') : $result['length']}}" required {{ $input ? 'disabled' : '' }}/>
                                            <span class="input-group-addon">m</span>
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Location Large <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Luas dari lokasi yang diajukan" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control meter" type="text" id="location_large" name="location_large" placeholder="Enter location large here" value="{{ old('location_large') ?  number_format(old('location_large')) : number_format($result['location_large'])}}" required {{ $input ? 'disabled' : '' }}/>
                                            <span class="input-group-addon">m<sup>2</sup></span>
                                        </div>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Note <span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Catatan untuk step ini" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <textarea name="note" id="note" class="form-control" placeholder="Enter note here" required @if ($input==true) readonly @endif >@if ($input==true) {{ $note }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if ($input==true) 
                                    <label for="example-search-input" class="control-label col-md-4">Download Attachment
                                        <i class="fa fa-question-circle tooltips" data-original-title="Download file yang dilampirkan pada step ini" data-container="body"></i><br></label>
                                        @endif
                                    <div class="col-md-5">
                                        @if ($input==true) 
                                        <label for="example-search-input" class="control-label col-md-4">
                                            @if(isset($file))
                                            <a href="{{ $file }}">Link Download Attachment</a>
                                            @else
                                            No Attachment
                                            @endif
                                        <label>
                                        @endif
                                    </div>
                                </div>
                                @if ($input==false) 
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <a class="btn red sweetalert-reject" data-id="{{ $result['id_location'] }}" data-name="{{ $result['name'] }}">Reject</a>
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