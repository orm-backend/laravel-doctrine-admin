@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-table.js" type="text/javascript" defer></script>
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
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@if (session('success'))
	<div class="row">
		<div class="col">
			<div class="alert alert-success fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ session('success') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
		</div>
	</div>
	@endif
	@if (session('warning'))
	<div class="row">
		<div class="col">
			<div class="alert alert-warning fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">{{ session('warning') }}</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
		</div>
	</div>
	@endif
	@include ('itaces::admin.partials.advanced-search-form')
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon"> <i
					class="kt-font-brand flaticon2-browser"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					{{ $meta['title'] }} <small></small>
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="btn-group">
					<div class="dropdown dropdown-inline">
						<button type="button"
							class="btn btn-default btn-icon-sm dropdown-toggle"
							data-toggle="dropdown" aria-haspopup="true"
							aria-expanded="false">
							<i class="la la-download"></i> Export
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<ul class="kt-nav">
								<li class="kt-nav__section kt-nav__section--first"><span
									class="kt-nav__section-text">Choose an option</span></li>
								<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
										class="kt-nav__link-icon la la-file-excel-o"></i> <span
										class="kt-nav__link-text">Excel</span>
								</a></li>
								<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
										class="kt-nav__link-icon la la-file-text-o"></i> <span
										class="kt-nav__link-text">CSV</span>
								</a></li>
								<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
										class="kt-nav__link-icon la la-file-code-o"></i> <span
										class="kt-nav__link-text">XML</span>
								</a></li>
							</ul>
						</div>
					</div>
					@can('create', $meta['classUrlName'])
					<a href="{{ route('admin.entity.create', $meta['classUrlName']) }}" class="btn btn-brand btn-elevate btn-icon-sm">
						<i class="la la-plus"></i> New Record
					</a>
					@endcan
				</div>
			</div>
		</div>
		@can('delete', $meta['classUrlName'])
		<div class="kt-portlet__body">
			<!--begin: Selected Rows Group Action Form -->
			<div class="kt-form kt-form--label-align-right kt-margin-t-20 collapse" id="kt_datatable_group_action_form">
				<div class="row align-items-center">
					<div class="col-xl-12">
						<form action="{{ route('admin.entity.batchDelete', [$meta['classUrlName']]) }}" method="post" name="selected-rows">
							@csrf
							<input type="hidden" name="selected" value="">
    						<div class="kt-form__group kt-form__group--inline">
    							<div class="kt-form__label kt-form__label-no-wrap">
    								<label class="kt-font-bold kt-font-danger-">Selected
    									<span id="kt_datatable_selected_number">0</span> records:</label>
    							</div>
    							<div class="kt-form__control">
    								<div class="btn-toolbar">
    									<button class="btn btn-brand" type="submit" id="kt_datatable_delete_all">Delete Selected</button>
    								</div>
    							</div>
    						</div>
    					</form>
					</div>
				</div>
			</div>
			<!--end: Selected Rows Group Action Form -->
		</div>
		@endcan
		<div class="kt-portlet__body kt-portlet__body--fit">
			<!--begin: Datatable -->
			<table class="kt-datatable itaces-datatable">
				<thead>
                    <tr>
                    	<th data-selector="kt-checkbox--solid" data-field="RecordID" data-sortable="false" data-width="20" data-textalign="center">#</th>
                    	@foreach ($container->fields() as $field)
                    	<th data-field="{{ $field->aliasname }}" data-textalign="{{ $field->textalign }}" data-width="{{ $field->width }}" data-sortable="{{ $field->sortable }}" data-type="{{ $field->type }}">{{ $field->title }}</th>
                    	@endforeach
                        @if ($container->first() && $container->first()->type() == 'image')
                    	<th data-field="Picture" data-sortable="false" data-overflow="visible" data-autohide="false" data-textalign="left">{{ __('Picture') }}</th>
                    	@endif
                        <th data-field="Actions" data-sortable="false" data-overflow="visible" data-autohide="false" data-textalign="left">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($container->entities() as $entity)
                        <tr>
                        	<td>{{ $entity->id() }}</td>
                        	@foreach ($entity->fields() as $field)
                        	@if ($field->type == 'image_collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<a class="kt-media" href="{{ route('admin.entity.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">
                        			<img src="{{ crop($element->path, 'center', 50, 50) }}" alt="{{ $element->name }}">
                        		</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'file_collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<a href="{{ route('admin.entity.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">{{ $element->name }}</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<a href="{{ route('admin.entity.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">{{ $element->name }}</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'reference')
                        	<td><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></td>
                        	@elseif ($field->type == 'image')
                        	<td>
                        		<a class="kt-media" href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">
                        			<img src="{{ crop($field->path, 'center', 50, 50) }}" alt="{{ $field->valueName }}">
                        		</a>
                        	</td>
                        	@else
                        	<td>{{ $field->value }}</td>
                        	@endif
                            @endforeach
                            @if ($entity->type() == 'image')
                        	<td><a href="/{{ $entity->field('path')->value }}" target="_blank"><img src="{{ crop($entity->field('path')->value, 'center', 50, 50) }}"></a></td>
                        	@endif
                            <td>
                            	@if ($entity->readingAllowed)
                            	<a href="{{ route('admin.entity.details', [$meta['classUrlName'], $entity->id()]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Show details">
    								<i class="la la-file-o"></i>
    							</a>
    							@endif
    							@if ($entity->updatingAllowed)
                            	<a href="{{ route('admin.entity.edit', [$meta['classUrlName'], $entity->id()]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
    								<i class="la la-edit"></i>
    							</a>
    							@endif
    							@if ($entity->delitingAllowed)
    							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="modal" data-target="#delete_modal" data-url="{{ route('admin.entity.delete', [$meta['classUrlName'], $entity->id()]) }}" title="Delete">
    								<i class="la la-trash"></i>
    							</a>
    							@endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
			</table>
			<!--end: Datatable -->
		</div>
	</div>
</div>
<!-- end:: Content -->
<script type="text/javascript">
window.pagination = {
		page: {{ $paginator->currentPage() }},
		perpage: {{ $paginator->perPage() }},
		total: {{ $paginator->total() }}
}
window.metadata = <?=json_encode($container->fields())?>
</script>
@endsection