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
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">New Image <small>App\Model\Image</small></h3>
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
					</div>
				</div>
				<form class="kt-form" name="entity-edit" method="post" action="{{ route('admin.entity.store', 'app-model-image') }}" enctype="multipart/form-data">
					@csrf
					<div class="kt-portlet__body">
    					<div class="form-group row">
    						<div class="col-lg-6">
                                <div class="kt-avatar kt-avatar--outline" id="{{ Str::random() }}">
									<div class="kt-avatar__holder"></div>
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
							<div class="col-lg-6">
                                <label>{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                        	<div class="col-lg-6">
                                <label>{{ __('URL Route') }}</label>
                                <input type="text" class="form-control @error('urlRoute') is-invalid @enderror" name="urlRoute" value="{{ old('urlRoute') }}">
                                @error('urlRoute')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
							<div class="col-lg-6">
                                <label>{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                        	<div class="col-lg-6">
                                <label>{{ __('Alt Text') }}</label>
                                <textarea class="form-control @error('altText') is-invalid @enderror" name="altText">{{ old('altText') }}</textarea>
                                @error('altText')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
							<div class="col-lg-6">
                                <label>{{ __('Photo Credit') }}</label>
                                <textarea class="form-control @error('photoCredit') is-invalid @enderror" name="photoCredit">{{ old('photoCredit') }}</textarea>
                                @error('photoCredit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                             </div>
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