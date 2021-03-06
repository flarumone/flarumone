<?php
$discussion = $document->data;
$postsCount = count($discussion->relationships->posts->data);
?>
<div class="container">
    <h2>{{ $discussion->attributes->title }}</h2>

    <div>
        @foreach ($posts as $post)
            <div>
                <?php $user = $getResource($post->relationships->user->data); ?>
                <h3>{{ $user ? $user->attributes->username : '[deleted]' }}</h3>
                <div class="Post-body">
                    {!! $post->attributes->contentHtml !!}
                </div>
            </div>

            <hr>
        @endforeach
    </div>

    @if ($page > 1)
        <a href="{{ $url(['page' => $page - 1]) }}">&laquo; Previous Page</a>
    @endif

    @if ($page < $postsCount / 20)
        <a href="{{ $url(['page' => $page + 1]) }}">Next Page &raquo;</a>
    @endif
</div>
