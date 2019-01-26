@component('mail::message')
# Your Tickets

Thank you for your purchase! You can find your tickets attached to this email and by clicking the following button.

@component('mail::button', ['url' => route('ticket.purchase', ['purchase' => $purchase]), 'color' => 'success'])
View purchase online
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
