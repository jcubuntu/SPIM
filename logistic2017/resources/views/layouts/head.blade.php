<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Backend</title>
	<meta name="keywords" content="HTML5 Admin Template" />
	<meta name="description" content="Porto Admin - Responsive HTML5 Template">
	<meta name="author" content="okler.net">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/bootstrap/css/bootstrap.css') }}" />

	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/font-awesome/css/font-awesome.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/magnific-popup/magnific-popup.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/select2/select2.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{ url('assets/backend/assets/stylesheets/theme.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('assets/backend/assets/vendor/fullcalendar/fullcalendar.css') }}">

	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />
	<link rel="stylesheet" href="{{ url('assets/backend/assets/vendor/pnotify/pnotify.custom.css') }}" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="{{ url('assets/backend/assets/stylesheets/skins/default.css') }}" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="{{ url('assets/backend/assets/stylesheets/theme-custom.css') }}">

	<style type="text/css">
		table#datatable thead tr th:first-child,
		table#datatable tbody tr td:first-child  {
			width: 50px;
			text-align: center;
		}
		table#datatable thead tr th:last-child,
		table#datatable tbody tr td:last-child {
			width: 120px;
			text-align: center;
		}
		table#datatable thead tr th:nth-last-child(2),
		table#datatable tbody tr td:nth-last-child(2) {
			width: 150px;
			text-align: center;
		}
		button:.btn-primary .fa,
		button:.btn-danger .fa,
		button:.btn-success .fa {
			color: #FFF;
		}
	</style>

	<!-- Head Libs -->
	<script src="{{ url('assets/backend/assets/vendor/modernizr/modernizr.js') }}"></script>
	@stack('stylesheet')
</head>