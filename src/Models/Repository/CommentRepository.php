<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Comment;
use PDOStatement;

class CommentRepository extends AbstractRepository
{
    public function create($commentContent, $userId, $postId): PDOStatement
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

    public function show(int $id): array
    {
        $comment = new Comment($this->db);
        $comment = $comment->getById($id);
        return $comment;
    }

    public function publish(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->updateComment($commentId);
    }

    public function getCommentFromPost(int $postId): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->findByPostId($postId);
        return $comments;
    }

    public function delete(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->destroy($commentId);
    }
}
