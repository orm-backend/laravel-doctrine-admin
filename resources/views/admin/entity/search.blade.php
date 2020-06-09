@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-table.js" type="text/javascript" defer></script>
@include('itaces::admin.includes.delete-modal')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include ('itaces::admin.includes.session-aler')
	@include ('itaces::admin.partials.advanced-search-form')
	<div class="kt-portlet kt-portlet--mobile">
		@include('itaces::admin.includes.search-header', ['meta' => $meta])
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
                        		<a class="kt-media" href="{{ route('admin.'.$meta['group'].'.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">
                        			<img src="{{ crop($element->path, 'center', 50, 50) }}" alt="{{ $element->name }}">
                        		</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'file_collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<a href="{{ route('admin.'.$meta['group'].'.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">{{ $element->name }}</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<a href="{{ route('admin.'.$meta['group'].'.details', [$field->refClassUrlName, $element->id]) }}" target="_blank">{{ $element->name }}</a>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'reference')
                        	<td><a href="{{ $field->value ? route('admin.'.$meta['group'].'.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></td>
                        	@elseif ($field->type == 'image')
                        	<td>
                        		<a class="kt-media" href="{{ $field->value ? route('admin.'.$meta['group'].'.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">
                        			<img src="{{ crop($field->path, 'center', 50, 50) }}" alt="{{ $field->valueName }}">
                        		</a>
                        	</td>
                        	@elseif ($field->value && $field->type == 'datetime')
                        	<td>{{ $field->value->toDateTimeString() }}</td>
                        	@elseif ($field->value && $field->type == 'date')
                        	<td>{{ $field->value->toDateString() }}</td>
                        	@elseif ($field->value && $field->type == 'time')
                        	<td>{{ $field->value->toTimeString() }}</td>
                        	@else
                        	<td>{{ (string) $field->value }}</td>
                        	@endif
                            @endforeach
                            @if ($entity->type() == 'image')
                        	<td><a href="{{ $entity->url }}" target="_blank"><img src="{{ crop($entity->field('path')->value, 'center', 50, 50) }}"></a></td>
                        	@endif
                            <td>
                            	@if ($entity->readingAllowed)
                            	<a href="{{ route('admin.'.$meta['group'].'.details', [$meta['classUrlName'], $entity->id()]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Show details">
    								<i class="la la-file-o"></i>
    							</a>
    							@endif
    							@if ($entity->updatingAllowed)
                            	<a href="{{ route('admin.'.$meta['group'].'.edit', [$meta['classUrlName'], $entity->id()]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">
    								<i class="la la-edit"></i>
    							</a>
    							@endif
    							@if ($entity->delitingAllowed)
    							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="modal" data-target="#delete_modal" data-url="{{ route('admin.'.$meta['group'].'.delete', [$meta['classUrlName'], $entity->id()]) }}" title="Delete">
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