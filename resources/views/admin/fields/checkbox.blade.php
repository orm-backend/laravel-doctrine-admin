<span class="kt-switch kt-switch--icon">
	<label>
		@php($value = $old[$field->name] ?? $field->value)
		<input class="@error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" type="checkbox" value="1" @if ($field->disabled) disabled @endif @if ($value) checked @endif>
		<span></span>
		@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
	</label>
</span>