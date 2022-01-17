@extends('layouts.main')

@section('page-style')
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
                <span class="caption-subject sbold uppercase font-blue">New Outlet Starter Bundling</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling name" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Code <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Bundling code" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Produk Bersifat Unik" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" name="status" data-off-text="Inactive" value="1" @if(old('status')) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="multiple" class="control-label col-md-3">Description
                           <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                       </label>
                       <div class="col-md-8">
                           <div class="input-icon right">
                               <textarea name="description" id="text_pro" class="form-control">{{ old('description') }}</textarea>
                           </div>
                       </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                            <!--<button type="submit" name="next" value="1" class="btn blue">Submit & Manage Photo</button>-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection