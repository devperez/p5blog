<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Comment;

class CommentRepository extends AbstractRepository
{
    public function create($commentContent, $userId, $postId)
    {
        $comment = new Comment($this->db);
        $comment = $comment->create($commentContent, $userId, $postId);
        return $comment;
    }
}
