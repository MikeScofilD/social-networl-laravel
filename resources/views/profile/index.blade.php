@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            @include('user.partials.user_block')
            <hr>
            @if (Auth::user()->id === $user->id)
                <form action="{{ route('profile.upload-avatar', ['username' => Auth::user()->username]) }}" class="my-4"
                    enctype="multipart/form-data" method="POST">
                    @csrf
                    <label for="">Загрузить аватар</label>
                    <input type="file" name="avatar" id="avatar">
                    <input type="submit" value="Загрузить" class="btn btn-primary" name="" id="">
                </form>
            @endif
            @if (!$statuses->count())
                <p>{{ $user->getFirstNameOrUserName() }} Пока ничего не опубликовал</p>
            @else
                @foreach ($statuses as $status)
                    <div class="media">
                        {{-- {{dd($status->user->username)}} --}}
                        <a href="{{ route('profile.index', ['username' => $status->user->username]) }}" class="mr-3">
                            @include('user.partials.avatar')
                        </a>
                        <div class="media-body">
                            <h4><a
                                    href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUserName() }}</a>
                            </h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
                                @if ($status->user->id !== Auth::user()->id)
                                    <li class="list-inline-item">
                                        {{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count()) }}
                                    </li>
                                @endif
                                <li class="list-inline-item">{{ $status->likes()->count() }}
                                    {{ Str::plural('like', $status->likes->count()) }}</li>
                            </ul>
                            @foreach ($status->replies as $reply)
                                <div class="media">
                                    {{-- {{dd($status->user->username)}} --}}
                                    <a href="{{ route('profile.index', ['username' => $reply->user->username]) }}"
                                        class="mr-3"><img class="media-object rounded avatar"
                                            src="{{ $reply->user->getAvatarUrl() }}"
                                            alt="{{ $reply->user->getNameOrUserName() }}"></a>
                                    <div class="media-body">
                                        <h4><a
                                                href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUserName() }}</a>
                                        </h4>
                                        <p>{{ $reply->body }}</p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
                                            @if ($reply->user->id !== Auth::user()->id)
                                                <li class="list-inline-item"><a
                                                        href="{{ route('status.like', ['statusId' => $reply->id]) }}">Лайк</a>
                                                </li>
                                            @endif
                                            <li class="list-inline-item">{{ $reply->likes()->count() }}
                                                {{ Str::plural('like', $reply->likes->count()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                            @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                                <form action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="POST"
                                    class="mb-4">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="reply-{{ $status->id }}" id="" cols="10" rows="2"
                                            class="form-control {{ $errors->has("reply-{$status->id}") ? 'is-invalid' : '' }}" placeholder="Прокоментировать"
                                            rows="3"></textarea>
                                        @if ($errors->has("reply-{$status->id}"))
                                            <div class="invalid-feedback">
                                                {{ $errors->first("reply-{$status->id}") }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Ответить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                {{-- {{ $statuses->links() }}  --}}
            @endif
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if (Auth::user()->hasFriendRequestsPending($user))
                <p>В ожидании {{ $user->getFirstNameOrUserName() }} подтверждения запроса в друзья</p>
            @elseif (Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route('friend.accept', ['username' => $user->username]) }}"
                    class="btn btn-primary mb-2">Подтвердить дружбу</a>
            @elseif (Auth::user()->isFriendWith($user))
                {{ $user->getFirstNameOrUserName() }} у вас в друзьях

                <form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="POST">
                    @csrf
                    <input type="submit" name="" id="" class="btn btn-primary my-2"
                        value="Удалить из друзей">
                </form>
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary mb-2">Добавить
                    в
                    друзья</a>
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
