@extends('layouts.template')

@push('stylesheet')
<style type="text/css">
	.monitorBox {
		overflow: auto;
		width: 100%;
		margin-top: 50px;
	}

	.monitor-block {
		display: inline-block;
		width: 100px;
		height: 100px;
		/*border: 1px solid #888;*/
	}

	.loader {
	    position: absolute;
	    width: 100%;
	    height: 100%;
	    text-align: center;
	    top: 50%;
	    margin-top: -60px;
	}
	.loader > img {
	    background: rgba(200, 200, 200, 0.5);
	    border-radius: 20px;
		padding: 20px;
	}

	.monitor-block > div {
		width: 100%;
		height: 100%;
	}
	.monitor-block > .warehouse {
		background-color: #888
	}
	.monitor-block > .warehouse.busy {
		background-color: green;
		cursor: pointer;
	}
	.monitor-block > .warehouse.deadstock {
		background-color: red;
	}
	.monitor-block > .warehouse.found-product {
		background-color: #ed9c28;
	}
	.monitor-block > .way {
		position: relative;
		/*background-color: #dadea2;*/
	}
	.fa.busy {
		color: green;
	}
	.fa.deadstock {
		color: red;
	}
	.fa.way {
		/*color: #dadea2;*/
	}
	.fa.found-product {
		color: #ed9c28;
	}
	.addWarehouse {
		display: block;
		width: 100%;
		height: 100%;
	}
	div.start,
	div.in,
	div.out {
		border: 1px solid #888;
		position: relative;
		top: 105px;
		background: #FFF !important;
		padding-top: 35px;
	}
	div.way:after,
	div.start:after {
	    background-color: #000;
	    content: "";
	    height: 110px;
	    position: absolute;
	    width: 4px;
	    right: 50%;
	    margin-right: -4px;
	}
	div.start:after {
	    top: -110px;
	}
	@media (min-width: 992px) { 
		div.start:before,
		div.out:before {
		    background-color: #000;
		    content: "";
		    height: 4px;
		    margin-top: -4px;
		    position: absolute;
		    width: 110px;
		    top: 50%;
		    left: -110px;
		}
		div.in {
			left: -105px;
		}
		div.out {
			right: -105px;
		}
	}
	.panel-footer {
		padding-top: 25px;
		padding-bottom: 25px;
		margin-bottom: 100px;
	}
</style>
@endpush

@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-desktop"></i> Warehouse Monitor</h2>
			</header>

			<div class="panel-body">
				<div class="pull-left sign-info">
					<!-- <i class="fa fa-square-o"></i> พื้นที่ว่าง -->
					<i class="fa fa-square"></i> Warehouse ที่ว่างอยู่
					<i class="fa fa-square busy"></i> Warehouse ที่มีสินค้า
					<i class="fa fa-square deadstock"></i> สินค้า Dead Stock
					<i class="fa fa-square found-product"></i> สินค้าที่ค้นหา
					<i class="fa fa-minus" style="color: #000"></i> เส้นทางเคลื่อนที่
				</div>	
				<div class="pull-right deadStockSelectorBox" style="margin-bottom: 50px;">
					<!-- Show Dead Stock in 
					{!! Form::select('deadStockSelector', config('deadstock.list'), null, ['placeholder' => 'Don\'t show', 'id' => 'deadStockSelector']); !!} -->

					ค้นหาสินค้า
					<select class="form-control" id="productList" name="productList">
						<option>---------------</option>
						@foreach($inStockList as $inStock)
							<option value="{{ $inStock->id }}">{{ $inStock->product->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="monitorBox" data-loading-overlay data-loading-overlay-options='{"css": { "backgroundColor": "#FFF" } }'>
					<div class="clearfix"></div>
					<center style="padding-bottom: 105px;">
						@for($y = $tableSize['maxY']; $y >= 0 ; $y--)
							@for($x = 0; $x <= $tableSize['maxX']; $x++)
								<?php
									$warehouse = $warehouseModel->where('x', $x)->where('y', $y)->first();
								?>
								<div data-x="{{ $x }}" data-y="{{ $y }}" class="monitor-block">
									@if($x == 1)
										@if($y == 0)
											<div class="start"></div>
										@elseif($y > 0)
											<div class="way"></div>
										@endif
									@elseif($y == 0)
										@if($x == 0)
											<div class="in"></div>
										@elseif($x == 2)
											<div class="out"></div>
										@endif
									@else
										@if($warehouse)
											@if($inStock = $warehouse->getProductInStock())
												<div class="warehouse busy{{ $inStock->isDeadStock() ? ' deadstock' : '' }}" data-stock-id="{{ $inStock->id }}" data-instock-timestamp="{{ strtotime($inStock->created_at)*1000 }}"></div>
											@else
												<div class="warehouse"></div>
											@endif
										@endif
									@endif
								</div>
							@endfor
							<div class="clearfix"></div>
						@endfor
					</center>
				</div>
			</div>
		</section>
	</div>

	<!-- <div class="col-lg-3">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title"><i class="fa fa-arrow-right"></i> ส่งสินค้าออก</h2>
			</header>

			<div class="panel-body">
				@if($inStockList->count())
					{!! Form::open(['route' => 'stock.out', 'id' => 'stock-out', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
						<div class="form-group">
							<label for="productList" class="control-label col-md-5">ค้นหาสินค้า</label>
							<div class="col-md-7">
								<select class="form-control" id="productList" name="productList">
									@foreach($inStockList as $inStock)
										<option value="{{ $inStock->id }}">{{ $inStock->product->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<button type="button" id="sendOutBtn" class="btn btn-primary btn-block">ส่งสินค้าออก <i class="fa fa-arrow-right"></i></button>
							</div>
						</div>
					{!! Form::close() !!}
				@else
					<span class="label label-danger">Out of stock.</span>
				@endif
			</div>
		</section>
	</div> -->
</div>
<div id="productInfoModal" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Product Info</h2>
		</header>
		<div class="panel-body">
			<div id="product-info-form" class="form-horizontal mb-lg" data-loading-overlay data-loading-overlay-options='{"css": { "backgroundColor": "#FFF" } }'>
				<input type="hidden" id="id" name="id" />
				<div class="form-group mt-lg">
					<label class="col-sm-3 control-label">RFID</label>
					<div class="col-sm-8">
						<input type="text" id="RFID" name="RFID" class="form-control" readonly />
					</div>
				</div>
				<div class="form-group mt-lg">
					<label class="col-sm-3 control-label">ชื่อสินค้า</label>
					<div class="col-sm-8">
						<input type="text" id="name" name="name" class="form-control" readonly />
					</div>
				</div>
				<div class="form-group mt-lg">
					<label class="col-sm-3 control-label">เวลาที่นำเข้า</label>
					<div class="col-sm-8">
						<input type="text" id="date" name="date" class="form-control" readonly />
					</div>
				</div>
				<div class="form-group mt-lg">
					<label class="col-sm-3 control-label">Dead Stock</label>
					<div class="col-sm-8">
						<input type="text" id="deadstock" name="deadstock" class="form-control" readonly />
					</div>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-primary modal-confirm"><i class="fa fa-arrow-right" style="color: #FFF"></i> ส่งสินค้าออก</button>
					<button class="btn btn-default modal-dismiss">Close</button>
				</div>
			</div>
		</footer>
	</section>
</div><!-- 
<div id="confirmModal" class="modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Are you sure?</h2>
		</header>
		<div class="panel-body" data-loading-overlay data-loading-overlay-options='{"css": { "backgroundColor": "#FFF" } }'>
			<div class="modal-wrapper">
				<div class="modal-icon">
					<i class="fa fa-question-circle"></i>
				</div>
				<div class="modal-text">
					<p>คุณต้องการที่จะนำสินค้าเหล่านี้ออกจากโกดังใช่หรือไม่ ?</p>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</div>
			</div>
		</footer>
	</section>
</div> -->

@endsection

@push('javascript')
<script type="text/javascript">
	const APPID     = "{{ env('NETPIE_APPID') }}";
	const APPKEY    = "{{ env('NETPIE_APPKEY') }}";
	const APPSECRET = "{{ env('NETPIE_APPSECRET') }}";
	const ALIAS 	= "{{ env('NETPIE_ALIAS') }}";

	var microgear = Microgear.create({
	    key: APPKEY,
	    secret: APPSECRET,
	    alias : ALIAS
	});

	microgear.on('message', function(topic, msg) {
		if(msg.indexOf('i') == 0) {
			var rfid = msg.substr(1);

			$.ajax({
				url: "{{ url('api/stockin') }}",
				method: "POST",
				data: {rfid: rfid}
			}).done(function(data) {
				var str = data.str;
				if(str !== 0) {
					new PNotify({
						title: 'มีสินค้าเข้า !',
						text: 'มีสินค้า 1 รายการกำลังถูกส่งเข้าสต๊อค',
						type: 'success',
						icon: 'fa fa-check'
					});
					var x = str.substr(1, 1);
					var y = str.substr(2, 1);

					$('div[data-x="' + x + '"][data-y="' + y + '"]').find('.warehouse').addClass('busy').data('stock-id', data.stock_id).data('instock-timestamp', data.instock_timestamp);
					microgear.chat('robot', str);
					console.log(str);
				} else {
					new PNotify({
						title: 'ผิดพลาด !',
						text: 'Something went wrong.',
						type: 'error',
						icon: 'fa fa-exclamation-circle'
					});
				}
			}).fail(function() {
				new PNotify({
					title: 'ผิดพลาด !',
					text: 'Something went wrong.',
					type: 'error',
					icon: 'fa fa-exclamation-circle'
				});
			});
		}
	});

	microgear.on('connected', function() {
		console.log('NETPIE: connected');
	});

	microgear.on('present', function(event) {
	    console.log(event);
	});

	microgear.on('absent', function(event) {
	    console.log(event);
	});

	microgear.connect(APPID);
	var loaderTimer;
	
 	function showLoader(ele) {
 		clearTimeout(loaderTimer);
		ele.trigger('loading-overlay:show');
 	}
 	function hideLoader(ele) {
		ele.trigger('loading-overlay:hide');
 	}

	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
	@if($inStockList->count())
		$(document).on('click', '.modal-confirm', function (e) {
			e.preventDefault();

			var $form = $('#product-info-form');
			var stock_id = $form.find('input#id').val();

			if(!stock_id) {
				new PNotify({
					title: 'ผิดพลาด !',
					text: 'กรุณาเลือกสินค้าจากโกดัง',
					type: 'error',
					icon: 'fa fa-exclamation-circle'
				});
				$.magnificPopup.close();
				return;
			}

			showLoader($form);
			timer = setTimeout(function() {
				$.ajax({
					url: "{{ route('stock.out') }}",
					method: "POST",
					data: {_token: "{{ csrf_token() }}", stock_id: stock_id}
				}).done(function(data) {
					new PNotify({
						title: 'สำเร็จ !',
						text: 'เพิ่มคิวงานไปยังหุ่นยนต์ขนของแล้ว.',
						type: 'success',
						icon: 'fa fa-check'
					});
					$('div[data-stock-id="' + stock_id + '"]').removeClass('busy deadstock');
					microgear.chat('robot', data);
					console.log(data);
				}).fail(function() {
					new PNotify({
						title: 'ผิดพลาด !',
						text: 'Something went wrong.',
						type: 'error',
						icon: 'fa fa-exclamation-circle'
					});
				}).always(function() {
					hideLoader($form);
					$.magnificPopup.close();
				});
			}, 700);
		});
	@endif
	$(document).ready(function() {
		$('div.start').html('Standby');
		$('div.in').html('In');
		$('div.out').html('Out');

		$('#productList').multiselect({
            enableFiltering: true,
            // includeSelectAllOption: true,
            dropRight: true,
            enableCaseInsensitiveFiltering: true,
            onChange: function(option, checked, select) {
            	$('.warehouse.found-product').removeClass('found-product');

	            $('#productList option:selected').each(function(index, value) {
	            	var stock_id = $(value).val();
	            	var productBlock = $('div[data-stock-id="' + stock_id + '"]');
	            	if(productBlock.length) {
	            		productBlock.addClass('found-product');
	            	}
	            });
            }
        });

		$('.warehouse.busy').magnificPopup({
			items: {
				src: $('#productInfoModal')
			},
			type: 'inline',
			preloader: false,
			modal: true,
			closeBtnInside: true,
			closeOnBgClick: true,

			mainClass: 'my-mfp-slide-bottom',

			callbacks: {
				beforeOpen: function() {
					showLoader($('#product-info-form'));
					var stock_id = this.st.el.data('stock-id');
					$.ajax({
						url: "{{ route('stock.index') }}/" + stock_id,
						method: "GET"
					}).done(function(data) {
						$.each(data, function(key, value) {
							$('#product-info-form').find('#'+key).val(value);
						});
					}).always(function() {
						hideLoader($('#product-info-form'));
					});
				}
			}
		});
	});
</script>
@endpush