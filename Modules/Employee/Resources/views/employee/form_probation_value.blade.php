<div style="margin-top: -4%">
	<form class="form-horizontal"  role="form" action="{{url('employee/recruitment/complement/'.$detail['id_employee'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Data Complement</h3></div>
			<hr style="border-top: 2px dashed;">               
		</div>
		@if(in_array($detail['status'], ['active']))
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
                        <button class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>