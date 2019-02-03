<!-- Active-Link will be set by js in front.js -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    @component('components.profile')
    @endcomponent

    <!-- Sidebar Navidation Menus-->
    <span class="heading">{{__('ticketshop.shop')}}</span>
    <ul class="list-unstyled">
        <li><a href="{{ route('ts.events') }}"> <i class="fa fa-ticket"></i>{{__('ticketshop.tickets')}}</a></li>
    </ul>

    @auth

    @if(Auth::user()->hasPermission('SELL_TICKETS'))
    <!-- Backoffice links -->
    <span class="heading">{{__('ticketshop.backoffice')}}</span>
    <ul class="list-unstyled">
        <li><a href="#retailDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-shopping-cart"></i>{{__('ticketshop.retail')}}
            </a>
            <ul id="retailDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('retail.sell.events') }}"><i class="fa fa-eur"></i>{{__('ticketshop.sell_tickets')}}</a></li>
                <li><a href="{{ route('retail.sold.tickets') }}"><i class="fa fa-history"></i>{{__('ticketshop.sold_tickets')}}</a></li>
            </ul>
        </li>
        <li><a href="#eventsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-calendar"></i>{{__('ticketshop.events')}}
            </a>
            <ul id="eventsDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('events.dashboard') }}"> <i class="fa fa-area-chart"></i>{{__('ticketshop.dashboard')}}</a></li>
                {{-- <li><a href="#"><i class="fa fa-th"></i>Block Seats</a></li> --}}
            </ul>
        </li>
    </ul>
    @endif

    @if(Auth::user()->hasPermission('ADMINISTRATE'))
    <!-- Admin links -->
    <span class="heading">Admin</span>
    <ul class="list-unstyled">
        <li><a href="#adminDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-cogs"></i>Administration
            </a>
            <ul id="adminDropdown" class="collapse list-unstyled ">
                <li><a href="#">Events & Projects</a></li>
                <li><a href="#">SeatMaps & PriceTables</a></li>
                <li><a href="#">Archive</a></li>
                <li><a href="#">RightsMgmt</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </li>
    </ul>
    @endif

    @endauth
</nav>