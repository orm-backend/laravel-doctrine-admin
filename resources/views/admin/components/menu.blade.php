<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
	<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
		<ul class="kt-menu__nav ">
			@foreach ($menu as $item)
				@if(isset($item['submenu']))
					@include('itaces::admin.components.menu.submenu', ['item' => $item])
				@else
					@include('itaces::admin.components.menu.item', ['item' => $item])
				@endif
			@endforeach
		</ul>
	</div>
</div>
<!-- end:: Aside Menu -->