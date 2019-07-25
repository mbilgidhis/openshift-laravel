@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('department.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('department.update') }}" method="post" role="form">
						@csrf
						<input type="hidden" name="id" value="{{ $department->id }}">
						<div class="form-group">
							<label for="name">Department Name</label>
							<input type="text" name="name" id="name" class="form-control" value="{{ $department->name }}" required autofocus autocomplete="on">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description">{{ $department->description }}</textarea>
						</div>
						@can('edit_department')
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary">Update</button>
						</div>
						@endcan
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

