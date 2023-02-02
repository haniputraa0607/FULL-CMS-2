@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp
@include('filter-v2')
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script type="text/javascript">
        // range date trx, receipt, order id, outlet, customer
        rules = {
            all_data:{
                display:'All Data',
                operator:[],
                opsi:[]
            },
            transaction_receipt_number:{
                display:'Receipt Number',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. TRX-123456789"
            },
            order_id:{
                display:'Order Id',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[],
                placeholder: "ex. I3LX"
            },
            id_outlet:{
                display:'Outlet',
                operator:[],
                opsi:{!! json_encode($outlets ?? []) !!},
            },
            outlet_name:{
                display:'Outlet Name',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            outlet_code:{
                display:'Outlet Code',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            transaction_grandtotal:{
                display:'Grand Total',
                operator:[
                    ['=','='],
					['<','<'],
					['>','>'],
					['<=','<='],
					['>=','>=']
                ],
                opsi:[]
            },
            payment:{
                display:'Payment',
                operator:[],
                opsi:{!! json_encode($payment_list?? []) !!},
            },
            transaction_payment_status:{
                display:'Payment Status',
                operator:[],
                opsi:[
                    ['Pending', 'Pending'],
                    ['Completed', 'Completed'],
                    ['Cancelled', 'Cancelled']
                ]
            },
            name:{
                display:'Customer Name',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            phone:{
                display:'Customer Phone',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
            email:{
                display:'Customer Email',
                operator:[
                    ['=', '='],
                    ['like', 'like']
                ],
                opsi:[]
            },
        };


        $('#table-outlet_service').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-outlet_service').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                },
                dataSrc: (res) => {
                    $('#list-filter-result-counter').text(res.total);
                    return res.data;
                }
            },
            serverSide: true,
            columns: [
                {
                    data: 'transaction_receipt_number',
                    orderable: false,
                    render: function(value, type, row) {

                    	let tooltipTemplate = '<i class="fa fa-question-circle tooltips" data-original-title="%tooltip_text%" data-container="body"></i>';
                    	let tooltipRetry = tooltipTemplate.replace('%tooltip_text%', 'Mengirim ulang permintaan refund ke payment gateway, hanya tersedia untuk beberapa payment gateway yang mendukung (shopeepay, midtrans)');
                    	let tooltipConfirmProcess = tooltipTemplate.replace('%tooltip_text%', 'Konfirmasi refund yang dilakukan secara manual diluar sistem. ketika diklik akan muncul popup berisi form yang perlu diisi');
                    	let tooltipDetailTransaction = tooltipTemplate.replace('%tooltip_text%', 'Halaman detail transaksi');
                    	let tooltipDetailRefund = tooltipTemplate.replace('%tooltip_text%', 'Detail dari hasil pengisian form confirm process');

                        const buttons = [
                            `<a class="btn blue btn-sm btn-outline" href="{{url('transaction/outlet-service/detail')}}/${row.id_transaction}">Detail Transaction ${tooltipDetailTransaction}</a>`
                        ];

                        return buttons.join('');
                    }
                },
                {data: 'transaction_date'},
                {
                    data: 'outlet_name',
                    render: function(value, type, row) {
                        return row.outlet_code + ' - ' + value;
                    }
                },
                {data: 'transaction_receipt_number'},
                {
                    data: 'name',
                    render: function(value, type, row) {
                        return `${row.name}`;
                    }
                },
                {
                    data: 'phone',
                    render: function(value, type, row) {
                        return `${row.phone}`;
                    }
                },
                {
                    data: 'transaction_grandtotal',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'transaction_tax',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'mdr',
                    render: value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value)
                },
                {
                    data: 'transaction_payment_status',
                    className: "text-center",
                    render: function(value, type, row) {
                    	if (value == 'Completed') {
                            return '<div class="badge badge-success">Completed</div>';
                        } else if(value == 'Cancelled') {
                            return '<div class="badge badge-danger">Cancelled</div>';
                        } else {
                            return '<div class="badge badge-warning">Pending</div>';
                        }
                        return `${row.transaction_payment_status}`;
                    }
                },
                {
                    data : 'trasaction_payment_type',
                    className: "text-center",
                    render: function(value, type, row) {
                    	if (value == 'Cash') {
                            const buttons = [
                                `<a class="btn red btn-sm" id="sweetalert-reject"  onClick="cancelPayment(${row.id_transaction},'${row.name}','${row.transaction_receipt_number}')">Cancel Payment</a>`
                            ];

                            return buttons.join('');
                        } else {
                            return '-';
                        }
                    }
                }
            ],
            searching: false,
            drawCallback: function( oSettings ) {
                $('.tooltips').tooltip();
            },
            order: [[ 1, "desc" ]]
        });
		
        function cancelPayment(id,name,receipt){
            swal({
                title: "Are you sure want to cancel this cash payment ?",
                text: "Please input receipt number name to continue!",
                type: "input",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, cancel it!",
                closeOnConfirm: false
                },
                function(inputValue){
                    if(inputValue==receipt){
                        $.ajax({
                            type : "POST",
                            url : "{{url('transaction/outlet-service/cancel-cash')}}/"+id,
                            data : {
                                '_token' : '{{csrf_token()}}'
                            },
                            success : function(response) {
                                if (response.status == 'success') {
                                    swal("Canceled!", "Hair Stylist transaction cash payment has been canceled.", "success")
                                    location.href = "{{url('transaction/outlet-service')}}";
                                }
                                else if(response.status == "fail"){
                                    swal("Error!", "Failed to cancel transaction cash payment.")
                                }
                                else {
                                    swal("Error!", "Something went wrong. Failed to cancel transaction cash payment.")
                                }
                            }
                        })
                    }else if(inputValue==''){
                        swal("Error!", "You need to input receipt number.")

                    }else{
                        swal("Error!", "Receipt number doesnt match")
                    }
                }
            );
        }

        $('#table-outlet_service').on('click', '.confirm-btn', function() {
            $('#modal-confirm :input').val(null);
            const data = $(this).data('data');
            $('#input-id-transaction').val(data.id_transaction);
            $('#input-customer-name').val(`${data.name} (${data.phone})`);
            $('#input-receipt-number').val(data.transaction_receipt_number);
            $('#modal-confirm').modal('show');
        });

        $('#table-outlet_service').on('click', '.retry-btn', function() {
            const parent = $(this).parents('tr');
            const data = $(this).data('data');
            $.blockUI({ message: '<h1>Please wait...</h1>' });
            $.post("{{url('transaction/retry-void-payment/retry')}}", {
                id_transaction: data.id_transaction,
                _token: "{{csrf_token()}}"
            }, function(response) {
                if (response.status == 'success') {
                    toastr.info('Success');
                } else {
                    toastr.error(response.messages?.join('<br />'));
                }
                $.blockUI({ message: '<h1>Reloading table...</h1>' });
                $('#table-outlet_service').DataTable().ajax.reload(null, false);
                $.unblockUI();
            });
        });

        $('#table-outlet_service').on('click', '.detail-btn', function() {
            const data = $(this).data('data');
            $('#preview-id-transaction').val(data.id_transaction);
            $('#preview-customer-name').val(`${data.name} (${data.phone})`);
            $('#preview-receipt-number').val(data.transaction_receipt_number);
            $('#preview-confirm-name').val(`${data.validator_name} (${data.validator_phone})`);
            $('#preview-confirm-at').val((new Date(data.confirm_at)).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"}));
            $('#preview-date-refund').val((new Date(data.refund_date)).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"}));
            $('#preview-note').val(data.note);

            let imageTag = '';

            if (data.images) {
                data.images.forEach(item => {
                    imageTag += `<img src="${item}" class="img-responsive" style="margin-bottom: 5px">`;
                });
            }

            $('#preview-image').html(imageTag);

            $('#modal-detail').modal('show');
        });

        $(document).ready(function() {
            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1,
                endDate: new Date()
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
    @yield('filter_view')
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Transaction Outlet Service</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-outlet_service">
            <thead>
              <tr>
                  <th>Actions</th>
                  <th>Date</th>
                  <th>Outlet</th>
                  <th>Receipt Number</th>
                  <th>Customer Name</th>
                  <th>Phone</th>
                  <th>Total Price</th>
                  <th>Tax</th>
                  <th>MDR</th>
                  <th>Payment Status</th>
                  <th>Cancel Cash Payment</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>

@endsection
