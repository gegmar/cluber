<!-- Page Footer-->
<footer class="main-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <p>{{ config('app.owner') }} &copy; 2019</p>
            </div>
            <div class="col-sm-4">
                <p><a href="{{ route('impress') }}">{{__('ticketshop.impress')}}</a> | <a href="{{ route('terms') }}">{{ __('ticketshop.terms')}}</a>
                    | <a href="{{ route('privacy') }}">{{ __('ticketshop.privacy')}}</a></p>
            </div>
            <div class="col-sm-4 text-right">
                <p>{{__('ticketshop.version')}} {{ config('app.version') }}</p>
            </div>
        </div>
    </div>
</footer>