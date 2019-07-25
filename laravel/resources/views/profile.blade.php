@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					@include('partials.flash')
					<div class="row">
						<div class="col-3">
							<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<a class="nav-link active" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="true">Password</a>
								<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
							</div>
						</div>
						<div class="col-9">
							<div class="tab-content" id="v-pills-tabContent">
								<div class="tab-pane fade show active" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
									<h5>Change Password</h5>
									<form action="{{ route('change-password') }}" method="post" class="changepassword">
										@csrf
										<div class="form-group">
											<label for="current">Current Password</label>
											<input type="password" name="current" id="current" class="form-control" placeholder="Your current password" autofocus required>
										</div>
										<div class="form-group">
											<label for="password">New Password</label>
											<input type="password" name="password" id="password" class="form-control" placeholder="Your new password" required>
										</div>
										<div class="form-group">
											<label for="password_confirmation">Repeat Password</label>
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat your new password" required>
										</div>
										<div class="form-group text-right">
											<button type="submit" class="btn btn-sm btn-primary">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
									<h5>Your Information</h5>
									<form action="{{ route('update-profile') }}" method="post">
										@csrf
										<div class="form-group">
											<label for="phone">Phone</label>
											<input type="text" name="phone" id="phone" class="form-control" placeholder="Your phone number" value="{{ $user->information['phone'] }}">
										</div>
										<div class="form-group">
											<label for="address">Address</label>
											<textarea name="address" id="address" rows="3" class="form-control">{{ $user->information['address'] }}</textarea>
										</div>
										<div class="form-group text-right">
											<button type="submit" class="btn btn-sm btn-primary">Save</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('.changepassword').submit(function() {
	    var c = confirm("Please remember, if you try to change your password, you will be automatically logged out!");
	    return c; //you can just return c because it will be true or false
	});
</script>
@endsection