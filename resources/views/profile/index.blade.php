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
                <a href="{{route('friend.accept', ['username' => $user->username])}}" class="btn btn-primary mb-2">Подтвердить дружбу</a>
            @elseif (Auth::user()->isFriendWith($user))
                {{ $user->getFirstNameOrUserName() }} у вас в друзьях

                <form action="{{route('friend.delete', ['username' => $user->username])}}" method="POST">
                    @csrf
                    <input type="submit" name="" id="" class="btn btn-primary my-2" value="Удалить из друзей">
                </form>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{route('friend.add', ['username'=>$user->username])}}" class="btn btn-primary mb-2">Добавить в друзья</a>
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
