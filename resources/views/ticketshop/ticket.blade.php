@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Ticket '.$ticket->id)

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.back_to_events')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.ticket_state')}}</li>
    </ul>
</div>
<section class="projects">
    <div class="container-fluid">
        <!-- Events -->
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">{{ $ticket->event->project->name}}</h3><small>{{$ticket->event->second_name}}</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">{{ date_format(date_create($ticket->event->start_date), 'l, d.m.Y') }}</span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>{{ date_format(date_create($ticket->event->start_date),
                        'H:i') }}</div>
                    <div class="comments"><i class="fa fa-map-marker"></i> {{ $ticket->event->location->name }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="dashboard-counts no-padding-bottom">
    <div class="container-fluid">
        <div class="row bg-white has-shadow">
            <!-- Purchase-State -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    @if($ticket->purchase->state == 'paid')
                    <div class="icon bg-green"><i class="fa fa-check"></i></div>
                    <div class="title">
                        <span>@lang('ticketshop.ticket_paid')</span>
                    </div>
                    @else
                    <div class="icon bg-red"><i class="fa fa-exclamation"></i></div>
                    <div class="title">
                        <span>@lang('ticketshop.ticket_not_paid')</span>
                    </div>
                    @endif
                    <div class="number"></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title">
                        <span>@lang('ticketshop.ticket_price')</span>
                    </div>
                    <div class="number"><strong>{{ $ticket->priceCategory->price}} <i class="fa fa-eur"></i></strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="fa fa-star"></i></div>
                    <div class="title">
                        <span>{{ $ticket->priceCategory->name}}</span>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-check"></i></div>
                    <div class="title">
                        <span>@lang('ticketshop.ticket_owner')</span>
                    </div>
                <div class="number"><strong>@if($ticket->purchase->customer_name != null) {{ $ticket->purchase->customer_name }} @else {{ $ticket->purchase->customer->name }} @endif</strong></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection