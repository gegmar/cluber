<header class="header">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <!-- Navbar Header-->
                <div class="navbar-header">
                    <!-- Navbar Brand --><a href="index.html" class="navbar-brand d-none d-sm-inline-block">
                        <div class="brand-text d-none d-lg-inline-block">{{ config('app.name', 'Laravel') }}</div>
                        <div class="brand-text d-none d-sm-inline-block d-lg-none">
                            <!-- Shortname -->
                        </div>
                    </a>
                    <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                </div>
                <!-- Navbar Menu -->
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <!-- Languages dropdown    -->
                    @if(App::isLocale('en'))
                    <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img
                                src="/img/flags/16/GB.png" alt="{{__('lang.english')}}"><span class="d-none d-sm-inline-block">{{__('lang.english')}}</span></a>
                        <ul aria-labelledby="languages" class="dropdown-menu">
                            <li><a rel="nofollow" href="{{ route('set-locale', ['locale' => 'de']) }}" class="dropdown-item"> <img src="/img/flags/16/DE.png" alt="{{__('lang.german')}}"
                                        class="mr-2">{{__('lang.german')}}</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img
                                src="/img/flags/16/DE.png" alt="{{__('lang.german')}}"><span class="d-none d-sm-inline-block">{{__('lang.german')}}</span></a>
                        <ul aria-labelledby="languages" class="dropdown-menu">
                            <li><a rel="nofollow" href="{{ route('set-locale', ['locale' => 'en']) }}" class="dropdown-item"> <img src="/img/flags/16/GB.png" alt="{{__('lang.english')}}"
                                        class="mr-2">{{__('lang.english')}}</a></li>
                        </ul>
                    </li>
                    @endif
                    @auth
                    <!-- Logout    -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link logout">
                            <span class="d-none d-sm-inline">{{__('Login')}}</span><i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    -->
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>