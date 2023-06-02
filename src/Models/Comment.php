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


    /***
     * @param string $commentContent
     * @param integer $userId
     * @param integer $postId
     * @return pdostatement
     */
    public function create(string $commentContent, int $userId, int $postId): PDOStatement
    {
        $comment = $this->db->getPdo()->prepare("INSERT INTO comment(comment, user_id, post_id) VALUES(?, ?, ?)");
        $comment->execute([$commentContent, $userId, $postId]);
        return $comment;
    }

    public function getAll(): array
    {
        $req = $this->db->getPdo()->query("SELECT * FROM comment ORDER BY published");
        return $req->fetchAll();
    }

    /***
     * @param integer $commentId
     * @return array
     */
    public function getById(int $commentId): array
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE id = ?");
        $req->execute([$commentId]);
        $comment = $req->fetch();
        return $comment;
    }

    /***
     * @param integer $commentId
     * @return void
     */
    public function updateComment(int $commentId): void
    {
        $value = true;
        $req = $this->db->getPdo()->prepare("UPDATE comment SET published = :value WHERE id = :id");
        $req->execute([
            ':value' => $value,
            ':id' => $commentId
        ]);
    }

    /***
     * @param integer $postId
     * @return array
     */
    public function findByPostId(int $postId): array
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE post_id = ?");
        $req->execute([$postId]);
        $comment = $req->fetchAll();
        return $comment;
    }

    /***
     * @param integer $commentId
     * @return void
     */
    public function destroy(int $commentId): void
    {
        $req = $this->db->getPdo()->prepare("DELETE FROM comment WHERE id = :commentId");
        $req->execute([
            'commentId' => $commentId
        ]);
    }
}
