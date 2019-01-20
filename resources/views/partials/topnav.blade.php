<nav class="navbar col-lg-12 col-12 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('/')}}"><img src="{{asset('images/wyzinventory.png')}}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="{{url('/')}}"><img src="{{asset('images/wyzinventory.png')}}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle" id="accountDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="{{asset('images/user.png')}}" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="accountDropdown">
                    {{--<a class="dropdown-item"> Change Password </a>--}}
                    <a class="dropdown-item"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"
                    > Sign Out </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>