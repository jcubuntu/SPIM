@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			{!! Form::open(['route' => [$route.'.store'], 'method' => 'POST', 'class' => 'form-horizontal form-bordered']) !!}
				<input type="hidden" name="from" value="{{ $x ? 'monitor' : 'create' }}">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
					</div>

					<h2 class="panel-title">เพิ่มตำแหน่งโกดังสินค้าใหม่</h2>
				</header>
				<div class="panel-body">
					@include('layouts.validation')

					<div class="form-group">
						<label class="col-md-3 control-label" for="x">Position X</label>
						<div class="col-md-1">
							<input type="number" class="form-control" name="x" id="x" value="{{ old('x', $x) }}" required>
						</div>

						<label class="col-md-1 control-label" for="y">Position Y</label>
						<div class="col-md-1">
							<input type="number" class="form-control" name="y" id="y" value="{{ old('y', $y) }}" required>
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