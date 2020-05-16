<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Metronic') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <!-- Styles -->
    <link href="{{ asset('assets/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/metronic.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/itaces/nested-criteria-builder.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/itaces/itaces.bundle.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="/assets/admin/media/logos/favicon.ico" />
    <!-- begin::Global Config(global config for global JS sciprts) -->
	<script>
		var KTAppOptions = {
			"colors": {
				"state": {
					"brand": "#2c77f4",
					"light": "#ffffff",
					"dark": "#282a3c",
					"primary": "#5867dd",
					"success": "#34bfa3",
					"info": "#36a3f7",
					"warning": "#ffb822",
					"danger": "#db1430"
				},
				"base": {
					"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
					"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
				}
			}
		};
	</script>
	<!-- end::Global Config -->
	<!--begin::Global Theme Bundle(used by all pages) -->
	<script src="{{ asset('assets/admin/plugins/global/plugins.bundle.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('assets/admin/js/metronic.bundle.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('assets/admin/js/itaces/nested-criteria-builder.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('assets/admin/js/itaces/core.datatable.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('assets/admin/js/itaces/core.js') }}" type="text/javascript" defer></script>
    <!--end::Global Theme Bundle -->
</head>
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->
    <!--[html-partial:include:{"file":"partials/_header/base-mobile.html"}]/-->
    @include('itaces::admin.partials.header.base-mobile')
    <div class="kt-grid kt-grid--hor kt-grid--root">
    	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
    		<!--[html-partial:include:{"file":"partials/_aside/base.html"}]/-->
    		@include('itaces::admin.partials.aside.base')
    		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
    			<!--[html-partial:include:{"file":"partials/_header/base.html"}]/-->
    			@include('itaces::admin.partials.header.base')
    			<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    				<!--[html-partial:include:{"file":"partials/_subheader/subheader-v1.html"}]/-->
    				<x-admin-breadcrumbs template="itaces::admin.components.breadcrumbs"/>
    				<!--[html-partial:include:{"file":"partials/_content/base.html"}]/-->
    				@yield('itaces::content')
    			</div>
    			<!--[html-partial:include:{"file":"partials/_footer/base.html"}]/-->
    			@include('itaces::admin.partials.footer.base')
    		</div>
    	</div>
    </div>
    <!-- end:: Page -->
    <!--[html-partial:include:{"file":"partials/_scrolltop.html"}]/-->
    @include('itaces::admin.partials.scrolltop')
    <!--[html-partial:include:{"file":"partials/_toolbar.html"}]/-->
    
    <!--[html-partial:include:{"file":"partials/_demo-panel.html"}]/-->
    
    <!--[html-partial:include:{"file":"partials/_chat.html"}]/-->
</body>
</html>
