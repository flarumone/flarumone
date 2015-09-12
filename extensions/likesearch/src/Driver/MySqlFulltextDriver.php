<?php namespace S12g\LikeSearch\Driver;

use Flarum\Core\Posts\Post;
use Flarum\Core\Discussions\Search\Fulltext\Driver;

class MySqlFulltextDriver implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function match($string)
    {
        $discussionIds = Post::where('type', 'comment')
            ->where('content', 'like', "%$string%")
            ->lists('discussion_id', 'id');

        $relevantPostIds = [];

        foreach ($discussionIds as $postId => $discussionId) {
            $relevantPostIds[$discussionId][] = $postId;
        }

        return $relevantPostIds;
    }
}
