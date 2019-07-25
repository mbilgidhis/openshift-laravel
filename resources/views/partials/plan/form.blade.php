@extends('layouts.default')


@section('content')
<div class="row">
    <div class="col-md-6 offset-3">
      <form action="{{ route('plan.store') }}" method="POST">
            <div class="form-group">
              <label for="status">Status</label>
              <input type="text" class="form-control" id="status" name="status" placeholder="Status">
            </div>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Title">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="form-control" name="description" placeholder="Description"></textarea>
            </div>
            <div class="form-group">
              <label for="start">Due Date</label>
              <div class="form-row">
                <div class="col">
                  {!! Form::text('start', '')->placeholder('Start') !!}
                </div>
                <div class="col">
                  {!! Form::text('end', '')->placeholder('End') !!}
                </div>
              </div>
            </div>
            @csrf
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop

@section('style')
  <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript">
    var picker = new Lightpick({
        field: document.getElementById('start'),
        secondField: document.getElementById('end'),
        singleDate: false,
        onSelect: function(start, end){
            var str = '';
            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
            str += end ? end.format('Do MMMM YYYY') : '...';
        }
    });
    </script>
@endsection