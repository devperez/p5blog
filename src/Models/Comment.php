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
     * This function stores a new comment in the database
     *
     * @param string $commentContent the content of the comment
     * @param integer $userId the id of the user
     * @param integer $postId the id of the post
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
     * This function fetches a comment using its id
     *
     * @param integer $commentId the id of the comment
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
     * This function updates a comment in the database using its id
     *
     * @param integer $commentId the id of the comment
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
     * This function fetches all comments related to a post using the id of the post
     *
     * @param integer $postId the id of the post
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
     * This function deletes a comment in the database using its id
     *
     * @param integer $commentId the id of the commment
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
