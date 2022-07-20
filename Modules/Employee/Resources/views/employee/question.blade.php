@php $i = 0; @endphp
@foreach($detail['question'] as $question)
    @if(isset($question['employee']))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark sbold uppercase font-yellow">{{$question['name_category']??''}}</span>
                    
                </div>
            </div>
             <table class="table">
            @foreach($question['employee'] as $val)
                    @php $i = $i+1; @endphp
                    @if($val['type']=='Type 1')
                            <tr class="row">
                              <td width="10px">{{$i}}</td>
                              <td class="col-md-6">{{$val['question']??''}}</td>
                              <td class="col-md-5" style="text-align: right">{{$val['answer']??''}}</td>
                            </tr>
                    @endif
                    @if($val['type']=='Type 3' || $val['type']=="Type 4")
                        @foreach($val['question'] as $key => $v)
                            <tr class="row">
                              <td width="10px">@if($key == 0) {{$i}} @endif</td>
                              <td class="col-md-6">({{$key+1}}) {{$v['text']??''}}</td>
                              <td class="col-md-5" style="text-align: right">{{$val['answer'][$key]['text']??''}}</td>
                            </tr>
                         @endforeach
                    @endif
                    @if($val['type']=='Type 2')
                            <tr class="row">
                              <td width="10px">{{$i}}</td>
                              <td class="col-md-6">{{$val['question']??''}}</td>
                              <td class="col-md-5" style="text-align: right"></td>
                            </tr>
                            
                            @if(is_array($val['answer'][0]['text']))
                            <?php
                             $b = array();
                             $body = array();
                            foreach ($val['answer'] as $key => $valu) {
                                $b = array_merge($b,array_keys($valu['text']));
                                array_push($body,$valu['text']);
                            }
                            $head = array_unique($b);
                            ?>
                            <tr class="row">
                                <td colspan="3"> 
                                    <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                @foreach($head as $ve)
                                                    <th style='text-align: center' width="10%"> {{ucfirst($ve)}} </th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($body as $b)
                                                <tr>
                                                    @foreach($head as $ve)
                                                    <td style='text-align: center'>{{$b[$ve]??''}}</td>
                                                    @endforeach
                                                </tr>    
                                                @endforeach
                                            </tbody>
                                    </table>

                                </td>
                             </tr>
                             @else
                             @foreach($val['answer'] as $vas)
                             <tr class="row">
                                 <td width="10px"></td>
                                <td colspan="2"> 
                                    {{$vas['text']??''}}
                                </td>
                             </tr>
                             @endforeach
                             @endif
                    @endif
             @endforeach
             
            </table>
        </div>
    @endif
@endforeach