@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include('itaces::admin.includes.alert', ['errors' => $errors])
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				@include('itaces::admin.includes.settings-header', ['meta' => $meta])
				<ul class="nav nav-pills nav-fill" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="javascript:;" data-target="#permission_tab">{{ __('Permissions') }}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="javascript:;" data-target="#developed_tab">{{ __('In developing') }}</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="permission_tab" role="tabpanel">
        				<form class="kt-form" name="entity-edit" method="post" action="{{ $formAction }}" enctype="multipart/form-data">
            				@csrf
            				<div class="kt-portlet__body">
        						<div class="row">
        							<div class="col-xl-2"></div>
        							<div class="col-xl-8">
        								<div class="kt-section">
        									<div class="kt-section__body">
        										<div class="accordion accordion-toggle-arrow" id="accordionGroup">
        											@foreach ($container->entities() as $entity)
        											@php ($old = old($entity->classUrlName))
        											@php ($old = $old[$loop->index] ?? null)
            										@php ($permission = $entity->field('permission'))
        											<div class="card">
        												<div class="card-header" id="heading{{ $loop->index }}">
        													<div class="card-title collapsed" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" @error($permission->fullname) aria-expanded="true" @enderror aria-controls="collapse{{ $loop->index }}">
        														<i class="flaticon2-layers-1"></i>
        														{{ $entity->field('role')->valueName }}
        													</div>
        												</div>
        												<div id="collapse{{ $loop->index }}" class="collapse @error($permission->fullname) show @enderror" aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionGroup">
        													<div class="card-body">
        														@if ($entity->id())
        														<div class="alert alert-light alert-elevate fade show" role="alert">
            														<div class="alert-icon"><i class="flaticon-warning"></i></div>
            														<div class="alert-text">{{ $entity->field('role')->valueName }} {{ __('permissions to access this entity are overridden by these settings') }}.</div>
            														<div class="alert-close">
            															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            																<span aria-hidden="true"><i class="la la-close"></i></span>
            															</button>
            														</div>
            													</div>
            													@endif
        														<input type="hidden" name="{{ $entity->field('id')->fullname }}" value="{{ $entity->field('id')->value }}">
        														<input type="hidden" name="{{ $entity->field('model')->fullname }}" value="{{ $entity->field('model')->value }}">
        														<input type="hidden" name="{{ $entity->field('role')->fullname }}" value="{{ $entity->field('role')->value }}">
                                                            	@if ($entity->field('role')->value == $guestId)
                        											@include('itaces::admin.fields.guest-permission', [
                        												'field' => $permission,
                        												'old' => $old,
                        												'message' => $message ?? null,
                        												'group' => $entity->field('role')->value
                        											])
                        										@else
                        											@include('itaces::admin.fields.group-permission', [
                        												'field' => $permission,
                        												'old' => $old,
                        												'message' => $message ?? null,
                        												'group' => $entity->field('role')->value
                        											])
                        										@endif
                    											<div class="form-group row">
                    												<div class="col-3"></div>
                    												<div class="col-8">
                    													<div class="input-group">
                                                                        	<input type="hidden" class="@error($permission->fullname) is-invalid @enderror" disabled>
                                                                        	@error($permission->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                                        </div>
                    												</div>
                    											</div>
                    											@if ($entity->id())
                    											<div class="form-group row">
                                                                	<label class="col-3 col-form-label">{{ __('Reset to defaults') }}</label>
                                                                	<div class="col-8">
                                                                		<input type="checkbox" name="reset[]" value="{{ $entity->field('id')->value }}" @if (in_array($entity->field('id')->value, old('reset', []))) checked @endif
                                                                			data-switch="true" data-on-text="reset" data-handle-width="70" data-off-text="reset" data-on-color="danger">
                                                                	</div>
                                                                </div>
                                                                @endif
        													</div>
        												</div>
        											</div>
        											@endforeach
        										</div>
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
    				<div class="tab-pane active" id="developed_tab" role="tabpanel">
    					<div class="row">
    						<div class="col-xl-2"></div>
    						<div class="col-xl-8">
    							<div class="kt-section">
    								<div class="kt-section__body"></div>
    							</div>
    						</div>
    						<div class="col-xl-2"></div>
    					</div>
    				</div>
    			</div>
			</div>
			<!--end::Portlet-->
		</div>
	</div>
</div>
<!-- end:: Content -->
@endsection