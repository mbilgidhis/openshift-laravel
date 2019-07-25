@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('project.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('project.update') }}" method="post" role="form">
						@csrf
						<input type="hidden" name="id" value="{{ $project->id }}">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" value="{{ $project->name }}" placeholder="Project Name" required autofocus autocomplete="off">
						</div>
						<div class="form-group">
							<label for="code">Project Code</label>
							<input type="text" name="code" id="code" class="form-control" value="{{ $project->project_code }}" placeholder="Project Code">
						</div>
						<div class="form-group">
							<label for="pmsales">PM/Sales</label>
							<input type="text" name="pmsales" id="pmsales" class="form-control" value="{{ $project->pm_sales }}" placeholder="PM/Sales" >
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description">{{ $project->description }}</textarea>
						</div>
						@can('edit_project')
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