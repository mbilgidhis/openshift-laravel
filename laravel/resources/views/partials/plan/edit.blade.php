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
					
					<h5 class="pb-3">{{ $plan->title }}</h5>
					@include('partials.flash')
					<form action="{{ route('plan.update') }}" role="form" method="post">
						@csrf
						<input type="hidden" name="id" value="{{ $plan->id }}">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" class="form-control" value="{{ $plan->title }}" {{ $disabled }} required autofocus autocomplete="off">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" rows="2" class="form-control" {{ $disabled }}>{{ $plan->description }}</textarea>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-6">
									<label for="start">Start</label>
									<input type="text" name="start" id="start" class="form-control" value="{{ $plan->start }}" {{ $disabled }} required>
								</div>
								<div class="col-md-6">
									<label for="end">End</label>
									<input type="text" name="end" id="end" class="form-control" value="{{ $plan->end }}" {{ $disabled }} required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="project">Project</label>
							<select name="project" id="project" class="form-control select2" {{ $disabled }}>
								<option></option>
								@foreach($projects as $project)
									<option value="{{ $project->id }}" <?=($project->id == $plan->project_id) ? 'selected' : '';?>>{{ $project->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="category">Category</label>
							<select name="category" id="category" class="form-control" {{ $disabled }} required>
								<option></option>
								@foreach($categories as $category)
									<option value="{{ $category->id }}" <?=($category->id == $plan->plan_category_id) ? 'selected' : '';?>>{{ $category->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="subcategory">Sub Category</label>
							<select name="subcategory" id="subcategory" class="form-control" {{ $disabled }} required>
								<option></option>
								@foreach( $subs as $sub )
								<option value="{{ $sub->id }}" {{ ($sub->id == $plan->plan_sub_category_id) ? 'selected' : '' }}>{{ $sub->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="status">Status</label>
							<select name="status" id="status" class="form-control" {{ $disabled }} required>
								<option></option>
								<option value="Ongoing" <?=($plan->status == 'Ongoing') ? 'selected' : '';?>>Ongoing</option>
								<option value="Completed" <?=($plan->status == 'Completed') ? 'selected' : '';?>>Completed</option>
								<option value="Failed" <?=($plan->status == 'Failed') ? 'selected' : '';?>>Failed</option>
								<option value="Pending" <?=($plan->status == 'Pending') ? 'selected' : '';?>>Pending</option>
							</select>
						</div>
						@hasanyrole('super admin|admin')
						<div class="form-group">
							<label for="assignee">Assignee</label>
							<select name="assignee" id="assignee" class="form-control" disabled>
								<option></option>
								@foreach($users as $user)
								<option value="{{ $user->id }}" <?=($plan->user_id == $user->id) ? 'selected' : '';?>>{{ $user->name }}</option>
								@endforeach
							</select>
						</div>
						@endhasanyrole

						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="important" id="important" data-checkbox="important" class="custom-control-input" {{ ($plan->important) ? 'checked' : '' }}>
								<label for="important" class="custom-control-label">Important</label>
							</div>
						</div>

						@can('edit_plan')
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary" {{ $disabled }}>Update</button>
						</div>
						@endcan
					</form>
					
					<div class="row pb-2 pt-5">
						<div class="col-md-9">
							<h5>Actual</h5>
						</div>
						@can('create_actual')
						<div class="col-md-3 text-right">
							@if( $disabled !=='disabled' )
							<a href="{{ route('actual.create', $plan->id) }}" class="btn btn-sm btn-success fancybox"><span class="fal fa-plus"></span> Add Actual</a>
							@endif
						</div>
						@endcan
					</div>
					
					<div class="table-responsive">
						<table class="table table-hover-table-striped">
							<thead>
								<th>#</th>
								<th>Title</th>
								<th>Category</th>
								<th>Actual Date</th>
								<th class="text-center"><span class="fal fa-tasks"></span></th>
							</thead>
							<tbody>
								@foreach($plan->actuals as $actual)
								<tr>
									<td>#</td>
									<td>{{ $actual->title }}</td>
									<td>{{ $actual->category['name'] }}</td>
									<td>{{ date('d M Y', strtotime($actual->actual_date_start) ) }}</td>
									<td class="text-center">
										@if( $disabled !== 'disabled')
										<a href="{{ route('actual.show', [$plan->id, $actual->id]) }}" class="btn btn-sm btn-warning fancybox" title="Edit"><span class="fal fa-edit"></span></a>
										@can('delete_actual')
										<form action="{{ route('actual.delete') }}" method="post" class="delete" style="display: inline">
											@csrf
											@method('delete')
											<input type="hidden" name="id" value="{{ $actual->id }}">
											<input type="hidden" name="plan" value="{{ $plan->id }}">
											<button type="submit" class="btn btn-sm btn-danger" title="Delete"><span class="fal fa-trash"></span></button>
										</form>
										@endcan
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
  <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/fancybox/jquery.fancybox.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/fancybox/helpers/jquery.fancybox-buttons.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/fancybox/helpers/jquery.fancybox-thumbs.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/select2/select2.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/select2/select2.bootstrap4.min.css') }}" rel='stylesheet' />
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/lib/jquery.mousewheel.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/fancybox/helpers/jquery.fancybox-thumbs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
	    $('.fancybox').fancybox({
	    	type: 'ajax',
	    	autoSize: true,
	    	// minWidth: 800,
	    });
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
	    $('.delete').submit(function() {
	        var c = confirm("Are you sure to delete?");
	        return c; //you can just return c because it will be true or false
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