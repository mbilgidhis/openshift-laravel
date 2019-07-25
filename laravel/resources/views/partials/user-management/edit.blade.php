@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('user-management.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('user-management.update') }}" method="post">
						@csrf
						<input type="hidden" value="{{ $user->id }}" name="id">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required autofocus {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required readonly {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
						</div>
						<div class="form-group">
							<label for="department">Department</label>
							<select name="department_id" id="department_id" class="form-control" required {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
								<option>-- Select Department --</option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}" {{ ( $department->id == $user->department_id ) ? 'selected' : '' }}>{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="team">Team</label>
							<select name="team_id" id="team_id" class="form-control" required {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
								<option>-- Select Team --</option>
								@foreach($teams as $team)
								<option value="{{ $team->id }}" {{ ( $team->id == $user->team_id ) ? 'selected' : '' }}>{{ $team->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" {{ ( $user->hasRole('super admin') ) ? 'disabled' : '' }}>
						</div>
						<div class="form-group">
							<label for="password-confirmation">Password Confirmation</label>
							<input type="password" name="password_confirmation" id="password-confirmation" class="form-control" {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
						</div>
						<div class="form-group">
							<label for="role">Role</label>
							<select name="role" id="role" class="form-control" {{ ( $user->id ==1 ) ? 'disabled' : 'required' }}>
								<option></option>
								@foreach( $roles as $role )
								<option value="{{ $role->name }}" {{ ( $role->name == $user->hasRole($role->name) ) ? 'selected' : '' }}>{{ $role->name }}</option>
								@endforeach
							</select>
						</div>
						
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="leader" id="leader" data-checkbox="leader" class="custom-control-input" {{ ($user->is_leader) ? 'checked' : '' }}>
								<label for="leader" class="custom-control-label">Leader</label>
							</div>
						</div>

						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mod_perm" id="mod_perm" data-checkbox="mod_perm" class="custom-control-input">
								<label for="mod_perm" class="custom-control-label">Modify Permissions</label>
							</div>
						</div>
						<div class="form-group" id="perm" style="display: none;">
							<label>Permission</label>
							@foreach($permissions as $permission)
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="permissions_{{ $permission->id }}" data-checkboxes="permissions" class="custom-control-input" id="{{ $permission->name }}" {{ ($permission->name == $user->hasPermissionTo($permission->name)) ? 'checked' : '' }} {{ ( $user->id == 1 ) ? 'disabled' : '' }}>
								<label class="custom-control-label" for="{{ $permission->name }}">{{ $permission->name }}</label>
							</div>
							@endforeach
						</div>
						<div class="form-group text-right pt-2">
							@if( $user->id != 1)
							<button type="submit" class="btn btn-primary btn-sm">Save</button>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('document').ready(function(){
		$('input#mod_perm').change(function(e) {
			var perm = $('input#mod_perm').is(':checked');
			if( perm ) {
				$('#perm').show('slow');
			} else {
				$('#perm').hide('slow');
			}
		});
	});
</script>
@endsection