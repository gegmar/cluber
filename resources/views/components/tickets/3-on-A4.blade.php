<!-- Displays a single Ticket -->
{{--
    Requires to pass the $ticket variable and the top offset via the component!
    @component('components.tickets.3-on-A4', ['ticket' => $ticket, 'topOffset' => 0])
    @endcomponent
--}}
@php
$logoPath = Storage::path('images/logo-fw.png');
@endphp
<style>
    /* Remove the margin. Else texts won't fit */
    p  { margin: 0mm; }
    h1 { margin: 0mm; }
    h2 { margin: 0mm; }
</style>

{{-- Print dotted line onto the page that separates tickets --}}
<div style="position: absolute; left: 30mm; width: 150mm; height: 4mm; top: {{ $topOffset - 5 }}mm;"><hr style="border: 1px dashed black;"/></div>

{{-- The following <div> encloses a ticket. --}}
<div style="position: absolute; left: 30mm; width: 150mm; height: 70mm; top: {{ $topOffset }}mm;">
    
    {{-- Print the logo (quadratic!) into the left top corner --}}
    <div style="position: absolute; left: 0mm; top: 0mm;">
        <img src="{{ $logoPath }}" alt="logo" style="height: 20mm;">
    </div>

    {{-- Beside the Logo core facts of the event are displayed --}}
    <div style="position: absolute; left: 40mm; top: 0mm;">
        <h1>{{ $ticket->event->project->name }}</h1>
        <h2>{{ $ticket->event->second_name }}</h2>
        <p><b>{{__('ticketshop.valid_from')}} @datetime($ticket->event->start_date) @time($ticket->event->start_date)</b></p>
        @if( $ticket->event->seatMap->layout !== null)
        <p>
            {{__('ticketshop.row')}} <b>{{ (int)ceil($ticket->seat_number / 18)  }}</b>, {{__('ticketshop.seat')}} <b>{{ 19- ( $ticket->seat_number % 18 != 0 ? $ticket->seat_number % 18 : 18) }}</b> ({{ $ticket->seat_number}})
        </p>
        @endif
    </div>

    {{-- Show the ticket id under the logo. This is the most important information, since the box office uses it to tick of shown-up visitors --}}
    <div style="position: absolute; top: 30mm;">
        <h1>#{{ $ticket->id }}</h1>
    </div>

    {{-- Display information about the location in the left bottom corner --}}
    <div style="position:absolute; left: 0mm; bottom: 0mm; width: 40mm;">
        <p>{{__('ticketshop.location')}}: <b>{{ $ticket->event->location->name }}</b></p>
        <p>{{__('ticketshop.address')}}: <b>{{ $ticket->event->location->address }}</b></p>
    </div>

    {{-- Add the buyer's information beside the integrity code --}}
    <div style="position: absolute; right: 20mm; bottom: 0mm; text-align: right;">
        <table>
            @if($ticket->purchase->customer_id != null)
            <tr>
                <td>{{__('ticketshop.customer')}}:</td>
                <td>@if ( $ticket->purchase->customer_name != null ) {{ $ticket->purchase->customer_name }} @else {{ $ticket->purchase->customer->name }} @endif</td>
            </tr>
            @endif
            <tr>
                <td>{{__('ticketshop.price')}}:</td>
                <td>{{ $ticket->priceCategory->price }} € ({{ $ticket->priceCategory->name }})</td>
            </tr>
            <tr>
                <td>{{__('ticketshop.bought_on')}}:</td>
                <td>@datetime($ticket->purchase->state_updated) @time($ticket->purchase->state_updated)</td>
            </tr>
            <tr>
                <td>{{__('ticketshop.vendor')}}:</td>
                <td>{{ $ticket->purchase->vendor->name }}</td>
            </tr>
            <tr>
                <td>{{__('ticketshop.purchase_id')}}:</td>
                <td>{{ $ticket->purchase->id }}</td>
            </tr>
        </table>
    </div>

    {{-- Put the qrcode into the right botton corner of the ticket --}}
    <div style="position: absolute; right: 0mm; bottom: 0mm;">
        <qrcode value="{{ route('ticket.show', $ticket) }}" ec="Q" style="width: 17mm; border: none;"></qrcode>
    </div>

</div>
{{-- 
    We need to use the style-tag to adjust the tickets and not classes, because classes get overriden by each other.    
--}}