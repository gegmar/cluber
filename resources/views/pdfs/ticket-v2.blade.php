{{--
    A4 format --> Because all major printers support this format (=DAU-Friendly Format)
    P-ortraitmode (not L-andscape-Mode)
    white background
    Use a serif-less font
--}}
@php
$counter = 0;
$amount = count($tickets);
@endphp
@while ($counter < $amount)
<page format="A4" orientation="P" backcolor="#ffffff" style="font: Verdana, Geneva, sans-serif;">
    
    {{-- Print the first ticket on the current A4-page --}}
    @if ($counter < $amount)
    @php
        $ticket = $tickets[$counter];
        $counter++;
    @endphp
    @component('components.tickets.3-on-A4', ['ticket' => $ticket, 'topOffset' => 35])
    @endcomponent
    @endif

    {{-- Print the second ticket on the current A4-page --}}
    @if ($counter < $amount)
    @php
        $ticket = $tickets[$counter];
        $counter++;
    @endphp
    @component('components.tickets.3-on-A4', ['ticket' => $ticket, 'topOffset' => 115])
    @endcomponent
    @endif

    {{-- Print the third ticket on the current A4-page --}}
    @if ($counter < $amount)
    @php
        $ticket = $tickets[$counter];
        $counter++;
    @endphp
    @component('components.tickets.3-on-A4', ['ticket' => $ticket, 'topOffset' => 195])
    @endcomponent
    @endif

</page>
@endwhile