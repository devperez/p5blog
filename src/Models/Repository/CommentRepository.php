<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Comment;
use PDOStatement;

class CommentRepository extends AbstractRepository
{
    /***
     * @param string $commentContent
     * @param integer $userId
     * @param integer $postId
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
     * @param integer $id
     * @return array
     */

    public function getOneById(int $id): array
    {
        $comment = new Comment($this->db);
        $comment = $comment->getById($id);
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
