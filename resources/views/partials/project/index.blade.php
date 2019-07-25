@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row pb-3">
						<div class="col-md-2 offset-md-10 text-right">
							@can('create_department')
							<a href="{{ route('project.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Add Project</a>
							@endcan
						</div>
					</div>
					<div class="table-responsive">
						@include('partials.flash')
						<table class="table table-hover table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Project Name</th>
									<th>Project Code</th>
									<th class="text-center"><i class="fal fa-tasks"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach($projects as $project)
								<tr>
									<td>#</td>
									<td>{{ $project->name }}</td>
									<td>{{ $project->project_code }}</td>
									<td class="text-center">
										<a href="{{ route('project.show', $project->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fal fa-edit"></i></a>
										@can('delete_project')
										<form action="{{ route('project.delete') }}" method="post" role="form" style="display: inline" class="delete">
											@csrf
											@method('delete')
											<input type="hidden" value="{{ $project->id }}" name="id">
											<button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fal fa-trash"></i></button>
										</form>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					{{ $projects->links() }}
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