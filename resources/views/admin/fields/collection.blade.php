<div class="input-group">
	<select class="form-control" name="{{ $field->fullname }}[]" multiple="multiple" autocomplete="off">
		<option value="0">[{{ __('nothing selected') }}]</option>
		@foreach ($field->value as $item)
        <option value="{{ $item->id }}" @if ($item->selected) selected @endif>{{ $item->name }}</option>
        @endforeach
    </select>
    <button type="button" class="btn btn-label-brand show-datatable" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname.'[]' }}">
    	<i class="la la-th-list"></i>
    </button>
</div>