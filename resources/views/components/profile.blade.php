@auth
<div class="sidebar-header d-flex align-items-center"><a href="{{ route('profile.show') }}">
        <div class="avatar"><img src="/img/avatar_default.png" alt="..." class="img-fluid rounded-circle"></div>
    </a>
    <div class="title">
        <h1 class="h4">{{ auth()->user()->name }}</h1>
        <p><a href="{{ route('profile.show') }}">{{__('ticketshop.profile')}}</a></p>
    </div>
</div>
@endauth