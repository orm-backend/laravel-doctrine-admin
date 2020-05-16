<li class="kt-menu__item kt-menu__item--submenu {{ isset($item['open']) && $item['open'] ? 'kt-menu__item--open' : '' }} {{ $item['active'] ? 'kt-menu__item--open kt-menu__item--active' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
	<a href="javascript:;" class="kt-menu__link kt-menu__toggle" title="{{ $item['title'] }}">
		@if (isset($item['icon']))
		<i class="kt-menu__link-icon {{ $item['icon'] }}"></i>
		@else
		<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
		@endif
		<span class="kt-menu__link-text">{{ $item['name'] }}</span>
		<i class="kt-menu__ver-arrow la la-angle-right"></i>
	</a>
	<div class="kt-menu__submenu">
		<span class="kt-menu__arrow"></span>
		<ul class="kt-menu__subnav">
			@foreach ($item['submenu'] as $child)
				@if(isset($child['submenu']))
					@include('itaces::admin.components.menu.submenu', ['item' => $child])
				@else
					@include('itaces::admin.components.menu.item', ['item' => $child])
				@endif
			@endforeach
		</ul>
	</div>
</li>