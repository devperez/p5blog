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

    public function index(): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->getAll();
        
        return $comments;
    }

    public function show(int $id)
    {
        $comment = new Comment($this->db);
        $comment = $comment->getById($id);
        return $comment;
    }

    public function publish(int $commentId)
    {
        $comment = new Comment($this->db);
        $comment = $comment->updateComment($commentId);
    }
}
