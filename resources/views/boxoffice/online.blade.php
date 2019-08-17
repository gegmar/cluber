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
                                <th>{{__('ticketshop.id')}}</th>
                                <th>{{__('ticketshop.vendor')}}</th>
                                <th>{{__('ticketshop.customer')}}</th>
                                <th>{{__('ticketshop.price-category')}} ({{__('ticketshop.price')}})</th>
                                <th>What?</th>
                                <th>{{__('ticketshop.state')}}</th>
                                <th>{{__('ticketshop.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->purchase->vendor->name }}</td>
                                <td>
                                    @if($ticket->purchase->customer_name)
                                    {{ $ticket->purchase->customer_name }}
                                    @elseif($ticket->purchase->customer)
                                    {{ $ticket->purchase->customer->name }}
                                    @else
                                    {{__('ticketshop.shop-customer')}}
                                    @endif
                                </td>
                                <td>{{ $ticket->priceCategory->name }} ({{ $ticket->priceCategory->price }} <i class="fa fa-eur"></i>)</td>
                                <td>{{ __('ticketshop.'.$ticket->purchase->state)}}</td>
                                <td class="state">
                                    @if($ticket->state == 'no_show')
                                    <span class="badge badge-secondary">{{__('ticketshop.no_show')}}</span>
                                    @else
                                    <span class="badge badge-success">{{__('ticketshop.consumed')}}</span>
                                    @endif
                                </td>
                                <td class="actions">
                                    @if($ticket->state != 'consumed')
                                    <a
                                        class="action-button btn btn-success"
                                        data-id="{{ $ticket->id }}"
                                        data-state="consumed"
                                        data-url="{{ route('boxoffice.change-ticket-state', ['ticket' => $ticket->random_id]) }}">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    @if($ticket->state != 'no_show')
                                    <a
                                        class="action-button btn btn-secondary"
                                        data-id="{{ $ticket->id }}"
                                        data-state="no_show"
                                        data-url="{{ route('boxoffice.change-ticket-state', ['ticket' => $ticket->random_id]) }}">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<!-- Data Tables-->
<script src="/vendor/datatables.net/js/jquery.dataTables.js"></script>
<script src="/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/vendor/ladda/spin.min.js"></script>
<script src="/vendor/ladda/ladda.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var dataTable = $('#tickets').DataTable({
        responsive: {
            details: false
        }
    }
    );

    $(document).on('sidebarChanged', function () {
        dataTable.columns.adjust();
        dataTable.responsive.recalc();
        dataTable.responsive.rebuild();
    });

    function addEventToActionButtons() {
        Ladda.bind('.action-button');
        $('.action-button').click(function() {
            var state = $(this).data('state');
            var row = $(this).closest('tr');
            $.post($(this).data('url'), {
                'new_state' : state,
                '_token'    : '{{ csrf_token() }}'
            }, function() {
                if (state == 'no_show') {
                    badge = '<span class="badge badge-secondary">{{__('ticketshop.no_show')}}</span>';
                } else {
                    badge = '<span class="badge badge-success">{{__('ticketshop.consumed')}}</span>';
                }
                row.children('td.state').html(badge);
                // Remove all action buttons and only recreate those suitable for the current state
                // For nicer displayed buttons look above
                row.children('td.actions').empty();
                if(state != 'consumed') {
                    row.children('td.actions').append('<a class="action-button btn btn-success" data-id="{{ $ticket->id }}" data-state="consumed" data-url="{{ route("boxoffice.change-ticket-state", ["ticket" => $ticket->random_id]) }}"> <i class="fa fa-check"></i> </a>');
                }
                if(state != 'no_show') {
                    row.children('td.actions').append('<a class="action-button btn btn-secondary" data-id="{{ $ticket->id }}" data-state="no_show" data-url="{{ route("boxoffice.change-ticket-state", ["ticket" => $ticket->random_id]) }}"><i class="fa fa-remove"></i> </a>');
                }
                addEventToActionButtons();
            });
        });
    }
    addEventToActionButtons();
    

});
</script>
@endsection