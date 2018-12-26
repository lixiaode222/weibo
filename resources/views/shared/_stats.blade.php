<a href="#">
    <strong id="following" class="stat">
        {{ count($user->followings) }}
    </strong>
    关注
</a>

<a href="#">
    <strong id="follwers" class="stat">
        {{ count($user->followers) }}
    </strong>
    粉丝
</a>

<a href="#">
    <strong id="statuses" class="stat">
        {{ count($user->statuses) }}
    </strong>
    微博
</a>