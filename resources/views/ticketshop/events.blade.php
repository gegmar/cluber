@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">{{__('ticketshop.events')}}</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
        @foreach( $projects as $project )
        <div class="row">
            @foreach( $project->events as $event )
            <div class="col-md-4">
                @if( !$event->isSoldOut() )
                <div class="card">
                    <div class="card-header">{{ $project->name }}</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $event->second_name }}</h4>
                        <p class="card-text"><i class="fa fa-calendar"></i> {{ date_format(date_create($event->start_date), 'l, d.m.Y') }}</p>
                        <p class="card-text"><i class="fa fa-clock-o"></i> {{ date_format(date_create($event->start_date),
                            'H:i') }}</p>
                        <a href="{{ route('ts.seatmap', ['event' => $event->id]) }}" class="btn btn-primary">{{__('ticketshop.Buy_Tickets')}}</a>
                    </div>
                    <div class="card-footer text-muted">{{__('ticketshop.tickets_still_available')}}</div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">{{ $project->name }}</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $event->second_name }}</h4>
                        <p class="card-text"><i class="fa fa-calendar"></i> {{ date_format(date_create($event->start_date), 'l, d.m.Y') }}</p>
                        <p class="card-text"><i class="fa fa-clock-o"></i> {{ date_format(date_create($event->start_date),
                            'H:i') }}</p>
                    </div>
                    <div class="card-footer text-muted">{{__('ticketshop.sold_out')}}</div>
                </div>
                @endif
            </div> <!-- end event col -->
            @endforeach
        </div> <!-- end project row -->
        @endforeach

    </div>
</section>
@endsection