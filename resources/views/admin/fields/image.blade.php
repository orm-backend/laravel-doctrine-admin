<div class="kt-avatar kt-avatar--outline @if ($field->value) kt-avatar--changed @endif" id="{{ Str::random() }}">
	<div class="kt-avatar__holder" style="background-image: url({{ crop($field->path, 'center', 120, 120) }})"></div>
	<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change file">
		<i class="fa fa-pen"></i>
		<input type="file" name="{{ $field->fullname }}_file" accept=".png, .jpg, .jpeg">
	</label>
	<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel file">
		<i class="fa fa-times"></i>
	</span>
</div>
<p><span class="form-text text-muted">Allowed file types: png, jpeg.</span></p>
<span class="form-text text-muted">Or select an existing one:</span>
<div class="input-group">
	<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
	<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
	<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
	@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>