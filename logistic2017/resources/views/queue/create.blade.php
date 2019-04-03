@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			{!! Form::open(['route' => [$route.'.store'], 'method' => 'POST', 'class' => 'form-horizontal form-bordered']) !!}
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					</div>

					<h2 class="panel-title">เพิ่มสินค้าใหม่</h2>
				</header>
				<div class="panel-body">
					@include('layouts.validation')

					<div class="form-group">
						<label class="col-md-3 control-label" for="product_id">Product</label>
						<div class="col-md-3">
							<select data-plugin-selectTwo name="product_id" id="product_id" class="form-control populate" required>
								@foreach($productList as $product)
									<option value="{{ $product->id }}"{!! old('product_id') == $product->id ? ' selected="selected"' : '' !!}>{{ $product->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="expire_date">วันหมดอายุ</label>
						<div class="col-md-3">
							<input type="text" class="form-control" name="expire_date" id="expire_date" style="cursor: pointer" value="{{ old('expire_date') }}" readonly required>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
							<button type="reset" class="btn btn-default"><i class="fa fa-repeat"></i> Reset</button>
							<a class="btn btn-default" href="{{ route($route.'.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
						</div>
					</div>
				</footer>
			{!! Form::close() !!}
		</section>
	</div>
</div>
@endsection

@push('javascript')
	<script src="{{ url('assets/backend/assets/vendor/jquery-maskedinput/jquery.maskedinput.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var expireDate = $('#expire_date').datepicker({
			  format: 'yyyy-mm-dd',
			  orientation: "bottom auto",
			  language: "th",
			  startDate: "{{ date('Y-m-d') }}"
			});
		});
	</script>
@endpush