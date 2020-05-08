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
                        	@if ($field->type == 'collection')
                        		@php ($value = implode(', ', array_column($field->value, 'name')))
                        	<td>{{ $value }}</td>
                        	@elseif ($field->type == 'reference')
                        	<td><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></td>
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