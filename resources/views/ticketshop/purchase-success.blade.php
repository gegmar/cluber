@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.tickets'))

@if(auth()->user() && $purchase->vendor_id == auth()->user()->id)
@section('nav-link', route('retail.sold.tickets'))
@else
@section('nav-link', route('ts.events'))
@endif

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        @if(auth()->user() && $purchase->vendor_id == auth()->user()->id)
        <li class="breadcrumb-item"><a href="{{ route('retail.sold.tickets') }}">{{__('ticketshop.sold_tickets')}}</a></li>
        @else
        <li class="breadcrumb-item"><a href="{{ route('ts.events') }}">{{__('ticketshop.back_to_events')}}</a></li>
        @endif
        <li class="breadcrumb-item active">{{__('ticketshop.download_tickets')}}</li>
    </ul>
</div>
<section class="projects">
    <div class="container-fluid">
        <!-- Events -->
        @foreach( $purchase->events() as $event)
        <div class="project">
            <div class="row bg-white has-shadow">
                <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
                    <div class="project-title d-flex align-items-center">
                        <div class="text">
                            <h3 class="h4">{{ $event->project->name}}</h3><small>{{$event->second_name}}</small>
                        </div>
                    </div>
                    <div class="project-date"><span class="hidden-sm-down">@datetime($event->start_date)</span></div>
                </div>
                <div class="right-col col-lg-6 d-flex align-items-center">
                    <div class="time"><i class="fa fa-clock-o"></i>@time($event->start_date)</div>
                    <div class="comments"><i class="fa fa-map-marker"></i> {{ $event->location->name }}</div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- Customer Data and tickets -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{__('ticketshop.tickets')}}</h3>
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
                                <tbody>
                                    @php $totalPrice = 0; @endphp
                                    @foreach( $purchase->ticketList() as $item )
                                    <tr>
                                        <td>{{ $item['category']->name }}</td>
                                        <td>{{ $item['count'] }}</td>
                                        <td>{{ $item['category']->price }} <i class="fa fa-eur"></i></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('ticketshop.total')}}</th>
                                        <th>{{ $purchase->tickets->count() }}</th>
                                        <th>{{ $purchase->total() }} <i class="fa fa-eur"></i></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if($purchase->customer !== null)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{__('ticketshop.customer_data')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">@lang('ticketshop.privacy_final')</p>
                        <ul>
                            <li>{{__('ticketshop.email')}}: {{ $purchase->customer->email }}</li>
                            <li>{{__('ticketshop.name')}}: {{ $purchase->customer->name }}</li>
                            <li>{{__('ticketshop.newsletter_option')}}: @if( $purchase->customer->hasPermission('RECEIVE_NEWSLETTER') ) {{__('ticketshop.yes')}} @else {{__('ticketshop.no')}} @endif</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{__('ticketshop.download_tickets')}}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{__('ticketshop.purchase_success')}}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a target="_blank" href="{{ route('ticket.download', ['purchase' => $purchase->random_id]) }}">{{__('ticketshop.tickets')}}</a></li>
                    </ul>
                </div>
            </div>
            
            @auth
            @if($purchase->vendor_id == auth()->user()->id)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{__('ticketshop.manage_purchase')}} (#{{ $purchase->id }})</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{__('ticketshop.delete_purchase_warning')}}</p>
                        <form action="{{ route('retail.sold.delete', ['purchase' => $purchase->random_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">{{__('ticketshop.delete')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endauth

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