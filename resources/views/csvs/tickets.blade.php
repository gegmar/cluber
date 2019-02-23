id;price;category;state;project;event;event_date;paid_at;customer;vendor
@foreach($events as $event)
@foreach($event->tickets as $ticket)
{{ $ticket->id }};{{ $ticket->price() }};{{ $ticket->priceCategory->name }};{{ $ticket->purchase->state }};{{ $ticket->event->project->name }};{{ $ticket->event->second_name }};{{ $ticket->event->start_date}};{{ $ticket->purchase->state_updated}};{{ $ticket->purchase->customer_id === null ? $ticket->purchase->customer_name : $ticket->purchase->customer->email }};{{$ticket->purchase->vendor->name}}
@endforeach
@endforeach