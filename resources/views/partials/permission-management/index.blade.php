@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row pb-3">
						<div class="col-md-2 offset-md-10 text-right">
							<a href="{{ route('permission-management.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Add Permission</a>
						</div>
					</div>
					<div class="table-responsive">
						@include('partials.flash')
						<table class="table table-hover table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Permission Name</th>
									<th><i class="fal fa-tasks"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach($permissions as $permission)
									<tr>
										<td>#</td>
										<td>{{ $permission->name }}</td>
										<td>
											<a href="{{ route('permission-management.show', $permission->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fal fa-edit"></i></a>
											@if( !in_array($permission->id, $default) )
												<form action="{{ route('permission-management.delete') }}" method="post" style="display: inline" class="delete">
													@csrf
													@method('delete')
													<input type="hidden" name="id" value="{{ $permission->id }}">
													<button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fal fa-trash"></i></button>
												</form>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>	
						{{ $permissions->links() }}
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