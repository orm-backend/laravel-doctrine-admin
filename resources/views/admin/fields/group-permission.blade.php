<div class="form-group row">
	@php ($value = $old[$field->name] ?? $field->value)
	<label class="col-3 col-form-label">{{ __('A group user can perform the following actions with the records of any users (including his own records):') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.entity.create') }}"
			@if ($value & config('itaces.perms.entity.create')) checked @endif
			data-switch="true" data-on-text="create" data-handle-width="70" data-off-text="create" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.entity.read') }}"
			@if ($value & config('itaces.perms.entity.read')) checked @endif
			data-switch="true" data-on-text="read" data-handle-width="70" data-off-text="read" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.entity.update') }}"
			@if ($value & config('itaces.perms.entity.update')) checked @endif
			data-switch="true" data-on-text="update" data-handle-width="70" data-off-text="update" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.entity.delete') }}"
			@if ($value & config('itaces.perms.entity.delete')) checked @endif
			data-switch="true" data-on-text="delete" data-handle-width="70" data-off-text="delete" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.entity.restore') }}"
			@if ($value & config('itaces.perms.entity.restore')) checked @endif
			data-switch="true" data-on-text="restore" data-handle-width="70" data-off-text="restore" data-on-color="brand">
	</div>
</div>
<div class="form-group row">
	<label class="col-3 col-form-label">{{ __('A group user can perform the following actions with his records:') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.record.read') }}"
			@if ($value & config('itaces.perms.record.read')) checked @endif
			data-switch="true" data-on-text="read" data-handle-width="70" data-off-text="read" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.record.update') }}"
			@if ($value & config('itaces.perms.record.update')) checked @endif
			data-switch="true" data-on-text="update" data-handle-width="70" data-off-text="update" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.record.delete') }}"
			@if ($value & config('itaces.perms.record.delete')) checked @endif
			data-switch="true" data-on-text="delete" data-handle-width="70" data-off-text="delete" data-on-color="brand">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.record.restore') }}"
			@if ($value & config('itaces.perms.record.restore')) checked @endif
			data-switch="true" data-on-text="restore" data-handle-width="70" data-off-text="restore" data-on-color="brand">
	</div>
</div>
<div class="form-group row">
	<label class="col-3 col-form-label">{{ __('Access is blocked to any data, other permissions are ignored') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.forbidden') }}"
			@if ($value & config('itaces.perms.forbidden')) checked @endif
			data-switch="true" data-on-text="forbidden" data-handle-width="70" data-off-text="forbidden" data-on-color="danger">
	</div>
	@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
