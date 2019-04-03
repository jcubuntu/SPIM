@if(count($errors))
<div id="alert-box" class="validation-message">
	<ul style="display: block;">
		@foreach($errors->all() as $error)
		<li>
			<label class="error" style="display: inline-block;">{!! $error !!}</label>
		</li>
		@endforeach
	</ul>
</div>
<script type="text/javascript">
  setTimeout(function() {
    $('#alert-box').slideUp(function() {
      $(this).remove();
    });
  }, 3500);
</script>
@elseif(session('error'))
@push('javascript')
	<script type="text/javascript">
		new PNotify({
			title: 'Error',
			text: '{{ session('error') }}',
			type: 'error',
			icon: 'fa fa-exclamation-circle'
		});
	</script>
@endpush
@elseif(session('success'))
@push('javascript')
	<script type="text/javascript">
		new PNotify({
			title: 'Success',
			text: '{{ session('success') }}',
			type: 'success',
			icon: 'fa fa-check'
		});
	</script>
@endpush
@endif