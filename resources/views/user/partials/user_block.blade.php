<div class="media mb-2">
    <a href="{{route('profile.index', ['username' => $user->username])}}"><img class="avatar" src="{{$user->getAvatarUrl()}}" class="me-3" alt=""></a>

    <div class="media-body">
        <h5 class="mt-0">
            <a href="{{route('profile.index', ['username' => $user->username])}}">{{$user->getNameOrUserName()}}</a>
        </h5>
        @if ($user->location)
            <p>{{$user->location}}</p>
        @endif
    </div>
</div>
