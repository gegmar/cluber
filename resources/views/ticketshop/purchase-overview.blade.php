@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', 'Tickets')

@section('nav-link', route('ts.events'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.events')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.seatmap', ['event' => $event->id]) }}">{{__('ticketshop.Select_Seats')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ts.customerData') }}">{{__('ticketshop.customer_data')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.overview')}}</li>
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
                        <h3 class="h4">{{__('ticketshop.my_tickets')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{__('ticketshop.price-category')}}</th>
                                        <th>{{__('ticketshop.number_of_tickets')}}</th>
                                        <th>{{__('ticketshop.price')}} / {{__('ticketshop.ticket')}}</th>
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
                                        <th>{{__('ticketshop.total')}}</th>
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
                        <h3 class="h4">{{__('ticketshop.customer_data')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">@lang('ticketshop.privacy_final')</p>
                        <ul>
                            <li>{{_('ticketshop.email')}}: {{ $customerData['email'] }}</li>
                            <li>{{__('ticketshop.name')}}: {{ $customerData['name'] }}</li>
                            <li>{{__('ticketshop.newsletter_option')}}: @if( array_key_exists('newsletter', $customerData) )
                                {{__('ticketshop.yes')}}
                                @else {{__('ticketshop.no')}} @endif</li>
                        </ul>
                        <a href="{{ route('ts.customerData') }}">{{__('ticketshop.edit')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{__('ticketshop.payment_method')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{__('ticketshop.select_payment_method')}}</p>
                    </div>
                    <form action="{{ route('ts.pay') }}" method="post">
                        @csrf
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><input type="radio" name="paymethod" value="PayPal" /> <img src="/img/logos/paypal.jpg"
                                    alt="PayPal" height="30px"> {{__('ticketshop.or_credit_card')}}</li>
                            <li class="list-group-item"><input type="radio" name="paymethod" value="Klarna" /> <img src="/img/logos/klarna.png"
                                    alt="Klarna" height="30px"> = SofortÜberweisung</li>
                            <li class="list-group-item"><button class="btn btn-primary">{{__('ticketshop.buy')}}</button></li>
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