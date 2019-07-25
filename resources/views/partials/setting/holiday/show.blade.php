@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('setting.holiday.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('setting.holiday.update') }}" method="post">
						@csrf
						<input type="hidden" name="id" name="id" value="{{ $holiday->id }}">
						<div class="form-group">
							<label for="name">Holiday Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Holiday Name" value="{{ $holiday->name }}" required autofocus autocomplete="off">
						</div>
						<div class="form-group">
							<label for="date">Date</label>
							<input type="text" name="date" id="date" class="form-control" placeholder="Date" value="{{ $holiday->start }}" required>
						</div>
						@if( $holiday->link )
						<div class="form-group">
							<label for="link">Google Link <a href="{{ $holiday->link }}" target="_blank" class="btn btn-link" title="{{ $holiday->name }}"><i class="fal fa-link"></i></a></label>
						</div>
						@endif
						<div class="form-group text-right">
							<button type="submit" class="btn btn-sm btn-primary">Update</button>
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
@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
	<script>
		$('document').ready(function() {
			var picker = new Lightpick({
			    field: document.getElementById('date'),
			    separator: '-',
			    format: 'YYYY-MM-DD',
			    repick: true,
			});
		});
	</script>
@endsection