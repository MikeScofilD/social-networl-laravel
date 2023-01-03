    @if (!$status->user->avatar)
        <img class="avatar" src="{{ $status->getAvatarUrl() }}" class="me-3"
            alt="{{ $status->user->getNameOrUserName() }}">
    @else
        <img class="avatar" src="{{ $status->user->getAvatarsPath($status->user->id) . $status->user->avatar }}" class="me-3"
            alt="{{ $status->user->getNameOrUserName() }}">
    @endif
