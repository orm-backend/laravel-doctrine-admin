
<!--begin: User Bar -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
		<div class="kt-header__topbar-user">
			<span class="kt-header__topbar-username kt-hidden-mobile">{{ auth()->user()->getName() }}</span>
			<span class="kt-header__topbar-icon">
				<i class="flaticon2-user-outline-symbol"></i>
			</span>

			<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->

			<!--<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span>-->
		</div>
	</div>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround kt-header__topbar-item--langs">
		<!--[html-partial:include:{"file":"partials/_topbar/dropdown/user.html"}]/-->
		@include('ormbackend::admin.partials.topbar.dropdown.user')
	</div>
</div>

<!--end: User Bar -->