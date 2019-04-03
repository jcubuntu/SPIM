@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			{!! Form::open(['route' => [$route.'.update', $warehouse->id], 'method' => 'PUT', 'class' => 'form-horizontal form-bordered']) !!}
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					</div>

					<h2 class="panel-title">แก้ไขข้อมูลโกดังสินค้า</h2>
				</header>
				<div class="panel-body">
					@include('layouts.validation')

					<div class="form-group">
						<label class="col-md-3 control-label" for="x">Position X</label>
						<div class="col-md-1">
							<input type="number" class="form-control" name="x" id="x" value="{{ old('x', $warehouse->x) }}" required>
						</div>

						<label class="col-md-1 control-label" for="y">Position Y</label>
						<div class="col-md-1">
							<input type="number" class="form-control" name="y" id="y" value="{{ old('y', $warehouse->y) }}" required>
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
@endpush