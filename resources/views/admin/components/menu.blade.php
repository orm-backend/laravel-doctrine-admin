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
			<li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
				<a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-menu-3"></i><span class="kt-menu__link-text">Quick Links</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul id="savedMenuItems" class="kt-menu__subnav"></ul>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- end:: Aside Menu -->