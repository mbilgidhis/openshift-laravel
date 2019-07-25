@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-muted"><span class="fal fa-calendar-alt"></span> MY PLANS</h6>
                            <div class="list-group-flush list-plan">
                                @foreach ($plans as $otherPlan)
                                <a href="{!! route('plan.show', $otherPlan->id) !!}" class="list-group-item list-group-item-action @if($otherPlan->id == $plan->id) active @endif">
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
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3>{{ $plan->title }}</h3>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-sm btn-light"><span class="fal fa-pen"></span></a>
                                                <a href="#" class="btn btn-sm btn-light"><span class="fal fa-trash"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="small">
                                                <span class="fal fa-calendar-alt"></span> 
                                                {{ Carbon\Carbon::parse($plan->start)->format('d M Y') }} 
                                                <span class="fal fa-arrow-right"></span> 
                                                {{ Carbon\Carbon::parse($plan->end)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>{{ $plan->description }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <span class="fa fa-tasks"></span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{ route('actual.create', $plan->id) }}" class="btn btn-sm btn-light"><span class="fal fa-plus"></span> ADD ACTUAL</a>
                                                    <a href="{{ route('actual.create', $plan->id) }}" class="btn btn-sm btn-light"><span class="fal fa-file-import"></span> IMPORT CSV</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group">
                                        @foreach ($plan->actuals as $actual)
                                            <li href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1">{{ $actual->title }}</h6>
                                                    <small>
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="fa fa-ellipsis-h-alt"></span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                <a href="#" class="dropdown-item small"><span class="fal fa-pen"></span> Ubah</a>
                                                                <a href="#" class="dropdown-item small"><span class="fal fa-trash"></span> Hapus</a>
                                                            </div>
                                                        </div>
                                                    </small>
                                                </div>
                                                <div>
                                                    <span class="fal fa-clipboard-check"></span> {{ Carbon\Carbon::parse($plan->due_date)->format('d M Y') }}
                                                </div>
                                                <p class="mb-1">
                                                    {{ $actual->description }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="media mb-3">
                                <div class="media-body">
                                    <div><img src="http://chittagongit.com/download/21970" alt="..." height="30" class="rounded-circle"> 
                                        {{ $plan->user->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6>DOWNLOAD</h6>
                                    <div>
                                        <button class="btn btn-sm btn-light">
                                            <span class="fa fa-file-excel"></span> CSV
                                        </button>
                                        <button class="btn btn-sm btn-light">
                                            <span class="fa fa-file-pdf"></span> PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6>CATEGORY</h6>
                                    <div>{{ $plan->category->name }}</div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6>DEPARTMENT</h6>
                                    <div>{{ Auth::user()->department->name }}</div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6>LAST UPDATE</h6>
                                    <div>
                                        <small>
                                            <span class="fa lfa-clock"></span> {{ Carbon\Carbon::parse($plan->updated_at)->format('d-m-Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <h6>CREATED</h6>
                                    <div>
                                        <small>
                                            {{ Carbon\Carbon::parse($plan->created_at)->format('d-m-Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('style')
    <style>
        .dropdown-toggle:after { content: none }
        .list-plan {
            max-height: 700px;
            margin-bottom: 10px;
            overflow-y:scroll;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection