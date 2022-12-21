<div class="media mb-2">
    <a href=""><img class="avatar" src="{{$user->getAvatarUrl()}}" class="me-3" alt=""></a>

    <div class="media-body">
        <h5 class="mt-0">
            <a href="/">{{$user->getNameOrUserName()}}</a>
        </h5>
        @if ($user->location)
            <p>{{$user->location}}</p>
        @endif
    </div>
</div>
