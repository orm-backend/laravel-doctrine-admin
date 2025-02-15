@extends('ormbackend::admin.layout')
@section('ormbackend::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/ormbackend/entity-edit.js" type="text/javascript" defer></script>
@include('ormbackend::admin.includes.delete-modal')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include('ormbackend::admin.includes.alert', ['errors' => $errors])
	@php ($entity = $container->first())
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				@include('ormbackend::admin.includes.edit-header', ['meta' => $meta, 'entity' => $entity])
				<form class="kt-form" name="entity-edit" method="post" action="{{ $formAction }}" enctype="multipart/form-data">
					@csrf
					<div class="kt-portlet__body">
    					<div class="row">
    						<div class="col-xl-2"></div>
    						<div class="col-xl-8">
    							<div class="kt-section">
									<div class="kt-section__body">
										@php ($field = $entity->field('id'))
										@include('ormbackend::admin.fields.id', ['field' => $field])
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ __('File') }}</label>
											<div class="col-8">
        										<div class="kt-avatar kt-avatar--outline" id="{{ Str::random() }}">
                									<div class="kt-avatar__holder" style="background-image: url({{ crop($entity->field('path')->value, 'center', 120, 120) }})"></div>
                									<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Select file">
                										<i class="fa fa-pen"></i>
                										<input type="file" name="image" accept=".png, .jpg, .jpeg">
                									</label>
                									<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel file">
                										<i class="fa fa-times"></i>
                									</span>
                								</div>
                								<p><span class="form-text text-muted">Allowed file types: png, jpeg.</span></p>
                								@error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        									</div>
        								</div>
        								@php ($old = old($entity->classUrlName))
										@include('ormbackend::admin.includes.fields', ['fields' => $entity->fields(), 'old' => $old, 'message' => $message ?? null, 'exclude' => [$field->fullname]])
									</div>
								</div>
    						</div>
    						<div class="col-xl-2"></div>
                        </div>
                    </div>
    				<div class="kt-portlet__foot kt-portlet__foot--solid">
    					<div class="kt-form__actions">
    						<div class="row">
    		            		<div class="col-lg-12 kt-align-center">
                                    <div class="btn-group">
        								<button type="submit" class="btn btn-brand"><i class="la la-check"></i> {{ __('Save') }}</button>
        								<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.file.search', 'app-model-image') }}"><i class="fa fa-undo"></i>{{ __('Cancel') }}</button>
    		            			</div>
    		            		</div>
    		            	</div>
    					</div>
    				</div>
				</form>
			</div>
			<!--end::Portlet-->
		</div>
	</div>
</div>
<!-- end:: Content -->
@endsection