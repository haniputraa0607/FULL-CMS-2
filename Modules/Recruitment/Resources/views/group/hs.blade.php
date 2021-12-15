@yield('filter_hs')
<div style="white-space: nowrap;">
    <div class="tab-pane">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">List Hair Stylist</span>
                </div>
                <a href="#form_hs" class="btn btn-sm blue" type="button" style="float:right" data-toggle="tab" >
                         Invite HS
                    </a>
                    <a href="#table_hs" class="btn btn-sm yellow active" type="button" style="float:right" data-toggle="tab" >
                        List HS
                    </a>
            </div>
            <div class="portlet-body form">
                <div class="tab-content">
                    <div class="tab-pane active" id="table_hs">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="kt_datatable">
                                <thead>
                                <tr>
                                 
                                        <th class="text-nowrap text-center"> Nickname </th>
                                        <th class="text-nowrap text-center"> Full Name </th>
                                        <th class="text-nowrap text-center"> Email </th>
                                        <th class="text-nowrap text-center"> Phone </th>
                                        <th class="text-nowrap text-center"> Gender </th>
                                        <th class="text-nowrap text-center"> Outlet </th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                        @if(!empty($hs['data']))
                                        @foreach($hs['data'] as $dt)
                                            <tr >
                                                <td>{{$dt['nickname']}}</td>
                                                <td>{{$dt['fullname']}}</td>
                                                <td>{{$dt['email']}}</td>
                                                <td>{{$dt['phone_number']}}</td>
                                                <td>{{$dt['gender']}}</td>
                                                <td>{{$dt['outlet_name']}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                             <div class="paginator-right">
                                @if ($hs['data_paginator'])
                                   {{ $hs['data_paginator']->links() }}
                               @endif  
                           </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="form_hs">
                        <form class="form-horizontal" role="form" action="{{url('recruitment/hair-stylist/group/invite_hs')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id_hairstylist_group" value="{{$result['id_hairstylist_group']}}">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-4">Hair Stylist<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih Hair Stylist" data-container="body"></i></label>
                                    <div class="col-md-5">
                                        <select required name="id_user_hair_stylist" id="id_user_hair_stylist" class="form-control input-sm select2" >
                                            <option value="">Select Product</option>
                                            @if(isset($lisths))
                                                @foreach($lisths as $row)
                                                        <option value="{{$row['id_user_hair_stylist']}}">{{$row['nickname']}} - {{$row['fullname']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>