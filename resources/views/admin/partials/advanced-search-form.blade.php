<!-- begin:: Advanced Search Form -->
<script src="/assets/admin/js/itaces/advanced-search-form.js" type="text/javascript" defer></script>
<div class="kt-portlet kt-portlet--mobile advanced-search-portlet">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				Search <small>{{ $meta['class'] }}</small>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar advanced-search-pane-head">
			<ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold kt-margin-r-10" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#search-tab_1" role="tab">
						Default
					</a>
				</li>
			</ul>
			<div class="kt-portlet__head-actions">
				<div class="dropdown dropdown-inline">
					<a href="#" class="btn btn-default btn-pill btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="la la-plus"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                        <!--begin::Form-->
                    	<form class="kt-form" name="store-filters-locally">
                            <ul class="kt-nav">
                            	<li class="kt-nav__head">
                                    Store or update filter
                                    <span data-toggle="kt-tooltip" data-placement="right" title="" data-original-title="A set of filters can be stored locally for future use.">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand kt-svg-icon--md1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect>
                                                <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect>
                                            </g>
                                        </svg>
    								</span>
                               </li>
                               <li class="kt-nav__separator"></li>
                               <li class="kt-section kt-margin-r-20 kt-margin-l-20">
            						<div class="form-group">
            							<label>Name:</label>
            							<input name="name" type="text" class="form-control" placeholder="Enter tab title" required="required">
            							<span class="form-text text-muted">Please enter a name that will appear as a tab title at the top of the form.
            							To update the filter, enter the same name under which it was saved.</span>
            						</div>
                            	</li>
                            	<li class="kt-nav__separator"></li>
                                <li class="kt-nav__foot">
                                    <button type="submit" class="btn btn-label-brand btn-bold btn-sm">
                                    	<i class="la la-check"></i> Save
                                    </button>
                                </li>
                    		</ul>
                		</form>
                        <!--end::Form-->
					</div>
				</div>
				<div class="dropdown dropdown-inline">
					<a href="#" class="btn btn-default btn-pill btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="flaticon2-soft-icons"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                        <!--begin::Form-->
                    	<form class="kt-form" name="list-local-filters">
                            <ul class="kt-nav">
                            	<li class="kt-nav__head">
                                    Stored filters
                               </li>
                               <li class="kt-nav__separator"></li>
                               <li>
                					<div class="kt-section kt-margin-r-20 kt-margin-l-20">
                						<div class="form-group">
                							<label class="form-text text-muted">If locally saved filters exist, they are displayed here and can be deleted.</label>
                							<div class="kt-checkbox-list"></div>
            							</div>
                					</div>
                            	</li>
                            	<li class="kt-nav__separator"></li>
                                <li class="kt-nav__foot">
                                    <button type="submit" class="btn btn-label-danger btn-bold btn-sm">
                                    	<i class="la la-remove"></i> Remove
                                    </button>
                                </li>
                    		</ul>
                		</form>
                        <!--end::Form-->
					</div>
				</div>
				<?php if ($_GET) :?>
				<div class="dropdown dropdown-inline">
					<a href="#" class="btn btn-default btn-pill btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="la la-save"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-md">
                        <!--begin::Form-->
                    	<form class="kt-form" name="add-menu-item">
                            <ul class="kt-nav">
                            	<li class="kt-nav__head">
                                    Add search results to menu
                                    <span data-toggle="kt-tooltip" data-placement="right" title="" data-original-title="The link to search results can be stored locally and will display as menu item.">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand kt-svg-icon--md1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"></circle>
                                                <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"></rect>
                                                <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"></rect>
                                            </g>
                                        </svg>
    								</span>
                               </li>
                               <li class="kt-nav__separator"></li>
                               <li class="kt-section kt-margin-r-20 kt-margin-l-20">
            						<div class="form-group">
            							<label>Name:</label>
            							<input name="name" type="text" class="form-control" placeholder="Enter link title" required="required">
            							<span class="form-text text-muted">Please enter the link title that appears at menu.</span>
            						</div>
                            	</li>
                            	<li class="kt-nav__separator"></li>
                                <li class="kt-nav__foot">
                                    <button type="submit" class="btn btn-label-brand btn-bold btn-sm">
                                    	<i class="la la-check"></i> Save
                                    </button>
                                </li>
                    		</ul>
                		</form>
                        <!--end::Form-->
					</div>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" name="advanced-search-form" data-class-url-name="{{ $meta['classUrlName'] }}">
    		<div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="search-tab_1">
                	<div id="query-builder_1" style="display: block;"></div>
                </div>
                <div class="kt-form__actions kt-margin-t-10">
        			<div class="row">
                		<div class="col">
        					<button type="submit" class="btn btn-brand float-right"><i class="la la-search"></i> {{ __('Search') }}</button>
                		</div>
                	</div>
        		</div>
    		</div>
    	</form>
	</div>
</div>
<!-- end:: Advanced Search Form -->