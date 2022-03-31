<table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
    <thead>
        <tr>
            <th> Holiday Name</th>
            <th> Yearly </th>
            <th> Holiday Date </th>
            {{-- <th> Action </th> --}}
        </tr>
    </thead>
    <tbody>
        @if (!empty($outlet[0]['holidays']))
            @foreach($outlet[0]['holidays'] as $value)
                <tr>
                    <td>{{ $value['holiday_name'] }}</td>
                    <td>@if($value['yearly'] == 1) <i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i> @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                    <td>
                        @foreach($value['date_holidays'] as $date)
                            @if($value['yearly'] == '1')
                                {{ date('d F', strtotime($date['date'])) }} 
                            @else
                                {{ date('d F Y', strtotime($date['date'])) }} 
                            @endif
                            <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        @else
        <tr>
            <td colspan="3" class="text-center"><em class="text-muted">No holiday</em></td>
        </tr>
        @endif
    </tbody>
</table>