@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pb-3">
                        <div class="col-md-2 offset-md-10 text-right">
                            <a href="{{ route('plan.create') }}" class="btn btn-sm btn-success"><i class="fal fa-plus"></i> Create Plan</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @include('partials.flash')
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Creator</th>
                                    <th>Assignee</th>
                                    <th>Category</th>
                                    <th>Due Date</th>
                                    <th class="text-center"><span class="fal fa-tasks"></span></th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                <tr>
                                    <td>{{ $plan->title }}</td>
                                    <td>{{ $plan->status }}</td>
                                    <td>{{ $plan->createdBy['name'] }}</td>
                                    <td>{{ $plan->user['name'] }}</td>
                                    <td>{{ $plan->category['name'] }}</td>
                                    <td>{{ date('d M Y', strtotime($plan->end)) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('plan.show', $plan->id) }}" class="btn btn-sm btn-primary"><span class="fal fa-tasks"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $plans->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
