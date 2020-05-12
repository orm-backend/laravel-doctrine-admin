@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<style>
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Are your sure?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p>If you continue, the record will be deleted from the database.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Yes, delete</button>
			</div>
		</div>
	</div>
</div>
@php ($entity = $container->first())
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet" id="kt_page_portlet">
		<div class="kt-portlet__head kt-portlet__head--lg no-print">
			<div class="kt-portlet__head-label">
				<h3 class="kt-portlet__head-title">{{ $meta['title'] }} <small>{{ $meta['class'] }}</small></h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<a href="{{ route('admin.entity.search', $meta['classUrlName']) }}" class="btn btn-clean kt-margin-r-10">
					<i class="la la-arrow-left"></i>
					<span class="kt-hidden-mobile">Back</span>
				</a>
				<div class="btn-group">
					@if ($entity->updatingAllowed)
					<button type="button" class="btn btn-brand goto" data-url="{{ route('admin.entity.edit', [$meta['classUrlName'], $entity->id()]) }}">
						<i class="la la-edit"></i>
						<span class="kt-hidden-mobile">{{ __('Edit') }}</span>
					</button>
					@endif
					@if ($entity->delitingAllowed)
					<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#delete_modal" data-url="{{ route('admin.entity.delete', [$meta['classUrlName'], $entity->id()]) }}">
						<i class="la la-remove"></i>
						<span class="kt-hidden-mobile">{{ __('Delete') }}</span>
					</button>
					@endif
				</div>
			</div>
		</div>
		<div class="kt-portlet__body kt-portlet__body--fit">
			<div class="entity-details">
				<div class="entity-detail__head">
					<div class="entity-detail__container">
						<h4>{{ $meta['title'] }} #{{ $entity->field('id')->value }}</h4>
						<div class="entity-detail__brand">
							<h1 class="entity-detail__title">{{ $entity->field('name') ? $entity->field('name')->value : ($entity->field('code') ? $entity->field('code')->value : '') }}</h1>
							@if ($entity->type() == 'image')
							<div class="entity-detail__logo">
    							<a href="/{{ $entity->field('path')->value }}" target="_blank"><img src="{{ crop($entity->field('path')->value, 'center', 400, 225) }}"></a>
    							<span class="entity-detail__desc">
    								<span>{{ file_mimetype(public_path($entity->field('path')->value)) }}</span>
    								<span>{{ file_human_size(public_path($entity->field('path')->value)) }}</span>
    							</span>
    						</div>
    						@endif
						</div>

						<div class="entity-detail__items">
							<div class="entity-detail__item">
								<span class="entity-detail__subtitle">CREATED</span>
								<span class="entity-detail__text">{{ $entity->field('createdAt')->value->isoFormat('MMM Do YYYY, hh:mm:ss') }}</span>
								<span class="entity-detail__text">{{ $entity->field('createdBy')->valueName ? 'by ' .$entity->field('createdBy')->valueName : '' }}</span>
							</div>
							<div class="entity-detail__item">
								<span class="entity-detail__subtitle">UPDATED</span>
								<span class="entity-detail__text">{{ $entity->field('updatedAt')->value ? $entity->field('updatedAt')->value->isoFormat('MMM Do YYYY, hh:mm:ss') : '—' }}</span>
								<span class="entity-detail__text">{{ $entity->field('updatedBy')->valueName ? 'by ' .$entity->field('updatedBy')->valueName : '' }}</span>
							</div>
							<div class="entity-detail__item">
								<span class="entity-detail__subtitle">DELETED</span>
								<span class="entity-detail__text">{{ $entity->field('deletedAt')->value ?$entity->field('deletedAt')->value->isoFormat('MMM Do YYYY, hh:mm:ss') : '—' }}</span>
								<span class="entity-detail__text">{{ $entity->field('deletedBy')->valueName ? 'by ' .$entity->field('deletedBy')->valueName : '' }}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="entity-detail__body">
					<div class="entity-detail__container">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="2">PROPERTIES</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($entity->fields() as $field)
										@if ($field->disabled || $field->type == 'reference' || $field->type == 'collection' || $field->type == 'file_collection' || $field->type == 'image_collection')
											@continue
										@endif
									<tr>
										<td width="25%">{{ $field->title }}</td>
										<td>
											@if ($field->type == 'image')
											<img src="{{ crop($field->path, 'center', 80, 80) }}" alt="{{ $field->valueName }}">
											@else
											{{ $field->value }}
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="entity-detail__footer">
					<div class="entity-detail__container">
						@php ($associations = [])
        				@foreach ($entity->fields() as $field)
        					@if (!$field->disabled && $field->type == 'reference')
        						@php ($associations[] = $field)
        					@endif
        				@endforeach
						@if ($associations)
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>ASSOCIATION</th>
										<th>ID</th>
										<th>NAME</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($associations as $field)
									<tr>
										<td width="25%">{{ $field->title }}</td>
										<td>{{ $field->value ? $field->value : '—' }}</td>
										<td>{{ $field->valueName ? $field->valueName : '—' }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						@endif
				
        				@foreach ($entity->fields() as $field)
        					@if ($field->disabled || ($field->type != 'collection' && $field->type != 'file_collection' && $field->type != 'image_collection'))
        						@continue
        					@endif
						@if ($field->type == 'image_collection')
						<div class="kt-section">
                            <div class="kt-section__desc">{{ $field->title }}</div>
                            <div class="kt-section__content">
                                @foreach ($field->value as $element)
    							<a class="kt-media kt-media--xl" href="{{ $element->url }}" target="_blank">
    								<img src="{{ crop($element->path, 'center', 80, 80) }}" alt="{{ $element->name }}">
    							</a>
    							@endforeach
                            </div>
                        </div>
						@else
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>{{ $field->refClassTitle }}</th>
										<th>Id</th>
										<th>Name</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($field->value as $element)
									<tr>
										<td></td>
										<td>{{ $element->id }}</td>
										@if ($field->type == 'file_collection')
										<td><a href="{{ $element->url }}" target="_blank"></td>
										@else
										<td>{{ $element->name }}</td>
										@endif
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						@endif
						@endforeach
					</div>
				</div>

				<div class="entity-detail__actions">
					<div class="entity-detail__container">
						<button type="button" class="btn btn-brand btn-bold"
							onclick="window.print();"><i class="la la-print"></i>
							<span class="kt-hidden-mobile">{{ __('Print') }}</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Content -->
@endsection