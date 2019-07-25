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
					<h5>Import User</h5>
					<p class="text-muted">If you need file example you can download <a href="{{ route('user-management.download') }}">here</a></p>
					<form action="{{ route('user-management.process') }}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<div class="custom-file">
								<label for="file" class="custom-file-label form-control">File to import</label>
								<input type="file" name="file" id="file" class="custom-file-input" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
							</div>
						</div>
						<div class="form-group">
							<label for="password">Default Password</label>
							<input type="text" name="password" id="password" class="form-control" placeholder="Default passsword for all imported user" required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="department">Department</label>
							<select name="department" id="department" class="form-control">
								<option></option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}">{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="team">Team</label>
							<select name="team" id="team" class="form-control">
								<option></option>
								@foreach($teams as $team)
								<option value="{{ $team->id }}">{{ $team->name }}</option>
								@endforeach
							</select>
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
							<button type="submit" class="btn btn-sm btn-primary">Import</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection