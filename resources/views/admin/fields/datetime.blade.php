<div class="input-group {{ $field->type }}">
	<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ $old[$field->name] ?? $field->value }}" @if ($field->disabled) disabled @endif>
	<div class="input-group-append">
		<span class="input-group-text">
			<i class="la la-calendar-check-o"></i>
		</span>
	</div>
</div>
@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror