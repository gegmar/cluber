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
<span style="font-size: 20px; font-weight: bold;">Tickets overview<br></span>
<br>
<br>
<table>
    <colgroup>
        <col style="width: 5%" class="col1">
        <col style="width: 30%">
        <col style="width: 25%">
        <col style="width: 30%">
        <col style="width: 10%">
    </colgroup>
    <thead>
        <tr>
            <th rowspan="2">ID</th>
            <th colspan="4" style="font-size: 16px;">
                {{$event->project->name}} | {{ $event->second_name }}
            </th>
        </tr>
        <tr>
            <th>Shop</th>
            <th>Owner</th>
            <th>Price Category (Price€)</th>
            <th>Arrived?</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
        <tr class="border-bottom">
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->purchase->vendor->name }}</td>
            <td>@if($ticket->purchase->customer){{ $ticket->purchase->customer->name}} @elseif($ticket->purchase->customer_name) {{ $ticket->purchase->customer_name }} @else Shop Customer @endif</td>
            <td>{{$ticket->priceCategory->name}} ({{ $ticket->priceCategory->price}} €)</td>
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