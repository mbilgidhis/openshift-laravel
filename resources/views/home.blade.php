@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-4 pb-2">
            <div class="card">
                <div class="card-body text-center">
                    <img class="rounded-circle text-center" height="100" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Card image cap">
                    <h4 class="mb-0">{{ Auth::user()->name }}</h4> 
                    {{-- <div class="text-muted font-italic mb-2">@php echo ( Auth::user()->department !== null ) ? Auth::user()->department->name : ''; @endphp</div> --}}
                    <div class="text-muted font-italic mb-2">{{ $jabatan }}</div>
                    <a href="{{ route('plan.create') }}" class="btn btn-sm btn-primary text-center"><span class="fal fa-plus"></span> NEW PLAN</a>
                </div>
                <div class="card-body pt-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item  d-flex justify-content-between align-items-center">
                            <span class="fal fa-calendar-alt"></span> 
                            Ongoing Plan
                            <span class="badge badge-primary badge-pill">{{ $plans->count() }}</span>
                        </li>
                        <li class="list-group-item  d-flex justify-content-between align-items-center">
                            <span class="fal fa-tasks"></span> 
                            Outdated Plan
                            <span class="badge badge-primary badge-pill">{{ $outdated->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 pb-2" >
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><span class="fal fa-calendar-alt"></span> Ongoing Plan</h6>
                    <ul class="list-group list-home newsticker">
                        @foreach ($plans as $otherPlan)
                        <li href="{!! route('plan.show', $otherPlan->id) !!}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $otherPlan->title }}</h6>
                                <small>{{ Carbon\Carbon::createFromTimeStamp(strtotime($otherPlan->created_at))->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                <div class="small">
                                    <span class="fal fa-calendar-alt"></span> 
                                    {{ Carbon\Carbon::parse($otherPlan->start)->format('d M Y') }} 
                                    <span class="fal fa-arrow-right"></span> 
                                    {{ Carbon\Carbon::parse($otherPlan->end)->format('d M Y') }}
                                </div>
                                {{ $otherPlan->description }}
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="card-footer">
                    <a href="#" class="btn btn-block btn-light"><span class="fal fa-list-alt"></span> SHOW ALL</a>
                </div> --}}
            </div>  
        </div>

        <div class="col-md-4 pb-2" >
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted"><span class="fal fa-tasks"></span> Outdated Plan/Plan w/o actual</h6>
                    <ul class="list-group list-home newsticker-2">
                    @foreach ($outdated as $outdate)
                        <li href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $outdate->title }}</h6>
                                <small>
                                    {{ Carbon\Carbon::createFromTimeStamp(strtotime($outdate->created_at))->diffForHumans() }}
                                </small>
                            </div>
                            <p class="mb-1">
                                <div class="small">
                                    <span class="fal fa-clipboard-check"></span> {{ Carbon\Carbon::parse($outdate->due_date)->format('d M Y') }}
                                </div>
                                {{ $outdate->description }}
                            </p>
                        </li>
                    @endforeach
                    </ul>
                </div>
               {{--  <div class="card-footer">
                    <a href="#" class="btn btn-block btn-light"><span class="fal fa-list-alt"></span> SHOW ALL</a>
                </div> --}}
            </div>
        </div>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="pb-3 pt-3">
                        <form action="{{ route('home') }}" method="get" class="form-inline">
                            <div class="form-group mb-2">
                                <label for="range" class="sr-only">Date Range</label>
                                <input type="text" readonly class="form-control-plaintext" id="range" value="Date Range">
                            </div>
                            <div class="form-group mb-2 mx-sm-3">
                                <label for="start" class="sr-only">Start</label>
                                <input type="text" name="start" id="start" class="form-control" value="{{ $start }}" required>
                            </div>
                            <div class="form-group mb-2 mx-sm-3">
                                <label for="end" class="sr-only">End</label>
                                <input type="text" name="end" id="end" class="form-control" value="{{ $end }}" required>
                            </div>   
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary">Set</button>
                            </div>
                        </form>
                    </div>

                    <div id="timeline" class="calendar-container"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('style')
    <link href="{{ asset('assets/vendors/fullcalendar/core/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/vendors/fullcalendar/timeline/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/vendors/fullcalendar/resource-timeline/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/vendors/fullcalendar/timegrid/main.css') }}" rel='stylesheet' />
    <link href="{{ asset('assets/vendors/lightpick/css/lightpick.css') }}" rel='stylesheet' />
    <style>
        .fc-toolbar, .fc-cell-text{
            font-size: .9em !important;
        }
        .list-home {
            height: 300px;
            margin-bottom: 10px;
            overflow-y:scroll;
            -webkit-overflow-scrolling: touch;
        }
        .newsticker {
            padding: 0 !important;
        }
        /*.dropdown-toggle:after { content: none }*/
    </style>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-advanced-news-ticker/1.0.1/js/newsTicker.min.js"></script>
<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendors/fullcalendar/core/main.js') }}"></script>
<script src="{{ asset('assets/vendors/fullcalendar/timeline/main.js') }}"></script>
<script src="{{ asset('assets/vendors/fullcalendar/resource-common/main.js') }}"></script>
<script src="{{ asset('assets/vendors/fullcalendar/resource-timeline/main.js') }}"></script>
{{-- <script src="{{ asset('assets/vendors/fullcalendar/timegrid/main.js') }}"></script> --}}
<script src="{{ asset('assets/vendors/fullcalendar/interaction/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/lightpick/js/lightpick.js') }}"></script>
<script>
    $('document').ready(function(){

        $('.newsticker').newsTicker({
            row_height: 100,
            direction: 'down',
            max_rows: 3,
            duration: 4000,
        });

        $('.newsticker-2').newsTicker({
            row_height: 100,
            direction: 'down',
            max_rows: 3,
            duration: 3000,
        });

        var picker = new Lightpick({
            field: document.getElementById('start'),
            secondField: document.getElementById('end'),
            singleDate: false,
            separator: '-',
            format: 'YYYY-MM-DD',
            repick: true,
        });

        var resourceurl = '<?=($start===null && $end===null) ? route('ajax.plan-resource')  : route('ajax.plan-resource') . "?start=$start&end=$end";?>';
        var calendarEl = document.getElementById('timeline');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['resourceTimeline', /*'resourceTimeGrid',*/ 'interaction'],
            defaultView: 'resourceTimelineMonth',
            header: {
                left: 'today,prev,next',
                center: 'title',
                right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
            },
            calendarWeekends: true,
            // editable: true,
            calendarEvents: [ // initial event data
                { title: 'Event Now', start: new Date() }
            ],
            resourceColumns: [
                {
                    labelText: 'Task Name',
                    field: 'title'
                },
                {
                    labelText: 'Assignee',
                    field: 'assignee'
                }
            ],
            resources: resourceurl,
            events: '{{ route('ajax.plan-event') }}',
            height: 500,
        });
        calendar.render();

    })
</script>   
@endsection