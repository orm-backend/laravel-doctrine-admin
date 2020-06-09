@extends('itaces::admin.popup')
@section('itaces::content')
<script src="/assets/admin/js/itaces/popup-table.js" type="text/javascript" defer></script>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include ('itaces::admin.partials.advanced-search-form')
    <div class="kt-portlet kt-portlet--mobile">
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
                        		<img src="{{ crop($element->path, 'center', 50, 50) }}" alt="{{ $element->name }}">
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'file_collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<span>{{ $element->name }}</span>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'collection')
                        	<td>
                        		@foreach ($field->value as $element)
                        		<span>{{ $element->name }}</span>
                        		@endforeach
                        	</td>
                        	@elseif ($field->type == 'reference')
                        	<td><span>{{ $field->valueName }}</span></td>
                        	@elseif ($field->type == 'image')
                        	<td>
                        		<img src="{{ crop($field->path, 'center', 50, 50) }}" alt="{{ $field->valueName }}">
                        	</td>
                        	@elseif ($field->value && $field->type == 'datetime')
                        	<td>{{ $field->value->toDateTimeString() }}</td>
                        	@elseif ($field->value && $field->type == 'date')
                        	<td>{{ $field->value->toDateString() }}</td>
                        	@elseif ($field->value && $field->type == 'time')
                        	<td>{{ $field->value->toTimeString() }}</td>
                        	@else
                        	<td>{{ $field->value }}</td>
                        	@endif
                            @endforeach
                            @if ($entity->type() == 'image')
                        	<td><img src="{{ crop($entity->field('path')->value, 'center', 50, 50) }}"></td>
                        	@endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable -->
        </div>
    </div>
</div>
<script type="text/javascript">
window.pagination = {
		page: {{ $paginator->currentPage() }},
		perpage: {{ $paginator->perPage() }},
		total: {{ $paginator->total() }}
}
window.metadata = <?=json_encode($container->fields())?>
</script>
@endsection