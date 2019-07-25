@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="row pb-3">
					    <div class="col-md-2 offset-md-10 text-right">
					        <a href="{{ route('setting.holiday.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Create Holiday</a>
					    </div>
					</div>
				    <div class="table-responsive">
				    	@include('partials.flash')
				    	<table class="table table-hover table-stripped">
				    		<thead>
				    			<tr>
				    				<th>#</th>
				    				<th>Date</th>
				    				<th>Name</th>
				    				<th><i class="fal fa-tasks"></i></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			@foreach( $holidays as $holiday )
								<tr>
									<td>#</td>
									<td>{{ $holiday->start->format('d M Y') }}</td>
									<td>{{ $holiday->name }}</td>
									<td>
										<a href="{{ route('setting.holiday.show', $holiday->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fal fa-edit"></i></a>
										@can('delete_project')
										<form action="{{ route('setting.holiday.delete') }}" method="post" role="form" style="display: inline" class="delete">
											@csrf
											@method('delete')
											<input type="hidden" value="{{ $holiday->id }}" name="id">
											<button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fal fa-trash"></i></button>
										</form>
										@endcan
									</td>
								</tr>
				    			@endforeach
				    		</tbody>
				    	</table>
				    	{{ $holidays->links() }}
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