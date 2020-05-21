<div class="input-group bootstrap-touchspin">
	<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
</div>
@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror