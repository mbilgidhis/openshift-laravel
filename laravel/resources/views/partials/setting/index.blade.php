@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					@include('partials.flash')
					<form action="{{ route('setting.update') }}" method="post">
						@csrf
						<div class="form-group">
							<label for="important">Color Important</label>
							<div class="input-group colorpick">
								<input type="text" name="important" id="important" class="form-control" value="{{ $important->value }}" required>
								<div class="input-group-append">
								    <span class="input-group-text colorpicker-input-addon"><i></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="ongoing">Color Ongoing</label>
							<div class="input-group colorpick">
								<input type="text" name="ongoing" id="ongoing" class="form-control" value="{{ $ongoing->value }}" required>
								<div class="input-group-append">
								    <span class="input-group-text colorpicker-input-addon"><i></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="failed">Color Failed</label>
							<div class="input-group colorpick">
								<input type="text" name="failed" id="failed" class="form-control" value="{{ $failed->value }}" required>
								<div class="input-group-append">
								    <span class="input-group-text colorpicker-input-addon"><i></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="completed">Color Completed</label>
							<div class="input-group colorpick">
								<input type="text" name="completed" id="completed" class="form-control" value="{{ $completed->value }}" required>
								<div class="input-group-append">
								    <span class="input-group-text colorpicker-input-addon"><i></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="pending">Color Pending</label>
							<div class="input-group colorpick">
								<input type="text" name="pending" id="pending" class="form-control" value="{{ $pending->value }}" required>
								<div class="input-group-append">
								    <span class="input-group-text colorpicker-input-addon"><i></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="start">Start Work</label>
							<input type="text" name="start" id="start" class="form-control clockpicker" value="{{ $wstart->value }}" required autocomplete="off" >
						</div>
						<div class="form-group">
							<label for="end">End Work</label>
							<input type="text" name="end" id="end" class="form-control clockpicker" required autocomplete="off" value="{{ $wend->value }}" required autocomplete="off" >
						</div>

						<div class="form-group">
							<label for="overtime">Overtime Start</label>
							<input type="text" name="overtime" id="overtime" class="form-control clockpicker" required autocomplete="off" value="{{ $overtime->value }}" required autocomplete="off" >
						</div>
						@can('edit_master_data')
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

@section('style')
  <link href="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/timepicker/bootstrap-clockpicker.min.css') }}" rel='stylesheet' />
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/timepicker/bootstrap-clockpicker.min.js') }}"></script>
    <script type="text/javascript">
	    $('.colorpick').colorpicker();
	    $('.clockpicker').clockpicker({
	        autoclose: true,
	        donetext: 'OK'
	    });
    </script>
@endsection