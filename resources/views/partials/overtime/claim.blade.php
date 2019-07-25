@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					<div class="pt-2 pb-2">
						<a href="{{ route('overtime.index') }}" class="btn btn-sm btn-info"><span class="fal fa-back"></span>Back</a>
					</div>
					@include('partials.flash')
					<form action="{{ route('overtime.create') }}" method="post">
						@csrf
						<div class="form-group">
							<label for="period">Period</label>
							<input type="text" name="period" id="period" class="form-control" placeholder="Period" required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="unclaimed">Unclaimed Overtime</label>
							<div class="table-responsive">
								<table class="table table-hover table-stripped">
									<thead>
										<tr>
											<th style="vertical-align: top;" class="text-center">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="checkall">
												</div>
											</th>
											<th>Activity</th>
											<th>Start</th>
											<th>End</th>
										</tr>
									</thead>
									<tbody>
										@foreach( $overtimes as $overtime )
											<tr class="check">
												<td class="text-center">
													<div class="form-check">
														<input class="form-check-input" name="id[]" type="checkbox" value="{{ $overtime->id }}">
													</div>
												</td>
												<td>{{ $overtime->activity }}</td>
												<td>{{ date('d M Y H:i', strtotime($overtime->start)) }}</td>
												<td>{{ date('d M Y H:i', strtotime($overtime->end))  }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
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
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
	<script>
		var picker = new Lightpick({
			field: document.getElementById('period'),
			format: 'MMMM YYYY',
			repick: true,
		});
		$('#checkall').click(function(){
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});
		$('.check').click(function(){
			var checkbox = $(this).find('input:checkbox');
			checkbox.prop("checked", !checkbox.prop("checked"));
		})
	</script>
@endsection

