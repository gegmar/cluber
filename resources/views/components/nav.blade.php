<!-- Active-Link will be set by js in front.js -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    @component('components.profile')
    @endcomponent

    @if(Auth::user() == null || !Auth::user()->hasPermission('SELL_TICKETS'))
    <!-- Sidebar Navidation Menus-->
    <span class="heading">{{__('ticketshop.shop')}}</span>
    <ul class="list-unstyled">
        <li><a href="{{ route('ts.events') }}"> <i class="fa fa-ticket"></i>{{__('ticketshop.tickets')}}</a></li>
    </ul>
    @endif

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
        <li><a href="{{ route('boxoffice.dashboard') }}"> <i class="fa fa-ticket"></i> {{__('ticketshop.box_office')}}</a></li>
        <li><a href="#"> <i class="fa fa-calculator"></i> {{__('ticketshop.final_bill')}}</a></li>
    </ul>
    @endif

    @if(Auth::user()->hasPermission('SUPERVISE'))
    <!-- Supervision links -->
    <span class="heading">{{__('ticketshop.supervision')}}</span>
    <ul class="list-unstyled">
        <li><a href="#analysisDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart"></i>{{__('ticketshop.analysis')}}
            </a>
            <ul id="analysisDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('supervision.dashboard') }}"><i class="fa fa-tasks"></i>{{__('ticketshop.projects')}}</a></li>
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