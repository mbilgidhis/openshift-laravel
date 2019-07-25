@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('team.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('team.update') }}" method="post">
						@csrf
						<input type="hidden" name="id" value="{{ $team->id }}">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Team Name" value="{{ $team->name }}" required autocomplete="off" autofocus>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control">{{ $team->description }}</textarea>
						</div>
						<div class="form-group">
							<label for="department_id">Department</label>
							<select name="department_id" id="department_id" class="form-control">
								<option></option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ ($department->id == $team->department_id) ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
						@can('edit_department')
						<div class="form-group text-right">
							<button type="submit" class="btn btn-primary btn-sm">Update</button>
						</div>
						@endcan
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection