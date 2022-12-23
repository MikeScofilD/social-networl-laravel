@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            @include('user.partials.user_block')
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if (Auth::user()->hasFriendRequestsPending($user))
                <p>В ожидании {{ $user->getFirstNameOrUserName() }} подтверждения запроса в друзья</p>
            @elseif (Auth::user()->hasFriendRequestReceived($user))
                <a href="" class="btn btn-primary mb-2">Подтвердить дружбу</a>
            @elseif (Auth::user()->isFriendWith($user))
                {{ $user->getFirstNameOrUserName() }} у вас в друзьях
            @else
                <a href="" class="btn btn-primary mb-2">Добавить в друзья</a>
            @endif
            <h3>{{ $user->getFirstNameOrUserName() }} Друзья: </h3>

            @if (!$user->friends()->count())
                <h3>{{ $user->getFirstNameOrUserName() }} Нет друзей.</h3>
            @else
                @foreach ($user->friends() as $user)
                    @include('user.partials.user_block')
                @endforeach
            @endif
        </div>
    </div>
@endsection
