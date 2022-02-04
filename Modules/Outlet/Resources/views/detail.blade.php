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

    <script type="text/javascript">
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
        });
        // sortable
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
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


@endsection