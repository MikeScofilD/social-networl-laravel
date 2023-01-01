@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form method="post" action="{{ route('status.post') }}">
                @csrf
                <div class="form-group">
                    <textarea name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                        placeholder="Что нового {{ Auth::user()->getFirstNameOrUserName() }}" name="" id="" cols="30"
                        rows="10"></textarea>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('status') }}
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Опубликовать</button>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            @if (!$statuses->count())
                <p>Нет ни одной записи</p>
            @else
                @foreach ($statuses as $status)
                    <div class="media">
                        {{-- {{dd($status->user->username)}} --}}
                        <a href="{{ route('profile.index', ['username' => $status->user->username]) }}" class="mr-3"><img
                                class="media-object rounded avatar" src="{{ $status->user->getAvatarUrl() }}"
                                alt="{{ $status->user->getNameOrUserName() }}"></a>
                        <div class="media-body">
                            <h4><a
                                    href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUserName() }}</a>
                            </h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
                                @if ($status->user->id !== Auth::user()->id)
                                    <li class="list-inline-item"><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Лайк</a></li>
                                @endif
                                 <li class="list-inline-item">{{$status->likes()->count()}} {{Str::plural('like', $status->likes->count())}}</li>
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
                                                <li class="list-inline-item"><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Лайк</a></li>
                                            @endif
                                              <li class="list-inline-item">{{$reply->likes()->count()}} {{Str::plural('like', $reply->likes->count())}}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
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
                        </div>
                    </div>
                @endforeach
                {{ $statuses->links() }}
            @endif
        </div>
    </div>
@endsection
