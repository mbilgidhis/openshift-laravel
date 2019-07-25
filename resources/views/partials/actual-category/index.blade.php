@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row pb-3">
						<div class="col-md-2 offset-md-10 text-right">
							@can('create_master_data')
							<a href="{{ route('actual-category.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Add Category</a>
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
									<th>Parent</th>
									<th class="text-center"><i class="fal fa-tasks"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach($categories as $category)
								<tr>
									<td>#</td>
									<td>{{ $category->name }}</td>
									<td>{{ $category->parent['name'] }}</td>
									<td class="text-center">
										<a href="{{ route('actual-category.show', $category->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fal fa-edit"></i></a>
										@can('delete_master_data')
										<form action="{{ route('actual-category.delete') }}" method="post" style="display: inline" class="delete">
											@csrf
											@method('delete')
											<input type="hidden" name="id" value="{{ $category->id }}">
											<button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fal fa-trash"></i></button>
										</form>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					{{ $categories->links() }}
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