<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@extends('layouts.main')
@section('page-style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
        @font-face {
            font-family: 'WorkSans-Bold';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("STORAGE_URL_VIEW") }}{{("fonts/Work_Sans/WorkSans-Bold.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'WorkSans-Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("STORAGE_URL_VIEW") }}{{("fonts/Work_Sans/WorkSans-Regular.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'WorkSans-SemiBold';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("STORAGE_URL_VIEW") }}{{("fonts/Work_Sans/WorkSans-SemiBold.ttf")}}') format('truetype');
        }

        @font-face {
            font-family: 'WorkSans-Medium';
            font-style: normal;
            font-weight: 400;
            src: url('{{env("STORAGE_URL_VIEW") }}{{("fonts/Work_Sans/WorkSans-Medium.ttf")}}') format('truetype');
        }

        .swal-text {
            text-align: center;
        }

        .kotak {
            margin : 10px;
            padding: 10px;
            /*margin-right: 15px;*/
            -webkit-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            -moz-box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            box-shadow: 0px 1px 3.3px 0px rgba(168,168,168,1);
            /* border-radius: 3px; */
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .kotak-qr {
            -webkit-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            -moz-box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            box-shadow: 0px 0px 5px 0px rgba(214,214,214,1);
            background: #fff;
            width: 130px;
            height: 130px;
            margin: 0 auto;
            border-radius: 20px;
            padding: 10px;
        }

        .kotak-full {
            margin-bottom : 15px;
            padding: 10px;
            background: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .kotak-inside {
            padding-left: 25px;
            padding-right: 25px
        }

        body {
            background: #fafafa;
        }

        .completed {
            color: green;
        }

        .bold {
            font-weight: bold;
        }

        .space-bottom {
            padding-bottom: 15px;
        }

        .space-top-all {
            padding-top: 15px;
        }

        .space-text {
            padding-bottom: 10px;
        }

        .space-nice {
            padding-bottom: 20px;
        }

        .space-bottom-big {
            padding-bottom: 25px;
        }

        .space-top {
            padding-top: 5px;
        }

        .line-bottom {
            border-bottom: 1px solid rgba(0,0,0,.1);
            margin-bottom: 15px;
        }

        .text-grey {
            color: #aaaaaa;
        }

        .text-much-grey {
            color: #bfbfbf;
        }

        .text-black {
            color: #000000;
        }

        .text-medium-grey {
            color: #707070;
        }

        .text-grey-white {
            color: #666;
        }

        .text-grey-light {
            color: #333333;
        }

        .text-grey-medium-light{
            color: #a9a9a9;
        }

        .text-black-grey-light{
            color: #5f5f5f;
        }


        .text-medium-grey-black{
            color: #424242;
        }

        .text-grey-black {
            color: #4c4c4c;
        }

        .text-grey-red {
            color: #9a0404;
        }

        .text-grey-red-cancel {
            color: rgba(154,4,4,1);
        }

        .text-grey-blue {
            color: rgba(0,140,203,1);
        }

        .text-grey-yellow {
            color: rgba(227,159,0,1);
        }

        .text-grey-green {
            color: rgba(4,154,74,1);
        }

        .text-grey-white-light {
            color: #b8b8b8;
        }

        .text-greyish-brown{
            color: #6c5648;
        }

        .open-sans-font {
            font-family: 'Open Sans', sans-serif;
        }

        .questrial-font {
            font-family: 'Questrial', sans-serif;
        }

        .WorkSans-Bold {
            font-family: 'WorkSans-Bold';
        }

        .WorkSans-Regular {
            font-family: 'WorkSans-Regular';
        }

        .WorkSans-SemiBold {
            font-family: 'WorkSans-SemiBold';
        }

        .WorkSans-Medium {
            font-family: 'WorkSans-Medium';
        }

        .text-21-7px {
            font-size: 21.7px;
        }

        .text-16-7px {
            font-size: 16.7px;
        }

        .text-15px {
            font-size: 15px;
        }

        .text-14-3px {
            font-size: 14.3px;
        }

        .text-14px {
            font-size: 14px;
        }

        .text-13-3px {
            font-size: 13.3px;
        }

        .text-12-7px {
            font-size: 12.7px;
        }

        .text-12px {
            font-size: 12px;
        }

        .text-13px {
            font-size: 13px;
        }

        .text-11-7px {
            font-size: 11.7px;
        }

        .round-greyish-brown{
            border: 1px solid #6c5648;
            border-radius: 50% !important;
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .bg-greyish-brown{
            background: #6c5648;
        }

        .round-white{
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right:3px;
        }

        .line-vertical{
            font-size: 5px;
            width:10px;
            margin-right: 3px;
        }

        .inline{
            display: inline-block;
        }

        .vertical-top{
            vertical-align: top;
            padding-top: 5px;
        }

        #modal-usaha {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0,0,0, 0.5);
            width: 100%;
            display: none;
            height: 100vh;
            z-index: 999;
        }

        .modal-usaha-content {
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -125px;
            margin-top: -125px;
        }

        .kotak-full.pending{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#aaa;
        }

        .kotak-full.on_going{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#ef9219;
        }

        .kotak-full.complated{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#fff;
        }

        .kotak-full.ready{
            padding-top:15px;
            padding-bottom:15px;
            background-color:#15977b;
        }

        .kotak-full.pending .text-greyish-brown,
        .kotak-full.on_going .text-greyish-brown,
        .kotak-full.ready .text-greyish-brown,

        .kotak-full.pending .text-grey-white-light,
        .kotak-full.on_going .text-grey-white-light,
        .kotak-full.ready .text-grey-white-light
        {
            color:#fff;
        }

        .kotak-full.redbg{
            margin-top:-10px;
            background-color:#c10100;
        }

        .kotak-full.redbg #content-taken{
            text-transform : uppercase;
            color:#fff;
            text-align:center;
            padding:10px;
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1170px; } }

        .page-header{
            position: fixed;
        }

        .page-logo {
            margin-right: auto;
        }
    </style>
@endsection

@section('page-script')

    <script>

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
    @php $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
    <div style="max-width: 480px; margin: auto">
        @if(isset($from))
            <?php
            if($data['transaction_flag_invalid'] == 'Invalid' || $data['transaction_flag_invalid'] == 'Pending Invalid'){
                $status = 'Invalid';
                $color = 'red';
            }else{
                $status = 'Valid';
                $color = 'green';
            }
            ?>
            <div class="kotak-biasa">
                <div class="container">
                    <div class="kotak-full" style="background-color: #ffffff;padding: 20px; height: 65px; box-shadow: 0 3.3px 6.7px #b3b3b3;">
                        <div class="row text-center">
                            <div class="col-12 text-16-7px WorkSans-Bold" style="color: {{$color}};font-size: 18px"><b> Status Transaksi {{$status}}</b></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <?php
        $color = [
            'Completed' => '#26C281',
            'Cancelled' => '#F3565D'
        ];
        ?>
        @if (!empty($manual_refund['refund_date']))
            <div class="alert text-black" style="background-color:yellow;width: 35%;text-align: center;margin-bottom: -40px;margin-left: -20px;font-size: 25px"><b>REFUNDED</b></div>
        @endif
        <div class="kotak-biasa" style="background-color: {{$color[$data['transaction_payment_status']]??'#F8CB00'}};padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 text-black-grey-light text-20px"><b style="color: white;font-size: 30px">{{$data['transaction_payment_status']}}</b></div>
                </div>
            </div>
        </div>
        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 text-15px text-black-grey-light space-text WorkSans-Bold">{{ $data['outlet']['outlet_name'] }}</div>
                    <div class="kotak-inside col-12">
                        <div class="col-12 text-11-7px text-grey-white space-nice text-center WorkSans">{{ $data['outlet']['outlet_address'] }}</div>
                    </div>
                    <div class="col-12 text-black-grey-light text-20px WorkSans-SemiBold">{{ $data['transaction_receipt_number'] }}</div>
                </div>
            </div>
        </div>

        <div class="kotak-biasa" style="background-color: #FFFFFF;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="container" style="padding: 10px;margin-top: 10px;">
                <div class="text-center">
                    <div class="col-12 text-13px space-text text-medium-grey WorkSans-Regular">
                        Data Pemesan
                    </div>
                    <div class="col-12 text-13-3px" style="padding-bottom: 25px;color: #000000;font-size: 15px">
                        {{$data['user']['name']??''}}<br>
                        {{$data['user']['phone']??''}}<br>
                        {{$data['user']['email']??''}}
                    </div>
                    <div class="col-12 text-13-3px" style="padding-bottom: 25px;color: #000000">{{ date('d', strtotime($data['transaction_date'])) }} {{ $bulan[date('n', strtotime($data['transaction_date']))] }} {{ date('Y', strtotime($data['transaction_date'])) }}</div>
                </div>
            </div>
        </div>

        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="row space-bottom">
                <div class="col-4 text-black-grey-light text-14px WorkSans-Bold">Transaksi</div>
                <div class="col-8 text-grey-white text-right text-medium-grey text-12px WorkSans-Regular">{{ date('d', strtotime($data['transaction_date'])) }} {{ $bulan[date('n', strtotime($data['transaction_date']))] }} {{ date('Y H:i', strtotime($data['transaction_date'])) }}</div>
            </div>
            <div class="kotak" style="margin: 0px;border-radius: 10px;">
                <div class="row">
                    @foreach ($data['product_academy'] as $trx)
                        <div class="col-2 text-13-3px WorkSans-SemiBold text-grey-light space-text"><b>{{$trx['transaction_product_qty']}}x</b></div>
                        <div class="col-7 text-13-3px WorkSans-SemiBold text-grey-light space-text" style="margin-left: -30px;margin-right: 20px;"><b>{{$trx['product_name']}}</b><br>{{$data['transaction_academy_total_meeting']}} x pertemuan</div>
                        <div class="col-3 text-13-3px text-right WorkSans-SemiBold text-black space-text">{{$trx['transaction_product_subtotal']}}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="row space-bottom">
                <div class="col-12 text-14px WorkSans-Bold text-black">Detail Pembayaran</div>
            </div>
            <div class="kotak" style="margin: 0px;margin-top: 10px;border-radius: 10px;">
                @foreach($data['payment_detail'] as $dt)
                    <div class="row">
                    @if(is_numeric(strpos(strtolower($dt['name']), 'discount')))
                        <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">{{ $dt['name'] }} </div>
                        {{--  <div class="col-6 text-13-3px text-right WorkSans-Medium space-text" style="color:#a6ba35;">- {{ str_replace(',', '.', $dt['amount']) }}</div>  --}}
                    @else
                        @if (isset($dt['is_discount']) && $dt['is_discount']==1)
                        <div class="col-6 text-13-3px WorkSans-Medium text-grey space-text">{{$dt['name']}}</div>
                        <div class="col-6 text-13-3px text-right WorkSans-Medium text-grey-red space-text">{{ str_replace(',', '.', $dt['amount']) }}</div>
                        @else
                        <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">{{$dt['name']}} ({{$dt['desc']}})</div>
                        <div class="col-6 text-13-3px text-right WorkSans-Medium text-grey-light space-text">{{ str_replace(',', '.', $dt['amount']) }}</div>
                        @endif
                    @endif
                    </div>
                @endforeach
                @if($data['transaction_tax'] > 0)
                    <div class="row">
                        <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">Tax</div>
                        <div class="col-6 text-13-3px text-right WorkSans-Medium text-grey-light space-text">{{ number_format($data['transaction_tax'],2,',','.') }}</div>
                    </div>
                @endif
                @if($data['mdr'] > 0)
                    <div class="row">
                        <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">MDR</div>
                        <div class="col-6 text-13-3px text-right WorkSans-Medium text-grey-light space-text">{{ number_format($data['mdr'],2,',','.') }}</div>
                    </div>
                @endif
            </div>

            <div style="margin: 0px;margin-top: 10px;padding: 10px;background: #f0f3f7;">
                <div class="row">
                    <div class="col-6 text-14px WorkSans-SemiBold text-grey-light">Grand Total</div>
                    <div class="col-6 text-14px text-right WorkSans-SemiBold text-grey-light">{{ str_replace(',', '.', $data['transaction_grandtotal']) }}</div>
                </div>
            </div>
        </div>

        <div class="kotak-biasa" style="background-color: #FFFFFF;padding: 15px;margin-top: 10px;box-shadow: 0 0.7px 3.3px #eeeeee;">
            <div class="row space-bottom">
                <div class="col-12 text-14px WorkSans-SemiBold text-black">Metode Pembayaran</div>
            </div>
            <div class="kotak" style="margin: 0px;margin-top: 10px;border-radius: 10px;">
                <div class="row">
                    @foreach($data['transaction_payment']??[] as $dt)
                        @if($dt['name'] == 'Balance')
                            <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">{{env('POINT_NAME')}}</div>
                            <div class="col-6 text-13-3px text-right WorkSans-Medium space-text" style="color:#de2e1f;">{{ $dt['amount'] }}</div>
                        @else
                            <div class="col-6 text-13-3px WorkSans-Medium text-grey-light space-text">{{$dt['name']}}</div>
                            <div class="col-6 text-13-3px text-right WorkSans-Medium text-grey-light space-text">{{ $dt['amount'] }}</div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if (!empty($manual_refund['refund_date']))
        <br>
        <h3 style="text-align: center">Manual Refund Detail</h3>
        <hr style="border-top: 2px dashed black;">
        <br>
        <div class="row">
            <div class="col-md-2">Confirmed By</div>
            <div class="col-md-6">: {{$manual_refund['validator_name']}} ({{$manual_refund['validator_phone']}}) </div>
        </div>
        <div class="row">
            <div class="col-md-2">Confirm At</div>
            <div class="col-md-6">: {{date('d F Y H:i', strtotime($manual_refund['confirm_at']))}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">Date Refund</div>
            <div class="col-md-6">: {{date('d F Y H:i', strtotime($manual_refund['refund_date']))}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">Note</div>
            <div class="col-md-6">: {{$manual_refund['note']}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">Image</div>
            <div class="col-md-6">:
                @if(!empty($manual_refund['images']))
                    @foreach($manual_refund['images'] as $url)
                        <a href="{{$url}}" target="_blank">{{$url}}</a><br>
                    @endforeach
                @else
                    -
                @endif
            </div>
        </div>
    @endif
@endsection