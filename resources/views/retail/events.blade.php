@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events'))

@section('nav-link', route('retail.sell.events'))

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
                        <p class="card-text">{{ $event->start_date }}</p>
                        <a href="{{ route('retail.sell.seats', ['event' => $event->id]) }}" class="btn btn-primary">{{__('ticketshop.sell_tickets')}}</a>
                    </div>
                    <div class="card-footer text-muted">{{__('ticketshop.tickets_available', $event->freeTickets(), ['ticketCount' => $event->freeTickets()])}}</div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">{{ $project->name }}</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $event->second_name }}</h4>
                        <p class="card-text">{{ $event->start_date }}</p>
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