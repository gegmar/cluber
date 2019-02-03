@component('mail::message')
# {{__('mail.your-tickets')}}

{{__('mail.thanks4buying-tickets')}}

@component('mail::button', ['url' => route('ticket.purchase', ['purchase' => $purchase]), 'color' => 'success'])
{{__('mail.view-online')}}
@endcomponent

{{__('thanks')}}<br>
{{ config('app.name') }}
@endcomponent
