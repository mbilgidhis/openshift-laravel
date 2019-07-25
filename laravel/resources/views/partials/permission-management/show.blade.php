@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('permission-management.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('permission-management.update') }}" method="post">
						@csrf
						<input type="hidden" name="id" value="{{ $permission->id }}">
						<div class="form-group">
							<label for="name">Permission Name</label>
							<input type="text" name="name" id="name" value="{{ $permission->name }}" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Assign To</label>
							@foreach($roles as $role)
								@if( $role->id != 1)
								<div class="custom-control custom-checkbox">
									<input type="checkbox" name="roles_{{ $role->id }}" data-checkboxes="roles" class="custom-control-input" id="{{ $role->name }}" {{ ($permission->name == $role->hasPermissionTo($permission->name)) ? 'checked' : '' }}>
									<label class="custom-control-label" for="{{ $role->name }}">{{ $role->name }}</label>
								</div>
								@endif
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