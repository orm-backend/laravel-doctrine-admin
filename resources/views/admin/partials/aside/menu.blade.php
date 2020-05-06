
<!-- begin:: Aside Menu -->
<?php use Illuminate\Support\Str;?>
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
	<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
		<ul class="kt-menu__nav ">
			<!-- <?=request()->path();?> -->
			<li class="kt-menu__item <?=(request()->path() == 'admin' ? 'kt-menu__item--active' : '')?>" aria-haspopup="true"><a href="/admin/" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">Dashboard</span></a></li>
			<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--open {{ Str::startsWith('/'.request()->path(), '/admin/entities') ? 'kt-menu__item--here' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
				<a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-menu-4"></i><span class="kt-menu__link-text">Entities</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
    					@foreach ($menu as $item)
            			<li class="kt-menu__item {{ Str::startsWith('/'.request()->path().'/', $item['link']) ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
            				<a href="{{ $item['link'] }}" class="kt-menu__link " title="{{ $item['title'] }}"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ $item['name'] }}</span></a>
            			</li>
            			@endforeach
            		</ul>
				</div>
			</li>
			<li class="kt-menu__item  kt-menu__item--submenu {{ Str::startsWith('/'.request()->path(), '/admin/trash') ? 'kt-menu__item--open kt-menu__item--here' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
				<a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-rubbish-bin"></i><span class="kt-menu__link-text">Trash</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
				<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
					<ul class="kt-menu__subnav">
						@foreach ($menu as $item)
							@if (!$item['trash'])
								@continue
							@endif
            			<li class="kt-menu__item {{ Str::startsWith('/'.request()->path().'/', $item['trash']) ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
            				<a href="{{ $item['trash'] }}" class="kt-menu__link" title="{{ $item['title'] }}"><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ $item['name'] }}</span></a>
            			</li>
            			@endforeach
					</ul>
				</div>
			</li>
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