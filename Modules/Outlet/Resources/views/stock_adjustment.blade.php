<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features'); 

 ?>
 @extends('layouts.main')

@section('page-style')
@endsection

@section('page-plugin')
@endsection

@section('page-script')
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Stock Adjustment Detail</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Datetime
                            </label>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ (date('F d, Y @ H:i', strtotime($result['created_at']))) }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Title
                            </label>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['title'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Outlet
                            </label>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['outlet']['outlet_name'] }}" readonly required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Product Icount
                            </label>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['product_icount']['name'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Unit
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['unit'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Stock Adjustment
                            </label>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['stock_adjustment'] }}" readonly required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Notes
                            </label>
                        </div>
                        <div class="col-md-5">
                            <textarea class="form-control" type="text" id="follow_up" name="follow_up"readonly required>{{ $result['notes'] }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                User
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="follow_up" name="follow_up" value="{{ $result['user']['name'] }}" readonly required/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    


@endsection