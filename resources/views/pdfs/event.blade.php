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
    div.stage
    {
        text-align: center;
        line-height: 20px;
        font-size: 15pt;
        border: medium 1px #000;
        background-color: darkgray;
    }
    /* SeatMap-Styles */
    table.seatmap {
        border:dashed 1px #444444;
        margin-top:5mm;
    }
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
    td.no-seat {
        color:#A00;
        border: medium none #000;
    }
    td.rownumber {
        border:medium none #000000;
        width:10mm; }
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
            @php
                $rowAndSeat = $ticket->getRowAndSeat();
            @endphp
            <td>{{ $rowAndSeat['row']  }} | {{ $rowAndSeat['seat'] }}</td>
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
@php
    $rowsAndColumns = $event->seatMap->getRowsAndColumns();
    $rows = json_decode($event->seatMap->layout);
@endphp
<page orientation="L">
    <div class="stage"><span>{{__('ticketshop.stage')}}</span></div>
    <table class="seatmap" cellspacing="7px">
        @php
            $seatCounter = 0; // will be reset at the start of a new row
            $idCounter = 0;   // counts the past seat_numbers
        @endphp
        @foreach($rows as $rowId => $row)
        <tr>
            <td class="rownumber">{{ $rowId + 1 }}</td>
            @php
                $seatCounter = 0;
            @endphp
            @foreach(str_split($row) as $colId => $character)
                @if($character === 'a')
                    @php
                    $seatCounter++;
                    $idCounter++;
                    $ticket = $event->tickets()->where('seat_number', $idCounter)->first();
                    @endphp
                    <td class="paid">@if($ticket) {{ $ticket->id }} @else &nbsp; @endif</td>
                @else
                    <td class="no-seat"></td>
                @endif
            @endforeach
            {{--
                fill in blank td-elements if the first row is not the largest one 
                --> table width is calculated by the first row)
            --}}
            @if($rowId === 0 && strlen($row) < $rowsAndColumns['columns'])
            @for($i=0; $i < $rowsAndColumns['columns'] - strlen($row); $i++)
                <td class="no-seat"></td>
            @endfor
            @endif
        </tr>
        @endforeach
    </table>
</page>
@endif

<page orientation="L">
    <h3>{{__('ticketshop.overview')}}</h3>
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