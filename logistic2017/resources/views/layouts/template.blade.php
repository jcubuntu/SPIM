<!doctype html>
<html class="fixed">
	@include('layouts.head')
	<body>
		<section class="body">

			<!-- start: header -->
			@include('layouts.header')
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				@include('layouts.sidebar')
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					@include('layouts.title')

					<!-- start: page -->
						@yield('content')
					<!-- end: page -->	

				</section>
			</div>

		</section>

		@include('layouts.javascript')
	</body>
</html>