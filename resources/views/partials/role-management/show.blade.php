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
					<form action="{{ route('role-management.update') }}" method="post">
						@csrf
						<input type="hidden" name="id" value="{{ $role->id }}">
						<div class="form-group">
							<label for="name">Role Name</label>
							<input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Permission</label>
							@foreach($permissions as $permission)
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="permissions_{{ $permission->id }}" data-checkboxes="permissions" class="custom-control-input" id="{{ $permission->name }}" {{ ($permission->name == $role->hasPermissionTo($permission->name)) ? 'checked' : '' }}>
								<label class="custom-control-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
							</div>
							@endforeach
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