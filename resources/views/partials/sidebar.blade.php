<nav class="sidebar sidebar-offcanvas" id="sidebar">
    @if(Auth::check())
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image"><img src="{{asset('images/user.png')}}" alt="image"/></div>
                <div class="profile-name">
                    @if(Auth::check())
                        <p class="name">{{Auth::user()->firstname}}</p>
                        <p class="designation">{{ucfirst(Auth::user()->getRoleNames()[0])}}</p>
                    @endif
                    {{--<div class="badge badge-teal mx-auto mt-3">Online</div>--}}
                </div>
            </div>
        </li>
        @if(Auth::user()->hasRole('admin'))
            <li class="nav-item"><a class="nav-link" href="{{url('products')}}">
                <img class="menu-icon" src="{{asset('images/menu_icons/01.png')}}" alt="menu icon"><span class="menu-title">Products</span></a>
        </li>
            <li class="nav-item"><a class="nav-link" href="{{url('storekeepers')}}">
                <img class="menu-icon" src="{{asset('images/menu_icons/01.png')}}" alt="menu icon"><span class="menu-title">Store keepers</span></a>
        </li>

            </li>
            <li class="nav-item"><a class="nav-link" href="{{url('audit/storekeepers')}}">
                <img class="menu-icon" src="{{asset('images/menu_icons/01.png')}}" alt="menu icon"><span class="menu-title">Audit Store keepers</span></a>
        </li>
        @endif
        @if(Auth::check())
        <li class="nav-item purchase-button d-xs-block d-none">
            {{--<a class="nav-link" href="{{ route('logout') }}"--}}
               {{--onclick="event.preventDefault();--}}
               {{--document.getElementById('logout-form').submit();">--}}
                {{--{{ __('Logout') }}--}}
            {{--</a>--}}
            {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                {{--@csrf--}}
            {{--</form>--}}
        </li>
            @endif

        @if(Auth::user()->hasRole('superagent'))
            <li class="nav-item"><a class="nav-link" href="{{url('storekeeper/products')}}">
                    <img class="menu-icon" src="{{asset('images/menu_icons/01.png')}}" alt="menu icon"><span class="menu-title">Products</span></a>
            </li>
            @endif

        @if(Auth::user()->hasRole('auditor'))
            <li class="nav-item"><a class="nav-link" href="{{url('audit/storekeepers')}}">
                    <img class="menu-icon" src="{{asset('images/menu_icons/01.png')}}" alt="menu icon"><span class="menu-title">Audit Store keepers</span></a>
            </li>
            @endif
    </ul>
        @endif
</nav>