<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Comment;
use PDOStatement;

/**
 * Repository for the comments.
 */
class CommentRepository extends AbstractRepository
{
    /**
     * This function is called when a new comment is getting created
     *
     * @param string $commentContent The comment itself
     * @param integer $userId The if of the user
     * @param integer $postId The if of the commented post
     * @return pdoStatement The PDOStatement of the created comment
     */
    public function create(string $commentContent, int $userId, int $postId): PDOStatement
    {
        $comment = new Comment($this->db);
        $comment = $comment->create($commentContent, $userId, $postId);
        return $comment;
    }

    /**
     * Fetches all the comments
     *
     * @return array An array of all the comments
     */
    public function index(): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->getAll();
        return $comments;
    }

    /**
     * This function gets a specific comment taking its id as a parameter
     *
     * @param integer $commentId The id of the comment
     *
     * @return array The details of the comment
     */
    public function getOneById(int $commentId): array
    {
        $comment = new Comment($this->db);
        $comment = $comment->getById($commentId);
        return $comment;
    }

    /**
     * Publishes a comment usind its id
     *
     * @param integer $commentId The id of the comment
     * @return void
     */
    public function publish(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->updateComment($commentId);
    }

    /**
     * Fetches the comments of a post using its id
     *
     * @param integer $postId The id of the post
     * @return array All the comments of the post
     */
    public function getCommentFromPost(int $postId): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->findByPostId($postId);
        return $comments;
    }

    /**
     * Deletes a comment using its id
     *
     * @param integer $commentId The id of the comment
     * @return void
     */
    public function delete(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->destroy($commentId);
    }
}
