@extends('layouts.template')

@section('content')
    <section class="panel">
		<div class="panel-body">
			<div class="text-right mb-md">
				<a href="{{ route($route.'.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
			</div>
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th>ID</th>
						<th>RFID</th>
						<th>Stock ID</th>
						<th>Name</th>
						<th>Expire Date</th>
						<th>Status</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($itemList as $command)
						<tr>
							<td>{{ $command->id }}</td>
							<td><a href="{{ route('product.edit', $command->product->id) }}" target="_blank">{{ $command->product->RFID }}</a></td>
							<td><a href="{{ route('warehouse.edit', $command->warehouse->id) }}" target="_blank">{{ $command->warehouse->id }} ({{ $command->warehouse->x.','.$command->warehouse->y }})</a></td>
							<td><a href="{{ route('product.edit', $command->product->id) }}" target="_blank">{{ $command->product->name }}</a></td>
							<td>{{ $command->getStatus() }}</td>
							<td>{{ $command->expire_date->format('d-m-Y') }}</td>
							<td>{{ $command->created_at->format('d-m-Y H:i:s') }}</td>
							<td>
								<a href="{{ route($route.'.edit', $command->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
								{!! Form::open(['url' => route($route.'.destroy', $command->id), 'method' => 'DELETE', 'style' => 'display: inline-block', 'onSubmit' => 'return confirm("คุณยืนยันที่จะลบข้อมูลนี้ใช่หรือไม่ ?")']) !!}
									<button type="submit" class="btn btn-danger"><i class="fa fa-remove"></i></button>
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</section>
@endsection

@push('javascript')
    <script src="{{ url('assets/backend/assets/javascripts/tables/examples.datatables.default.js') }}"></script>
@endpush