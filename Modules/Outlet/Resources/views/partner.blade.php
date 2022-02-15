<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
<form class="form-horizontal" enctype="multipart/form-data">
    @foreach ($outlet as $key => $val)
    @if($val['location_outlet']['location_partner'])
    <div class="form-body">
        <h4>Partner</h4>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Title
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['title']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Name
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['name']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Contact Person
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['contact_person']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Contact Person
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['contact_person']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Gender
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['gender']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Phone
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['phone']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Mobile
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['mobile']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Email
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['email']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Address
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['location_outlet']['location_partner']['address']??'' }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Start Date
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ (!empty($val['location_outlet']['location_partner']['start_date']) ? date('d F Y', strtotime($val['location_outlet']['location_partner']['start_date'])) : '')}}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                End Date
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ (!empty($val['location_outlet']['location_partner']['start_date']) ? date('d F Y', strtotime($val['location_outlet']['location_partner']['end_date'])) : '')}}" required placeholder="Outlet Name">
            </div>
        </div>

    </div>
    @endif
    @endforeach
</form>