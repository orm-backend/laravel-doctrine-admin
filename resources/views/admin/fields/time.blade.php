<div class="input-group time">
	<div class="input-group-prepend">
		<span class="input-group-text">
			<i class="la la-clock-o"></i>
		</span>
	</div>
	<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" placeholder="00:00:00" value="{{ $old[$field->name] ?? $field->value }}" @if ($field->disabled) disabled @endif>
</div>
@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror