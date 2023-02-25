@extends('layouts.app')

@section('site-content')
<div class="page">
    <!-- Main Navbar-->
    @component('components.header')
    @endcomponent
    <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        @auth
        @component('components.nav')
        @endcomponent
        @endauth
        <div class="content-inner" @guest style="width:100%" @endguest>
            <div id="navbar-link" data-link="@yield('nav-link')"></div>
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">@yield('page-title')</h2>
                </div>
            </header>
            @if(config('app.shopping_cart_notification'))
            @component('components.notification')
            <strong><i class="fa fa-info-circle"></i></strong> Dieser Onlineshop unterstützt keinen Warenkorb. Bitte kaufen Sie Ihre Tickets je Veranstaltung.
            @endcomponent
            @endif
            @if(config('app.corona_notification'))
            @component('components.notification')
            <strong><i class="fa fa-info-circle"></i></strong> Sehr geehrte Theaterfreunde, aufgrund von Corona-Erkrankungen müssen wir die ersten beiden Termine am 3. und 4. März 2023 absagen. Informationen zur Rückerstattung von bereits erworbenen Karten finden Sie auf unsere Website unter <a href="https://www.theater-frei-wild.at">www.theater-frei-wild.at</a>.
            @endcomponent
            @endif
            <!-- Dashboard Counts Section-->
            @yield('content')

            @component('components.footer')
            @endcomponent
        </div>
    </div>
</div>
@endsection