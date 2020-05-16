<li class="kt-menu__item {{ $item['active'] ? 'kt-menu__item--active' : '' }}" aria-haspopup="true">
	<a href="{{ $item['url'] }}" class="kt-menu__link" title="{{ $item['title'] }}">
		@if (isset($item['icon']))
		<i class="kt-menu__link-icon {{ $item['icon'] }}"></i>
		@else
		<i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
		@endif
		<span class="kt-menu__link-text">{{ $item['name'] }}</span>
	</a>
</li>