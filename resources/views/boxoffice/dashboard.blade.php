@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.events'))

@section('nav-link', route('boxoffice.dashboard'))

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
                    <a class="btn btn-info pull-right" href="{{ route('boxoffice.download-overview', ['event' => $event->id]) }}" target="_blank"><i class="fa fa-file-excel-o"></i> {{__('ticketshop.download-overview')}}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('custom-js')
<script type="text/javascript">
$(document).ready(function() {

});
</script>
@endsection