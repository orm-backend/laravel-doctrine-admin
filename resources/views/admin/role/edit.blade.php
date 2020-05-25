@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
@include('itaces::admin.includes.delete-modal')
@php ($entity = $container->first())
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include('itaces::admin.includes.alert', ['errors' => $errors])
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				@include('itaces::admin.includes.edit-header', ['meta' => $meta, 'entity' => $entity])
				<form class="kt-form" name="entity-edit" method="post" action="{{ $formAction }}" enctype="multipart/form-data">
    				@csrf
    				<div class="kt-portlet__body">
						<div class="row">
							<div class="col-xl-2"></div>
							<div class="col-xl-8">
								<div class="kt-section">
									<div class="kt-section__body">
										@php ($id = $entity->field('id'))
										@php ($permission = $entity->field('permission'))
										@include('itaces::admin.fields.id', ['field' => $id])
										@php ($old = old($entity->classUrlName))
										@if ($entity->field('code')->value == config('itaces.roles.guest', 'guest'))
											@include('itaces::admin.fields.guest-permission', ['field' => $permission, 'old' => $old, 'message' => $message ?? null])
										@elseif ($entity->field('code')->value != config('itaces.roles.dashboard', 'dashboard'))
											@include('itaces::admin.fields.group-permission', ['field' => $permission, 'old' => $old, 'message' => $message ?? null])
											@if ($entity->field('code')->value != config('itaces.roles.administrator', 'admin'))
											<div class="form-group row">
                                            	<label class="col-3 col-form-label">{{ __('Access is blocked to any data, other permissions are ignored') }}</label>
                                            	<div class="col-8">
                                            		@php ($value = $old[$permission->name] ?? $permission->value)
                                            		<input type="checkbox" name="permissions[]" value="{{ config('itaces.perms.forbidden') }}"
                                            			@if ($value & config('itaces.perms.forbidden')) checked @endif
                                            			data-switch="true" data-on-text="forbidden" data-handle-width="70" data-off-text="forbidden" data-on-color="danger">
                                            	</div>
                                            </div>
                                            @endif
										@endif
										@error($permission->fullname)
											<div class="form-group row">
												<div class="col-3"></div>
												<div class="col-8">
													<div class="invalid-feedback">{{ $message }}</div>
												</div>
											</div>
										@enderror
										@include('itaces::admin.includes.fields', ['fields' => $entity->fields(), 'old' => $old, 'message' => $message ?? null, 'exclude' => [$id->fullname, $permission->fullname]])
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