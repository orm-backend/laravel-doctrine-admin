@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@if ($errors->any())
	<div class="row">
		<div class="col">
			<div class="alert alert-warning fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="la la-close"></i></span>
                    </button>
                </div>
            </div>
		</div>
	</div>
	@endif
	@php ($entity = $container->first())
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">{{ $meta['title'] }} <small>{{ $meta['class'] }}</small></h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<a href="{{ route('admin.entity.search', 'app-model-image') }}" class="btn btn-clean kt-margin-r-10">
							<i class="la la-arrow-left"></i>
							<span class="kt-hidden-mobile">Back</span>
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-brand submit" data-form="entity-edit">
								<i class="la la-check"></i>
								<span class="kt-hidden-mobile">{{ __('Save') }}</span>
							</button>
						</div>
						<button type="button" class="btn btn-brand goto" data-url="{{ route('admin.entity.details', ['app-model-image', $entity->id()]) }}">
							<i class="la la-file-o"></i>
							<span class="kt-hidden-mobile">{{ __('View') }}</span>
						</button>
						<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.entity.delete', ['app-model-image', $entity->id()]) }}">
							<i class="la la-remove"></i>
							<span class="kt-hidden-mobile">{{ __('Delete') }}</span>
						</button>
					</div>
				</div>
				<form class="kt-form" name="entity-edit" method="post" action="{{ $formAction }}" enctype="multipart/form-data">
					@csrf
					<div class="kt-portlet__body">
    					<div class="row">
    						<div class="col-xl-2"></div>
    						<div class="col-xl-8">
    							<div class="kt-section">
									<div class="kt-section__body">
										@php ($field = $entity->field('id'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<div class="input-group bootstrap-touchspin">
													<input type="text" class="form-control" name="{{ $field->fullname }}" value="{{ $field->value }}" disabled>
												</div>
											</div>
										</div>
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
										@php ($field = $entity->field('path'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" disabled>
                                				@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('name'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}">
                                				@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('urlRoute'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}">
                                				@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('description'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<textarea class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}">{{ oldd($field->fullname, $field->value) }}</textarea>
                                				@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('altText'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<textarea class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}">{{ oldd($field->fullname, $field->value) }}</textarea>
                                				@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('photoCredit'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
												<textarea class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}">{{ oldd($field->fullname, $field->value) }}</textarea>
												@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
											</div>
										</div>
										@php ($field = $entity->field('createdAt'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
    											<div class="input-group datetime">
                            						<input type="text" class="form-control" name="{{ $field->fullname }}" value="{{ $field->value }}" disabled>
                            						<div class="input-group-append">
                            							<span class="input-group-text">
                            								<i class="la la-calendar-check-o"></i>
                            							</span>
                            						</div>
                            					</div>
                            				</div>
                    					</div>
                    					@php ($field = $entity->field('updatedAt'))
                    					<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
    											<div class="input-group datetime">
                            						<input type="text" class="form-control" name="{{ $field->fullname }}" value="{{ $field->value }}" disabled>
                            						<div class="input-group-append">
                            							<span class="input-group-text">
                            								<i class="la la-calendar-check-o"></i>
                            							</span>
                            						</div>
                            					</div>
                        					</div>
                    					</div>
                    					@php ($field = $entity->field('deletedAt'))
                    					<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
    											<div class="input-group datetime">
                            						<input type="text" class="form-control" name="{{ $field->fullname }}" value="{{ $field->value }}" disabled>
                            						<div class="input-group-append">
                            							<span class="input-group-text">
                            								<i class="la la-calendar-check-o"></i>
                            							</span>
                            						</div>
                            					</div>
                        					</div>
                    					</div>
                    					@php ($field = $entity->field('createdBy'))
                    					<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
                            					<div class="input-group">
        											<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
        											<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
        											<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
        											@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
        										</div>
        									</div>
        								</div>
										@php ($field = $entity->field('updatedBy'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
                            					<div class="input-group">
        											<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
        											<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
        											<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
        											@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
        										</div>
        									</div>
        								</div>
										@php ($field = $entity->field('deletedBy'))
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
                            					<div class="input-group">
        											<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
        											<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
        											<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
        											@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
        										</div>
        									</div>
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
    								<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.entity.search', 'app-model-image') }}"><i class="fa fa-undo"></i>{{ __('Cancel') }}</button>
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