@section('child-script')
<?php
use App\Lib\MyHelper;
$configs  = session('configs');
?>
<script>
	rules1={
		hair_stylist_group_name:{
                                    display:'Name',
                                    operator:[
                                    ['=','='],
                                    ['like','like']
                                    ],
                                    opsi:[]
                                },
		hair_stylist_group_code:{
                                    display:'Code',
                                    operator:[
                                    ['=','='],
                                    ['like','like']
                                    ],
                                    opsi:[]
                                },
	};
	database={
		operator: 'or',
		value: {!!json_encode(array_values($rule??[]))!!}
	};
	var updatedatetime=false;
	function optionWriters(value,show,option=''){
		return '<option value="'+value+'" '+option+'>'+show+'</option>'
	}
	function selectSubjectBuilder(rules1,selected='',id='::n::'){
		var html='<select name="rule['+id+'][subject]" class="form-control input-sm select2 inputSubject" placeholder="Search Subject" style="width:100%" required>';
		rules1s=Object.entries(rules1);
		rules1s.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriters(x[0],x[1].display,'selected');
			}else{
				html+=optionWriters(x[0],x[1].display);
			}
		});
		html+='</select>';
		return html;
	}
	function selectOperatorBuilder(rules1,selected='',id='::n::'){
		var html='<select name="rule['+id+'][operator]" class="form-control input-sm select2 inputOperator" placeholder="Search Operator" id="test" style="width:100%" required>';
		rules1.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriters(x[0],x[1],'selected');
			}else{
				html+=optionWriters(x[0],x[1]);
			}
		});
		html+='</select>';
		return html;
	}
	function selectOpsiBuilder(rules1,selected='',id='::n::'){
		var html='<select name="rule['+id+'][parameter]" class="form-control input-sm select2 inputOpsi" placeholder="Search Operator" id="test" style="width:100%" required>';
		rules1.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriters(x[0],x[1],'selected');
			}else{
				html+=optionWriters(x[0],x[1]);
			}
		});
		html+='</select>';
		return html;
	}
	function inputBuilder(type,value='',id='::n::'){
		if(type==undefined){
			type='text';
		}
		if(type=='datetime'){
			updatedatetime=true;
			return '<input type="text" placeholder="Insert datetime" class="form-control datetime" name="rule['+id+'][parameter]" value="'+value+'"  required/>';
		}
		return '<input type="'+type+'" placeholder="Keyword" class="form-control" name="rule['+id+'][parameter]" value="'+value+'"  required/>';

	}
	function rowBuilders(val){
		var html='<div class="mt-repeater-cell" style="padding-bottom:10px" data-id="::n::">\
		<div class="col-md-12">\
		<div class="col-md-1">\
		<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline btnDelete">\
		<i class="fa fa-close"></i>\
		</a>\
		</div>\
		<div class="col-md-4">\
		::subjectOption::\
		</div>\
		<div class="col-md-4 optionCol">\
		::operatorOption::\
		</div>\
		<div class="col-md-3 valCol">\
		::otherVal::\
		</div>\
		</div>\
		</div>';
		html=html.replace('::subjectOption::',selectSubjectBuilder(rules1,val[0]));
		if(rules1[val[0]].operator.length>0){//is operator exist
			html=html.replace('::operatorOption::',selectOperatorBuilder(rules1[val[0]].operator,val[1]));
			html=html.replace('::otherVal::',inputBuilder(rules1[val[0]].type,val[2]));
		}else{
			html=html.replace('::operatorOption::',selectOpsiBuilder(rules1[val[0]].opsi,val[1]));
			html=html.replace('::otherVal::','');
		}
		var lastIds=$('#repeaterContainer1 .mt-repeater-cell').last().data('id');
		if(lastIds==undefined){lastIds=-1};
		html=html.replace(/::n::/g,lastIds+1);
		return html;
	}
	function updateColumn1(data){
		data.forEach(function(i){
			add1(i);
		});
	}
	function add1(newValue){
		if(newValue==undefined){
			var defaultCol=Object.keys(rules1)[0];
			var defaultOperator=rules1[defaultCol].operator[0][0];
			var newValue=[defaultCol,defaultOperator,''];
		}
		$('#repeaterContainer1').append(rowBuilders(newValue));
		$('.select2').select2();
		if(updatedatetime){
			$('.datetime').datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:5
		    });
			updatedatetime=false;
		}
	}
	$(document).ready(function(){
		if(database.value.length<1){
			var defaultCol=Object.keys(rules1)[0];
			var defaultOperator=rules1[defaultCol].operator[0][0];
			var newValue=[defaultCol,defaultOperator,''];
			database.value.push(newValue);
		}
		updateColumn1(database.value);
		$('#addNewBtn1').on('click',function(){add()});
		$('.form-body').on('click','.btnDelete',function(x){
			$(this).parents('.mt-repeater-cell').first().fadeOut(500,function(){$(this).remove()});
		});
		$('.form-body').on('change','.inputSubject',function(){
			var value=$(this).val();
			var parId=$(this).parents('.mt-repeater-cell').first().data('id');
			if(rules1[value].operator.length>0){
				var oprview=selectOperatorBuilder(rules1[value].operator,'',parId);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html(inputBuilder(rules1[value].type,'',parId));
				$(this).parents('.mt-repeater-cell').first().find('.valCol').show();
				$('.select2').select2();
			}else if(rules1[value].opsi.length>0){
				var oprview=selectOpsiBuilder(rules1[value].opsi,'',parId);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				$(this).parents('.mt-repeater-cell').first().find('.valCol').hide();
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html('');
				$('.select2').select2();
			}
			if(updatedatetime){
				$('.datetime').datetimepicker({
			        format: "dd M yyyy hh:ii",
			        autoclose: true,
			        todayBtn: true,
			        minuteStep:5
			    });
				updatedatetime=false;
			}
		});
		$('input[name="operator"]').val(database.operator);
	})
</script>
@endsection
@section('filter_hs')
<form action="{{$filter_action ?? '#'}}" method="post">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">Filter List</span>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<div class="form-group mt-repeater">
					<div data-repeater-list="conditions">
						<div data-repeater-item class="mt-repeater-item mt-overflow" id="repeaterContainer1">
						</div>
					</div>
					<div class="form-action col-md-12">
						<div class="col-md-12">
							<button class="btn btn-success mt-repeater-add" type="button" id="addNewBtn1">
								<i class="fa fa-plus"></i> Add New Condition
							</button>
						</div>
					</div>

					<div class="form-action col-md-12" style="margin-top:15px">
						<div class="col-md-5">
							<select name="operator" class="form-control input-sm " placeholder="Search Rule" required>
								<option value="and" @if (isset($operator) && $operator == 'and') selected @endif>Valid when all conditions are met</option>
								<option value="or" @if (isset($operator) && $operator == 'or') selected @endif>Valid when minimum one condition is met</option>
							</select>
						</div>
						<div class="col-md-4">
							{{ csrf_field() }}
							<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@if(isset($rule))
<div class="alert alert-block alert-info fade in">
	<button type="button" class="close" data-dismiss="alert"></button>
	<h4 class="alert-heading">Displaying search result :</h4>
	<p>{{$data_total}}</p><br>
	<form action="{{$filter_action ?? '#'}}" method="post">
		{{csrf_field()}}
		<button class="btn btn-sm btn-warning" name="clear" value="session">Reset</button>
	</form>
	<br>
</div>
@endif
@endsection