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
    /* SeatMap-Styles */
    table.seatmap { border:dashed 1px #444444;margin-top:5mm;margin-left:10mm;}
    table.seatmap td {
        font-size:15pt;
        font-weight:bold;
        border:solid 1px #000000;
        padding:1px;
        text-align:center;
        width:30px;
        height:30px;
    }
    td.paid { color:#0A0;}
    td.reserved { color:#A00; }
    td.cstummer { background-color:#123; }
    rownumber { border:solid 1px #000000;width:10mm; }
    seatnumber { border:solid 1px #000000;width:50px; }
</style>
<span style="font-size: 20px; font-weight: bold;">{{__('ticketshop.tickets-overview')}}<br></span>
<br>
<br>
<table>
    <colgroup>
        <col style="width: 5%" class="col1">
        <col style="width: 5%">
        <col style="width: 20%">
        <col style="width: 20%">
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
            <th rowspan="2">#</th>
            <th rowspan="2">ID</th>
            @if($event->seatMap->layout)
            <th colspan="6" style="font-size: 16px;">
            @else
            <th colspan="5" style="font-size: 16px;">
            @endif
                {{$event->project->name}} | {{ $event->second_name }} | @datetime($event->start_date) @time($event->start_date)
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
        {{-- Add an index in the first row to give a better overview --}}
        @php
            $index = 0;
        @endphp

        {{-- List all tickets from pre-event sales (onlineshop and shop customers) --}}
        @foreach($tickets as $ticket)
        @php
            $index++;
        @endphp
        <tr class="border-bottom">
            <td>{{ $index }}</td>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->purchase->vendor->name }}</td>
            <td>@if($ticket->purchase->customer_name) {{ $ticket->purchase->customer_name }} @elseif($ticket->purchase->customer){{ $ticket->purchase->customer->name}} @else {{__('ticketshop.shop-customer')}} @endif</td>
            <td>{{$ticket->priceCategory->name}} ({{ $ticket->priceCategory->price}} €)</td>
            @if($event->seatMap->layout)
            <td>{{ (int)ceil($ticket->seat_number / 18)  }} | {{ 19- ( $ticket->seat_number % 18 != 0 ? $ticket->seat_number % 18 : 18) }}</td>
            @endif
            <td>{{ __('ticketshop.'.$ticket->purchase->state)}}</td>
            <td></td>
        </tr>
        @endforeach

        {{--
            Add empty lines to allow box office entering their sales.
            This shall also grant that they always have an overview on
            how many tickets are still available. Also print 10% more
            additional lines than available for possible overbookings.
        --}}
        @for (; $index <= ($event->seatMap->seats * 1.1); $index++)
        <tr class="border-bottom">
            <td>{{ $index }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @if($event->seatMap->layout)
            <td></td>
            @endif
            <td></td>
            <td></td>
        </tr>
        @endfor
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="font-size: 16px;">
                
            </th>
        </tr>
    </tfoot>
</table>

@if($event->seatMap->layout)
<!-- 
	Event Seatmap
-->
<page orientation="paysage">
    <div class="stage"><span>B&uuml;hne</span></div>
	<table class="seatmap" cellspacing="7px">
		@for($row = 1; $row < 8; $row++)
		<tr>
			<td class="rownumber">R {{ $row }}</td>
            @for ($seatInRow = 1; $seatInRow < 19 ; $seatInRow++)
            @php
            $seatNumber = $seatInRow + ($row - 1) *18;
            $ticket = $event->tickets()->where('seat_number', $seatNumber)->first();
            @endphp
            <td class="@if($ticket) paid @endif">@if($ticket) {{ $ticket->id }} @else &nbsp; @endif</td>
			@endfor
		</tr>
		@endfor
		<tr class="seatnumber">
			<td>&nbsp;</td>
			@for($seatInRow = 18; $seatInRow > 0; $seatInRow--)
			<td> {{ $seatInRow }}</td>
			@endfor
		</tr>
	</table>
</page>
@endif

<page orientation="paysage">
    <h3>Übersicht</h3>
    <h4>{{$event->project->name}} | {{ $event->second_name }} | @datetime($event->start_date) @time($event->start_date)</h4>
    <table cellspacing="7px">
        <thead>
            <tr>
                <th>{{__('ticketshop.shop')}}</th>
                <th>{{__('ticketshop.price-category')}}</th>
                <th>{{__('ticketshop.price')}} <i class="fa fa-eur"></i></th>
                <th>{{__('ticketshop.paid')}}</th>
                <th>{{__('ticketshop.reserved')}}</th>
                <th>{{__('ticketshop.free-tickets')}}</th>
                <th>{{__('ticketshop.sums')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overview as $row)
            <tr>
                <td>{{ $row->vendor }}</td>
                <td>{{ $row->category }}</td>
                <td>{{ $row->price }}</td>
                <td>{{ $row->paid }}</td>
                <td>{{ $row->reserved }}</td>
                <td>{{ $row->free }}</td>
                <td>{{ $row->sum }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @foreach($sums as $row)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $row->paid }}</th>
                <th>{{ $row->reserved }}</th>
                <th>{{ $row->free }}</th>
                <th><strong>{{ $row->sum }}</strong></th>
            </tr>
            @endforeach
        </tfoot>
    </table>
</page>