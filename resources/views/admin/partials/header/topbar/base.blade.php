
<!-- begin:: Header Topbar -->
<div class="kt-header__topbar">
	<!--[html-partial:include:{"file":"partials/_header/topbar/_search.html"}]/-->
	{{-- @include('itaces::admin.partials.header.topbar.search') --}}
	<!--[html-partial:include:{"file":"partials/_header/topbar/_my-cart.html"}]/-->

	<!--[html-partial:include:{"file":"partials/_header/topbar/_languages.html"}]/-->
	@include('itaces::admin.partials.header.topbar.languages')
	<!--[html-partial:include:{"file":"partials/_header/topbar/_user.html"}]/-->
	@include('itaces::admin.partials.header.topbar.user')
</div>

<!-- end:: Header Topbar -->