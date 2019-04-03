<!-- Vendor -->
<script src="{{ url('assets/backend/assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>


<!-- Specific Page Vendor -->
<script src="{{ url('assets/backend/assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/select2/select2.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/ios7-switch/ios7-switch.js') }}"></script>

<script src="{{ url('assets/backend/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script src="{{ url('assets/backend/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

<script src="{{ url('assets/backend/assets/vendor/pnotify/pnotify.custom.js') }}"></script>


<script src="{{ url('js/microgear.js') }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{ url('assets/backend/assets/javascripts/theme.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{{ url('assets/backend/assets/javascripts/theme.init.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var deadStockCount = $('.notification-menu .content ul li').length;
		$('.dead-stock-count').html(deadStockCount);
	});
</script>

@stack('javascript')