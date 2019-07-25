@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
			    <div class="card-body">
			    	<div class="row pb-3">
			    		<div class="col-md-3 offset-md-9 text-right">
			    			@can('user_management')
							<a href="{{ route('user-management.import') }}" class="btn btn-sm btn-success"><i class="fal fa-file-upload"></i> Import User</a>
			    			<a href="{{ route('user-management.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Add User</a>
			    			@endcan
			    		</div>
			    	</div>
			    	<div class="table-responsive">
				    	@include('partials.flash')
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Department</th>
									<th>Active</th>
									<th><span class="fal fa-tasks"></span></th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->department['name'] }}</td>
									<td>{{ $user->active }}</td>
									<td>
										<a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Edit User"><span class="fal fa-edit"></span></a>
										@if( $user->id != 1)
										@if( $user->active == 'Yes' )
											<form action="{{ route('user-management.set-status') }}" method="post" style="display: inline;" class="disable">
												@csrf
												<input type="hidden" name="id" value="{{ $user->id }}">
												<input type="hidden" name="status" value="0">
												<button type="submit" class="btn btn-secondary btn-sm" title="Disable User"><i class="fal fa-ban"></i></button>
											</form>
											
										@else
											<form action="{{ route('user-management.set-status') }}" method="post" style="display: inline;" class="enable">
												@csrf
												<input type="hidden" name="id" value="{{ $user->id }}">
												<input type="hidden" name="status" value="1">
												<button type="submit" class="btn btn-success btn-sm" title="Enable User"><i class="fal fa-check"></i></button>
											</form>
										@endif
										<form action="{{ route('user-management.delete') }}" method="post" class="delete" style="display: inline;">
											@csrf
											@method('delete')
											<input type="hidden" name="id" value="{{ $user->id }}">
											<button type="submit" class="btn btn-sm btn-danger" title="Delete User"><span class="fal fa-trash"></span></button>
										</form>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $users->links() }}
					</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('.delete').submit(function() {
	    var c = confirm("Are you sure to delete?");
	    return c; //you can just return c because it will be true or false
	});
	$('.disable').submit(function() {
	    var c = confirm("Are you sure to disable this user?");
	    return c; //you can just return c because it will be true or false
	});
	$('.enable').submit(function() {
	    var c = confirm("Are you sure to enable this user?");
	    return c; //you can just return c because it will be true or false
	});
</script>
@endsection