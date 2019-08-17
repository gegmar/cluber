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
                                <td>
                                    @if($ticket->state == 'open')
                                    <span class="badge badge-info">{{__('ticketshop.open')}}</span>
                                    @elseif($ticket->state == 'no_show')
                                    <span class="badge badge-secondary">{{__('ticketshop.no_show')}}</span>
                                    @else
                                    <span class="badge badge-success">{{__('ticketshop.consumed')}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->state != 'consumed')
                                    <form style="display:inline-block" action="{{ route('boxoffice.change-ticket-state', ['ticket' => $ticket->random_id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="new_state" value="consumed" />
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                                    </form>
                                    @endif
                                    @if($ticket->state != 'open')
                                    <form style="display:inline-block" action="{{ route('boxoffice.change-ticket-state', ['ticket' => $ticket->random_id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="new_state" value="open" />
                                        <button type="submit" class="btn btn-info"><i class="fa fa-undo"></i></button>
                                    </form>
                                    @endif
                                    @if($ticket->state != 'no_show')
                                    <form style="display:inline-block" action="{{ route('boxoffice.change-ticket-state', ['ticket' => $ticket->random_id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="new_state" value="no_show" />
                                        <button type="submit" class="btn btn-secondary"><i class="fa fa-remove"></i></button>
                                    </form>
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

    
});
</script>
@endsection