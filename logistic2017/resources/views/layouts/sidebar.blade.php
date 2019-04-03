<?php 
	$user = auth()->user();
?>
<aside id="sidebar-left" class="sidebar-left">

	<div class="sidebar-header">
		<div class="sidebar-title">
			Menu
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<li>
						<a href="{{ route('warehouse.monitor') }}">
							<i class="fa fa-desktop" aria-hidden="true"></i>
							<span>Warehouse Monitor</span>
						</a>
					</li>
					<li class="nav-parent">
						<a>
							<i class="fa fa-database" aria-hidden="true"></i>
							<span>Data Management</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="{{ route('company.index') }}">
									<i class="fa fa-suitcase" aria-hidden="true"></i>
									<span>Company</span>
								</a>
							</li>
							<li>
								<a href="{{ route('category.index') }}">
									<i class="fa fa-suitcase" aria-hidden="true"></i>
									<span>Product Category</span>
								</a>
							</li>
							<li>
								<a href="{{ route('product.index') }}">
									<i class="fa fa-suitcase" aria-hidden="true"></i>
									<span>Product</span>
								</a>
							</li>
							<li>
								<a href="{{ route('warehouse.index') }}">
									<i class="fa fa-suitcase" aria-hidden="true"></i>
									<span>Warehouse</span>
								</a>
							</li>
							
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>