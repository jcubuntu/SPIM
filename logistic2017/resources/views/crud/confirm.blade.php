<div id="confirmModal" class="modal-block modal-header-color mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Are you sure ?</h2>
		</header>
		<div class="panel-body">
			<div class="modal-wrapper">
				<div class="modal-icon">
					<i class="fa fa-question-circle"></i>
				</div>
				<div class="modal-text">
					<h4 id="headline"></h4>
					<p id="message"></p>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-submit"><i class="fa fa-check"></i> Confirm</button>
					<button type="button" class="btn btn-default btn-cancel"><i class="fa fa-remove"></i> Cancel</button>
				</div>
			</div>
		</footer>
	</section>
</div>

@push('javascript')
<script type="text/javascript">
	var confirmDialog = function(style, headline, message, cb) {
	    $.magnificPopup.open({
	        modal: true,
	        items: {
	            src: $('#confirmModal'),
	            type: 'inline'
	        },
	        callbacks: {
	            open: function() {
	            	var $modal = $('#confirmModal');
	                var $content = $(this.content);

	                $modal.addClass('modal-block-'+style);
	                $modal.find('.btn-submit').addClass('btn-'+style);
	                $modal.find('#headline').html(headline);
	                $modal.find('#message').html(message);
	 
	                $content.on('click', '.btn-submit', function() {
	                    if (typeof cb == 'function') {
	                        cb();
	                    }
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
	            },
	            close: function() {
	            	var $modal = $('#confirmModal');
	            	$modal.removeClass('modal-block-'+style);
	                $modal.find('.btn-submit').removeClass('btn-'+style);
	                $modal.find('#headline').html('');
	                $modal.find('#message').html('');
	            }
	        }
	    });
	};
</script>
@endpush