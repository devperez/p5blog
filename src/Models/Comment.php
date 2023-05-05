<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDOStatement;

class Comment extends Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    public function create($commentContent, $userId, $postId): PDOStatement
    {
        //var_dump($comment, $userId, $postId);
        $comment = $this->db->getPdo()->prepare("INSERT INTO comment(comment, user_id, post_id) VALUES(?, ?, ?)");
        $comment->execute([$commentContent, $userId, $postId]);
        return $comment;
    }
}
