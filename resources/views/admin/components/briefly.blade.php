<div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
	<div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				Briefly
			</h3>
		</div>
	</div>
	<div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-widget17">
        	<div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #db1430">
        		<div class="kt-widget17__chart" style="height:320px;">
        			<canvas id="kt_chart_activities"></canvas>
        		</div>
        	</div>
        	<div class="kt-widget17__stats">
        		<div class="kt-widget17__items">
        			<div class="kt-widget17__item">
        				<span class="kt-widget17__icon">
        					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
        						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        							<rect x="0" y="0" width="24" height="24" />
        							<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
        							<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
        						</g>
        					</svg>
        				</span>
        				<span class="kt-widget17__subtitle">
        					Entities
        				</span>
        				<span class="kt-widget17__desc">
        					{{ $entities }} total
        				</span>
        			</div>
        			<div class="kt-widget17__item">
        				<span class="kt-widget17__icon">
        					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
        						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        							<rect x="0" y="0" width="24" height="24" />
        							<path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
        							<rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
        						</g>
        					</svg>
        				</span>
        				<span class="kt-widget17__subtitle">
        					Entities
        				</span>
        				<span class="kt-widget17__desc">
        					{{ $controlled }} under admin control
        				</span>
        			</div>
        		</div>
        		<div class="kt-widget17__items">
        			<div class="kt-widget17__item">
        				<span class="kt-widget17__icon">
        					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
        						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
        					</svg>
        				</span>
        				<span class="kt-widget17__subtitle">
        					Users
        				</span>
        				<span class="kt-widget17__desc">
        					{{ $registered }} registered
        				</span>
        			</div>
        			<div class="kt-widget17__item">
        				<span class="kt-widget17__icon">
        					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
        						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
        					</svg>
        				</span>
        				<span class="kt-widget17__subtitle">
        					Users
        				</span>
        				<span class="kt-widget17__desc">
        					{{ $confirmed }} confirmed
        				</span>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
</div>