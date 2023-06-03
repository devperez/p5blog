<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Comment;
use PDOStatement;

class CommentRepository extends AbstractRepository
{
    /***
     * This function is called when a new comment is getting created
     *
     * @param string $commentContent the comment itself
     * @param integer $userId the if of the user
     * @param integer $postId the if of the commented post
     * @return pdoStatement
     */
    public function create(string $commentContent, int $userId, int $postId): PDOStatement
    {
        $comment = new Comment($this->db);
        $comment = $comment->create($commentContent, $userId, $postId);
        return $comment;
    }

    /***
     * @return array
     */

    public function index(): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->getAll();
        return $comments;
    }

    /***
     * This function gets a specific comment taking its id as a parameter
     *
     * @param integer $commentId
     *
     * @return array
     */

    public function getOneById(int $commentId): array
    {
        $comment = new Comment($this->db);
        $comment = $comment->getById($commentId);
        return $comment;
    }

    /***
     * @param integer $commentId
     * @return void
     */

    public function publish(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->updateComment($commentId);
    }

    /***
     * @param integer $postId
     * @return array
     */

    public function getCommentFromPost(int $postId): array
    {
        $comment = new Comment($this->db);
        $comments = $comment->findByPostId($postId);
        return $comments;
    }

    /***
     * @param integer $commentId
     * @return void
     */

    public function delete(int $commentId): void
    {
        $comment = new Comment($this->db);
        $comment = $comment->destroy($commentId);
    }
}
