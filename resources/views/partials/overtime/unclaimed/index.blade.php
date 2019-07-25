@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					@can('create_claim_overtime')
					<div class="row pb-3">
					    <div class="col-md-2 offset-md-10 text-right">
					        <a href="{{ route('overtime.claim') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Claim Overtime</a>
					    </div>
					</div>
					@endcan
					@hasrole('admin|manager|super admin')
					<div class="pb-3">
						{{-- <form action="#" method="get"> --}}
							<div class="form-row">
								<label for="user" class="col-md-2 col-form-label">Owner</label>
								<div class="col-md-5">
									<select name="user" id="user" class="form-control select2" style="width: 100%">
										<option></option>
										@foreach($users as $user)
											<option value="{{ $user->id }}" {{ ($owner == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-2">
									<a href="{{ route('overtime.unclaimed.index') }}" class="btn btn-sm btn-primary form-control">Reset</a>
								</div>
							</div>
						{{-- </form> --}}
					</div>
					@endhasrole
					<div class="table-responsive">
						<table class="table table-hover table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Activity</th>
									<th>Start</th>
									<th>End</th>
									@hasrole('admin|manager|super admin')
									<th>Claimant</th>
									@endhasrole
									<th><i class="fal fa-tasks"></i></th>
								</tr>
							</thead>
							<tbody>
								@foreach( $overtimes as $overtime )
								<tr>
									<td>#</td>
									<td>{{ $overtime->activity }}</td>
									<td>{{ date('d M Y H:i:s', strtotime($overtime->start)) }}</td>
									<td>{{ date('d M Y H:i:s', strtotime($overtime->end)) }}</td>
									@hasrole('admin|manager|super admin')
									<td>{{ $overtime->owner->name }}</td>
									@endhasrole
									<td>
										
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@if( $owner !== null )
						{{ $overtimes->appends(['owner' => $owner])->links() }}
						@else
						{{ $overtimes->links() }}
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
	<link href="{{ asset('assets/select2/select2.min.css') }}" rel='stylesheet' />
	<link href="{{ asset('assets/select2/select2.bootstrap4.min.css') }}" rel='stylesheet' />
@endsection


@section('script')
@hasrole('admin|manager|super admin')
	<script type="text/javascript" src="{{ asset('assets/select2/select2.min.js') }}"></script>
	<script>
		$('.select2').select2({
			theme: 'bootstrap4',
			placeholder: 'Please Select',
			allowClear: true,
		}).on('select2:select', function(e){
			var data = e.params.data;
			var id = data.id;
			window.location = '{{ url()->current() }}?owner=' + id;
		});
	</script>
@endhasrole
@endsection
