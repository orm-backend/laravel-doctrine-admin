@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Are your sure?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<p>If you continue, the record will be deleted from the database.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Yes, delete</button>
			</div>
		</div>
	</div>
</div>
@php ($entity = $container->first())
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
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">{{ $meta['title'] }} <small>{{ $meta['class'] }}</small></h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<a href="{{ route('admin.entity.search', $meta['classUrlName']) }}" class="btn btn-clean kt-margin-r-10">
							<i class="la la-arrow-left"></i>
							<span class="kt-hidden-mobile">Back</span>
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-brand submit" data-form="entity-edit">
								<i class="la la-check"></i>
								<span class="kt-hidden-mobile">{{ __('Save') }}</span>
							</button>
							<button type="button" class="btn btn-brand goto" data-url="{{ route('admin.entity.details', [$meta['classUrlName'], $entity->id()]) }}">
								<i class="la la-file-o"></i>
								<span class="kt-hidden-mobile">{{ __('View') }}</span>
							</button>
							<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#delete_modal" data-url="{{ route('admin.entity.delete', [$meta['classUrlName'], $entity->id()]) }}">
								<i class="la la-remove"></i>
								<span class="kt-hidden-mobile">{{ __('Delete') }}</span>
							</button>
						</div>
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
										@foreach ($entity->fields() as $field)
										<div class="form-group row">
											<label class="col-3 col-form-label">{{ $field->title }}</label>
											<div class="col-8">
											@switch($field->type)
												@case('text')
												<input class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" type="{{ $field->type }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
												@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('number')
												<div class="input-group bootstrap-touchspin">
													<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
												</div>
												@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('datetime')
												<div class="input-group {{ $field->type }}">
                            						<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
                            						<div class="input-group-append">
                            							<span class="input-group-text">
                            								<i class="la la-calendar-check-o"></i>
                            							</span>
                            						</div>
                            					</div>
                            					@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('date')
												<div class="input-group {{ $field->type }}">
                            						<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
                            						<div class="input-group-append">
                            							<span class="input-group-text">
                            								<i class="la la-calendar-check-o"></i>
                            							</span>
                            						</div>
                            					</div>
                            					@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('time')
												<div class="input-group time">
                            						<div class="input-group-prepend">
                            							<span class="input-group-text">
                            								<i class="la la-clock-o"></i>
                            							</span>
                            						</div>
                            						<input type="text" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" placeholder="00:00:00" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
                            					</div>
                            					@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('textarea')
												<textarea class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" @if ($field->disabled) disabled @endif>{{ oldd($field->fullname, $field->value) }}</textarea>
												@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												@break
												@case('checkbox')
												<span class="kt-switch kt-switch--icon">
            										<label>
            											<input class="@error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" type="checkbox" value="1" @if ($field->disabled) disabled @endif @if (oldd($field->fullname, $field->value)) checked @endif>
            											<span></span>
            											@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
            										</label>
            									</span>
												@break
												@case('radio')
												<div class="form-group">
                            						<div class="kt-radio-inline">
                            							@foreach ($field->options as $value => $option)
                            							<label class="kt-radio">
                            								<input class="@error($field->fullname) is-invalid @enderror" type="radio" name="{{ $field->fullname }}" value="{{ $value }}" @if ($field->disabled) disabled @endif @if (oldd($field->fullname, $field->value) == $value) checked @endif> {{ $option }}
                            								<span></span>
                            							</label>
                            							@endforeach
                            						</div>
                            						@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
                            					</div>
												@break
												@case('reference')
												<div class="input-group">
													<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
													<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
													<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
													@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												</div>
												@break
												@case('collection')
												@case('file_collection')
												@case('image_collection')
												<div class="input-group">
													<select class="form-control" name="{{ $field->fullname }}[]" multiple="multiple" autocomplete="off">
														@foreach ($field->value as $item)
                                                        <option value="{{ $item->id }}" @if ($item->selected) selected @endif>{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-label-brand show-datatable" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname.'[]' }}">
                                                    	<i class="la la-th-list"></i>
                                                    </button>
												</div>
												@break
												@case('image')
												<div class="kt-avatar kt-avatar--outline @if ($field->value) kt-avatar--changed @endif" id="{{ Str::random() }}">
													<div class="kt-avatar__holder" style="background-image: url({{ crop($field->path, 'center', 120, 120) }})"></div>
													<label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change file">
														<i class="fa fa-pen"></i>
														<input type="file" name="{{ $field->fullname }}_file" accept=".png, .jpg, .jpeg">
													</label>
													<span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel file">
														<i class="fa fa-times"></i>
													</span>
												</div>
												<p><span class="form-text text-muted">Allowed file types: png, jpeg.</span></p>
												<span class="form-text text-muted">Or select an existing one:</span>
												<div class="input-group">
													<input type="number" class="form-control @error($field->fullname) is-invalid @enderror" name="{{ $field->fullname }}" value="{{ oldd($field->fullname, $field->value) }}" @if ($field->disabled) disabled @endif>
													<div class="input-group-append"><span class="input-group-text"><a href="{{ $field->value ? route('admin.entity.details', [$field->refClassUrlName, $field->value]) : 'javascript:,' }}" target="_blank">{{ $field->valueName }}</a></span></div>
													<button type="button" class="btn btn-label-brand show-datatable {{ $field->disabled ? 'disabled' : '' }}" data-url="{{ route('admin.datatable.search', $field->refClassUrlName).'?opener='.$field->fullname }}" data-sort="{{ '-'.$field->refClassAlias.'.id' }}" {{ $field->disabled ? 'disabled' : '' }}><i class="la la-th-list"></i></button>
													@error($field->fullname)<div class="invalid-feedback">{{ $message }}</div>@enderror
												</div>
												@break
											@endswitch
											</div>
										</div>
										@endforeach
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