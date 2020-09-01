<div class="form-group row">
	@php ($value = $old[$field->name] ?? $field->value)
	@php ($group = isset($group) ? '['.$group.']' : '')
	<label class="col-3 col-form-label">{{ __('A group user can perform the following actions with the records of any users (including his own records):') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.entity.create') }}"
			@if ($value & config('ormbackend.perms.entity.create')) checked @endif
			data-switch="true" data-on-text="create" data-handle-width="70" data-off-text="create" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.entity.read') }}"
			@if ($value & config('ormbackend.perms.entity.read')) checked @endif
			data-switch="true" data-on-text="read" data-handle-width="70" data-off-text="read" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.entity.update') }}"
			@if ($value & config('ormbackend.perms.entity.update')) checked @endif
			data-switch="true" data-on-text="update" data-handle-width="70" data-off-text="update" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.entity.delete') }}"
			@if ($value & config('ormbackend.perms.entity.delete')) checked @endif
			data-switch="true" data-on-text="delete" data-handle-width="70" data-off-text="delete" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.entity.restore') }}"
			@if ($value & config('ormbackend.perms.entity.restore')) checked @endif
			data-switch="true" data-on-text="restore" data-handle-width="70" data-off-text="restore" data-on-color="brand">
	</div>
</div>
<div class="form-group row">
	<label class="col-3 col-form-label">{{ __('A group user can perform the following actions with his records:') }}</label>
	<div class="col-8">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.record.read') }}"
			@if ($value & config('ormbackend.perms.record.read')) checked @endif
			data-switch="true" data-on-text="read" data-handle-width="70" data-off-text="read" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.record.update') }}"
			@if ($value & config('ormbackend.perms.record.update')) checked @endif
			data-switch="true" data-on-text="update" data-handle-width="70" data-off-text="update" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.record.delete') }}"
			@if ($value & config('ormbackend.perms.record.delete')) checked @endif
			data-switch="true" data-on-text="delete" data-handle-width="70" data-off-text="delete" data-on-color="brand">
		<input type="checkbox" name="permissions{{$group}}[]" value="{{ config('ormbackend.perms.record.restore') }}"
			@if ($value & config('ormbackend.perms.record.restore')) checked @endif
			data-switch="true" data-on-text="restore" data-handle-width="70" data-off-text="restore" data-on-color="brand">
	</div>
</div>
