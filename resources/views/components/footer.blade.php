<!-- Page Footer-->
<footer class="main-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <p>{{ config('app.owner') }} &copy; {{ date_format(new \DateTime, 'Y')}}</p>
            </div>
            <div class="col-sm-4">
                <p><a target="_blank" href="{{ route('impress') }}">{{__('ticketshop.impress')}}</a> | <a target="_blank" href="{{ route('terms') }}">{{ __('ticketshop.terms')}}</a>
                    | <a target="_blank" href="{{ route('privacy') }}">{{ __('ticketshop.privacy')}}</a></p>
            </div>
            <div class="col-sm-4 text-right">
                <p>{{__('ticketshop.version')}} {{ config('app.version') }}</p>
            </div>
        </div>
    </div>
</footer>