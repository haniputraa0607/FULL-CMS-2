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
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
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
            shop_status:{
                display:'Status',
                operator:[],
                opsi:[
                    ['Pending', 'Pending'],
                    ['Received', 'Received'],
                    ['Ready', 'Ready'],
                    ['Delivery', 'Delivery'],
                    ['Arrived', 'Arrived'],
                    ['Completed', 'Completed'],
                    ['Rejected by Admin', 'Rejected by Admin'],
                    ['Rejected by Customer', 'Rejected by Customer']
                ]
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

        $('#table-shop').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-shop').DataTable().page.info();
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
                            `<a class="btn blue btn-sm btn-outline" href="{{url('transaction/shop/detail')}}/${row.id_transaction}">Detail Transaction ${tooltipDetailTransaction}</a>`
                        ];

                        return buttons.join('');
                    }
                },
                {data: 'transaction_date'},
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
                    data: 'shop_status',
                    className: "text-center",
                    render: function(value, type, row) {
                        if(value == 'Pending'){
                            return '<div class="badge badge-secondary">Pending</div>';
                        }else if (value == 'Completed') {
                            return '<div class="badge badge-success">Completed</div>';
                        } else if(value == 'Rejected by Admin' || value == 'Rejected by Customer') {
                            return '<div class="badge badge-danger">Cancelled</div>';
                        } else {
                            return '<div class="badge badge-warning">'+value+'</div>';
                        }
                    }
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
                }
            ],
            searching: false,
            drawCallback: function( oSettings ) {
                $('.tooltips').tooltip();
            },
            order: [[ 1, "desc" ]]
        });
		

        $('#table-shop').on('click', '.confirm-btn', function() {
            $('#modal-confirm :input').val(null);
            const data = $(this).data('data');
            $('#input-id-transaction').val(data.id_transaction);
            $('#input-customer-name').val(`${data.name} (${data.phone})`);
            $('#input-receipt-number').val(data.transaction_receipt_number);
            $('#modal-confirm').modal('show');
        });

        $('#table-shop').on('click', '.retry-btn', function() {
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
                $('#table-shop').DataTable().ajax.reload(null, false);
                $.unblockUI();
            });
        });

        $('#table-shop').on('click', '.detail-btn', function() {
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
                <span class="caption-subject font-blue sbold uppercase">Transaction Shop</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" width="100%" id="table-shop">
            <thead>
              <tr>
                  <th>Actions</th>
                  <th>Date</th>
                  <th>Receipt Number</th>
                  <th>Customer Name</th>
                  <th>Phone</th>
                  <th>Total Price</th>
                  <th>Shop Status</th>
                  <th>Payment Status</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
    </div>

@endsection
