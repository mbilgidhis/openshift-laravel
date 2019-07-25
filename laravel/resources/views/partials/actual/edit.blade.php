@extends('layouts.fancybox')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('actual.update', [$plan->id, $actual->id]) }}" method="post" role="form">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan->id }}">
                        <input type="hidden" name="id" value="{{ $actual->id }}">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $actual->title }}" required autofocus autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Description">{{ $actual->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="actual_date">Actual Date</label>
                            <input type="text" name="actual_date" id="actual_date" class="form-control" value="{{ date('Y-m-d', strtotime($actual->actual_date_start)) }}" required autocomplete="off">
                        </div>
                        <div class="form-group form-row">
                            <div class="col">
                                <label for="start">Start Time</label>
                                <input type="text" name="start" id="start" class="form-control clockpicker" value="{{ date('H:i', strtotime($actual->actual_date_start)) }}" required autocomplete="off">
                            </div>
                            <div class="col">
                                <label for="end">End Time</label>
                                <input type="text" name="end" id="end" class="form-control clockpicker" value="{{ date('H:i', strtotime($actual->actual_date_end)) }}"" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" <?=($category->id == $actual->actual_category_id) ? 'selected' : '';?>>{{ $category->name }}</option>
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
                            <input type="text" name="pmsales" id="pmsales" class="form-control" value="{{ $actual->pm_sales }}" placeholder="{{ $plan->project->pm_sales }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="site">Customer Site</label>
                            <input type="text" name="site" id="site" class="form-control" value="{{ $actual->site }}" placeholder="Customer Site" autocomplete="off">
                        </div>
                        @endif
                        @can('edit_actual')
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
  <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('assets/timepicker/bootstrap-clockpicker.min.css') }}" rel='stylesheet' />
  <style>
      .clockpicker-popover{
        z-index: 10000!important;
      }
  </style>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/timepicker/bootstrap-clockpicker.min.js') }}"></script>
    <script type="text/javascript">
        var picker = new Lightpick({
            field: document.getElementById('actual_date'),
            separator: '-',
            format: 'YYYY-MM-DD',
            repick: true,
        });
        $('#colorpicker').colorpicker({
            inline: true,
        });
        $('.clockpicker').clockpicker({
            autoclose: true,
            donetext: 'OK'
        });
    </script>
@endsection