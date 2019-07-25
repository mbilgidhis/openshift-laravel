@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('plan-category.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('plan-category.update') }}" method="post" role="form">
						@csrf
						<input type="hidden" name="id" value="{{ $category->id }}">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" value="{{ $category->name }}" class="form-control" placeholder="Category Name" autofocus required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description">{{ $category->description }}</textarea>
						</div>
						@can('edit_master_data')
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