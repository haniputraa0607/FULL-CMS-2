@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('[data-switch=true]').bootstrapSwitch();
            $('#btn-submit').on('click', function(event) {
                if(document.getElementById('auto_generate_pin').checked == false){
                    if($('#pin1').val() !== $('#pin2').val()) {
                        Swal.fire(
                            "Woops!",
                            'Password didn\'t match' ,
                            "error"
                        )
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }


                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test($('#input-email').val())){
                    Swal.fire(
                        "Woops!",
                        'Format email is not valid' ,
                        "error"
                    )
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });

        function changeLevel(value){
            if(value == 'User Franchise'){
                $("#select_outlet").show();
            }else{
                $("#select_outlet").hide();
            }
        }

        function changeResetPin() {
            if(document.getElementById('reset_pin').checked){
                $("#div_password").hide();
                $('#pin1').prop('required', false);
                $('#pin2').prop('required', false);
            }else{
                $("#div_password").show();
                $('#pin1').prop('required', true);
                $('#pin2').prop('required', true);
            }
        }

        $('#input-username').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9_-]*$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str) || e.which == 8) {
                return true;
            }

            e.preventDefault();
            return false;
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Partner Detail</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('businessdev/partners/update')}}/{{$result['id_partner']}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" id="input-name" name="name" value="{{$result['name']}}" placeholder="Enter name here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Phone <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan phone" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" id="input-phone" name="phone" value="{{$result['phone']}}" placeholder="Enter phone here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Email <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan email" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="email" id="input-email" name="email" value="{{$result['email']}}" placeholder="Enter email here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Address <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan address" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" id="input-address" name="address" value="{{$result['address']}}" placeholder="Enter address here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Ownership Status <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih Ownership Status" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input data-switch="true" type="checkbox" name="ownership_status" data-on-text="Central" data-off-text="Partner" {{$result['ownership_status'] ==  'Central' ? 'checked' : ''}}/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Coopertaion Scheme<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih Coopertaion Scheme" data-container="body"></i></label>
                        <div class="col-md-6">
                            <select name="cooperation_scheme" class="form-control input-sm select2" placeholder="Coopertaion Scheme">
                              <option value="Profit Sharing" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Profit Sharing') selected @endif @endif>Profit Sharing</option>
                              <option value="Management Fee" @if(isset($result['cooperation_scheme'])) @if($result['cooperation_scheme'] == 'Management Fee') selected @endif @endif>Management Fee</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Bank Account<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih Bank Account" data-container="body"></i></label>
                        <div class="col-md-6">
                            <select name="id_bank_account" class="form-control input-sm select2" placeholder="Bank Account">
                            @foreach($bank as $b)
                                <option value="{{$b['id_bank_account']}}" @if($result['id_bank_account'] == $b['id_bank_account']) selected @endif>{{$b['id_bank_account']}} - {{$b['beneficiary_name']}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Status<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih status partner" data-container="body"></i></label>
                        <div class="col-md-6">
                            @if($title=='Candidate Partners')
                            <input data-switch="true" type="checkbox" name="status" data-on-text="Active" data-off-text="Candidate" {{$result['status'] ==  'Active' ? 'checked' : ''}}/>
                            @else
                            <input data-switch="true" type="checkbox" name="status" data-on-text="Active" data-off-text="Inactive" {{$result['status'] ==  'Active' ? 'checked' : ''}}/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Start Date <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Mulai menjadi Partner" data-container="body"></i></label>
                        <div class="col-md-6">
                            @if($title=='Candidate Partners')
                            @else
                            <input class="form-control" type="text" id="input-start-date" name="start_date" value="{{date('d F Y H:i', strtotime($result['start_date']))}}" readonly/>
                            @endif
                        </div>
                    </div>
                    @foreach($result['partner_locations'] as $location)
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-4">Location name {{$loop->iteration}} <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Lokasi Outlet Partner" data-container="body"></i></label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="input-name_location" name="name_location" value="{{$location['name']}}" placeholder="Enter phone here"/>  
                        </div>
                        <a href="..." class="btn btn-primary"></i>Detail</a>  
                    </div>
                    @endforeach
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection