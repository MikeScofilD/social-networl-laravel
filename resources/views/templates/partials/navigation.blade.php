    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Social</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if (Auth::check())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Стена <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Друзья</a>
                    </li>
                    <form method="GET" action="{{route('search.results')}}" class="form-inline my-2 my-lg-0">
                        <input name="query" class="form-control mr-sm-2" type="search" placeholder="Поиск..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
                    </form>
                </ul>
                @endif
                <ul class="navbar-nav ml-auto">
                    @if (Auth::check())
                        <li class="nav-item"><a href="{{route('profile.index', ['username' => Auth::user()->username])}}" class="nav-link">{{Auth::user()->getNameOrUserName()}}</a></li>
                        <li class="nav-item"><a href="" class="nav-link">Обновить профиль</a></li>
                        <li class="nav-item"><a href="{{route('auth.signout')}}" class="nav-link">Выйти</a></li>
                    @else
                        <li class="nav-item"><a href="{{route('auth.signup')}}" class="nav-link">Зарегестрироватся</a></li>
                        <li class="nav-item"><a href="{{route('auth.signin')}}" class="nav-link">Войти</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
