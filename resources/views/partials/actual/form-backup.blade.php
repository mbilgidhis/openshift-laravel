@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
        {!!Form::open()->route('actual.store', ['plan_id' => $plan->id])->method('post')->id('actual_form')!!}
            <div class="form-group">
              {!!Form::text('title', 'Title')!!}
            </div>
            <div class="form-group">
                {!!Form::textarea('description', 'Description')!!}
            </div>
            <div class="form-group">
              {!!Form::text('actual_date', 'Actual Date')!!}
            </div>
            {!! Form::hidden('start')->value(Carbon\Carbon::parse($plan->start)->format('Y-m-d')) !!}
            <button type="submit" class="btn btn-primary">Save</button>
        {!!Form::close()!!}
    </div>
</div>
@stop

@section('style')
  <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript">
    var actualDate = document.getElementById('actual_date');
    var picker = new Lightpick({
        field: actualDate,
        minDate: moment($('#start').val()).format('YYYY-MM-DD')
    });
    </script>
@endsection
