@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Ваши друзья</h3>

            @if (!$friends->count())
                <h3>У вас нет друзей.</h3>
            @else
                @foreach ($friends as $user)
                    @include('user.partials.user_block')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h3>Запросы в друзья</h3>
            @if (!$friendRequest->count())
                <h3>У вас нет заявок в друзья.</h3>
            @else
                @foreach ($friendRequest as $user)
                    @include('user.partials.user_block')
                @endforeach
            @endif
        </div>
    </div>
@endsection
