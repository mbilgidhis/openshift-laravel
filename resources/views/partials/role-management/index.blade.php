@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row pb-3">
						<div class="col-md-2 offset-md-10 text-right">
							<a href="{{ route('role-management.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Add Role</a>
						</div>
					</div>
					<div class="table-responsive">
						@include('partials.flash')
						<table class="table table-hover table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Role Name</th>
									<th><i class="fal fa-tasks"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach($roles as $role)
									<tr>
										<td>#</td>
										<td>{{ $role->name }}</td>
										<td>
											@if( $role->id != 1)
											<a href="{{ route('role-management.show', $role->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fal fa-edit"></i></a>
											@endif
											@if( !in_array($role->id, array(1,2,3,4)) )
												<form action="{{ route('role-management.delete') }}" method="post" style="display: inline" class="delete">
													@csrf
													@method('delete')
													<input type="hidden" name="id" value="{{ $role->id }}">
													<button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fal fa-trash"></i></button>
												</form>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>	
						{{ $roles->links() }}
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
</script>
@endsection