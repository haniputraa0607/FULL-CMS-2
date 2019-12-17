@section('buyXgetYForm')
<div class="row">
		<div class="col-md-6">
	<div id="selectProduct2" class="form-group" style="width: 100%!important">
			<label for="multipleProduct2" class="control-label">Product Utama<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk X yang akan menjadi syarat untuk mendapatkan promo </br></br>X : Produk utama </br>Y : Produk benefit" data-container="body" data-html="true"></i></label>
			<select id="multipleProduct3" name="product" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true" data-value="{{ ($result['promo_campaign_buyxgety_product_requirement']??false) ? json_encode( ([$result['promo_campaign_buyxgety_product_requirement']['id_product']] ?? ([$result['promo_campaign_buyxgety_product_requirement'][0]['id_product']]??'') ) ) :''}}" style="width: 100%!important">
			</select>
		</div>
	</div>
</div>
<div id="ruleSection2">
	<label class="control-label">Price Rule
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Masukan rentang jumlah produk dan benefit yang didapatkan dalam promo ini" data-container="body"></i></label>
	<div class="row">
		<div class="col-md-3">
			<div class="col-md-6 text-center">
				<label>Min. Qty <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk X minimal untuk mendapatkan diskon produk Y" data-container="body"></i></label>
			</div>
			<div class="col-md-6 text-center">
				<label>Max. Qty <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk X maksimal untuk mendapatkan diskon produk Y" data-container="body"></i></label>
			</div>
		</div>
		<div class="col-md-9">
			<div class="col-md-4 text-center">
				<label>Product Benefit <i class="fa fa-question-circle tooltips" data-original-title="Produk Y yang akan diberikan diskon setelah pembelian produk X" data-container="body"></i></label>
			</div>
			<div class="col-md-3 text-center">
				<label>Benefit <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk Y yang akan dikenakan diskon setelah pembelian produk X </br></br> Free : jumlah product Y yang diberikan </br></br> Discount : Besar diskon yang diberikan pada produk Y" data-html="true" data-container="body"></i></label>
			</div>
			<div class="col-md-5 text-center">
			</div>
		</div>
	</div>
	<div id="ruleSectionBody2">
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary new">Add New</button>
	</div>
</div>@endSection

@section('child-script2')
<script type="text/javascript">
	var lastError2='';
	var template2='	<div class="row" data-id="::n::">\
		<div class="col-md-3">\
			<div class="col-md-6">\
				<div class="form-group">\
					<input type="text" class="form-control ::classMinQty:: text-center qty_mask" min="1" name="promo_rule[::n::][min_qty_requirement]" value="::min_qty::" required>\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error1::</p>\
			</div>\
			<div class="col-md-6">\
				<div class="form-group">\
					<input type="text" class="form-control ::classMaxQty:: text-center qty_mask" min="1" name="promo_rule[::n::][max_qty_requirement]" value="::max_qty::" required>\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error2::</p>\
			</div>\
		</div>\
		<div class="col-md-9">\
			<div class="col-md-4">\
				<div class="form-group">\
					<select name="promo_rule[::n::][benefit_id_product]" class="form-control product-selector select2" placeholder="Select product" style="width: 100%!important">::productList::</select>\
				</div>\
			</div>\
			<div class="col-md-4">\
				<select class="form-control benefit" name="promo_rule[::n::][benefit_type]">\
					<option value="free" ::selected_free::> Free Product</option>\
					<option value="nominal" ::selected_nominal::> Nominal Discount </option>\
					<option value="percent" ::selected_percent::> Percent Discount </option>\
		        </select>\
			</div>\
			<div class="col-md-3">\
				<div class="form-group ::hide_qty::">\
					<div class="input-group">\
						<input type="text" class="form-control benefit_qty text-center digit_mask" min="0" name="promo_rule[::n::][benefit_qty]" value="::benefit_qty::" ::required_qty:: placeholder="Benefit Qty">\
						<div class="input-group-addon">qty</div>\
					</div>\
				</div>\
				<div class="form-group ::hide_nominal::">\
					<div class="input-group">\
						<div class="input-group-addon">IDR</div>\
						<input type="text" class="form-control digit_mask text-center" min="0" name="promo_rule[::n::][discount_nominal]" value="::discount_nominal::" ::required_nominal:: placeholder="100000">\
					</div>\
				</div>\
				<div class="form-group ::hide_percent::">\
					<div class="input-group">\
						<input type="number" class="form-control discount_value max100 benefit_percent text-center" min="0" max="100" name="promo_rule[::n::][discount_percent]" value="::discount_value::"" ::discount_prop:: ::required_percent:: style="padding-left: 7px;padding-right: 7px;text-align: center;" placeholder="50">\
						<div class="input-group-addon">%</div>\
					</div>\
				</div>\
			</div>\
			<div class="col-md-1">\
				<button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash-o"></i></button>\
			</div>\
		</div>\
	</div>';
	@if(isset($result['promo_campaign_buyxgety_rules']))
		database2={!!json_encode($result['promo_campaign_buyxgety_rules'])!!};
	@else
		database2=[];
	@endif
	function add2(id){
		if(!isNaN(id)){
			database2.splice(id+1,0,{});
		}else{
			database2.splice(0,0,{});
		}
		reOrder();
	}
	function update2(col,val){
		var ncol=col.replace('promo_rule','database2').replace(/\[/g,'["').replace(/\]/g,'"]');
		eval(ncol+'=val');
	}
	function reOrder2(drawIfTrue=true){
		var html='';
		var last=0;
		var status=true;
		var lastErrorReal='';
		if(database2.length<1||database2[0]==undefined){
			database2=[];
			add2();
		}
		database2.forEach(function(it,id){
			var edited=template2;
			var errorNow='';
			var discount_value=it['discount_percent'];
			var discount_nominal_value=it['discount_nominal'];
			var qty = it['benefit_qty'];
			var hide_qty = '';
			var hide_nominal = '';
			var hide_percent = '';
			var selected_free = '';
			var selected_nominal = '';
			var selected_percent = '';
			var required_qty = '';
			var required_nominal = '';
			var required_percent = '';
			var it_min_qty = it['min_qty_requirement']+'';
			var it_max_qty = it['max_qty_requirement']+'';
			it_min_qty = it_min_qty.replace(/,/g , '');
			it_max_qty = it_max_qty.replace(/,/g , '');
			it_min_qty = parseInt(it_min_qty);
			it_max_qty = parseInt(it_max_qty);

			if(it['benefit_type'] == "free"){

				hide_nominal = 'd-none';
				hide_percent = 'd-none';
				selected_free = 'selected';
				required_qty = 'required';
				discount_value = 100;
				discount_nominal_value = ''

			}else if(it['benefit_type'] == "percent") {

				hide_qty = 'd-none';
				hide_nominal = 'd-none';
				selected_percent = 'selected';
				required_percent = 'required';
				discount_nominal_value = ''

			}else if(it['benefit_type'] == "nominal") {

				hide_qty = 'd-none';
				hide_percent = 'd-none';
				selected_nominal = 'selected';
				required_nominal = 'required';
				discount_value = '';

			}else {

				if (it['discount_nominal']) {

					discount_nominal_value = it['discount_nominal'];
					hide_qty = 'd-none';
					hide_percent = 'd-none';
					hide_nominal = '';
					selected_nominal = 'selected';
					required_qty = '';
					required_nominal = 'required';
					discount_value = '';
					
				}else if (it['discount_percent'] && it['discount_percent'] != 100) {

					hide_qty = 'd-none';
					hide_nominal = 'd-none';
					hide_percent = '';
					selected_percent = 'selected';
					required_percent = 'required';
					discount_nominal_value = ''

				}else {
					hide_nominal = 'd-none';
					hide_percent = 'd-none';
					selected_free = 'selected';
					discount_value = 100;
					discount_nominal_value = ''

				}

			}

			$('button[type="submit"]').prop('disabled', false);
			if(it['discount_percent']-100>0){
				discount_value=100;
			}
			edited=edited.replace(/::n::/g,id).replace('::min_qty::',it['min_qty_requirement']).replace('::max_qty::',it['max_qty_requirement']).replace('::discount_value::',discount_value).replace('::benefit_qty::',it['benefit_qty']).replace('::hide_qty::', hide_qty).replace('::hide_nominal::', hide_nominal).replace('::hide_percent::', hide_percent).replace('::selected_free::', selected_free).replace('::selected_nominal::', selected_nominal).replace('::selected_percent::', selected_percent).replace('::discount_nominal::',discount_nominal_value?discount_nominal_value:'').replace('::required_qty::',required_qty).replace('::required_nominal::',required_nominal).replace('::required_percent::',required_percent);

			if(it_min_qty-last<=0){
				if(!lastErrorReal){
					edited=edited.replace('::error1::','Min. Quantity should be greater than '+last).replace('::classMinQty::','red');
					errorNow='min_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else if(it_min_qty-it_max_qty>0){
				if(!lastErrorReal){
					edited=edited.replace('::error2::','Max. Quantity should be greater than or equal '+it['min_qty_requirement']).replace('::classMaxQty::','red');
					errorNow='max_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else{
				edited=edited.replace('::error::','');
			}
			edited=edited.replace('::classMinQty::','').replace('::classMaxQty::','').replace('::error1::','').replace('::error2::','');
			if(!lastErrorReal){
				lastErrorReal=errorNow;
			}
			if(listProduct){
				var htmlProduct='<option value="0">Same Product</option>';
				listProduct.forEach(function(i){
					var addthis='';
					if(it['benefit_id_product']&&it['benefit_id_product']==i['id_product']){
						addthis='selected';
					}
					htmlProduct+='<option value="'+i['id_product']+'" '+addthis+'>'+i['product']+'</option>';
				})
				edited=edited.replace('::productList::',htmlProduct);
			}else{
				edited=edited.replace('::productList::','');
			}
			last=it['max_qty_requirement'];
			html+=edited;
		})
		if(lastErrorReal!=lastError2||(status&&drawIfTrue)){
			lastError2=lastErrorReal;
			$('#ruleSectionBody2').html(html);
			$('.product-selector').select2({ width: '100%' ,placeholder:'Select product'});
		}

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});
		$('.qty_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});

		return status;
	}
	$(document).ready(function(){
		$('#buyXgetYProduct').on('click','.new',function(){
			if(!reOrder2()){
				return false;
			}
			database2.push({});
			reOrder2();
		});
		$('#buyXgetYProduct').on('keyup','.max100',function(){
			if($(this).val()>100){
				$(this).val(100);
			}
		});
		$('#buyXgetYProduct').on('click','.remove',function(){
			var id=$($(this).parents('.row')[0]).data('id');
			delete database2[id];
			database2=database2.filter(function(x){return x!==undefined;});
			reOrder2();
		});
		$('#buyXgetYProduct').on('change','input,select',function(){
			var col=$(this).prop('name');
			var val=$(this).val();
			update2(col,val);
			reOrder2();
		});
		$('#buyXgetYProduct').on('change','input[name="discount_type"]',function(){
			if($('input[name="discount_type"]:checked').val()=='Percent'){
				$('.discount_value').prop('max','100');
			}else{
				$('.discount_value').removeProp('max');
			}
		});
		$('button[type="submit"]').on('click',function(){
			if($('input[name=promo_type]:checked').val()=='Buy X Get Y'){
				return reOrder2();
			}
		});
	});

</script>
@endSection