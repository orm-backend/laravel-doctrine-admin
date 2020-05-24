@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
@php ($entity = $container->first())
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include('itaces::admin.includes.alert', ['errors' => $errors])
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				@include('itaces::admin.includes.create-header', ['meta' => $meta, 'entity' => $entity])
				<form class="kt-form" name="entity-edit" method="post" action="{{ $formAction }}" enctype="multipart/form-data">
    				@csrf
    				<div class="kt-portlet__body">
						<div class="row">
							<div class="col-xl-2"></div>
							<div class="col-xl-8">
								<div class="kt-section">
									<div class="kt-section__body">
										@php ($fields = [])
										@foreach ($entity->fields() as $field)
    										@if (!$field->disabled)
    											@php ($fields[] = $field)
    										@endif
										@endforeach
										@php ($permission = $entity->field('permission'))
										@php ($id = $entity->field('id'))
										@php ($old = old($entity->classUrlName))
										@if ($entity->field('code')->value == config('itaces.roles.guest', 'guest'))
											@include('itaces::admin.fields.guest-permission', ['field' => $permission, 'old' => $old, 'message' => $message ?? null])
										@else
											@include('itaces::admin.fields.group-permission', ['field' => $permission, 'old' => $old, 'message' => $message ?? null])
										@endif
										@include('itaces::admin.includes.fields', ['fields' => $fields, 'old' => $old, 'message' => $message ?? null, 'exclude' => [$id->fullname, $permission->fullname]])
									</div>
								</div>
							</div>
							<div class="col-xl-2"></div>
						</div>
    				</div>
    				<div class="kt-portlet__foot kt-portlet__foot--solid">
    					<div class="kt-form__actions">
    						<div class="row">
    		            		<div class="col-xl-4"></div>
    		            		<div class="col-xl-8">
    								<button type="submit" class="btn btn-brand"><i class="la la-check"></i> {{ __('Save') }}</button>
    								<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.entity.search', $meta['classUrlName']) }}"><i class="fa fa-undo"></i>{{ __('Cancel') }}</button>
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