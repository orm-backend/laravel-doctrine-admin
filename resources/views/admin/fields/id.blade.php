<div class="form-group row">
	<label class="col-3 col-form-label">{{ $field->title }}</label>
	<input type="hidden" class="form-control" name="{{ $field->fullname }}" value="{{ $field->value }}">
	<div class="col-8">
		<div class="input-group bootstrap-touchspin">
			<input type="text" class="form-control" value="{{ $field->value }}" disabled>
		</div>
	</div>
</div>
