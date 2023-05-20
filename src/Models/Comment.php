<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;
use PDOStatement;

class Comment extends Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    public function create($commentContent, $userId, $postId): PDOStatement
    {
        $comment = $this->db->getPdo()->prepare("INSERT INTO comment(comment, user_id, post_id) VALUES(?, ?, ?)");
        $comment->execute([$commentContent, $userId, $postId]);
        return $comment;
    }

    public function getAll()
    {
        $req = $this->db->getPdo()->query("SELECT * FROM comment ORDER BY published");
        return $req->fetchAll();
    }

    public function getById($id)
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE id = ?");
        $req->execute([$id]);
        $comment = $req->fetch();
        return $comment;
    }

    public function updateComment(int $commentId)
    {
        $value = true;
        $req = $this->db->getPdo()->prepare("UPDATE comment SET published = :value WHERE id = :id");
        $req->execute([
            ':value' => $value,
            ':id' => $commentId
        ]);
    }

    public function findByPostId($postId)
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE post_id = ?");
        $req->execute([$postId]);
        $comment = $req->fetchAll();
        return $comment;
    }

    public function destroy($commentId)
    {
        $req = $this->db->getPdo()->prepare("DELETE FROM comment WHERE id = :commentId");
        $req->execute([
            'commentId' => $commentId
        ]);
    }
}
