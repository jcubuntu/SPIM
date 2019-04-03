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
				<table class="table table-bordered table-striped mb-none" id="datatable">
					<thead>
						<tr>
							<th>ID</th>
							@foreach($tableColumn as $key => $name)
								<th>
									{{ $name }}
								</th>
							@endforeach
							<th>Created At</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($itemList as $item)
							<tr>
								<td>{{ $item->id }}</td>
								@foreach($tableColumn as $key => $name)
									<td>
									@if(str_contains($key, '->'))
										<?php $_item = $item; ?>
										@foreach(explode('->', $key) as $_key)
											<?php $_item = $_item->$_key; ?>
										@endforeach
										{{ $_item }}
									@else
										{{ $item->{$key} }}
									@endif 
									</td>
								@endforeach
								<td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
								<td>
									<button class="btn btn-primary btn-sm edit-btn" data-id="{{ $item->id }}"><i class="fa fa-pencil"></i></button>
									{!! Form::open(['route' => [$baseRouteName.'.destroy', $item->id], 'method' => 'DELETE', 'style' => 'display: inline']) !!}
										<button class="btn btn-danger btn-sm delete-btn"><i class="fa fa-remove"></i></button>
									{!! Form::close() !!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>


	<div class="col-md-3">
		<section class="panel">
			{!! Form::open(['route' => $baseRouteName.'.store', 'method' => 'POST', 'id' => 'add-form']) !!}
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					</div>
					<h2 class="panel-title"><i class="fa fa-database"></i> Add Data</h2>
				</header>

				<div class="panel-body">
					@include('layouts.validation')
					<div class="row">
						@foreach($formInputList as $label => $input)
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label">{{ $label }}</label>
									@include('crud.input', compact('input'))
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<footer class="panel-footer text-right">
					<button class="btn btn-success add-btn"><i class="fa fa-check"></i> Add</button>
				</footer>
			{!! Form::close() !!}
		</section>
	</div>
</div>

@include('crud.edit')
@include('crud.confirm')

@endsection

@push('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('#datatable').dataTable({
			"order": [[ 0, "desc" ]]
		});

    	$('.delete-btn').click(function(e) {
    		e.preventDefault();
    		var $form = $(this).closest('form');
			confirmDialog('danger', 'Delete Data', 'Are you sure that you want to delete this data ?', function() {
				$form.submit();
			});
    	});

    	$('.add-btn').click(function(e) {
    		e.preventDefault();
    		var $form = $(this).closest('form');
			confirmDialog('success', 'Add Data', 'Are you sure that you want to add this data ?', function() {
				$form.submit();
			});
    	});
	});
</script>
@endpush