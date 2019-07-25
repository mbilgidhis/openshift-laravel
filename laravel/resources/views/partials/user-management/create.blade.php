@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('user-management.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('user-management.insert') }}" method="post">
						@csrf
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Name" required autocomplete="off" autofocus>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
						</div>
						<div class="form-group">
							<label for="department">Department</label>
							<select name="department_id" id="department_id" class="form-control">
								<option></option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}">{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="department">Team</label>
							<select name="team_id" id="team_id" class="form-control">
								<option></option>
								@foreach($teams as $team)
								<option value="{{ $team->id }}">{{ $team->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="leader" id="leader" data-checkbox="leader" class="custom-control-input">
								<label for="leader" class="custom-control-label">Leader</label>
							</div>
						</div>
						<div class="form-group">
							<label for="role">Role</label>
							<select name="role" id="role" class="form-control">
								<option></option>
								@foreach($roles as $role)
								<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endforeach
							</select>
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
@endsection