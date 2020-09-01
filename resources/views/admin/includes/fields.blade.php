@foreach ($fields as $field)
	@continue( isset($exclude) && in_array($field->fullname, $exclude) )
<div class="form-group row">
	<label class="col-3 col-form-label">{{ $field->title }}</label>
	<div class="col-8">
	@switch($field->type)
		@case('text')
    		@include('ormbackend::admin.fields.text', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
    		@break
		@case('number')
			@include('ormbackend::admin.fields.number', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('datetime')
    		@include('ormbackend::admin.fields.datetime', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('date')
    		@include('ormbackend::admin.fields.date', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('time')
    		@include('ormbackend::admin.fields.time', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('textarea')
    		@include('ormbackend::admin.fields.textarea', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('checkbox')
    		@include('ormbackend::admin.fields.checkbox', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('radio')
    		@include('ormbackend::admin.fields.radio', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('reference')
    		@include('ormbackend::admin.fields.reference', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('collection')
		@case('file_collection')
		@case('image_collection')
    		@include('ormbackend::admin.fields.collection', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
		@case('image')
    		@include('ormbackend::admin.fields.image', ['meta' => $meta, 'field' => $field, 'old' => $old, 'message' => $message ?? null])
			@break
	@endswitch
	</div>
</div>
@endforeach