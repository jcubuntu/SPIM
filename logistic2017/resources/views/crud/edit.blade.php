<div id="editModal" class="modal-block mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Edit Data</h2>
		</header>
			<div class="panel-body">
				{!! Form::open(['id' => 'edit-form', 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					@foreach($formInputList as $label => $input)
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ $label }}</label>
							<div class="col-sm-9">
								@include('crud.input', compact('input'))
							</div>
						</div>
					@endforeach
				{!! Form::close() !!}
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-success btn-submit"><i class="fa fa-check"></i> Confirm</button>
						<button type="button" class="btn btn-default btn-cancel"><i class="fa fa-remove"></i> Cancel</button>
					</div>
				</div>
			</footer>
	</section>
</div>

@push('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('.edit-btn').click(function() {
    		var id = $(this).data('id');
    		$.ajax({
    			url: "{{ route($baseRouteName.'.index') }}/" + id,
    			method: "GET",
    			success: function(response) {
    				$('#edit-form').attr('action', "{{ route($baseRouteName.'.index') }}/"+id);
    				response = $.parseJSON(response);

    				$.each(response, function(key, value) {
    					var input = $('#edit-form #' + key);
    					if(input.is('select')) {
    						input.find('option').removeAttr('selected')
    											.filter('[value="' + value + '"]')
    											.attr('selected', true);
    					} else {
    						input.val(value);
    					}
    				});

    				$.magnificPopup.open({
		    			items: {
							src: $('#editModal'),
							type: 'inline'
						},
						callbacks: {
				            open: function() {
				                var $content = $(this.content);

				                $content.on('click', '.btn-submit', function() {
				                    $('#edit-form').submit();
				                    $.magnificPopup.close();
				                    $(document).off('keydown', keydownHandler);
				                    return true;
				                });
	 
						        $content.on('click', '.btn-cancel', function() {
						            $.magnificPopup.close();
						            $(document).off('keydown', keydownHandler);
						        });
				 
				                var keydownHandler = function (e) {
				                    if (e.keyCode == 13) {
				                        $content.find('.btn-submit').click();
				                        return false;
				                    } else if (e.keyCode == 27) {
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
