<div class="kt-portlet__head kt-portlet__head--lg">
	<div class="kt-portlet__head-label">
		<h3 class="kt-portlet__head-title">{{ $meta['title'] }} <small>{{ $meta['class'] }}</small></h3>
	</div>
	<div class="kt-portlet__head-toolbar">
		<a href="{{ route('admin.entity.search', $meta['classUrlName']) }}" class="btn btn-clean kt-margin-r-10">
			<i class="la la-arrow-left"></i>
			<span class="kt-hidden-mobile">Back</span>
		</a>
		<div class="btn-group">
			<button type="button" class="btn btn-brand submit" data-form="entity-edit">
				<i class="la la-check"></i>
				<span class="kt-hidden-mobile">{{ __('Save') }}</span>
			</button>
			<button type="button" class="btn btn-brand goto" data-url="{{ route('admin.entity.details', [$meta['classUrlName'], $entity->id()]) }}">
				<i class="la la-file-o"></i>
				<span class="kt-hidden-mobile">{{ __('View') }}</span>
			</button>
			@if ($entity->delitingAllowed)
			<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#delete_modal" data-url="{{ route('admin.entity.delete', [$meta['classUrlName'], $entity->id()]) }}">
				<i class="la la-remove"></i>
				<span class="kt-hidden-mobile">{{ __('Delete') }}</span>
			</button>
			@endif
		</div>
	</div>
</div>