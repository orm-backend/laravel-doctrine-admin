@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Change Password') }}</div>
				<div class="card-body">
					<form method="POST" action="{{ route('password.edit') }}">
						@csrf
						@foreach ($errors->all() as $error)
						<p class="text-danger">{{ $error }}</p>
						@endforeach

						<div class="form-group row">
							<label for="old_password"
								class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

							<div class="col-md-6">
								<input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror"
									name="old_password" autocomplete="old-password">
							</div>
						</div>

						<div class="form-group row">
							<label for="password"
								class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
									name="password" autocomplete="new-password">
							</div>
						</div>

						<div class="form-group row">
							<label for="password_confirmation"
								class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

							<div class="col-md-6">
								<input id="password_confirmation" type="password"
									class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
									autocomplete="new-password">
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
