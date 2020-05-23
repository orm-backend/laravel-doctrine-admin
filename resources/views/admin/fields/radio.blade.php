@php ($oldValue = $old[$field->name] ?? $field->value)
<div class="form-group">
	<div class="kt-radio-inline">
		@foreach ($field->options as $value => $option)
		<label class="kt-radio">
			<input class="@error($field->fullname) is-invalid @enderror" type="radio" name="{{ $field->fullname }}" value="{{ $value }}" @if ($field->disabled) disabled @endif @if (oldValue == $value) checked @endif> {{ $option }}
			<span></span>
		</label>
		@endforeach
	</div>
	@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>