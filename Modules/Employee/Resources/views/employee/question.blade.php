@php $i = 0; @endphp
@foreach($detail['question'] as $question)
    @if(isset($question['employee']))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">{{$question['name_category']}}</span>
                    
                </div>
            </div>
            @foreach($question['employee'] as $val)
                @php $i = $i+1; @endphp
                <div class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">{{$i}}</label>
                                @if($val['type']=='Type 1'||$val['type']=="Type 2")
                                <label class="col-md-5 control-label" style="text-align: left">{{$val['question']}}</label>
                                @else
                                <?php $s=1; ?>
                                @foreach($val['question'] as $v)
                                
                                <label class="col-md-5 control-label" style="text-align: left">({{$s++}}) {{$v['text']}}</label><br>
                               
                                @endforeach
                                @endif
                                <div class="col-md-6">
                                    <input type="number" name="hours" value="{{old('hours')}}" placeholder="Masukkan jam overtime" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <label style="width: 15px">{{$i}}</label>
                        @if($val['type']=='Type 1'||$val['type']=="Type 2")
                        <label class="col-5">{{$val['question']}}</label>
                        @else
                        <?php $s=1; ?>
                        @foreach($val['question'] as $v)
                        @if($s==1)
                        <label class="col-5" @if($i >= 10) style="margin-left: 5px" @endif>({{$s++}}) {{$v['text']}}</label><br>
                        @else
                        <label class="col-5" @if($i >= 10) style="margin-left: 22px"  @else style="margin-left: 17px" @endif>({{$s++}}) {{$v['text']}}</label><br>
                        @endif
                        @endforeach
                        @endif
                        @if($val['type']=='Type 1')
                        <div class="col-5">
                            1
                        </div>
                        @else
                        @foreach($val['answer'] as $v)
                        <div class="col-5">
                            1
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @endforeach
        </div>
    @endif
@endforeach