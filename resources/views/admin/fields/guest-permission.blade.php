<div class="form-group row">
	@php ($value = $old[$field->name] ?? $field->value)
	@php ($group = isset($group) ? '['.$group.']' : '')
	<label class="col-3 col-form-label">{{ __('A site visitor can do the following:') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.guest.create') }}"
			@if ($value & config('ormbackend.perms.guest.create')) checked @endif
			data-switch="true" data-on-text="create" data-handle-width="70" data-off-text="create" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.guest.read') }}"
			@if ($value & config('ormbackend.perms.guest.read')) checked @endif
			data-switch="true" data-on-text="read" data-handle-width="70" data-off-text="read" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.guest.update') }}"
			@if ($value & config('ormbackend.perms.guest.update')) checked @endif
			data-switch="true" data-on-text="update" data-handle-width="70" data-off-text="update" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.guest.delete') }}"
			@if ($value & config('ormbackend.perms.guest.delete')) checked @endif
			data-switch="true" data-on-text="delete" data-handle-width="70" data-off-text="delete" data-on-color="brand">
	</div>
</div>
