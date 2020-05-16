<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<div class="kt-subheader__breadcrumbs">
				@foreach ($menu as $item)
					@if (isset($item['icon']) && $item['icon'])
					<a href="{{ $item['url'] }}" class="kt-subheader__breadcrumbs-home" title="{{ $item['title'] }}"><i class="{{ $item['icon'] }}"></i></a>
					@endif
					@if ($loop->last)
					<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">{{ $item['name'] }}</span>
					@else
					<a href="{{ $item['url'] }}" class="kt-subheader__breadcrumbs-link" title="{{ $item['title'] }}">{{ $item['name'] }}</a>
					<span class="kt-subheader__breadcrumbs-separator"></span>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
<!-- end:: Subheader -->
