<div class="media">
    <a href=""><img src="/" class="me-3" alt="">{{$user->getNameOrUserName()}}</a>

    <div class="media-body">
        <h5 class="mt-0">
            <a href="/">{{$user->getNameOrUserName()}}</a>
        </h5>
        @if ($user->location)
            <p>{{$user->location}}</p>
        @endif
    </div>
</div>
