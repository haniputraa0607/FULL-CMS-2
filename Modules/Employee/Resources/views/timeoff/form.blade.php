<form class="form-horizontal" role="form" action="{{ url('employee/timeoff/update') }}/{{ $result['id_employee_time_off'] }}" method="post" enctype="multipart/form-data" id="update-time-off">
    <div class="form-body">
        <input class="form-control" type="hidden" name="id_outlet" value="{{ $result['outlet']['id_outlet'] }}" readonly/>
        <input class="form-control" type="hidden" name="id_employee" id="list_hs"  value="{{ $result['employee']['id'] }}" readonly/>
        <input class="form-control" type="hidden" name="type" id="type"  value="Manager Approved" readonly/>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Start Month <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan mulai cuti" data-container="body"></i></label>
            <div class="col-md-3">
                <select class="form-control select2" name="month" id="month_start" required onchange="selectMonthStart(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
                    <option value="" selected disabled>Select Month</option>
                    <option value="1" @if(isset($result['month_start'])) @if($result['month_start'] == 1) selected @endif @endif>January</option>
                    <option value="2" @if(isset($result['month_start'])) @if($result['month_start'] == 2) selected @endif @endif>February</option>
                    <option value="3" @if(isset($result['month_start'])) @if($result['month_start'] == 3) selected @endif @endif>March</option>
                    <option value="4" @if(isset($result['month_start'])) @if($result['month_start'] == 4) selected @endif @endif>April</option>
                    <option value="5" @if(isset($result['month_start'])) @if($result['month_start'] == 5) selected @endif @endif>May</option>
                    <option value="6" @if(isset($result['month_start'])) @if($result['month_start'] == 6) selected @endif @endif>June</option>
                    <option value="7" @if(isset($result['month_start'])) @if($result['month_start'] == 7) selected @endif @endif>July</option>
                    <option value="8" @if(isset($result['month_start'])) @if($result['month_start'] == 8) selected @endif @endif>August</option>
                    <option value="9" @if(isset($result['month_start'])) @if($result['month_start'] == 9) selected @endif @endif>September</option>
                    <option value="10" @if(isset($result['month_start'])) @if($result['month_start'] == 10) selected @endif @endif>October</option>
                    <option value="11" @if(isset($result['month_start'])) @if($result['month_start'] == 11) selected @endif @endif>November</option>
                    <option value="12" @if(isset($result['month_start'])) @if($result['month_start'] == 12) selected @endif @endif>December</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Start Year <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun mulai cuti" data-container="body"></i></label>
            <div class="col-md-2">
                <input class="form-control numberonly" type="text" maxlength="4" id="year_start" name="year" placeholder="Enter year" value="{{ $result['year_start'] }}" required onchange="selectYearStart(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif/>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Start Date Time Off <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan mulai cuti" data-container="body"></i></label>
            <div class="col-md-4">
                @if(isset($result['approve_by']) || isset($result['reject_at'])) 
                <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['start_date'])) }}" disabled>
                @else
                <select class="form-control select2" name="start_date" required id="list_date_start">
                    <option value="" selected disabled>Select Date</option>
                    @foreach($result['start_list_date'] ?? [] as $d => $date)
                        <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}"  @if(isset($result['start_date'])) @if(date('Y-m-d', strtotime($result['start_date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">End Month <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk bulan selesai cuti" data-container="body"></i></label>
            <div class="col-md-3">
                <select class="form-control select2" name="month" id="month_end" required onchange="selectMonthEnd(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
                    <option value="" selected disabled>Select Month</option>
                    <option value="1" @if(isset($result['month_end'])) @if($result['month_end'] == 1) selected @endif @endif>January</option>
                    <option value="2" @if(isset($result['month_end'])) @if($result['month_end'] == 2) selected @endif @endif>February</option>
                    <option value="3" @if(isset($result['month_end'])) @if($result['month_end'] == 3) selected @endif @endif>March</option>
                    <option value="4" @if(isset($result['month_end'])) @if($result['month_end'] == 4) selected @endif @endif>April</option>
                    <option value="5" @if(isset($result['month_end'])) @if($result['month_end'] == 5) selected @endif @endif>May</option>
                    <option value="6" @if(isset($result['month_end'])) @if($result['month_end'] == 6) selected @endif @endif>June</option>
                    <option value="7" @if(isset($result['month_end'])) @if($result['month_end'] == 7) selected @endif @endif>July</option>
                    <option value="8" @if(isset($result['month_end'])) @if($result['month_end'] == 8) selected @endif @endif>August</option>
                    <option value="9" @if(isset($result['month_end'])) @if($result['month_end'] == 9) selected @endif @endif>September</option>
                    <option value="10" @if(isset($result['month_end'])) @if($result['month_end'] == 10) selected @endif @endif>October</option>
                    <option value="11" @if(isset($result['month_end'])) @if($result['month_end'] == 11) selected @endif @endif>November</option>
                    <option value="12" @if(isset($result['month_end'])) @if($result['month_end'] == 12) selected @endif @endif>December</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">End Year <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Jadwal untuk tahun selesai cuti" data-container="body"></i></label>
            <div class="col-md-2">
                <input class="form-control numberonly" type="text" maxlength="4" id="year_end" name="year" placeholder="Enter year" value="{{ $result['year_end'] }}" required onchange="selectYearEnd(this.value)" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif/>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">End Date Time Off <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih tanggal karyawan akan selesai cuti" data-container="body"></i></label>
            <div class="col-md-4">
                @if(isset($result['approve_by']) || isset($result['reject_at'])) 
                <input type="text" class="datepicker form-control" value="{{ date('d F Y', strtotime($result['end_date'])) }}" disabled>
                @else
                <select class="form-control select2" name="end_date" required id="list_date_end">
                    <option value="" selected disabled>Select Date</option>
                    @foreach($result['end_list_date'] ?? [] as $d => $date)
                        <option value="{{$date['date']}}" data-id="{{ $date['id_employee_schedule'] }}" data-timestart="{{ $date['time_start'] }}" data-timeend="{{ $date['time_end'] }}"  @if(isset($result['end_date'])) @if(date('Y-m-d', strtotime($result['end_date'])) == date('Y-m-d', strtotime($date['date']))) selected @endif @endif> {{$date['date_format']}}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Uses Quota Time Off<span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Memakai jatah cuti atau tidak" data-container="body"></i></label>
            <div class="col-md-3">
                <input type="checkbox" class="make-switch check_quota" data-size="small" data-on-color="info" data-on-text="Yes" data-off-color="default" name='use_quota_time_off' data-off-text="No" @if($result['use_quota_time_off'] == 1) checked @endif @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Notes
                <i class="fa fa-question-circle tooltips" data-original-title="Catatan dari manager" data-container="body"></i></label>
            <div class="col-md-5">
                <textarea class="form-control" name="notes" placeholder="Notes" @if(isset($dataDoc['Manager Approved']['notes'])) disabled @endif>@if(isset($dataDoc['Manager Approved']['notes'])) {{$dataDoc['Manager Approved']['notes']}}  @endif</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Attachment
                <i class="fa fa-question-circle tooltips" data-original-title="Dokumen dari manager" data-container="body"></i></label>
            <div class="col-md-5">
                @if(isset($dataDoc['Manager Approved']['attachment']))
					@if(empty($dataDoc['Manager Approved']['attachment']))
						<p style="margin-top: 2%">No file</p>
					@else
						<a style="margin-top: 2%" class="btn blue btn-xs" href="{{$dataDoc['Manager Approved']['attachment'] }} ">Link Download Attachment</i></a>
					@endif
                @else
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"> </span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                            <span class="fileinput-new"> Select file </span>
                            <span class="fileinput-exists"> Change </span>
                            <input type="file" accept=".pdf, application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf" name="attachment"> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if (isset($result['approve']))
        <div class="form-group">
            <label for="example-search-input" class="control-label col-md-4">Approved By <span class="required" aria-required="true">*</span>
                <i class="fa fa-question-circle tooltips" data-original-title="Permohonan disetujui oleh user ini" data-container="body"></i></label>
            <div class="col-md-5">
                <input class="form-control" type="text" placeholder="Enter request by" value="{{ $result['approve']['name'] }}" required readonly/>
            </div>
        </div>
        @endif
    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12 text-center">
                @if (empty($result['reject_at']))
                    @if(empty($result['approve']))
                    <a onclick="submitTimeOff('submit')" class="btn blue" @if(isset($result['approve_by']) || isset($result['reject_at'])) disabled @endif>Submit</a>
                    {{-- <a onclick="submitTimeOff('approve')" id="approve" class="btn green approve">Approve</a> --}}
                    @endif
                @endif
            </div>
        </div>
    </div>
</form>