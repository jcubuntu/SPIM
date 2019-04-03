@extends('layouts.template')

@push('stylesheet')
<link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
<style type="text/css">
	.block {
		width: 100px;
		height: 100px;
	}
	.block a,
	.block span {
		width: 100px;
		height: 100px;
	    text-align: center;
	    vertical-align: middle;
	    display: table-cell;
	    color: #333;
	    text-decoration: none;
	}
	.block a.warehouse {
		background: #bbb;
		box-shadow: inset 0 0 2px #333;
	}
	.block a.warehouse.full {
		background: orange;
		color: #FFF;
	}
	.block a.warehouse.available {
		background: #0088cc;
		color: #FFF;
	}
	.block a.warehouse.deadstock {
		background: red;
		color: #FFF;
	}
	.block.in,
	.block.out,
	.block.start {
		background-color: green;
	}
	.block.in span,
	.block.out span,
	.block.start span {
	    color: #FFF;
	}
	#block-table {
		max-width: 100%;
	}

	.v-line:after {
		content:     "";
		display: block;
		position:    relative;
		height: 100%;
		left:        50%;
		border-left: 2px solid #000000;
	}

	.h-line:after {
		content:    "";
		display: block;
		top:        50%;
		right:      0;
		left:       0;
		border-top: 2px solid #000000;
	}

	.hv-line:before {
		content: "";
		display: block;
		position: relative;
		height: 100%;
		left: 50%;
		border-left: 2px solid #000000;
	}

	.hv-line:after {
		content: "";
		position: relative;
		height: 2px;
		top: -50%;
		background: #000;
		display: block;
	}

	.robot {
		position: relative;
	}

	.robot > i.fa {
		position: absolute;
		top: 50%;
		left: 51%;
		transform: translate(-50%, -50%);
		font-size: 65px;
		color: rgba(0, 178, 255, 0.7);
	}

</style>
@endpush

@section('content')
<div class="row">
	<div class="col-lg-8">
		<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					</div>

					<h2 class="panel-title">Warehouse Monitor <small><a href="{{ url('/reset') }}">Reset</a></small></h2>
				</header>
				<div class="panel-body text-right">
					<i class="fa fa-square" style="color: #bbb"></i> Available
					<i class="fa fa-square" style="color: orange; margin-left: 5px"></i> Full
					<i class="fa fa-square" style="color: red; margin-left: 5px"></i> Deadstock
					<i class="fa fa-circle" style="color: #00B2FF; margin-left: 5px"></i> Robot
					<center>
						<table id="block-table">
							<tbody>
							<tr>

								<td class="block">
									<a href="#" class="warehouse" data-x="0" data-y="3">
										Items: (0/1)
									</a>
								</td>

								<td class="block h-line" data-x="0" data-y="3"></td>
								<td class="block hv-line" data-x="1" data-y="3"></td>
							</tr>
							<tr>

								<td class="block">
									<a href="#" class="warehouse" data-x="0" data-y="2">
										Items: (0/1)
									</a>
								</td>

								<td class="block h-line" data-x="0" data-y="2"></td>
								<td class="block hv-line" data-x="1" data-y="2"></td>
							</tr>
							<tr>

								<td class="block">
									<a href="#" class="warehouse" data-x="0" data-y="1">
										Items: (0/1)
									</a>
								</td>

								<td class="block h-line" data-x="0" data-y="1"></td>
								<td class="block hv-line robot" data-x="1" data-y="1"></td>
							</tr>
							<tr>
								<td class="block"></td>
								<td class="block"></td>
								<td class="block start robot" data-x="1" data-y="0">
									<span>START</span>
								</td>
								<td class="block"></td>
								<td class="block"></td>
							</tr>
							</tbody>
						</table>
					</center>
				</div>
		</section>
	</div>
</div>

<div id="warehouseInfo" class="modal-block modal-block-lg mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Warehouse Info <span></span></h2>
		</header>
			<div class="panel-body">
				<div class="row">
					<div class="tabs">
						<ul class="nav nav-tabs nav-justified">

						</ul>
						<div class="tab-content">

						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-default btn-cancel"><i class="fa fa-remove"></i> Cancel</button>
					</div>
				</div>
			</footer>
	</section>
</div>

<div id="template-content" style="display: none">
	<div class="form-horizontal">
		<div class="alert alert-danger alert-deadstock" style="display: none">
			<i class="fa fa-exclamation-triangle"> DEAD STOCK</i>
		</div>
			<input type="hidden" id="item_id" name="item_id">
		<div class="form-group">
			<label for="RFID" class="control-label col-md-4">RFID</label>
			<div class="col-md-6">
				<input type="text" id="RFID" name="RFID" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="product_name" class="control-label col-md-4">Product Name</label>
			<div class="col-md-6">
				<input type="text" id="product_name" name="product_name" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="company_name" class="control-label col-md-4">Company</label>
			<div class="col-md-6">
				<input type="text" id="company_name" name="company_name" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="imported_at" class="control-label col-md-4">Imported date</label>
			<div class="col-md-6">
				<input type="text" id="imported_at" name="imported_at" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<label for="deadstock_in" class="control-label col-md-4">Dead stock in</label>
			<div class="col-md-6">
				<input type="text" id="deadstock_in" name="deadstock_in" class="form-control" readonly>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button class="btn btn-primary btn-export"><i class="fa fa-arrow-right"></i> Export</button>
			</div>
		</div>
	</div>
</div>
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
	microgear.on('connected', function() {
		microgear.setAlias(ALIAS);        // Jack
		microgear.subscribe("/RFID/+");   // Jack
		console.log('NETPIE: connected');
	});

	microgear.on('present', function(event) {
	    console.log(event);
	});

	microgear.on('absent', function(event) {
	    console.log(event);
	});
	// setTimeout(function() {
	// 	microgear.chat('website', 'i12345678');
	// 	console.log('chat');
	// }, 2000);
	microgear.on('message', function(topic, msg) {
		console.log('Recive message: ' + msg);
		if(msg.indexOf('p') == 0) {
			var pos = msg.split(' ');
			setRobotPosition(pos[1], pos[2]);
		}
		else if(msg.indexOf('r') == 0) {
			var rfid = msg.substr(1);
			putItem(rfid);
		}
	});

	microgear.connect(APPID);
	function setRobotPosition(x, y) {
		$('td.robot').removeClass('robot').find('i.fa').remove();
		$('td.block[data-x="' + x + '"][data-y="' + y + '"]').addClass('robot').append('<i class="fa fa-circle"></i>');
	}

	function putItem(rfid) {
		$.ajax({
			url: "{{ url('api/stockin') }}",
			method: "POST",
			data: {rfid: rfid}
		}).done(function(data) { // Import
			var str = data.str;
			if(str !== 0) {
				new PNotify({
					title: 'Stock Imported !',
					text: '1 product is being delivered in stock.',
					type: 'success',
					icon: 'fa fa-check'
				});
				var x = str.substr(1, 1);
				var y = str.substr(2, 1);

				if( typeof data.x !== 'undefined'
						&& typeof data.y !== 'undefined'
						&& typeof data.remaining !== 'undefined'
						&& typeof data.warehouseSize !== 'undefined') {
					var ele = $('a.warehouse[data-x="' + data.x + '"][data-y="' + data.y + '"]')
					if(data.remaining <= 0) {
						data.remaining = 0;
						ele.removeClass('full').addClass('available');
					} else if(data.remaining >= data.warehouseSize) {
						data.remaining = data.warehouseSize;
						ele.addClass('full').removeClass('available');
					}
					if(data.hasDeadstock == true) {
						ele.addClass('deadstock');
					}
					else {
						ele.removeClass('deadstock');
					}
					var html = 'Items: (' + data.remaining + '/' + data.warehouseSize + ')';
					ele.html(html);
				}

				microgear.chat('robot01', str);
				microgear.publish("/WAREHOUSE/website", str);
				console.log(str);
			} else {
				new PNotify({
					title: 'Error !',
					text: 'No space in warehouse.',
					type: 'error',
					icon: 'fa fa-exclamation-circle'
				});
				// microgear.chat('robot', 0);
				console.log('Full');
			}
		}).fail(function() {
			new PNotify({
				title: 'Error !',
				text: 'Something went wrong.',
				type: 'error',
				icon: 'fa fa-exclamation-circle'
			});
		});
	}
		
	$(document).ready(function() {
		var $modal = $('#warehouseInfo');
		var deadstockIndex = {!! json_encode($deadstockIndex) !!};
		var itemsInWarehouse = {!! json_encode($itemInWarehouseList) !!};
		console.log(deadstockIndex);

		$.each(itemsInWarehouse, function(index, item) {
			var ele = $('a.warehouse[data-x="' + item.warehouse.x + '"][data-y="' + item.warehouse.y + '"]')
			if(ele.length) ele.text('Items: (1/1)').addClass('full')
		});

		$.each(deadstockIndex, function(index, pos) {
			var ele = $('a.warehouse[data-x="' + pos[0] + '"][data-y="' + pos[1] + '"]');
			if(ele.length) ele.removeClass('full').addClass('deadstock')
		});

		$('.warehouse').click(function() {
    		var x = $(this).data('x');
    		var y = $(this).data('y');
    		var title = '(Pos: ' + x + ',' + y + ')';
    		$modal.find('.panel-title span').html(title);

			$modal.find('.nav-tabs').html('');
			$modal.find('.tab-content').html('');

    		$.ajax({
    			url: "{{ route('warehouse.getItem') }}",
    			method: "GET",
    			data: {
    				_token: "{{ csrf_token() }}",
    				x: x,
    				y: y
    			},
    			success: function(response) {
    				$.each(response, function(index, item) {
    					var id = 'layer-'+(index+1);
						// var menu = $('<li/>').html('<a href="#' + id + '" data-toggle="tab" class="text-center"><i class="fa fa-bars"></i> Layer ' + (index+1) + '</a>');
						var menu = $('<li/>').html('<a href="#' + id + '" data-toggle="tab" class="text-center"></a>');
						var content = $('<div/>').addClass('tab-pane').attr('id', id);

						if(index == 0) {
							menu.addClass('active');
							content.addClass('active');
						}

    					if(item == 'available') {
    						content.html('<div class="alert alert-warning">Out of stock in this warehouse.</div>');
    					} else {
    						content.html($('#template-content').html());

    						content.find('.alert-deadstock').hide();

    						$.each(item, function(key, value) {
    							if(key == 'deadstock') {
    								if(value) {
    									var deadTab = $('<span/>').addClass('label label-danger').html('DEAD STOCK');
										// menu.find('a').append(' ').append(deadTab);
										content.find('.alert-deadstock').show();
    								} else {
    									content.find('.alert-deadstock').hide();
    								}
    							} else {
    								content.find('#'+key).val(value);
    							}
    						});
    					}

						$modal.find('.nav-tabs').append(menu);
						$modal.find('.tab-content').append(content);
    				});

    				$modal.find('.btn-export').unbind().click(function() {
    					var $tab = $(this).closest('.tab-pane');
    					var item_id = $tab.find('#item_id').val();
    					$.ajax({
    						url: "{{ route('warehouse.index') }}/export/" + item_id,
    						method: "POST",
    						data: {
    							_token: "{{ csrf_token() }}"
    						},
    						success: function(response) { // Export
					            $.magnificPopup.close();
								new PNotify({
									title: response.title,
									text: response.message,
									type: response.type
								});
								if( typeof response.str !== 'undefined') {
									microgear.chat('robot01', response.str);
									microgear.publish("/WAREHOUSE/website", response.str);
									console.log(response.str);
								}

								if( typeof response.x !== 'undefined' 
								 && typeof response.y !== 'undefined' 
								 && typeof response.remaining !== 'undefined' 
								 && typeof response.warehouseSize !== 'undefined') {
									var ele = $('a.warehouse[data-x="' + response.x + '"][data-y="' + response.y + '"]')
									if(response.remaining <= 0) {
										response.remaining = 0;
										ele.removeClass('full available');
									} else if(response.remaining >= response.warehouseSize) {
										response.remaining = response.warehouseSize;
										ele.addClass('full').removeClass('available');
									} else {
										ele.addClass('available').removeClass('full');
									}
									if(response.hasDeadstock == true) {
										ele.addClass('deadstock');
									}
									else {
										ele.removeClass('deadstock');
									}
									var html = 'Items: (' + response.remaining + '/' + response.warehouseSize + ')';
									ele.html(html);
								}
    						}
    					});
    				});

    				$.magnificPopup.open({
						items: {
							src: $modal,
							type: 'inline'
						},
						callbacks: {
				            open: function() {
				                var $content = $(this.content);
						        $content.on('click', '.btn-cancel', function() {
						            $.magnificPopup.close();
						            $(document).off('keydown', keydownHandler);
						        });
				                var keydownHandler = function (e) {
				                    if (e.keyCode == 27) {
				                        $content.find('.btn-cancel').click();
				                        return false;
				                    }
				                };
				                $(document).on('keydown', keydownHandler);
				            }
				        }
					});
    			}
    		});
    	});
	});
</script>
@endpush