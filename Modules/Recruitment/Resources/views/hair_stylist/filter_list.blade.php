<script>
    function changeSelect() {
        setTimeout(function () {
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    function changeSubject(val) {
        var subject = val;
        var temp1 = subject.replace("conditions[", "");
        var index = temp1.replace("][subject]", "");
        var subject_value = document.getElementsByName(val)[0].value;
        console.log(subject_value)
        if (subject_value == 'gender') {
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Male', 'Male');
            operator_value.options[operator_value.options.length] = new Option('Female', 'Female');

            var parameter = "conditions[" + index + "][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        } else if (subject_value == 'level') {
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Hairstylist', 'Hairstylist');
            operator_value.options[operator_value.options.length] = new Option('Supervisor', 'Supervisor');

            var parameter = "conditions[" + index + "][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        } else if (subject_value == 'outlet') {
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            $.each(<?= json_encode($outlets) ?>, function(index, value) {
                            operator_value.options[operator_value.options.length] = new Option(value.outlet_name,value.id_outlet);
                        });
            
            var parameter = "conditions[" + index + "][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        } else {
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');

            var parameter = "conditions[" + index + "][parameter]";
            document.getElementsByName(parameter)[0].type = 'text';
        }
    }

</script>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-blue ">
            <i class="icon-settings font-blue "></i>
            <span class="caption-subject bold uppercase">Filter</span>
        </div>
    </div>
    <div class="portlet-body form">

        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">{{ $title_date_start??'Date Start' }} :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{ $date_start }}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <label class="col-md-2 control-label">{{ $title_date_end??'Date End' }} :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_end" value="{{ $date_end }}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div><hr>

        <div class="form-body">
            <div class="form-group mt-repeater">
                <div data-repeater-list="conditions">
                    @if (!empty($conditions))
                    @foreach ($conditions as $key => $con)
                    @if(isset($con['subject']))
                    <div data-repeater-item class="mt-repeater-item mt-overflow">
                        <div class="mt-repeater-cell">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                        @if(isset($list_type) && $list_type == 'hs')
                                        <option value="nickname" @if ($con['subject'] == 'nickname') selected @endif>Nickname</option>
                                        @endif
                                        <option value="email" @if ($con['subject'] == 'email') selected @endif>Email</option>
                                        <option value="phone_number" @if ($con['subject'] == 'phone_number') selected @endif>Phone</option>
                                        <option value="fullname" @if ($con['subject'] == 'fullname') selected @endif>Full Name</option>
                                        <option value="gender" @if ($con['subject'] == 'gender') selected @endif>Gender</option>
                                        <option value="level" @if ($con['subject'] == 'level') selected @endif>Level</option>
                                        <option value="outlet" @if ($con['subject'] == 'outlet') selected @endif>Outlet</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                        @if($con['subject'] == 'gender')
                                        <option value="Male" @if ($con['operator'] == 'Male') selected @endif>Male</option>
                                        <option value="Female" @if ($con['operator']  == 'Female') selected @endif>Female</option>
                                        @elseif($con['subject'] == 'level')
                                        <option value="Hairstylist" @if ($con['operator'] == 'Hairstylist') selected @endif>Hairstylist</option>
                                        <option value="Supervisor" @if ($con['operator']  == 'Supervisor') selected @endif>Supervisor</option>
                                        @elseif($con['subject'] == 'outlet')
                                            @foreach($outlets as $outlet)
                                                <option value="{{$outlet['id_outlet']}}" @if ($outlet['id_outlet']  == $con['operator']) selected @endif>{{$outlet['outlet_name']}}</option>
                                            @endforeach
                                        @else
                                        <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                <option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
                                        @endif
                                    </select>
                                </div>

                                @if ($con['subject'] == 'gender' || $con['subject'] == 'level'|| $con['subject'] == 'outlet' )
                                <div class="col-md-3">
                                    <input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                </div>
                                @else
                                <div class="col-md-3">
                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div data-repeater-item class="mt-repeater-item mt-overflow">
                        <div class="mt-repeater-cell">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                        <option value="" selected disabled>Search Subject</option>
                                        @if(isset($list_type) && $list_type == 'hs')
                                        <option value="nickname">Nickname</option>
                                        @endif
                                        <option value="email">Email</option>
                                        <option value="phone_number">Phone</option>
                                        <option value="fullname">Full Name</option>
                                        <option value="gender">Gender</option>
                                        <option value="level">Level</option>
                                        <option value="outlet">Outlet</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                        <option value="=" selected>=</option>
                                        <option value="like">Like</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div data-repeater-item class="mt-repeater-item mt-overflow">
                        <div class="mt-repeater-cell">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
                                        <option value="" selected disabled>Search Subject</option>
                                        @if(isset($list_type) && $list_type == 'hs')
                                        <option value="nickname">Nickname</option>
                                        @endif
                                        <option value="email">Email</option>
                                        <option value="phone_number">Phone</option>
                                        <option value="fullname">Full Name</option>
                                        <option value="gender">Gender</option>
                                        <option value="level">Level</option>
                                        <option value="outlet">Outlet</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                        <option value="=" selected>=</option>
                                        <option value="like">Like</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="form-action col-md-12">
                    <div class="col-md-12">
                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
                            <i class="fa fa-plus"></i> Add New Condition</a>
                    </div>
                </div>

                <div class="form-action col-md-12" style="margin-top:15px">
                    <div class="col-md-5">
                        <select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
                            <option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
                            <option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        {{ csrf_field() }}
                        <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
                        <a class="btn green" href="{{url()->current()}}">Reset</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>