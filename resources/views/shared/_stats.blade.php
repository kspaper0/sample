<div class="stats">
    <a href="{{ route('users.followings', $user->id) }}">
        <strong id="following" class="stat">
            {{ count($user->followings) }}
        </strong>
        <!-- $user->followings()->get() = $user->followings -->
        Followings
    </a>

    <a href="{{ route('users.followers', $user->id) }}">
        <strong id="followers" class="stat">
            {{ count($user->followers) }}
        </strong>
        Followers
    </a>

    <a href="{{ route('users.show', $user->id) }}">
        <strong id="statuses" class="stat">
            {{ $user->statuses()->count() }}
        </strong>
        <!-- Eloquent 模型的 count 方法 -->
        Blogs
    </a>
</div>