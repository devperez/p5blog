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

    public function show($id)
    {
        $comment = new Comment($this->db);
        $comment = $comment->findById($id);
        return $comment;
    }
}
