@extends('layouts.fancybox')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('actual.store', $plan->id) }}" method="post" role="form">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan->id }}">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" required autofocus autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="actual_date">Actual Date</label>
                            <input type="text" name="actual_date" id="actual_date" class="form-control" required autocomplete="off">
                        </div>
                        <div class="form-group form-row">
                            <div class="col clockpicker">
                                <label for="start">Start Time</label>
                                <input type="text" name="start" id="start" class="form-control " required autocomplete="off">
                            </div>
                            <div class="col clockpicker">
                                <label for="end">End Time</label>
                                <input type="text" name="end" id="end" class="form-control " required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if( $plan->project )
                            <div class="form-group">
                                <label for="project">Project</label>
                                <input type="text" id="project" value="{{ $plan->project->name }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="project_code">Project Code</label>
                                <input type="text" id="project_code" value="{{ $plan->project->project_code }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="pmsales">PM/Sales <abbr title="PM/Sales will be automatically filled using Project's PM/Sales if not specified">*</abbr></label>
                                <input type="text" name="pmsales" id="pmsales" class="form-control" placeholder="{{ $plan->project->pm_sales }}" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="site">Customer Site</label>
                                <input type="text" name="site" id="site" class="form-control" placeholder="Customer Site" autocomplete="off">
                            </div>
                        @endif

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
  <link href="{{ asset('assets/timepicker/bootstrap-clockpicker.min.css') }}" rel='stylesheet' />
  <style>
      .clockpicker-popover{
          z-index: 10000!important;
        }
  </style>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/timepicker/bootstrap-clockpicker.min.js') }}"></script>
    <script type="text/javascript">
        var picker = new Lightpick({
            field: document.getElementById('actual_date'),
            separator: '-',
            format: 'YYYY-MM-DD',
            repick: true,
        });
        $('.clockpicker').clockpicker({
            autoclose: true,
            donetext: 'OK'
        });
    </script>
@endsection