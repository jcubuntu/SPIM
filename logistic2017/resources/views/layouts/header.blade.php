<header class="header">
	<div class="logo-container">
		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<!-- start: search & user box -->
	<div class="header-right">

		<ul class="notifications">
			<li>
				<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					<span class="badge dead-stock-count">3</span>
				</a>

				<div class="dropdown-menu notification-menu">
					<div class="notification-title">
						<span class="pull-right label label-default dead-stock-count">3</span>
						Product Dead Stock.
					</div>

					<div class="content">
						<ul>
							<?php
							/* $inStockList = App\Models\Stock::getProductsInStock()->get(); ?>
							@foreach($inStockList as $inStock)
								@if($inStock->isDeadStock())
									<li>
										<a href="{{ route('warehouse.monitor') }}" class="clearfix">
											<div class="image">
												<i class="fa fa-exclamation-triangle bg-danger"></i>
											</div>
											<span class="title">Warehouse {{ $inStock->warehouse_id }}</span>
											<span class="message">{{ $inStock->created_at->addDays($inStock->product->deadstock)->diffForHumans() }}</span>
										</a>
									</li>
								@endif
							@endforeach
							*/?>
						</ul>
					</div>
				</div>
			</li>
		</ul>

		<span class="separator"></span>

		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
					<img src="{{ url('assets/backend/assets/images/!logged-user.jpg') }}" alt="{{ auth()->user()->username }}" class="img-circle" data-lock-picture="{{ url('assets/backend/assets/images/!logged-user.jpg') }}" />
				</figure>
				<div class="profile-info" data-lock-name="{{ auth()->user()->username }}">
					<span class="name">{{ ucfirst(auth()->user()->username) }}</span>
					<span class="role">Administrator</span>
				</div>

				<i class="fa custom-caret"></i>
			</a>

			<div class="dropdown-menu">
				<ul class="list-unstyled">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1" href="{{ route('auth.logout') }}"><i class="fa fa-power-off"></i> Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>