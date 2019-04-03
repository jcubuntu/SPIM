@if($input['type'] == 'select')
	<select name="{{ $input['name'] }}" id="{{ $input['name'] }}" class="form-control" required>
		<option value="" disabled selected>--- Select {{ array_search($input, $formInputList) }} ---</option>
		@foreach($input['options'] as $key => $value)
			<option value="{{ $value }}"{{ old($input['name'], null) == $value ? ' selected' : ''}}>{{ $key }}</option>
		@endforeach
	</select>
@elseif($input['type'] == 'textarea')
	<textarea class="form-control" name="{{ $input['name'] }}" id="{{ $input['name'] }}" required>{{ old($input['name']) }}</textarea>
@else
	<input type="{{ $input['type'] }}" class="form-control" name="{{ $input['name'] }}" id="{{ $input['name'] }}" required value="{{ old($input['name']) }}">
@endif