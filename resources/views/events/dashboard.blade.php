@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events'))

@section('nav-link', route('events.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">{{__('ticketshop.dashboard')}}</li>
    </ul>
</div>
<!-- Projects Section-->
<section class="projects no-padding-bottom">
    <div class="container-fluid">
        <!-- Project-->
        @foreach($upcomingEvents as $event)
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">{{ $event->project->name }}</h3><small>{{ $event->second_name }}</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">@datetime($event->start_date) <i class="fa fa-calendar"></i></span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>@time($event->start_date)</div>
                    <div class="comments"><i class="fa fa-ticket"></i>{{ $event->tickets->count() }}</div>
                    <div class="project-progress">
                        <div class="progress">
                            <div role="progressbar" style="width: {{ round($event->tickets->count() * 100 / $event->seatMap->seats) }}%; height: 6px;" aria-valuenow="{{ $event->tickets->count() }}" aria-valuemin="0"
                                aria-valuemax="{{ $event->seatMap->seats }}" class="progress-bar bg-red"></div>
                        </div>
                    </div>
                    <a class="btn btn-info pull-right" href="{{ route('events.download-overview', ['event' => $event->id]) }}" target="_blank"><i class="fa fa-table"></i> {{__('ticketshop.download-overview')}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-top">
    <div class="container-fluid">
        <div class="row bg-white has-shadow">
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="fa fa-calendar"></i></div>
                    <div class="title"><span>@lang('ticketshop.events-active')</span></div>
                    <div class="number"><strong>{{ $openEvents->count() }}</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="fa fa-bar-chart"></i></div>
                    <div class="title"><span>@lang('ticketshop.market-share')</span></div>
                    <div class="number"><strong>{{$marketShare}}%</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-bill"></i></div>
                    <div class="title"><span>@lang('ticketshop.number-sales')</span></div>
                    <div class="number"><strong>{{ $totalSales }}</strong></div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-xl-3 col-sm-6">
                <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>@lang('ticketshop.total-turnover')</span>
                    </div>
                    <div class="number"><strong>{{ $myTurnOver}} <i class="fa fa-eur"></i></strong></div>
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