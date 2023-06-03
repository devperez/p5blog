<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;
use ReflectionClass;

/**
 * Model abstract class
 */
abstract class Model
{
    /**
     * Creates a new instance of Model
     *
     * @param DBConnection $db The database connection
     */
    public function __construct(private readonly DBConnection $db)
    {
    }

    /**
     * Fetches either all the users, posts or comments
     *
     * @return array An array of all the posts, users or comments
     */
    public function all(): array
    {
        $req = $this->db->getPdo()->query("SELECT * FROM {$this->getTableName() } ORDER BY created_at DESC");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $req->fetchAll();
    }

    /**
     * Fetches a user, a post or a comment using its id
     *
     * @param integer $id Can be either a post, user, or comment id
     * @return model A post model, a user model or a comment model
     */
    public function findById(int $id): Model
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM {$this->getTableName() } WHERE id = ?");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $req->execute([$id]);
        return $req->fetch();
    }

    /**
     * Gets the name of the table
     *
     * @return string The name of the table
     */
    private function getTableName(): string
    {
        $shortName = (new ReflectionClass($this))->getShortName();
        return strtolower($shortName);
    }

    /**
     * Fetches the author of a post
     *
     * @param integer $userId The id of the user
     * @return string the username
     */
    public function getAuthorName(int $userId): string
    {
        $sql = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $sql->execute([$userId]);
        $user = $sql->fetch();
        $username = $user['username'];
        return $username;
    }

    /**
     * Stores a post in the post table
     *
     * @param string $title The title of the post
     * @param string $subtitle The subtitle of the post
     * @param string $article The content of the post
     * @param integer $userId The id of the user
     * @return void
     */
    public function storePost(string $title, string $subtitle, string $article, int $userId): void
    {
        $sql = $this->db->getPdo()->prepare("INSERT INTO post (title, subtitle, content, user_id) VALUES (:title, :subtitle, :article, :userId)");
        $sql->bindParam(':title', $title);
        $sql->bindParam(':subtitle', $subtitle);
        $sql->bindParam(':article', $article);
        $sql->bindParam(':userId', $userId);
        $sql->execute();
    }

    /**
     * Updates a post from the post table
     *
     * @param integer $postId The id of the post
     * @param string $title The title of the post
     * @param string $subtitle The subtitle of the post
     * @param string $content The content of the post
     * @return void
     */
    public function updatePost(int $postId, string $title, string $subtitle, string $content): void
    {
        $sql = $this->db->getPdo()->prepare("UPDATE post SET title = :title, subtitle = :subtitle, content = :content WHERE id = :id");
        $sql->execute([
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content,
            'id' => $postId,
        ]);
    }

    /**
     * Deletes a post from the post table
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $sql = $this->db->getPdo()->prepare("DELETE FROM post WHERE id = :id");
        $sql->execute([
            'id' => $postId,
        ]);
    }
}
