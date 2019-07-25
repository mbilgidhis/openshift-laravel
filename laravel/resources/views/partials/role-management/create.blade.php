@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('role-management.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('role-management.insert') }}" method="post">
						@csrf
						<div class="form-group">
							<label for="name">Role Name</label>
							<input type="text" name="name" id="name" placeholder="Role Name" class="form-control" required autocomplete="off" autofocus>
						</div>
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection