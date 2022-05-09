<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            showMeridian: true,
            timepicker: false
        });
    </script>
    <script>
        var map;

        var markers = [];

        function initialize(latNow, longNow) {
          var haightAshbury = new google.maps.LatLng(latNow,longNow);
          var marker        = new google.maps.Marker({
            position:new google.maps.LatLng(latNow,longNow),
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
          });

          var mapOptions = {
              zoom: 12,
              center: haightAshbury,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          var infowindow = new google.maps.InfoWindow({
              content: '<p>Marker Location:</p>'
          });

          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var input = /** @type  {HTMLInputElement} */(
          document.getElementById('pac-input'));

          var types = document.getElementById('type-selector');
          map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
          map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

          var autocomplete = new google.maps.places.Autocomplete(input);

          autocomplete.bindTo('bounds', map);

          var infowindow = new google.maps.InfoWindow();

          google.maps.event.addListener(autocomplete, 'place_changed', function() {
          deleteMarkers();
          infowindow.close();
          marker.setVisible(true);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
              return;
          }

        // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);
          } else {
              map.setCenter(place.geometry.location);
              map.setZoom(17);  // Why 17? Because it looks good.
          }
              addMarker(place.geometry.location);
          });

          google.maps.event.addListener(map, 'click', function(event) {

            deleteMarkers();
            addMarker(event.latLng);
            // marker.openInfoWindowHtml(latLng);
            // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
            infowindow.open(map, marker);
          });
          // Adds a marker at the center of the map.
          addMarker(haightAshbury);
        }

        function placeMarker(location) {
          marker = new google.maps.Marker({
            position: location,
            map: map,
          });

          markers.push(marker);

          infowindow = new google.maps.InfoWindow({
             content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
          });
          infowindow.open(map,marker);
        }

        // Add a marker to the map and push to the array.

        function addMarker(location) {
          var marker = new google.maps.Marker({
            position: location,
            map: map
          });

          $('#lat').val(location.lat());
          $('#lng').val(location.lng());
          markers.push(marker);
        }

        // Sets the map on all markers in the array.

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setAllMap(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setAllMap(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize());
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            /* BUAT NAVIGATION */
            navigator.geolocation.getCurrentPosition(function(position){
                initialize(position.coords.latitude, position.coords.longitude);
            },
            function (error) {
              if (error.code == error.PERMISSION_DENIED)
                  initialize(-7.7972, 110.3688);
            });

            /* BUAT YANG LAIN */
            token = '<?php echo csrf_token()?>';

            //select old city
            var old_prov = "{{old('id_province')}}"
            var old_city = "{{old('id_city')}}"
            if(old_prov != null){
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo url('outlet/get/city')?>",
                    data    : "_token="+token+"&id_province="+old_prov,
                    success : function(result) {
                        if (result['status'] == "success") {
                            $('#city').prop('disabled', false);

                            var city           = result['result'];
                            var selectCity = '<option value=""></option>';
                            var tmpCity = '';
                            for (var i = 0; i < city.length; i++) {
                                if(old_city == city[i]['id_city']){
                                    tmpCity = city[i]['id_city']+'|'+city[i]['city_postal_code'];
                                    selectCity += '<option value="'+city[i]['id_city']+'|'+city[i]['city_postal_code']+'" selected>'+city[i]['city_name']+'</option>';
                                }else{
                                    selectCity += '<option value="'+city[i]['id_city']+'|'+city[i]['city_postal_code']+'" >'+city[i]['city_name']+'</option>';
                                }
                            }

                            $('#city').html(selectCity);
                            $('#city').val(tmpCity).trigger("change");
                        }
                        else {
                            $('#city').prop('disabled', true);
                        }
                    }
                });
            }

            $('#province').change(function() {
                var isi         = $('#province').val();

                $.ajax({
                    type    : "POST",
                    url     : "<?php echo url('outlet/get/city')?>",
                    data    : "_token="+token+"&id_province="+isi,
                    success : function(result) {
                        if (result['status'] == "success") {
                            $('#city').prop('disabled', false);

                            var city           = result['result'];
                            var selectCity = '<option value=""></option>';

                            for (var i = 0; i < city.length; i++) {
                                selectCity += '<option value="'+city[i]['id_city']+'|'+city[i]['city_postal_code']+'" >'+city[i]['city_name']+'</option>';
                            }

                            $('#city').html(selectCity);
                        }
                        else {
                            $('#city').prop('disabled', true);
                        }
                    }
                });
            });

            $('#city').change(function() {
                var isi = $('#city').val();

                var isi = isi.split('|');

                $('#id_city').val(isi[0]);
            });
        });
    </script>

<script type="text/javascript">
    $(document).on('click', '.same', function() {
      var open = $(this).parent().parent().parent().find('.kelas-open').val();
      var close = $(this).parent().parent().parent().find('.kelas-close').val();
      if (open == '') {
        alert('Open Hour field cannot be empty');
        $(this).parent().parent().parent().find('.kelas-open').focus();
        return false;
      }

      if (close == '') {
        alert('Close Hour field cannot be empty');
        $(this).parent().parent().parent().find('.kelas-close').focus();
        return false;
      }

      if ($(this).is(':checked')) {
        var check = $('input[name="ampas[]"]:checked').length;
        var count = $('.same').prop('checked', false);
        $(this).prop('checked', true);

        if (check == 1) {
            var all_open = $('.kelas-open');
            var array_open = [];
            for (i = 0; i < all_open.length; i++) {
              array_open.push(all_open[i]['defaultValue']);
            }
            sessionStorage.setItem("item_open", array_open);

            var all_close = $('.kelas-close');
            var array_close = [];
            for (i = 0; i < all_close.length; i++) {
              array_close.push(all_close[i]['defaultValue']);
            }
            sessionStorage.setItem("item_close", array_close);
        }

        $('.kelas-open').val(open);
        $('.kelas-close').val(close);

      } else {

          var item_open = sessionStorage.getItem("item_open");
          var item_close = sessionStorage.getItem("item_close");

          var myarr_open = item_open.split(",");
          var myarr_close = item_close.split(",");
          $('.kelas-open').each(function(i, obj) {
              $(this).val(myarr_open[i]);
          });

          $('.kelas-close').each(function(i, obj) {
              $(this).val(myarr_close[i]);
          });

          $(this).parent().parent().parent().find('.kelas-open').val(open);
          $(this).parent().parent().parent().find('.kelas-close').val(close);
      }
    });

    $('.latlong').change(function(){
        var lat = $('#lat').val()
        var long = $('#lng').val()
        console.log(lat)
        console.log(long)
        initialize(lat, long);
    })

    function changeValueIsClose(key) {
        if($('#is_closed_value_'+key).prop("checked") == true){
            $('#is_closed_'+key).val("1");
        }else{
            $('#is_closed_'+key).val("0");
        }
    }

    setTimeout(
        function() { $(':password').val(''); },
        1000  //1,000 milliseconds = 1 second
    );
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
                <span class="caption-subject font-blue sbold uppercase">New Office Branch</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Code
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="outlet_code" value="{{ old('outlet_code') }}" placeholder="Outlet Branch Code" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="outlet_name" value="{{ old('outlet_name') }}" placeholder="Outlet Branch Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Status
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Status outlet. Outlet tidak akan ditampilkan di aplikasi ketika status Inactive" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                                <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio14" name="outlet_status" class="md-radiobtn" @if(old('outlet_status') == 'Active') checked @endif value="Active" required>
                                    <label for="radio14">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Active </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio16" name="outlet_status" class="md-radiobtn" value="Inactive" @if(old('outlet_status') == 'Inactive') checked @endif required>
                                    <label for="radio16">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Inactive </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Province
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="province" class="form-control select2-multiple" name="id_province" data-placeholder="Select Province" required>
                                <optgroup label="Province List">
                                    <option value="">Select Province</option>
                                    @if (!empty($province))
                                        @foreach($province as $suw)
                                            <option value="{{ $suw['id_province'] }}" @if(old('id_province') == $suw['id_province']) selected @endif>{{ $suw['province_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            City
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <select id="city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                                <optgroup label="Province List">
                                    <option value="">Select City</option>

                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Address
                            <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="outlet_address" class="form-control" placeholder="Outlet Branch Address">{{ old('outlet_address') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Phone
                            <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="outlet_phone" value="{{ old('outlet_phone') }}" placeholder="Outlet Branch Phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Email
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Alamat email outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="outlet_email" value="{{ old('outlet_email') }}" placeholder="Outlet Branch Email" required>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Latitude</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control latlong" name="outlet_latitude" value="{{ old('outlet_latitude') }}" id="lat">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Longitude</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control latlong" name="outlet_longitude" value="{{ old('outlet_longitude') }}" id="lng">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"></label>
                        <div class="col-md-9">
                            <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                            <div id="map-canvas" style="width:900;height:380px;"></div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <input type="hidden" name="id_city" id="id_city">
                            <input type="hidden" name="type" value="Office">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection