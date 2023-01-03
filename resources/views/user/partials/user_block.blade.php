<div class="media mb-2">
    <a href="{{ route('profile.index', ['username' => $user->username]) }}">
        @if (!$user->avatar)
            <img class="avatar" src="{{ $user->getAvatarUrl() }}" class="me-3" alt="">
        @else
            <img class="avatar" src="{{ $user->getAvatarsPath($user->id) . $user->avatar}}" class="me-3" alt="">
        @endif
    </a>

    <div class="media-body">
        <h5 class="mt-0">
            <a href="{{ route('profile.index', ['username' => $user->username]) }}">{{ $user->getNameOrUserName() }}</a>
        </h5>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
