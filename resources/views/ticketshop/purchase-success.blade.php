@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">Back to Event overview</a></li>
        <li class="breadcrumb-item active">Download Tickets</li>
    </ul>
</div>
<section class="projects">
    <div class="container-fluid">
        <!-- Event-->
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">{{ $purchase->event->project->name}}</h3><small>{{$purchase->event->second_name}}</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">{{ date_format(date_create($purchase->event->start_date), 'l, d.m.Y') }}</span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>{{ date_format(date_create($purchase->event->start_date),
                        'H:i') }}</div>
                    <div class="comments"><i class="fa fa-map-marker"></i> {{ $purchase->event->location->name }}</div>
                </div>
            </div>
        </div>
        <!-- Customer Data and tickets -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">My Tickets</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ticket type</th>
                                        <th>Number of tickets</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Standard</td>
                                        <td>4</td>
                                    </tr>
                                    <tr>
                                        <td>Reduced</td>
                                        <td>2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Customer data</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">This information will be used to send your tickets via mail and track it
                        in our system (<a href="{{ route('privacy') }}">privacy terms</a>)</p>
                        <ul>
                            <li>E-Mail: {{ $purchase->customer->email }}</li>
                            <li>Name: {{ $purchase->customer->name }}</li>
                            <li>Newsletter subscription via mail: @if( $purchase->customer->hasPermission('RECEIVE_NEWSLETTER') )yes @else no @endif</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Download Tickets</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Success! You can download your tickets here as pdf! Please bring them to
                            the event in order to enter the location.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('ticket.download', ['purchase' => $purchase->random_id]) }}">Tickets</a></li>
                    </ul>
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