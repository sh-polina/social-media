<?php

namespace App\Services;

use App\Models\Likes;
use App\Models\UserPost;

class LikeManager
{
    public function __construct(private readonly int $userId)
    {

    }

    public function likePost(UserPost $post): void
    {
        $like = new Likes();
        $like->post_id = $post->id;
        $like->user_id = $this->userId;

        $like->save();
    }

    public function unlikePost(UserPost $post): void
    {
        Likes::where('user_id', $this->userId)->where('post_id', $post->id)->delete();
    }

    public function isPostLiked(UserPost $post): bool
    {
        return Likes::where('user_id', $this->userId)->where('post_id', $post->id)->exists();
    }
}
