<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;
use ReflectionClass;

abstract class Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    public function all(): array
    {
        $req = $this->db->getPdo()->query("SELECT * FROM {$this->getTableName() } ORDER BY created_at DESC");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $req->fetchAll();
    }

    /***
     * This function is called when fetching a user, a post or a comment using its id
     *
     * @param integer $id can be either a post, user, or comment id
     * @return model
     */
    public function findById(int $id): Model
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM {$this->getTableName() } WHERE id = ?");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $req->execute([$id]);
        return $req->fetch();
    }

    private function getTableName(): string
    {
        $shortName = (new ReflectionClass($this))->getShortName();
        return strtolower($shortName);
    }

    /***
     * This function gets the author of a post
     *
     * @param integer $userId the id of the user
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

    /***
     * This function stores a post in the post table
     *
     * @param string $title the title of the post
     * @param string $subtitle the subtitle of the post
     * @param string $article the content of the post
     * @param integer $userId the id of the user
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

    /***
     * This function updates a post from the post table
     *
     * @param integer $postId the id of the post
     * @param string $title the title of the post
     * @param string $subtitle the subtitle of the post
     * @param string $content the content of the post
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

    /***
     * This function deletes a post from the post table
     *
     * @param integer $postId the id of the post
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
