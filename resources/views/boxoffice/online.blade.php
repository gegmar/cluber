@extends('layouts.common')

@section('title', 'Ticketshop')

@section('page-title', __('ticketshop.box_office'))

@section('nav-link', route('boxoffice.dashboard'))

@section('content')
<!---  Breadcrumb -->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('boxoffice.dashboard') }}">{{__('ticketshop.events')}}</a></li>
        <li class="breadcrumb-item active">{{__('ticketshop.sold_tickets')}}</li>
    </ul>
</div>

<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
    <div class="container-fluid">
        <div class="row bg-white has-shadow">
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
                <div class="icon bg-violet"><i class="icon-user"></i></div>
                <div class="title"><span>{{__('ticketshop.occupancy')}}</span></div>
                <div class="number"><strong>{{ round($occupancy*100, 1) }}%</strong></div>
            </div>
        </div>
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
                <div class="icon bg-red"><i class="icon-padnote"></i></div>
                <div class="title"><span>{!! __('ticketshop.available_tickets') !!}</span></div>
                <div class="number"><strong>{{ $freeTickets }}</strong></div>
            </div>
        </div>
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
                <div class="icon bg-green"><i class="icon-bill"></i></div>
                <div class="title">{!! __('ticketshop.total-turnover') !!}</div>
                <div class="number"><strong>{{ $turnover }} <i class="fa fa-eur"></i></strong></div>
            </div>
        </div>
        <!-- Item -->
        <div class="col-xl-3 col-sm-6">
            <div class="item d-flex align-items-center">
                <button class="btn btn-primary" data-toggle="modal" data-target="#boxofficeModal">{{__('ticketshop.set_box_office_sales')}}</button>
            </div>
        </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>{{ $event->project->name . ' | ' . $event->second_name . ' | ' }} @datetime($event->start_date) @time($event->start_date)</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tickets" style="width: 100%;" class="table">
                        <thead>
                            <tr>
                                <th>{{__('ticketshop.consumer_came')}}</th>
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.state')}}</th>
                                <th>{{__('ticketshop.price-category')}} ({{__('ticketshop.price')}})</th>
                                <th>{{__('ticketshop.customer')}}</th>
                                <th>{{__('ticketshop.vendor')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>
                                    <input type="checkbox" class="ticket-state" data-url="{{ route('boxoffice.switch-ticket-state', [$ticket]) }}" @if($ticket->state == 'consumed') checked="checked @endif">
                                </td>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ __('ticketshop.'.$ticket->purchase->state)}}</td>
                                <td>{{ $ticket->priceCategory->name }} ({{ $ticket->priceCategory->price }} <i class="fa fa-eur"></i>)</td>
                                <td>
                                    @if($ticket->purchase->customer_name)
                                    {{ $ticket->purchase->customer_name }}
                                    @elseif($ticket->purchase->customer)
                                    {{ $ticket->purchase->customer->name }}
                                    @else
                                    {{__('ticketshop.shop-customer')}}
                                    @endif
                                </td>
                                <td>{{ $ticket->purchase->vendor->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@component('components.modals.set-boxoffice-sales', ['event' => $event])
@endcomponent
@endsection

@section('custom-js')
<!-- Data Tables-->
<script src="/vendor/datatables.net/js/jquery.dataTables.js"></script>
<script src="/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#tickets').DataTable({
        responsive: {
            details: false
        }
    });

    $(document).on('sidebarChanged', function () {
        dataTable.columns.adjust();
        dataTable.responsive.recalc();
        dataTable.responsive.rebuild();
    });

    $('.ticket-state').click(function() {
        $.post($(this).data('url'), {
            '_token'    : '{{ csrf_token() }}'
        });
    });

});
</script>
@endsection