<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    
    
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            $('.summernote').summernote({
                placeholder: 'Product Description',
                tabsize: 2,
                height: 120,
                // fontNames: ['Open Sans'],
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
                callbacks: {
                    onImageUpload: function(files){
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/product')}}",
                            success: function(data){
                            }
                        });
                    }
                }
            });


            function sendFile(file, id){
                token = "<?php echo csrf_token(); ?>";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                $.ajax({
                    url : "{{url('summernote/picture/upload/product')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#'+id).summernote('editor.saveRange');
							$('#'+id).summernote('editor.restoreRange');
							$('#'+id).summernote('editor.focus');
                            $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                    },
                    error: function(data){
                    }
                })
            }

            // untuk show atau hide informasi photo
            if ($('.deteksi').data('dis') != 1) {
                $('.deteksi-trigger').hide();
            }
            else {
                $('.deteksi-trigger').show();
            }

            let token = "{{ csrf_token() }}";

            // sortable
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

            // hapus gambar
            $('.hapus-gambar').click(function() {
                let id     = $(this).data('id');
                let parent = $(this).parent().parent().parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('product/photo/delete') }}",
                    data : "_token="+token+"&id_product_photo="+id,
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

            $('.disc').click(function() {
                let type = $(this).data('type');

                if (type == "percentage") {
                    $('.'+type+'-div').show();
                    $('.'+type).prop('required', true);
                    $('.nominal-div').hide();
                    $('.nominal').removeAttr('required');
                    $('.nominal').val('');
                }
                else {
                    $('.'+type+'-div').show();
                    $('.'+type).prop('required', true);
                    $('.percentage-div').hide();
                    $('.percentage').removeAttr('required');
                    $('.percentage').val('');
                }
            });

            @foreach($outlet_all as $key => $ou)
            <?php $marker = 0; ?>
                @foreach($ou['product_detail'] as $keyPrice => $price)
                    @if($price['id_product'] == $product[0]['id_product'])
                        @php $marker = 1; break; @endphp
                    @endif
                @endforeach
                var option =  '<option class="option-visibility" data-id={{$product[0]["id_product"]}}/{{$ou["id_outlet"]}}>{{$ou["outlet_code"]}} - {{$ou["outlet_name"]}}</option>'
                @if($marker == 1 && $price["product_detail_visibility"])
                        $('#visibleglobal-{{lcfirst($price["product_detail_visibility"])}}').append(option)
                @else
                    $('#visibleglobal-default').append(option)
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

            $('#default-to-hidden').click(function() {
                if($('#visibleglobal-default').val() == null){
                    toastr.warning("Choose minimal 1 outlet in default visibility");
                }else{
                    var id =[];
                    $('#visibleglobal-default option:selected').each(function () {
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
                                $('#visibleglobal-default option:selected').each(function () {
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

            $('#default-to-visible').click(function() {
                if($('#visibleglobal-default').val() == null){
                    toastr.warning("Choose minimal 1 outlet in default visibility");
                }else{
                    var id =[];
                    $('#visibleglobal-default option:selected').each(function () {
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
                                $('#visibleglobal-default option:selected').each(function () {
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

            $('#move-default').click(function() {
                if($('#visibleglobal-hidden').val() == null && $('#visibleglobal-visible').val() == null){
                    toastr.warning("Choose minimal 1 outlet in hidden or visible");
                }else{
                    var id =[];
                    $('#visibleglobal-hidden option:selected').each(function () {
                        var $this = $(this);
                        id.push($this.attr('data-id'))
                    })
                    $('#visibleglobal-visible option:selected').each(function () {
                        var $this = $(this);
                        id.push($this.attr('data-id'))
                    })
                    let token  = "{{ csrf_token() }}";

                    $.ajax({
                        type : "POST",
                        url : "{{ url('product/update/visible') }}",
                        data : "_token="+token+"&id_visibility="+id+"&visibility=",
                        success : function(result) {
                            if (result.status == "success") {
                                toastr.info("Visibility has been updated.");
                                $('#visibleglobal-hidden option:selected').each(function () {
                                    var $this = $(this);
                                    var option = '<option class="option-visibility" data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>'
                                    $('#visibleglobal-default').append(option)
                                    $(this).remove()
                                })
                                $('#visibleglobal-visible option:selected').each(function () {
                                    var $this = $(this);
                                    var option = '<option class="option-visibility" data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>'
                                    $('#visibleglobal-default').append(option)
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

            $('#search-outlet').on("keyup", function(){
                var search = $('#search-outlet').val();
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
                $('#search-outlet').val("")
                $(".option-visibility").each(function(){
                    $(this).show()
                })
                $('#btn-reset').hide()
                $('#div-left').show()
            })
        });
        $(document).ready(function() {
            $(".price_float").each(function() {
                var input = $(this).val();
                var input = input.replace(/[^[^0-9]\s\_\-]+/g, "");
                input = input ? parseFloat( input ) : 0;
                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id", {minimumFractionDigits: 2} );
                } );
            });
		});

		$('.price').each(function() {
			var input = $(this).val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;

			$(this).val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString( "id" );
			});
		});

		$( ".price" ).on( "keyup", numberFormat);
		function numberFormat(event){
			var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}

			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			var $this = $( this );
			var input = $this.val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;

			$this.val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString( "id" );
			});
		}

		$( ".price" ).on( "blur", checkFormat);
		function checkFormat(event){
			var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
			if(!$.isNumeric(data)){
				$( this ).val("");
			}
		}
		$( "#formWithPrice2" ).submit(function() {
			$( "#submit" ).attr("disabled", true);
			$( "#submit" ).addClass("m-loader m-loader--light m-loader--right");
			$( ".price_float" ).each(function() {
				var number = $( this ).val().replace(/[($)\s\._\-]+/g, '').replace(/[($)\s\,_\-]+/g, '.');
				$(this).val(number);
			});
			$('.price').each(function() {
				var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
				$(this).val(number);
			});

		});

    </script>
    <script type="text/javascript">
        $('.datatable').dataTable();
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete-disc', function() {
            let token  = "{{ csrf_token() }}";
            let column = $(this).parents('tr');
            let id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('product/discount/delete') }}",
                data : "_token="+token+"&id_product_discount="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Discount has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete discount.");
                    }
                }
            });
        });

         $(".file").change(function(e) {
            var widthImg  = 300;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                    //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        $('#fieldphoto').val("");

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
        $(".filePhotoDetail").change(function(e) {
            var widthImg  = 720;
            var heightImg = 360;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                    //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproductDetail').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA&amp;text=no+image');
                        $('#filePhotoDetail').val("");

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
        $('#select_tag').change(function(){
			var value = $(this).val();
            if(value !== null){
                value.forEach(function(tag_selected,i){
                    if(tag_selected == '+'){
                        $('.bootstrap-select').removeClass('open')
                        $('#m_modal_5').modal('show');
                        value.splice (i, 1);
                    }
                })
                $('#select_tag').val(value)
                $('#select_tag').selectpicker('refresh')
            }
		})

		$('#new_tag').click(function(){
			var tag_name = $('#tag_name').val();
			var token  = "{{ csrf_token() }}";
            var tag_selected = $('#select_tag').val()
			$.ajax({
                type : "POST",
                url : "{{ url('product/tag/create') }}",
                data : "_token="+token+"&tag_name="+tag_name+"&ajax=1",
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("New tag has been created.");
						$('#option_new_tag').after(
							'<option value="'+result.result.id_tag+'">'+result.result.tag_name+'</option>'
						);
						$('#select_tag').selectpicker('refresh');
                        if(tag_selected !== null){
                            tag_selected.splice (0, 0, result.result.id_tag);
                            $('#select_tag').val(tag_selected)
                        }else{
                            $('#select_tag').val([result.result.id_tag])
                        }
                        $('#select_tag').selectpicker('refresh')
                    }
                    else if(result.status == "fail"){
                        toastr.error(result.messages[0]);
                    }else{
                        toastr.warning('Failed to create tag.');
                    }
                    $('#m_modal_5').modal('hide');
                }
            });
		})
    $('#close_modal').click(function(){
        var value = $('#select_tag').val();
        value.splice (0, 0);
        $('#select_tag').val(value)
        $('#select_tag').selectpicker('refresh')
	})
    </script>

<script type="text/javascript">
    $(document).on('click', '.same', function() {
      var price = $(this).parent().parent().parent().find('.product-price').val();
      var visibility = $(this).parent().parent().parent().find('.product-visibility').val();
      var stock = $(this).parent().parent().parent().find('.product-stock').val();

      if (price == '') {
        alert('Price field cannot be empty');
        $(this).parent().parent().parent().find('.product').focus();
        return false;
      }


      if (stock == '') {
        alert('Stock field cannot be empty');
        $(this).parent().parent().parent().find('.product-price-stock').focus();
        return false;
      }

      if ($('.checkbox-outlet').is(':checked')) {
        var check = $('input[name="sameall[]"]:checked').length;
        var count = $('.checkbox-outlet').prop('checked', false);
        $(this).prop('checked', true);

        if (check == 1) {
            var all_visibility = $('.product-visibility-value');
            var array_visibility = [];
            for (i = 0; i < all_visibility.length; i++) {
                array_visibility.push(all_visibility[i]['defaultValue']);
            }
            sessionStorage.setItem("product_visibility", array_visibility);

            var all_stock = $('.product-stock-value');
            var array_stock = [];
            for (i = 0; i < all_stock.length; i++) {
                array_stock.push(all_stock[i]['defaultValue']);
            }
            sessionStorage.setItem("product_stock", array_stock);

        }

        $('.product-visibility').val(visibility);
        $('.product-stock').val(stock);

      } else {

          var item_visibility = sessionStorage.getItem("product_visibility");
          var item_stock = sessionStorage.getItem("product_stock");

            if(item_visibility){
                var item_visibility = item_visibility.split(",");
                $('.product-visibility').each(function(i, obj) {
                    $(this).val(item_visibility[i]);
                });
            }

            if(item_stock){
                var item_stock = item_stock.split(",");
                $('.product-stock').each(function(i, obj) {
                    $(this).val(item_stock[i]);
                });
            }

            $(this).parent().parent().parent().find('.product-visibility').val(visibility);
            $(this).parent().parent().parent().find('.product-stock').val(stock);
        }

        if ($('.checkbox-price').is(':checked')) {
            var check = $('input[name="sameall[]"]:checked').length;
            var count = $('.checkbox-price').prop('checked', false);
            $(this).prop('checked', true);

            if (check == 1) {
                var all_price = $('.product-price');
                var array_price = [];
                for (i = 0; i < all_price.length; i++) {
                    array_price.push(all_price[i]['defaultValue']);
                }
                sessionStorage.setItem("product_price", array_price);
            }

            $('.product-price').val(price);

        } else {

            var item_price = sessionStorage.getItem("product_price");

            if(item_price){
                var item_price = item_price.split(",");

                $('.product-price').each(function(i, obj) {
                    $(this).val(item_price[i]);
                });

                $(this).parent().parent().parent().find('.product-price').val(price);
            }
        }
    });

    $('#checkbox-variant').on('ifChanged', function(event) {
        if(this.checked) {
            $('#nav-prod-variant').show();
            $("input[name=product_global_price]").val('');
            $("input[name=product_global_price]").prop('disabled', true);
            $('input[name=product_global_price]').prop('required',false);
        }else{
            $('#nav-prod-variant').hide();
            $("input[name=product_global_price]").val($("#old_global_price").val());
            $("input[name=product_global_price]").prop('disabled', false);
            $('input[name=product_global_price]').prop('required',true);
        }
    });

    $('#select2-product-variant').change(function(e) {
        var selected = $(e.target).val();
        if(selected !== null){
            var last = selected[selected.length-1];
            var cek = 0;
            for(var i=0;i<selected.length;i++){
                var split = selected[i].split("|");
                var split2 = last.split("|");

                if(split[0] === split2[1]){
                    cek = 1;
                    selected.splice(i, 1);
                }
            }
            if(cek === 1){
                $("#select2-product-variant").val(selected).trigger('change');
            }
        }
    });

    var row = "{{$count}}";
    function addProductVariantGroup() {
        var product_variant = $('#select2-product-variant').val();
        var product_variant_price = $('#product-variant-group-price').val();
        var product_variant_group_code = $('#product-variant-group-code').val();
        var product_variant_group_id = $('#product-variant-group-id').val();
        var text = $('#select2-product-variant option:selected').toArray().map(item => item.text).join();
        var visibility = $('input[name="product_variant_group_visibility"]:checked').val();
        var msg_error = '';

        if(product_variant.length <= 0){
            msg_error += '-Please select one or more product variant <br>';
        }

        var check_level = '';
        var id = [];
        for(var i=0;i<product_variant.length;i++){
            var split = product_variant[i].split("|");
            id.push(split[0]);
            if(check_level == split[1]){
                msg_error += '-Can not select same level in product variant group<br>';
            }
            check_level = split[1];
        }

        var checkSameCombination = 0;
        $('#table-product-variant > tbody  > tr').each(function(index, tr) {
            if($('#product-variant-'+index).val()){
                var arrProdVariantFromTable = $('#product-variant-'+index).val().split(",");
                var flag = 0;
                for(var i=0;i<arrProdVariantFromTable.length;i++){
                    if(id.indexOf(arrProdVariantFromTable[i]) >= 0){
                        flag++;
                    }
                }
                if(flag > 1){
                    checkSameCombination = 1;
                }
            }
        });

        if(checkSameCombination === 1){
            msg_error += '-Combination "'+text+'" already exist<br>';
        }

        if(product_variant_group_code === ''){
            msg_error += '-Please input code <br>';
        }

        if(product_variant_price === ''){
            msg_error += '-Please input price <br>';
        }

        if(msg_error !== ""){
            toastr.warning(msg_error);
        }else{
            var html = '';
            html += '<tr>';
            html += '<td>'+text+'</td>';
            html += '<td>'+product_variant_group_code+'</td>';
            html += '<td>'+product_variant_price+'</td>';
            html += '<td>'+visibility+'</td>';
            if(product_variant_group_id){
                html += '<td><a  onclick="deleteRowProductVariant(this,'+product_variant_group_id+')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>' +
                    '<a  onclick="editRowProductVariant(this,'+row+')" data-toggle="confirmation" class="btn btn-sm btn-primary" style="margin-left: 2%"><i class="fa fa-pen"></i> Edit</a></td>';
            }else{
                html += '<td><a  onclick="deleteRowProductVariant(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>' +
                    '<a  onclick="editRowProductVariant(this,'+row+')" data-toggle="confirmation" class="btn btn-sm btn-primary" style="margin-left: 2%"><i class="fa fa-pen"></i> Edit</a></td>';
            }

            html += '<input type="hidden" id="product-variant-'+row+'" name="data['+row+'][id]" value="'+id+'">';
            html += '<input type="hidden" id="product-variant-edit-'+row+'" name="data['+row+'][id-edit]" value="'+product_variant+'">';
            html += '<input type="hidden" id="product-variant-group-code-'+row+'" name="data['+row+'][code]" value="'+product_variant_group_code+'">';
            html += '<input type="hidden" id="product-variant-price-'+row+'" name="data['+row+'][price]" value="'+product_variant_price+'">';
            html += '<input type="hidden" id="product-variant-group-id-'+row+'" name="data['+row+'][group_id]" value="'+product_variant_group_id+'">';
            html += '<input type="hidden" id="product-variant-group-visibility-'+row+'" name="data['+row+'][visibility]" value="'+visibility+'">';
            html += '</tr>';

            $("#select2-product-variant").val(null).trigger('change');
            $('#product-variant-group-price').val('');
            $('#product-variant-group-code').val('');
            $('#product-variant-group-id').val('');

            $( "#product-variant-group-body" ).append(html);
            row++;

            var arr_tmp = [];
            $("#table-product-variant > tbody > tr").each(function(index, tr) {
                var price = document.getElementById("table-product-variant").rows[index+1].cells[1].innerHTML;
                arr_tmp.push(price);
            });

            var min_price = Math.min.apply(Math,arr_tmp);
            $('#product_base_price_pvg').val(min_price);
        }
    }

    function deleteRowProductVariant(content, id = null) {
        if(confirm('Are you sure you want to delete this product variant group?')) {

            if(id !== null){
                var token  = "{{ csrf_token() }}";
                $.ajax({
                    type : "POST",
                    url : "{{ url('product/product-variant-group/delete') }}",
                    data : "_token="+token+"&id_product_variant_group="+id,
                    success : function(result) {
                        if (result.status == "success") {
                            $(content).parent().parent('tr').remove();
                            toastr.info("Successfully delete the product variant group");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete product variant group.");
                        }
                    }
                });
            }else{
                $(content).parent().parent('tr').remove();
                toastr.info("Successfully delete the product variant");
            }
        }
    }

    function editRowProductVariant(content,id) {
        var product_variant = $('#select2-product-variant').val();
        var product_variant_price = $('#product-variant-group-price').val();
        var product_variant_group_code = $('#product-variant-group-code').val();

        if(product_variant !== null || product_variant_price !== "" || product_variant_group_code !== ""){
            toastr.warning("Please complete your edit process");
        }else{
            var data_id = $('#product-variant-edit-'+id).val().split(',');
            var data_price = $('#product-variant-price-'+id).val();
            var group_id = $('#product-variant-group-id-'+id).val();
            var code = $('#product-variant-group-code-'+id).val();
            var visibility = $('#product-variant-group-visibility-'+id).val();

            if(visibility == 'Visible'){
                document.getElementById("radio-variant-visibility1").checked = true;
                document.getElementById("radio-variant-visibility2").checked = false;
            }else{
                document.getElementById("radio-variant-visibility1").checked = false;
                document.getElementById("radio-variant-visibility2").checked = true;
            }

            $("#select2-product-variant").val(data_id).trigger('change');
            $('#product-variant-group-price').val(data_price);
            $('#product-variant-group-id').val(group_id);
            $('#product-variant-group-code').val(code);
            $(content).parent().parent('tr').remove();
        }
    }

    function submitProductVariant() {
        var product_variant = $('#select2-product-variant').val();
        var product_variant_price = $('#product-variant-group-price').val();
        var product_variant_group_code = $('#product-variant-group-code').val();

        if(product_variant !== null || product_variant_price !== "" || product_variant_group_code !== ""){
            toastr.warning("Please complete your edit process");
        }else{
            var tbody = $("#table-product-variant tbody");

            if (tbody.children().length == 0) {
                toastr.warning("Please add 1 or more product variant group.");
            }else{
                $( "#form_product_variant_group" ).submit();
            }
        }
    }

    var count_product_service_use = {{(empty($product_icount_use) ? 1: count($product_icount_use))}}
    function addProductServiceUse() {
        var html_select = '';
        <?php
        foreach($product_uses as $row){
        ?>
            html_select += `<option value='<?php echo $row['id_product_icount']; ?>'><?php echo $row['code']; ?> - <?php echo $row['name']; ?></option>`;
        <?php
        }
        ?>

        var html = '<div id="div_product_use_'+count_product_service_use+'">'+
        '<div class="form-group">'+
        '<div class="col-md-1"></div>'+
        '<div class="col-md-5">'+
        '<select class="form-control select2" id="product_use_code_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][id_product_icount]" required placeholder="Select product use" style="width: 100%" onchange="changeUnit('+count_product_service_use+',this.value)">'+
        '<option></option>'+html_select+
        '</select>'+
        '</div>'+
        '<div class="col-md-2">'+
        '<select class="form-control select2" id="product_use_unit_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][unit]" required placeholder="Select unit" style="width: 100%">'+
        '<option></option>'+
        '<option value="PCS">PCS</option>'+
        '</select>'+
        '</div>'+
        '<div class="col-md-1">'+
        '<div class="input-group">'+
        '<input type="text" class="form-control price" id="product_use_qty_'+count_product_service_use+'" name="product_icount['+count_product_service_use+'][qty]" required>'+
        '</div>'+
        '</div>'+
        '<div class="col-md-2" style="margin-left: 2%">'+
        '<a class="btn btn-danger btn" onclick="deleteProductServiceUse('+count_product_service_use+')">&nbsp;<i class="fa fa-trash"></i></a>'+
        '</div>'+
        '</div>'+
        '</div>';

        $("#div_product_use").append(html);
        $('.select2').select2({placeholder: "Search"});
        count_product_service_use++;
    }

    function deleteProductServiceUse(number){
        $('#div_product_use_'+number).empty();
    }

    function productServiceUseSubmit() {
        var data = $('#form-product-service').serialize();

        if (!$('form#form-product-service')[0].checkValidity()) {
            toastr.warning("Incompleted Data. Please fill blank input.");
        }else{
            $('form#form-product-service').submit();
        }
    }

    function changeUnit(no,value){
        this_id = '#product_use_unit_'+no;
        $(this_id).empty();
        $('#product_use_unit_'+no).val('');
        $('#product_use_qty_'+no).val('');
        var html_select = '<option></option>';
        var unit1 = '';
        var unit2 = '';
        var unit3 = '';
        <?php 
            foreach($product_uses as $row){ ?>
                if(value=={{ $row['id_product_icount'] }}){
                    unit1 = '{{ $row['unit1'] }}'
                    unit2 = '{{ $row['unit2'] }}'
                    unit3 = '{{ $row['unit3'] }}'
                    if(unit1!=''){
                        html_select += "<option value='<?php echo $row['unit1']; ?>'><?php echo $row['unit1']; ?></option>";
                    }
                    if(unit2!=''){
                        html_select += "<option value='<?php echo $row['unit2']; ?>'><?php echo $row['unit2']; ?></option>";
                    }
                    if(unit3!=''){
                        html_select += "<option value='<?php echo $row['unit3']; ?>'><?php echo $row['unit3']; ?></option>";
                    }
                }
            <?php 
            }
        ?>
        $(this_id).append(html_select);
        $(".select2").select2({
            placeholder: "Search"
        });

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

    @php
        // print_r($product);die();
    @endphp
    @if ($title == 'Product')
    <a href="{{url('product')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @else    
    <a href="{{url('product/icount')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @endif
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject bold uppercase font-blue">{{ $product[0]['product_name'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active">
                    <a href="#info" data-toggle="tab"> Info </a>
                </li>
                <li>
                    <a href="#stock_product" data-toggle="tab"> Stock </a>
                </li>
                {{--  <li>
                    <a href="#productuse" data-toggle="tab"> Product Icount </a>
                </li>  --}}
                <li id="nav-prod-variant" @if($product[0]['product_variant_status'] != 1 || true) style="display: none" @endif>
                    <a href="#variant-group" data-toggle="tab"> Variant Group</a>
                </li>
                <!-- @if(MyHelper::hasAccess([53], $grantedFeature))
                    <li>
                        <a href="#photo" data-toggle="tab"> Photo </a>
                    </li>
                @endif -->
                <li>
                    <a href="#outletsetting" data-toggle="tab"> Outlet Setting</a>
                </li>
                <li>
                    <a href="#outletpricesetting" data-toggle="tab"> Outlet Price Setting</a>
                </li>
                <li>
                    <a href="#visibility" data-toggle="tab"> Visibility </a>
                </li>
                <li>
                    <a href="#commission" data-toggle="tab">Commission Default </a>
                </li>
				<!-- <li>
                    <a href="#discount" data-toggle="tab"> Discount </a>
                </li> -->
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('product::product.info')
                </div>
                <div class="tab-pane" id="stock_product">
                    @include('product::product.stock_product')
                </div>
                {{--  <div class="tab-pane" id="productuse">
                    @include('product::product.product_use')
                </div>  --}}
                <div class="tab-pane" id="variant-group">
                    @include('product::product.product-variant-group')
                </div>
                <div class="tab-pane" id="photo">
                    @include('product::product.photo')
                </div>
				<div class="tab-pane" id="outletsetting">
                    @include('product::product.productDetail')
                </div>
                <div class="tab-pane" id="outletpricesetting">
                    @include('product::product.productSpecialPriceDetail')
                </div>
                <div class="tab-pane" id="discount">
                    @include('product::product.discount')
                </div>
                <div class="tab-pane" id="visibility">
                    @include('product::product.visibility_global')
                </div>
                <div class="tab-pane" id="commission">
                     @include('product::product.commission')
                </div>
            </div>
        </div>
    </div>


@endsection