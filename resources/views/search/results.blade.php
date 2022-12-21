@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h1>Результаты поиска: {{ Request::input('query') }}</h1>
            @if (!$users->count())
                <p>Пользователь не найден</p>
            @else
                <div class="row">
                    <div class="col-lg-6">
                        @foreach ($users as $user)
                            @include('user.partials.user_block')
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
