@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('actual-category.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('actual-category.store') }}" method="post" role="form">
						@csrf
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name"  class="form-control" placeholder="Category Name" autofocus required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<label for="parent">Parent</label>
							<select name="parent" id="parent" class="form-control">
								<option></option>
								@foreach($categories as $category)
								<option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
								@endforeach
							</select>
						</div>
						@can('create_master_data')
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary">Save</button>
						</div>
						@endcan
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection