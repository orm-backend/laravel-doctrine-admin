<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
	@if (Route::has('profile.edit'))
	<li class="kt-nav__item">
		<a href="{{ route('profile.edit') }}" class="kt-nav__link">
			<span class="kt-nav__link-icon">
				<i class="fa fa-user-edit"></i>
			</span>
			<span class="kt-nav__link-text">{{ __('Your Profile') }}</span>
		</a>
	</li>
    @endif
    @if (Route::has('password.edit'))
    <li class="kt-nav__item">
		<a href="{{ route('password.edit') }}" class="kt-nav__link">
			<span class="kt-nav__link-icon">
				<i class="fa fa-user-shield"></i>
			</span>
			<span class="kt-nav__link-text">{{ __('Change Password') }}</span>
		</a>
	</li>
	@endif
	@if (Route::has('email.edit'))
	<li class="kt-nav__item">
		<a href="{{ route('email.edit') }}" class="kt-nav__link">
			<span class="kt-nav__link-icon">
				<i class="fa fa-user-cog"></i>
			</span>
			<span class="kt-nav__link-text">{{ __('Change Email') }}</span>
		</a>
	</li>
	@endif
	<li class="kt-nav__item">
		<a href="{{ route('logout') }}" class="kt-nav__link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
			<span class="kt-nav__link-icon">
				<i class="fa fa-power-off"></i>
			</span>
			<span class="kt-nav__link-text">{{ __('Logout') }}</span>
		</a>
	</li>

</ul>
