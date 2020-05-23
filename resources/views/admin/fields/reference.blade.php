<div class="input-group">
	<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ $old[$field->name] ?? $field->value }}" @if ($field->disabled) disabled @endif>
	<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
	<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
	@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>