@php ($value = $old[$field->name] ?? $field->value)
<div class="kt-avatar kt-avatar--outline" id="{{ Str::random() }}">
	<div class="kt-avatar__holder" style="background-image: url({{ crop($field->path, 'center', 120, 120) }})"></div>
	<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change file">
		<i class="fa fa-pen"></i>
		<input type="file" name="{{ $field->fullname }}" accept=".png, .jpg, .jpeg">
	</label>
	<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel file">
		<i class="fa fa-times"></i>
	</span>
	@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>