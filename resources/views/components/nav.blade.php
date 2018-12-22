<!-- Active-Link will be set by js in front.js -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    @component('components.profile')
    @endcomponent
    <!-- Sidebar Navidation Menus--><span class="heading">Customer</span>
    <ul class="list-unstyled">
        <li><a href="{{ route('laystart') }}"> <i class="fa fa-ticket"></i>Tickets </a></li>
    </ul><span class="heading">Backoffice</span>
    <ul class="list-unstyled">
        <li><a href="#retailDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-shopping-cart"></i>Retail
            </a>
            <ul id="retailDropdown" class="collapse list-unstyled ">
                <li><a href="{{ route('layselltick') }}"><i class="fa fa-eur"></i>Sell Tickets</a></li>
                <li><a href="{{ route('laysoldtick') }}"><i class="fa fa-history"></i>Sold Tickets</a></li>
            </ul>
        </li>
        <li><a href="#eventsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-calendar"></i>Events
            </a>
            <ul id="eventsDropdown" class="collapse list-unstyled ">
                <li><a href="#"> <i class="fa fa-area-chart"></i>Dashboard</a></li>
                <li><a href="#"><i class="fa fa-th"></i>Block Seats</a></li>
            </ul>
        </li>
    </ul><span class="heading">Admin</span>
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
</nav>