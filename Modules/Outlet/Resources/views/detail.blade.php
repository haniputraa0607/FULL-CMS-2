<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .sweet-alert {
            z-index: 10053;
        }
        .sweet-overlay {
            z-index: 10052; !important
        }
    </style>
@endsection

@section('page-script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false
        });
        // sortable
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
        function validationShift(value) {
            var id = value.id;
            var split = id.split('_');
            var index = split[3];
            var start = $('#start_'+index).val()+':00';
            var end = $('#end_'+index).val()+':00';
            var data = $('#'+id).val()+':00';

            if(data != '0:00' && start != '0:00' && end != '0:00'){
                var array_start = start.split(":");
                var seconds_start = (parseInt(array_start[0], 10) * 60 * 60) + (parseInt(array_start[1], 10) * 60) + parseInt(array_start[2], 10);

                var array_end = end.split(":");
                var seconds_end = (parseInt(array_end[0], 10) * 60 * 60) + (parseInt(array_end[1], 10) * 60) + parseInt(array_end[2], 10);

                var array_data = data.split(":");
                var seconds_data = (parseInt(array_data[0], 10) * 60 * 60) + (parseInt(array_data[1], 10) * 60) + parseInt(array_data[2], 10);

                if(seconds_data < seconds_start || seconds_data > seconds_end){
                    $('#'+id).val('0:00');
                }
            }
        }
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
              zoom: 15,
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

        $(document).ready(function(){
            $('[data-switch=true]').bootstrapSwitch();

            /* MAPS */
            longNow = "{{ $outlet[0]['outlet_longitude'] }}";
            latNow = "{{ $outlet[0]['outlet_latitude'] }}";

            if (latNow == "" || longNow == "") {
              navigator.geolocation.getCurrentPosition(function(position){
                  initialize(position.coords.latitude, position.coords.longitude);
              },
              function (error) {
                if (error.code == error.PERMISSION_DENIED)
                  initialize(-7.7972, 110.3688);
              });
            }
            else {
              initialize(latNow, longNow);
            }

            /*=====================================*/

            // untuk show atau hide informasi photo
            if ($('.deteksi').data('dis') != 1) {
                $('.deteksi-trigger').hide();
            }
            else {
                $('.deteksi-trigger').show();
            }

            let token = "{{ csrf_token() }}";

            // hapus gambar
            $('.hapus-gambar').click(function() {
                let id     = $(this).data('id');
                let parent = $(this).parent().parent().parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('outlet/photo/delete') }}",
                    data : "_token="+token+"&id_outlet_photo="+id,
                    success : function(result) {

                        if (result == "success") {
                            parent.remove();
                            toastr.info("Photo has been deleted.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete photo.");
                        }
                    }
                });
            });

            // change info
            $('#infoOutlet').click(function() {
            //   initialize();
            // console.log(latNow)
            // console.log(latNow)

            // initialize(latNow, longNow);

            });

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

            @foreach($product as $key => $pro)
                var option =  '<option class="option-visibility" data-id={{$pro["id_product"]}}/{{$outlet[0]["id_outlet"]}}>{{$pro["product_code"]}} - {{$pro["product_name"]}}</option>'
                @if(isset($pro['product_detail_all'][0]["product_detail_visibility"]) && $pro['product_detail_all'][0]["product_detail_visibility"])
                    $('#visibleglobal-{{lcfirst($pro["product_detail_all"][0]["product_detail_visibility"])}}').append(option)
                @else
                    $('#visibleglobal-{{lcfirst($pro["product_visibility"])}}').append(option)
                @endif
            @endforeach

            $('#move-hiden').click(function() {
                if($('#visibleglobal-visible').val() == null){
                    toastr.warning("Choose minimal 1 outlet in visible");
                }else{
                    var id =[];
                    $('#visibleglobal-visible option:selected').each(function () {
                        var $this = $(this);
                        id.push($this.attr('data-id'))
                    })
                    let token  = "{{ csrf_token() }}";

                    $.ajax({
                        type : "POST",
                        url : "{{ url('product/update/visible') }}",
                        data : "_token="+token+"&id_visibility="+id+"&visibility=Hidden",
                        success : function(result) {
                            if (result.status == "success") {
                                toastr.info("Visibility has been updated.");
                                $('#visibleglobal-visible option:selected').each(function () {
                                    var $this = $(this);
                                    var option = '<option class="option-visibility" data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>'
                                    $('#visibleglobal-hidden').append(option)
                                    $(this).remove()
                                })

                            }
                            else {
                                toastr.warning("Something went wrong. Failed to update visibility.");
                            }
                        }
                    });
                }
            });

            $('#move-visible').click(function() {
                if($('#visibleglobal-hidden').val() == null){
                    toastr.warning("Choose minimal 1 outlet in hidden");
                }else{
                    var id =[];
                    $('#visibleglobal-hidden option:selected').each(function () {
                        var $this = $(this);
                        id.push($this.attr('data-id'))
                    })
                    let token  = "{{ csrf_token() }}";

                    $.ajax({
                        type : "POST",
                        url : "{{ url('product/update/visible') }}",
                        data : "_token="+token+"&id_visibility="+id+"&visibility=Visible",
                        success : function(result) {
                            if (result.status == "success") {
                                toastr.info("Visibility has been updated.");
                                $('#visibleglobal-hidden option:selected').each(function () {
                                    var $this = $(this);
                                    var option = '<option class="option-visibility" data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>'
                                    $('#visibleglobal-visible').append(option)
                                    $(this).remove()
                                })

                            }
                            else {
                                toastr.warning("Something went wrong. Failed to update visibility.");
                            }
                        }
                    });
                }
            });

            $('#search-product').on("keyup", function(){
                var search = $('#search-product').val();
                $(".option-visibility").each(function(){
                    if(!$(this).text().toLowerCase().includes(search.toLowerCase())){
                        $(this).hide()
                    }else{
                        $(this).show()
                    }
                });
                $('#btn-reset').show()
                $('#div-left').hide()
            })

            $('#btn-reset').click(function(){
                $('#search-product').val("")
                $(".option-visibility").each(function(){
                    $(this).show()
                })
                $('#btn-reset').hide()
                $('#div-left').show()
            })

            $('.summernote').summernote({
                placeholder: 'Category Description',
                tabsize: 2,
                 toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
                height: 120
            });
        });
    </script>

    <script type="text/javascript">
        $('.datatable').dataTable();
        $('#sample_1').dataTable({
            order: [0, "asc"],
            "columnDefs": [
                { "width": "100", "targets": 0 }
            ]
        });
        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('outlet/detail/'.$outlet[0]['outlet_code'].'/admin/delete') }}",
                data : "_token="+token+"&id_user_outlet="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Admin Outlet has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete admin outlet.");
                    }
                }
            });
        });
        $(".file").change(function(e) {
            var widthImg  = 600;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                       $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $(this).val("");

                        $('#imageoutlet').children('img').attr('src', 'https://www.placehold.it/600x300/EFEFEF/AAAAAA&amp;text=no+image');
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
    </script>
    <script type="text/javascript">
    $(document).on('click', '.same', function() {
        var open = $(this).parent().parent().parent().find('.kelas-open').val();
        var close = $(this).parent().parent().parent().find('.kelas-close').val();
        if (open == '') {
            alert('Open field cannot be empty');
            $(this).parent().parent().parent().find('.kelas-open').focus();
            return false;
        }

        if (close == '') {
            alert('Close field cannot be empty');
            $(this).parent().parent().parent().find('.kelas-close').focus();
            return false;
        }

        var id = $(this).data('id');
        var shift_start_morning = $('#shift_start_morning_'+id).val();
        var shift_end_morning = $('#shift_end_morning_'+id).val();
        if (shift_start_morning == '') {
            alert('Shift morning start field cannot be empty');
            return false;
        }

        if (shift_end_morning == '') {
            alert('Shift morning end field cannot be empty');
            return false;
        }

        var shift_start_middle = $('#shift_start_middle_'+id).val();
        var shift_end_middle = $('#shift_end_middle_'+id).val();
        if (shift_start_middle == '') {
            alert('Shift middle start field cannot be empty');
            return false;
        }

        if (shift_end_middle == '') {
            alert('Shift middle end field cannot be empty');
            return false;
        }

        var shift_start_evening = $('#shift_start_evening_'+id).val();
        var shift_end_evening = $('#shift_end_evening_'+id).val();
        if (shift_start_evening == '') {
            alert('Shift evening start field cannot be empty');
            return false;
        }

        if (shift_end_evening == '') {
            alert('Shift evening end field cannot be empty');
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

                var all_shift_start_morning = $('.shift-start-morning');
                var array_shift_start_morning = [];
                for (i = 0; i < all_shift_start_morning.length; i++) {
                    array_shift_start_morning.push(all_shift_start_morning[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_start_morning", array_shift_start_morning);

                var all_shift_end_morning = $('.shift-end-morning');
                var array_shift_end_morning = [];
                for (i = 0; i < all_shift_end_morning.length; i++) {
                    array_shift_end_morning.push(all_shift_end_morning[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_end_morning", array_shift_end_morning);

                var all_shift_start_middle = $('.shift-start-middle');
                var array_shift_start_middle = [];
                for (i = 0; i < all_shift_start_middle.length; i++) {
                    array_shift_start_middle.push(all_shift_start_middle[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_start_middle", array_shift_start_middle);

                var all_shift_end_middle = $('.shift-end-middle');
                var array_shift_end_middle = [];
                for (i = 0; i < all_shift_end_middle.length; i++) {
                    array_shift_end_middle.push(all_shift_end_middle[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_end_middle", array_shift_end_middle);

                var all_shift_start_evening = $('.shift-start-evening');
                var array_shift_start_evening = [];
                for (i = 0; i < all_shift_start_evening.length; i++) {
                    array_shift_start_evening.push(all_shift_start_evening[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_start_evening", array_shift_start_evening);

                var all_shift_end_evening = $('.shift-end-evening');
                var array_shift_end_evening = [];
                for (i = 0; i < all_shift_end_evening.length; i++) {
                    array_shift_end_evening.push(all_shift_end_evening[i]['defaultValue']);
                }
                sessionStorage.setItem("item_shift_end_evening", array_shift_end_evening);
            }

            $('.kelas-open').val(open);
            $('.kelas-close').val(close);
            $('.shift-start-morning').val(shift_start_morning);
            $('.shift-end-morning').val(shift_end_morning);
            $('.shift-start-middle').val(shift_start_middle);
            $('.shift-end-middle').val(shift_end_middle);
            $('.shift-start-evening').val(shift_start_evening);
            $('.shift-end-evening').val(shift_end_evening);
        } else {

            var item_open = sessionStorage.getItem("item_open");
            var item_close = sessionStorage.getItem("item_close");
            var item_shift_start_morning = sessionStorage.getItem("item_shift_start_morning");
            var item_shift_end_morning = sessionStorage.getItem("item_shift_end_morning");
            var item_shift_start_middle = sessionStorage.getItem("item_shift_start_middle");
            var item_shift_end_middle = sessionStorage.getItem("item_shift_end_middle");
            var item_shift_start_evening = sessionStorage.getItem("item_shift_start_evening");
            var item_shift_end_evening = sessionStorage.getItem("item_shift_end_evening");

            var myarr_open = item_open.split(",");
            var myarr_close = item_close.split(",");
            var myarr_shift_start_morning = item_shift_start_morning.split(",");
            var myarr_shift_end_morning = item_shift_end_morning.split(",");
            var myarr_shift_start_middle = item_shift_start_middle.split(",");
            var myarr_shift_end_middle = item_shift_end_middle.split(",");
            var myarr_shift_start_evening = item_shift_start_evening.split(",");
            var myarr_shift_end_evening = item_shift_end_evening.split(",");
            $('.kelas-open').each(function(i, obj) {
                $(this).val(myarr_open[i]);
            });

            $('.kelas-close').each(function(i, obj) {
                $(this).val(myarr_close[i]);
            });

            $('.shift-start-morning').each(function(i, obj) {
                $(this).val(myarr_shift_start_morning[i]);
            });

            $('.shift-end-morning').each(function(i, obj) {
                $(this).val(myarr_shift_end_morning[i]);
            });

            $('.shift-start-middle').each(function(i, obj) {
                $(this).val(myarr_shift_start_middle[i]);
            });

            $('.shift-end-middle').each(function(i, obj) {
                $(this).val(myarr_shift_end_middle[i]);
            });

            $('.shift-start-evening').each(function(i, obj) {
                $(this).val(myarr_shift_start_evening[i]);
            });

            $('.shift-end-evening').each(function(i, obj) {
                $(this).val(myarr_shift_end_evening[i]);
            });

            $(this).parent().parent().parent().find('.kelas-open').val(open);
            $(this).parent().parent().parent().find('.kelas-close').val(close);
            $(this).parent().parent().parent().find('.shift-start-morning').val(shift_start_morning);
            $(this).parent().parent().parent().find('.shift-end-morning').val(shift_start_morning);
            $(this).parent().parent().parent().find('.shift-start-middle').val(shift_start_middle);
            $(this).parent().parent().parent().find('.shift-end-middle').val(shift_start_middle);
            $(this).parent().parent().parent().find('.shift-start-evening').val(shift_start_evening);
            $(this).parent().parent().parent().find('.shift-end-evening').val(shift_end_evening);
        }
    });

    $('.latlong').change(function(){
        var lat = $('#lat').val()
        var long = $('#lng').val()
        console.log(lat)
        console.log(long)
        initialize(lat, long);
    })
    $('.is_closed').change(function(){
        if($(this).is(':checked')){
            $('#'+$(this).attr('data-id')).val('1')
        }else{
            $('#'+$(this).attr('data-id')).val('0')
        }
    })

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    var count_outlet_box = {{(empty($outlet[0]['outlet_box']) ? 1: count($outlet[0]['outlet_box']))}}
    function addOutletBox() {
        var html = '<div id="div_outlet_box_parent_'+count_outlet_box+'">'+
                    '<div class="form-group">'+
                    '<div class="col-md-2">'+
                    '<input class="form-control" type="text" maxlength="200" id="outlet_box_code_'+count_outlet_box+'" name="outlet_box_data['+count_outlet_box+'][outlet_box_code]" required placeholder="Box code"/>'+
                    '</div>'+
                    '<div class="col-md-2">'+
                    '<input class="form-control" type="text" maxlength="200" id="outlet_box_name_'+count_outlet_box+'" name="outlet_box_data['+count_outlet_box+'][outlet_box_name]" required placeholder="Enter name"/>'+
                    '</div>'+
                    '<div class="col-md-4">'+
                    '<input class="form-control" type="text" maxlength="200" id="outlet_box_url_'+count_outlet_box+'" name="outlet_box_data['+count_outlet_box+'][outlet_box_url]" required placeholder="Enter box url"/>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<input data-switch="true" type="checkbox" name="outlet_box_data['+count_outlet_box+'][outlet_box_status]" data-on-text="Active" data-off-text="Inactive" checked/>'+
                    '</div>'+
                    '<div class="col-md-1" style="margin-left: -4%">'+
                    '<a class="btn btn-danger btn" onclick="deleteOutletBox('+count_outlet_box+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                    '</div>'+
                    '</div>'+
                    '</div>';

        $("#div_outlet_box_parent").append(html);
        $('[data-switch=true]').bootstrapSwitch();
        count_outlet_box++;
    }

    function deleteOutletBox(number){
        $('#div_outlet_box_parent_'+number).empty();
    }
    
    function outletBoxSubmit() {
        var data = $('#form-outlet-box').serialize();

        if(data.indexOf("outlet_box_data") < 0){
            toastr.warning("Data can not be empty");
        }else if (!$('form#form-outlet-box')[0].checkValidity()) {
            toastr.warning("Incompleted Data. Please fill blank input.");
        }else{
            $('form#form-outlet-box').submit();
        }
    }

    $(".filePhotoDetail").change(function(e) {
        var widthImg  = 720;
        var heightImg = 360;

        var _URL = window.URL || window.webkitURL;
        var image, file;

        if ((file = this.files[0])) {
            image = new Image();

            image.onload = function() {
                if (this.width != widthImg && this.height != heightImg) {
                    toastr.warning("Please check dimension of your photo.");
                    $('#outletImageDetail').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA&amp;text=no+image');
                    $('#filePhotoDetail').val("");
                    $("#removeImage").trigger( "click" );
                }
            };

            image.src = _URL.createObjectURL(file);
        }

    });

    function conversion(id_product,name,id){
        $('#form_conversion .main').empty();
        $('#form_conversion .info-conv').empty();
        $('#form_conversion .output').empty();

        var unit = $(`tr[data-id=${id}] .unit`).html();

        var max = $(`tr[data-id=${id}] .qty`).html();
        var unit_conv = $(`tr[data-id=${id}] .link`).attr('data-conv');
        var info_conv = $(`tr[data-id=${id}] .link`).attr('data-info');

        document.getElementById('cek_maximal').style.display = 'none';
        document.getElementById('cek_conversion').style.display = 'none';

        if(unit_conv == ''){
            var html = `
                <div class="text-center"><span>Conversion for this product has not been set yet</span></div>
            `;
            $('#form_conversion .modal-footer .submit_conversion').prop('disabled', true);
        }else{
            var select = `<option value="" selected disabled></option>`;
            var qty_to_converse_key_up = '';
            var type_key_up = '';
            var qty_to_converse_change = '';
            var type_change = '';
           
            var new_array = [];
            var array_conversion = unit_conv.split(";");
            array_conversion.forEach(function(data,index){
                array_conversion[index] = data.split(",");
                var unit_select = array_conversion[index][2];
                
                select += `<option value="${unit_select}">${unit_select}</option>`;
                new_array[unit_select] =  array_conversion[index];
            });

            var array_info = info_conv.split(";");
            var span_info = ``;
            array_info.forEach(function(data,index){
                span_info += `<br>${data}`;
            });

            var html_info = `
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert" style="margin-bottom: 10px !important">
                        <strong>${name} CONVERSION INFO : </strong>
                        ${span_info}
                    </div> 
            `;

            var html = `
                <div class="col-md-1"></div>
                <input type="hidden" name="id_product_icount" value="${id_product}" required/>
                <input type="hidden" name="type" required/>
                <input type="hidden" name="conv" required/>
                <input type="hidden" name="qty_original" value="${max}" required/>
                <div class="col-md-2">
                    <input class="form-control numberonly" type="text" id="input_qty_conv" name="qty" required/>
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="text" id="input-cp" id="unit_conv" name="unit" value="${unit}" readonly required/>
                </div>
                <div class="col-md-2 text-center" style="margin-top: 7px !important">
                    <span><i class="fa fa-arrow-right fa-2x"></i></span>
                </div>
                <div class="col-md-3">
                    <select class="select2 form-control" name="unit_conversion" id="select_unit_conv" required>
                        ${select}
                    </select>
                </div>
                <div class="col-md-1"></div>
            `;

        }
        $('#form_conversion .main').append(html);
        $('#form_conversion .info-conv').append(html_info);
        $('#form_conversion .form-group .select2').select2({
            placeholder: ""
        });
        $('.numberonly').inputmask("remove");
        $('.numberonly').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "numeric", 
            rightAlign: false,
            min : '',
            max: '9999',
            prefix : "",
        });
        $('#form_conversion').modal('show');
        $('#input_qty_conv').keyup(function () {
            var cek_max = 0;
            var qty_conv = $('#input_qty_conv').val();
            if(parseInt(qty_conv)<=parseInt(max) || qty_conv == ''){
                document.getElementById('cek_maximal').style.display = 'none';
                if(qty_conv!=''){
                    $('#form_conversion .modal-footer .submit_conversion').prop('disabled', false);
                }
            }else{
                $('#cek_maximal').html(`Invalid value, Maximal value to conversion is ${max}`);
                document.getElementById('cek_maximal').style.display = 'block';
                $('#form_conversion .modal-footer .submit_conversion').prop('disabled', true);
                $('#form_conversion .output').empty();
                cek_max = 1;
            }

            var unit_conversion = $('#select_unit_conv option:selected').val();
            if(unit_conversion != ''){
                qty_to_converse_key_up = new_array[unit_conversion][1];
                type_key_up = new_array[unit_conversion][0];
                $('input[name=type]').val(type_key_up);
                $('input[name=conv]').val(qty_to_converse_key_up);
                if(type_key_up=='distribution'){
                    if(parseInt(qty_conv)<parseInt(qty_to_converse_key_up)){
                        document.getElementById('cek_conversion').style.display = 'block';
                        $('#form_conversion .modal-footer .submit_conversion').prop('disabled', true);
                        $('#form_conversion .output').empty();
                    }else{
                        document.getElementById('cek_conversion').style.display = 'none';
                        if(cek_max != 1){
                            output(id_product, name, max, qty_conv, unit, type_key_up, qty_to_converse_key_up, unit_conversion);
                        }
                    }
                }else{
                    document.getElementById('cek_conversion').style.display = 'none';
                    $('#form_conversion .modal-footer .submit_conversion').prop('disabled', false);
                    if(cek_max != 1){
                        output(id_product, name, max, qty_conv, unit, type_key_up, qty_to_converse_key_up, unit_conversion);
                    }
                }
            }

        });

        $('#select_unit_conv').change(function(){
            var unit_value = $('#select_unit_conv option:selected').val();
            var qty_change = $('#input_qty_conv').val();
            qty_to_converse_change = new_array[unit_value][1];
            type_change = new_array[unit_value][0];
            $('input[name=type]').val(type_change);
            $('input[name=conv]').val(qty_to_converse_change);
            if(type_change=='distribution'){
                if(qty_change != ''){
                    if(parseInt(qty_change)<parseInt(qty_to_converse_change)){
                        document.getElementById('cek_conversion').style.display = 'block';
                        $('#form_conversion .modal-footer .submit_conversion').prop('disabled', true);
                        $('#form_conversion .output').empty();
                    }else{
                        document.getElementById('cek_conversion').style.display = 'none';
                        $('#form_conversion .modal-footer .submit_conversion').prop('disabled', false);
                        output(id_product, name, max, qty_change, unit, type_change, qty_to_converse_change, unit_value);
                    }
                }
            }else{
                document.getElementById('cek_conversion').style.display = 'none';
                $('#form_conversion .modal-footer .submit_conversion').prop('disabled', false);
                output(id_product, name, max, qty_change, unit, type_change, qty_to_converse_change, unit_value);
            }
        })


    }

    function output(id, product, max, qty, unit, method, conv, unit_conv){
        $('#form_conversion .output').empty();
        var output_val = '';
        if(method == 'distribution'){
            output_val = Math.floor(qty / conv);
            qty = output_val * conv;

        }else{
            output_val = qty * conv;
        }
        var output_qty_after = max - qty;
        var conv_qty = $(`tr[data-id=${id}_${unit_conv}] .qty`).html();
            if(conv_qty != undefined){
                output_val = output_val + parseInt(conv_qty);
            }
        var html = `
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${product}</td>
                        <td class="text-center">${unit}</td>
                        <td class="text-center">${output_qty_after}</td>
                    </tr>
                    <tr>
                        <td>${product}</td>
                        <td class="text-center">${unit_conv}</td>
                        <td class="text-center">${output_val}</td>
                    </tr>
                </tbody>
            </table>
        `;
        $('#form_conversion .output').append(html);
    }

    $('#form_conversion .modal-footer .submit_conversion').on('click', function(){
        if (!$('form#form_conversion_submit')[0].checkValidity()) {
            toastr.warning("Incompleted Data. Please fill blank input.");
        }else{
            $('form#form_conversion_submit').submit();
        }
    });



  </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.appender').on('click','.appender-btn',function(){
            var value=$(this).data('value');
            var target=$(this).parents('.appender').data('target');
            var newValue=$(target).val()+value;
            $(target).val(newValue);
            $(target).focus();
        });
    });
    function showXenditInput() {
        $('#input-xendit-form').removeClass('hidden');
        $('#input-xendit-view').addClass('hidden');
    }
    function hideXenditInput() {
        $('#input-xendit-form').addClass('hidden');
        $('#input-xendit-view').removeClass('hidden');
    }
    function submitXenditInput() {
        const xenditId = $('#input-xendit-form :input[name=xendit_id]').val();
        const button = $('#input-xendit-form button');
        const okButton = $('#input-xendit-form #input-xendit-ok-btn').html('<i class="fa fa-spinner fa-spin"></i>');
        button.prop('disabled', true);
        $.ajax({
            method: "POST",
            url: "{{url('fire/xendit-account/update')}}",
            data: {
                _token: "{{csrf_token()}}",
                xendit_id: xenditId,
                id_outlet: {{$outlet[0]['id_outlet']}}
            },
            success: response => {
                console.log(response);
                okButton.html('<i class="fa fa-check"></i>');
                button.prop('disabled', false);
                if (response.status == 'success') {
                    hideXenditInput();
                    if (xenditId) {
                        $('#input-xendit-view span').html(`${response.result.public_profile.business_name} (${response.result.email})`);
                    } else {
                        $('#input-xendit-view span').html('<em class="text-muted">Not Set</em>');
                    }
                    toastr.info("Success update data");
                } else {
                    okButton.html('<i class="fa fa-check"></i>');
                    button.prop('disabled', false);
                    toastr.error(response?.messages[0]);
                }
            },
            error: errors => {
                console.log(errors);
                okButton.html('<i class="fa fa-check"></i>');
                button.prop('disabled', false);
                toastr.error(errors?.responseJSON?.messages ? errors?.responseJSON?.messages[0] : "Something went wrong");
            }
        })
    }
</script>
<script type="text/javascript">
    const productIcountUnit = {};
    function updateSelectUnit() {
        const selectedProduct = $('.select_product_icount').val();
        if (!selectedProduct) {
            return;
        }
        const units = productIcountUnit[$('.select_product_icount').val()];
        const options = [];
        if (units) {
            for (key in units) {
                unit = units[key];
                options.push(`<option value="${unit.id_unit_icount}">${unit.unit}</option>`);
            }
        }
        $('#form_stock_adjustment_submit :input[name=unit]').html(options.join(''));
        unitSelected();
    }

    function unitSelected() {
        const units = productIcountUnit[$('.select_product_icount').val()];
        if (units == undefined) {
            $('#form_stock_adjustment_submit :input[name=current_stock]').val('');
            $('#form_stock_adjustment_submit :input[name=new_stock]').val('');
            $('#form_stock_adjustment_submit :input[name=stock_adjustment]').val('');
            return;
        }
        let unit = undefined;
        units.forEach(unitx => {
            if (unitx.id_unit_icount == $('#form_stock_adjustment_submit :input[name=unit]').val()) {
                unit = unitx;
            }
        })
        if (unit) {
            $('#form_stock_adjustment_submit :input[name=current_stock]').val(unit.stock);
            $('#form_stock_adjustment_submit :input[name=new_stock]').val(unit.stock);
            $('#form_stock_adjustment_submit :input[name=stock_adjustment]').val(0);
        }
    }

    function adjustStock(column) {
        let a, b, c;
        const stock = $('#form_stock_adjustment_submit :input[name=current_stock]').val();
        if (column == 'new_stock') {
            a = $(`#form_stock_adjustment_submit :input[name=new_stock]`);
            b = $(`#form_stock_adjustment_submit :input[name=stock_adjustment]`);
            b.val(parseInt(a.val()) - parseInt(stock));
        } else {
            a = $(`#form_stock_adjustment_submit :input[name=stock_adjustment]`);
            b = $(`#form_stock_adjustment_submit :input[name=new_stock]`);
            b.val(parseInt(a.val()) + parseInt(stock));
        }
    }

    function submitStockAdjustment() {
        $.ajax({
            method: 'POST',
            url: '{{url('fire/outlet/stock/adjust')}}',
            data: {
                id_outlet: {{$outlet[0]['id_outlet']}},
                id_product_icount: $('.select_product_icount').val(),
                unit: $('#form_stock_adjustment_submit :input[name=unit]').val(),
                stock_adjustment: $('#form_stock_adjustment_submit :input[name=stock_adjustment]').val(),
                notes: $('#form_stock_adjustment_submit :input[name=notes]').val(),
                title: $('#form_stock_adjustment_submit :input[name=title]').val(),
                _token: '{{csrf_token()}}',
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#form_stock_adjustment_submit :input').val('').change();
                    $('#form_stock_adjustment_submit :input[name=title]').val('Stock Adjustment');
                    swal({
                            title: 'Success', 
                            text: 'Success adjust stock', 
                            type: 'success'
                        }, 
                        function() {
                            window.location.hash = '#product_icount';
                            window.location.reload();
                        }
                    );
                    $('#modal_stock_adjustment').modal('hide');
                    return;
                } else {
                    if (response.messages) {
                        swal('Error', response.messages.join('\n'), 'error');
                    } else {
                        swal('Error', 'Something went wrong', 'error');
                    }
                }
            },
        });
    }

    $(document).ready(() => {
        $('.select_product_icount').select2({
            ajax: {
                url: '{{url('fire/product/be/icount/list')}}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q: params.term,
                        for_select2: 1,
                        id_outlet: {{$outlet[0]['id_outlet']}},
                    };

                    return query;
                },
                processResults: response => {
                    const result = {
                        results : [],
                        pagination: {
                            more: false,
                        }
                    };
                    if (response.result) {
                        result.results = response.result.map(item => {
                            const unit_icount = {};
                            item.unit_icount.forEach(unit => {
                                unit.stock = 0;
                                item.product_icount_outlet_stocks.forEach(stock => {
                                    if (stock.unit == unit.unit) {
                                        unit.stock = stock.stock;
                                    }
                                })
                                unit_icount[unit.id_unit_icount] = unit;
                            })
                            productIcountUnit[item.id_product_icount] = item.unit_icount;
                            return {
                                'id': item.id_product_icount,
                                'text': item.name
                            };
                        });
                    }
                    return result;
                },
                delay: 250,
            },
            minimumInputLength: 1,
        });
    })
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

    <a href="{{url('outlet/list')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $outlet[0]['outlet_code'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
                <li>
                    <a href="#product" data-toggle="tab" > Product Stock </a>
                </li>
                <li>
                    <a href="#product_icount" data-toggle="tab" > Product Icount Stock </a>
                </li>
{{--                 <li id="pinOutlet">
                    <a href="#pin" data-toggle="tab" > Update Pin </a>
                </li> --}}
                @if(MyHelper::hasAccess([29], $grantedFeature))
                    <li>
                        <a href="#photo" data-toggle="tab"> Photo </a>
                    </li>
                @endif
                <li>
                    <a href="#box" data-toggle="tab"> Box </a>
                </li>
                @if(MyHelper::hasAccess([4], $configs))
                    @if(MyHelper::hasAccess([34], $grantedFeature))
                        <li>
                            <a href="#holiday" data-toggle="tab"> Holiday </a>
                        </li>
                    @endif
                @endif
                @if(MyHelper::hasAccess([5], $configs))
                    @if(MyHelper::hasAccess([39,40,41], $grantedFeature))
                        <li>
                            <a href="#admin" data-toggle="tab"> Admin Outlet </a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="#schedule" data-toggle="tab"> Schedule </a>
                </li>
                @if(MyHelper::hasAccess([51], $grantedFeature))
                <li>
                    <a href="#visibility" data-toggle="tab"> Visibility </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('outlet::info')
                </div>
                <div class="tab-pane" id="product">
                    @include('outlet::product')
                </div>
                <div class="tab-pane" id="product_icount">
                    @include('outlet::product_icount')
                </div>
                <div class="tab-pane" id="pin">
                    @include('outlet::pin')
                </div>
                <div class="tab-pane" id="photo">
                    @include('outlet::photo')
                </div>
                <div class="tab-pane" id="box">
                    @include('outlet::box')
                </div>
                <div class="tab-pane" id="holiday">
                    @include('outlet::holiday')
                </div>
                <div class="tab-pane" id="admin">
                    @include('outlet::admin')
                </div>
                <div class="tab-pane" id="schedule">
                    @include('outlet::schedule_open')
                </div>
                <div class="tab-pane" id="visibility">
                    @include('outlet::outlet_visibility')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="form_conversion" tabindex="-1" role="dialog" aria-labelledby="conversionModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">UNIT CONVERSION</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 15px !important">
                    <form class="form-horizontal" role="form" action="{{ url('outlet/detail') }}/{{ $outlet[0]['outlet_code'] }}/stock" id="form_conversion_submit" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group info-conv">

                            </div>
                            <div class="form-group main">
                                
                            </div>
                            <p style="color: red; display: none; margin-top: 8px; margin-bottom: 8px; margin-left: 50px" id="cek_maximal">Invalid value, Maximal value to conversion is 6</p>
                            <p style="color: red; display: none; margin-top: 8px; margin-bottom: 8px; margin-left: 50px" id="cek_conversion">The number of units to be converted is not enough</p>
                        </div>
                        {{ csrf_field() }}
                    </form>
                    <div class= "output">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary submit_conversion">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection