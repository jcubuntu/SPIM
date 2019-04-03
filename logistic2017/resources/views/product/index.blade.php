@extends('layouts.template')

@section('content')
<div class="row">
	<div class="col-md-9">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				</div>

				<h2 class="panel-title"><i class="fa fa-list"></i> Data List</h2>
			</header>

			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th>ID</th>
							<th>RFID</th>
							<th>Name</th>
							<th>Product Category</th>
							<th>Company</th>
							<th>Dead Stock</th>
							<th>Created Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($itemList as $command)
							<tr>
								<td>{{ $command->id }}</td>
								<td>{{ $command->RFID }}</td>
								<td>{{ $command->name }}</td>
								<td>{{ $command->deadstock }} days</td>
								<td>{{ $command->created_at->format('d-m-Y H:i:s') }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>


	<div class="col-md-3">
		<section class="panel">
			{!! Form::open(['route' => 'product.store', 'method' => 'POST']) !!}
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					</div>
					<h2 class="panel-title"><i class="fa fa-database"></i> Add Data</h2>
				</header>

				<div class="panel-body">
					<div class="row">

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Product Name</label>
								<input type="text" class="form-control" name="name" id="name">
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">RFID</label>
								<input type="number" class="form-control" name="RFID" id="RFID">
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Product Category</label>
								<select name="category_id" id="category_id" class="form-control">
									
								</select>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Company</label>
								<select name="company_id" id="company_id" class="form-control">
									
								</select>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Deadstock Period</label>
								<input type="number" class="form-control" name="deadstock_period" id="deadstock_period">
							</div>
						</div>
					</div>
				</div>


				<footer class="panel-footer text-right">
					<button class="btn btn-success"><i class="fa fa-check"></i> Add</button>
				</footer>
				{!! Form::close() !!}
		</section>

		<div id="actionModal" class="modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Are you sure?</h2>
				</header>
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="modal-icon">
							<i class="fa fa-question-circle"></i>
						</div>
						<div class="modal-text">
							<h4>Add Data</h4>
							<p>Are you sure that you want to add this data ?</p>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-confirm"><i class="fa fa-plus"></i> Confirm</button>
							<button type="button" class="btn btn-default modal-dismiss"><i class="fa fa-remove"></i> Cancel</button>
						</div>
					</div>
				</footer>
			</section>
		</div>

	</div>
</div>
    
@endsection

@push('javascript')
    <script src="{{ url('assets/backend/assets/javascripts/tables/examples.datatables.default.js') }}"></script>
@endpush