@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('plan.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('plan.store') }}" method="post" role="form">
						@csrf
						<div class="form-group">
							<label for="title">Plan Name</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Plan Name" required autofocus autocomplete="off">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description"></textarea>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-6">
									<label for="start">Start</label>
									<input type="text" name="start" id="start" class="form-control" placeholder="Start Date" required>
								</div>
								<div class="col-md-6">
									<label for="end">End</label>
									<input type="text" name="end" id="end" class="form-control" placeholder="End Date" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="project">Project</label>
							<select name="project" id="project" class="form-control select2">
								<option></option>
								@foreach($projects as $project)
									<option value="{{ $project->id }}">{{ $project->name . ' | ' . $project->project_code }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="category">Category</label>
							<select name="category" id="category" class="form-control" required>
								<option></option>
								@foreach($categories as $category)
									<option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="subcategory">Sub Category</label>
							<select name="subcategory" id="subcategory" class="form-control" readonly required>
							</select>
						</div>

						@hasanyrole('super admin|admin')
						<div class="form-group">
							<label for="assignee">Assignee</label>
							<select name="assignee" id="assignee" class="form-control select2" required>
								<option></option>
								@foreach($users as $user)
								@if( $user->id != 1 )
								<option value="{{ $user->id }}">{{ $user->name }}</option>
								@endif
								@endforeach
							</select>
						</div>
						@endhasanyrole

						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="important" id="important" data-checkbox="important" class="custom-control-input">
								<label for="important" class="custom-control-label">Important</label>
							</div>
						</div>
						
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
  <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/select2/select2.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/select2/select2.bootstrap4.min.css') }}" rel='stylesheet' />
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
	    $('.select2').select2({
	    	theme: 'bootstrap4',
	    	placeholder: 'Please Select',
	    	allowClear: true,
	    });
	    var picker = new Lightpick({
	        field: document.getElementById('start'),
	        secondField: document.getElementById('end'),
	        singleDate: false,
	        separator: '-',
	        format: 'YYYY-MM-DD',
	        repick: true,
	    });
	    $('#category').change(function(e) {
	    	var id = parseInt($('#category').val());
	    	if( Number.isInteger(id) ) {
	    		$.ajax({
	    			url: '<?php echo url('/')?>/ajax/sub-category/' + id,
	    			method: 'get',
	    			success: function(data) {
	    				$('#subcategory').empty();
	    				$('#subcategory').removeAttr('readonly');
	    				$('#subcategory').append('<option>');
	    				$.each(data, function(i, data) {
	    					$('<option>', {
	    						value: data.id,
	    						text: data.name
	    					}).html(data.name).appendTo('#subcategory');
	    				});
	    			}
	    		});
	    	} else {
	    		$('#subcategory').empty();
	    		$('#subcategory').attr('readonly', true);
	    	}
	    })
    </script>
@endsection