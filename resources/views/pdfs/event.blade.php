<style type="text/css">
table
{
    width:  100%;
    border: solid 1px #000;
}
th
{
    text-align: center;
    /*border: solid 1px #113300;
    background: #EEFFEE;*/
}
td
{
    text-align: left;
    border-top: solid 1px #000;
    border-right: solid 1px #000;
}
</style>
<span style="font-size: 20px; font-weight: bold;">{{__('ticketshop.tickets-overview')}}<br></span>
<br>
<br>
<table>
    <colgroup>
        <col style="width: 5%" class="col1">
        <col style="width: 20%">
        <col style="width: 25%">
        @if($event->seatMap->layout)
        <col style="width: 20%">
        <col style="width: 10%">
        @else
        <col style="width: 30%">
        @endif
        <col style="width: 15%">
        <col style="width: 5%">
    </colgroup>
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            @if($event->seatMap->layout)
            <th colspan="6" style="font-size: 16px;">
            @else
            <th colspan="5" style="font-size: 16px;">
            @endif
                {{$event->project->name}} | {{ $event->second_name }}
            </th>
        </tr>
        <tr>
            <th>{{__('ticketshop.shop')}}</th>
            <th>{{__('ticketshop.owner')}}</th>
            <th>{{__('ticketshop.price-category')}} ({{__('ticketshop.price')}} <i class="fa fa-eur"></i>)</th>
            @if($event->seatMap->layout)
            <th>{{__('ticketshop.row')}} | {{__('ticketshop.seat')}}</th>
            @endif
            <th>{{__('ticketshop.state')}}</th>
            <th>{{__('ticketshop.arrived')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr class="border-bottom">
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->purchase->vendor->name }}</td>
            <td>@if($ticket->purchase->customer_name) {{ $ticket->purchase->customer_name }} @elseif($ticket->purchase->customer){{ $ticket->purchase->customer->name}} @else {{__('ticketshop.shop-customer')}} @endif</td>
            <td>{{$ticket->priceCategory->name}} ({{ $ticket->priceCategory->price}} €)</td>
            @if($event->seatMap->layout)
            <td>{{ (int)ceil($ticket->seat_number / 18)  }} | {{ $ticket->seat_number % 18 }}</td>
            @endif
            <td>{{ __('ticketshop.'.$ticket->purchase->state)}}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="font-size: 16px;">
                
            </th>
        </tr>
    </tfoot>
</table>