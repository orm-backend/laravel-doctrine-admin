
<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
	<!--[html-partial:include:{"file":"partials/_aside/_brand.html"}]/-->
	@include('ormbackend::admin.partials.aside.brand')
	<!--[html-partial:include:{"file":"partials/_aside/_menu.html"}]/-->
	<x-menu name="admin" template="ormbackend::admin.components.menu" />
</div>

<!-- end:: Aside -->