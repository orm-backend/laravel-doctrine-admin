<input class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" type="{{ $field->type }}" value="{{ $old[$field->name] ?? $field->value }}" @if ($field->disabled) disabled @endif>
@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror