@extends('layouts.app')

@section('title', __('ticketshop.Events'))


@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">{{ __('ticketshop.Start') }}</li>
@endsection

@section('content')

<div class="accordion" id="projects">

    @foreach( $projects as $project)
    <div class="card">
        <div class="card-header" id="heading-{{ $project->id }}">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $project->id }}"
                    aria-expanded="true" aria-controls="collapse-{{ $project->id }}">
                    {{ $project->name }}
                </button>
            </h5>
        </div>

        <div id="collapse-{{ $project->id }}" class="collapse show" aria-labelledby="heading-{{ $project->id }}"
            data-parent="#projects">
            <div class="card-body">

                <p>{{ $project->description }}</p>

                <div class="card-deck">
                    <div class="row">
                        @foreach( $project->events as $event )
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->second_name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $event->location->name }}</h6>
                                    <p class="card-text">{{ $event->start_date}}</p>
                                    <a href="{{ route('ts.seatmap', ['event' => $event->id]) }}" class="btn btn-primary">{{
                                        __('ticketshop.Buy_Tickets') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection