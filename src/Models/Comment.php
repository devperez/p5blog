<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;
use PDOStatement;

/**
 * Model for the comments
 */
class Comment extends Model
{
    /**
     * Creates a new instance of Comment
     *
     * @param DBConnection $db The database connection
     */
    public function __construct(private readonly DBConnection $db)
    {
    }


    /**
     * Stores a new comment in the database
     *
     * @param string $commentContent The content of the comment
     * @param integer $userId The id of the user
     * @param integer $postId The id of the post
     * @return pdostatement Returns a pdostatement object
     */
    public function create(string $commentContent, int $userId, int $postId): PDOStatement
    {
        $comment = $this->db->getPdo()->prepare("INSERT INTO comment(comment, user_id, post_id) VALUES(?, ?, ?)");
        $comment->execute([$commentContent, $userId, $postId]);
        return $comment;
    }


    /**
     * Fetches all the comments and sorts them out unpublished first
     *
     * @return array Returns an array of all the comments
     */
    public function getAll(): array
    {
        $req = $this->db->getPdo()->query("SELECT * FROM comment ORDER BY published");
        return $req->fetchAll();
    }

    /**
     * Fetches a comment using its id
     *
     * @param integer $commentId The id of the comment
     * @return array Returns an array of the comment with its details
     */
    public function getById(int $commentId): array
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE id = ?");
        $req->execute([$commentId]);
        $comment = $req->fetch();
        return $comment;
    }

    /**
     * Updates a comment in the database using its id
     *
     * @param integer $commentId The id of the comment
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

    /**
     * Fetches all comments related to a post using the id of the post
     *
     * @param integer $postId The id of the post
     * @return array Returns an array of all the comments linked to a post
     */
    public function findByPostId(int $postId): array
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM comment WHERE post_id = ?");
        $req->execute([$postId]);
        $comment = $req->fetchAll();
        return $comment;
    }

    /**
     * Deletes a comment in the database using its id
     *
     * @param integer $commentId The id of the commment
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
