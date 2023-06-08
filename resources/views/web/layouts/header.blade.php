{{-- <div id="preloader">
    <div class="loader"></div>
</div>
 --}}<header class="header-area">
    <div class="classy-nav-container breakpoint-off">
        <div class="container">
            <nav class="classy-navbar justify-content-between" id="conferNav">
                <a class="nav-brand" href="{{url('/')}}">
                    <img src="{{url('events/logo-event.svg')}}" alt="">
                </a>
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>
                <div class="classy-menu">
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <div class="classynav">
                        <ul id="nav">
                            <li><a href="https://{{config('plats.cws')}}">Create Event</a></li>
                            <li class="{{request()->is('solution') ? 'active' : ''}}">
                                <a href="{{route('web.solution')}}">Solutions</a>
                            </li>
                            <li class="{{request()->is('template') ? 'active' : ''}}">
                                <a href="{{route('web.template')}}">Templates</a>
                            </li>
                            <li class="{{request()->is('pricing') ? 'active' : ''}}">
                                <a href="{{route('web.pricing')}}">Pricing</a>
                            </li>
                            <li class="{{request()->is('resource') ? 'active' : ''}}">
                                <a href="{{route('web.resource')}}">Resources</a>
                            </li>
                            <li class="{{request()->is('contact') ? 'active' : ''}}">
                                <a href="{{route('web.contact')}}">Contact</a>
                            </li>
                            <li>
                                @if (auth()->guest())
                                    <a href="{{route('web.formLogin')}}">Sign In</a>
                                @else
                                    <a href="#">
                                        <i class="fa fa-user"></i>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
