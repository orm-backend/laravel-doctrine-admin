@foreach ($fields as $field)
	@continue( isset($exclude) && in_array($field->fullname, $exclude) )
<div class="form-group row">
	<label class="col-3 col-form-label">{{ $field->title }}</label>
	<div class="col-8">
	@switch($field->type)
		@case('text')
    		@include('itaces::admin.fields.text', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
    		@break
		@case('number')
			@include('itaces::admin.fields.number', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('datetime')
    		@include('itaces::admin.fields.datetime', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('date')
    		@include('itaces::admin.fields.date', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('time')
    		@include('itaces::admin.fields.time', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('textarea')
    		@include('itaces::admin.fields.textarea', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('checkbox')
    		@include('itaces::admin.fields.checkbox', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('radio')
    		@include('itaces::admin.fields.radio', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('reference')
    		@include('itaces::admin.fields.reference', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('collection')
		@case('file_collection')
		@case('image_collection')
    		@include('itaces::admin.fields.collection', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('image')
    		@include('itaces::admin.fields.image', ['field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
	@endswitch
	</div>
</div>
@endforeach