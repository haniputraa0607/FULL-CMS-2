<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="portlet-body form">
    <form class="form-horizontal" role="form" action="{{url('businessdev/partners/outlet/close/updateActive')}}" method="post" enctype="multipart/form-data">
        <div class="form-body">
           <div class="form-body">
                            <input class="form-control" type="hidden" id="id_outlet_close_temporary" name="id_outlet_close_temporary" value="{{$result['id_outlet_close_temporary']}}"/>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Outlet</label>
                                <div class="col-md-5">
                                    <input  disabled class="form-control" type="text" id="input-name"  value="{{$result['outlet_name']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Jenis Aktivasi</label>
                                <div class="col-md-5">
                                    <input  disabled class="form-control" type="text" id="input-name"  value="{{$result['jenis_active']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Title<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Title" data-container="body"></i></label>
                                <div class="col-md-5">
                                    <input @if($result['status']!='Process' ) disabled @endif class="form-control" type="text" id="input-name" name="title" value="{{$result['title']}}" placeholder="Enter name here"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Tanggal <span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal " data-container="body"></i></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" id="date" @if($result['status']!='Process' ) disabled @endif class="datepicker form-control" name="date" value="{{ (!empty($result['date']) ? date('d F Y', strtotime($result['date'])) : '')}}" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-4">Note
                                    <i class="fa fa-question-circle tooltips" data-original-title="Note" data-container="body"></i></label>
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
            <div class="portlet light" style="margin-bottom: 0; padding-bottom: 0">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject sbold uppercase font-black">Change Location</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <input type="hidden" value="{{$result['lokasi']['id_outlet_close_temporary_location']}}" name="id_outlet_close_temporary_location" id="input-id_outlet_close_temporary_location">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Name <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Nama Calon Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input @if($result['status']!='Process' ) disabled @endif class="form-control" type="text" id="input-name-location" name="nameLocation" value="{{$result['lokasi']['name']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Address <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Address Calon Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <textarea @if($result['status']!='Process' ) disabled @endif name="addressLocation" id="input-address-location" class="form-control" placeholder="Enter location name here">{{$result['lokasi']['address']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Latitude <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Latitude Calon Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input @if($result['status']!='Process' ) disabled @endif class="form-control" type="text" id="input-latitude-location" name="latitudeLocation" value="{{$result['lokasi']['latitude']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">Location Longitude <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Longitude Calon Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <input @if($result['status']!='Process' ) disabled @endif class="form-control" type="text" id="input-longitude-location" name="longitudeLocation" value="{{$result['lokasi']['longitude']}}" placeholder="Enter location name here"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">From Location City </label>
                            <div class="col-md-5">
                                <select disabled class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                    <option value="" selected disabled>Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id_city']}}" @if($result['lokasi']['from_id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-4">To Location City <span class="required" aria-required="true">*</span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Kota Calon Lokasi" data-container="body"></i></label>
                            <div class="col-md-5">
                                <select @if($result['status']!='Process' ) disabled @endif class="form-control select2" name="id_cityLocation" id="id_cityLocation" required>
                                    <option value="" selected disabled>Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id_city']}}" @if($result['lokasi']['id_city'] == $city['id_city']) selected @endif>{{$city['city_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="form-actions">
            {{ csrf_field() }}
            @if($result['status']=='Process' )
            <div class="row">
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </div>
            @endif
        </div>
    </form>
</div>