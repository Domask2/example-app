@guest
@else
    <ul class="nav navbar-nav justify-content-center">
        <li class="nav-item dropdown mr-3">
            <a class="nav-link dropdown-toggle text-info" href="#" id="navbarDropdown" role="button"
               data-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-server mr-2"></i>Базы данных
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach($databases as $item)
                    <li><a class="dropdown-item" href="{{route('db.show', $item)}}"><i
                                class="bi bi-server mr-2" style="color: orange"></i>{{$item->title}} - <i>"{{$item->key}}"</i></a></li>
                @endforeach
                @if(count($databases))
                    <li>
                        <hr class="dropdown-divider">
                    </li>@endif
                <li>
                    <a class="dropdown-item" href="{{route('db.create')}}"><i class="bi bi-plus-lg mr-2"></i>Добавить базу</a>
                </li>
            </ul>
        </li>
        @can('view', auth()->user())
            <li class="nav-item mr-3">
                <a class="nav-link text-info" href="{{route('admin')}}" role="button">
                    <i class="bi bi-code-square mr-2"></i>Админ
                </a>
            </li>
        @endcan

    </ul>
@endguest

<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link text-info" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link text-info" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-info" href="#" id="navbarDropdown" role="button"
               data-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill mr-2"></i>{{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="bi bi-x-circle mr-3"></i>Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    @endguest
</ul>
