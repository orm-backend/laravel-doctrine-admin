@extends('itaces::admin.layout')
@section('itaces::content')
<!-- begin:: Content -->
<script src="/assets/admin/js/itaces/entity-edit.js" type="text/javascript" defer></script>
@include('itaces::admin.includes.delete-modal')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	@include('itaces::admin.includes.alert', ['errors' => $errors])
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">User <small>App\Model\User</small></h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<a href="{{ route('admin.entity.search', 'app-model-user') }}" class="btn btn-clean kt-margin-r-10">
							<i class="la la-arrow-left"></i>
							<span class="kt-hidden-mobile">Back</span>
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-brand submit" data-form="entity-edit">
								<i class="la la-check"></i>
								<span class="kt-hidden-mobile">{{ __('Save') }}</span>
							</button>
						</div>
						<button type="button" class="btn btn-brand goto" data-url="{{ route('admin.entity.details', ['app-model-user', $user->id]) }}">
							<i class="la la-file-o"></i>
							<span class="kt-hidden-mobile">{{ __('View') }}</span>
						</button>
						<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.entity.delete', ['app-model-user', $user->id]) }}">
							<i class="la la-remove"></i>
							<span class="kt-hidden-mobile">{{ __('Delete') }}</span>
						</button>
					</div>
				</div>
				<form class="kt-form" name="entity-edit" method="post" action="{{ route('admin.entity.update', ['app-model-user', $user->id]) }}" autocomplete="off">
    				@csrf
    				<div class="kt-portlet__body">
    					<div class="form-group row">
    						<div class="col-lg-6">
    							<label>Email:</label>
    							<div class="input-group">
        							<div class="input-group-prepend"><span class="input-group-text">@</span></div>
        							<input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email', $user->email) }}">
        							@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    							</div>
    						</div>
    						<div class="col-lg-6">
    							<label>Password:</label>
    							<input name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" autocomplete="off">
    							@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    						</div>
    					</div>
						<div class="form-group row">
    						<div class="col-lg-6">
    							<label>Roles:</label>
    							<div class="input-group">
									<select class="form-control kt-select2 @error('roles') is-invalid @enderror" name="roles[]" multiple="multiple">
										<optgroup label="Roles">
										@foreach ($roles as $role)
											@php ($selected = old('roles') ? array_search($role->getId(), old('roles')) !== false : $user->getRoles()->contains($role))
											<option value="{{ $role->getId() }}" @if ($selected) selected @endif>{{ $role->getName() }}</option>
										@endforeach
										</optgroup>
									</select>
									@error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
								</div>
    						</div>
    						<div class="col-lg-6">
    							<label>Confirm password:</label>
    							<input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" autocomplete="off">
    							@error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
    						</div>
    					</div>
    				</div>
    				<div class="kt-portlet__foot kt-portlet__foot--solid">
    					<div class="kt-form__actions">
    						<div class="row">
    		            		<div class="col-xl-4"></div>
    		            		<div class="col-xl-8">
    								<button type="submit" class="btn btn-brand"><i class="la la-check"></i> {{ __('Save') }}</button>
    								<button type="button" class="btn btn-secondary goto" data-url="{{ route('admin.entity.search', 'app-model-user') }}"><i class="fa fa-undo"></i>{{ __('Cancel') }}</button>
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