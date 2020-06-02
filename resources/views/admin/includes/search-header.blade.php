<div class="kt-portlet__head kt-portlet__head--lg">
	<div class="kt-portlet__head-label">
		<span class="kt-portlet__head-icon"> <i
			class="kt-font-brand {{ config('admin.icons.'.$meta['group'], 'flaticon2-menu-4') }}"></i>
		</span>
		<h3 class="kt-portlet__head-title">
			{{ $meta['title'] }} <small></small>
		</h3>
	</div>
	<div class="kt-portlet__head-toolbar">
		<div class="btn-group">
			<div class="dropdown dropdown-inline">
				<button type="button"
					class="btn btn-default btn-icon-sm dropdown-toggle"
					data-toggle="dropdown" aria-haspopup="true"
					aria-expanded="false">
					<i class="la la-download"></i> Export
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<ul class="kt-nav">
						<li class="kt-nav__section kt-nav__section--first"><span
							class="kt-nav__section-text">Choose an option</span></li>
						<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
								class="kt-nav__link-icon la la-file-excel-o"></i> <span
								class="kt-nav__link-text">Excel</span>
						</a></li>
						<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
								class="kt-nav__link-icon la la-file-text-o"></i> <span
								class="kt-nav__link-text">CSV</span>
						</a></li>
						<li class="kt-nav__item"><a href="#" class="kt-nav__link"> <i
								class="kt-nav__link-icon la la-file-code-o"></i> <span
								class="kt-nav__link-text">XML</span>
						</a></li>
					</ul>
				</div>
			</div>
			@can('create', $meta['classUrlName'])
			<a href="{{ route('admin.'.$meta['group'].'.create', [$meta['classUrlName']]) }}" class="btn btn-brand btn-elevate btn-icon-sm">
				<i class="la la-plus"></i> New Record
			</a>
			@endcan
		</div>
	</div>
</div>
@can('delete', $meta['classUrlName'])
<div class="kt-portlet__body">
	<!--begin: Selected Rows Group Action Form -->
	<div class="kt-form kt-form--label-align-right kt-margin-t-20 collapse" id="kt_datatable_group_action_form">
		<div class="row align-items-center">
			<div class="col-xl-12">
				<form action="{{ route('admin.'.$meta['group'].'.batchDelete', [$meta['classUrlName']]) }}" method="post" name="selected-rows">
					@csrf
					<input type="hidden" name="selected" value="">
					<div class="kt-form__group kt-form__group--inline">
						<div class="kt-form__label kt-form__label-no-wrap">
							<label class="kt-font-bold kt-font-danger-">Selected
								<span id="kt_datatable_selected_number">0</span> records:</label>
						</div>
						<div class="kt-form__control">
							<div class="btn-toolbar">
								<button class="btn btn-brand" type="submit" id="kt_datatable_delete_all">Delete Selected</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end: Selected Rows Group Action Form -->
</div>
@endcan