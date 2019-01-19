@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">Events</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.seatmap', ['event' => $event->id]) }}">Select Seats</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.customerData') }}">My Data</a></li>
        <li class="breadcrumb-item active">Overview</li>
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
                            <h3 class="h4">{{ $event->project->name }}</h3><small>{{ $event->second_name }}</small>
                        </div>
                    </div>
                    <div class="project-date">
                        <span class="hidden-sm-down">{{ date_format(date_create($event->start_date), 'l, d.m.Y') }}</span>
                    </div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>{{ date_format(date_create($event->start_date),
                        'H:i') }}</div>
                    <div class="comments"><i class="fa fa-map-marker"></i> {{ $event->location->name }}</div>
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
                                        <th>Price per ticket</th>
                                    </tr>
                                </thead>
                                @php
                                $prices = $event->priceList->categories;
                                $prices = $prices->keyBy('name'); // enable us to find correct prices in the later loop
                                @endphp
                                <tbody>
                                    @php
                                        $sumTickets = 0;
                                        $sumPrice = 0;
                                    @endphp
                                    @foreach( $tickets as $label => $count )
                                    @if( $count > 0 )
                                    @php
                                        $sumTickets += $count;
                                        $sumPrice += $count * $prices[$label]->price;
                                    @endphp
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>{{ $count }}</td>
                                        <td>{{ $prices[$label]->price }} <i class="fa fa-eur"></i></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $sumTickets }}</th>
                                        <th>{{ $sumPrice }} <i class="fa fa-eur"></i></th>
                                    </tr>
                                </tfoot>
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
                            <li>E-Mail: {{ $customerData['email'] }}</li>
                            <li>Name: {{ $customerData['name'] }}</li>
                            <li>Newsletter subscription via mail: @if( array_key_exists('newsletter', $customerData) )
                                yes
                                @else no @endif</li>
                        </ul>
                        <a href="{{ route('ts.customerData') }}">Edit my data</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Payment Method</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Select a payment method for this purchase!</p>
                    </div>
                    <form action="{{ route('ts.pay') }}" method="post">
                        @csrf
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><input type="radio" name="paymethod" value="PayPal" /> <img src="/img/logos/paypal.jpg"
                                    alt="PayPal" height="30px"></li>
                            <li class="list-group-item"><input type="radio" name="paymethod" value="Klarna" /> <img src="/img/logos/klarna.png"
                                    alt="Klarna" height="30px"></li>
                            <li class="list-group-item"><button class="btn btn-primary">Buy</button></li>
                        </ul>
                    </form>
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