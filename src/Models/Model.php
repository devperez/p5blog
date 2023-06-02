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
     * @param integer $id
     * return string the username
     */
    public function getAuthorName(int $id): string
    {
        $sql = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $sql->execute([$id]);
        $user = $sql->fetch();
        $username = $user['username'];
        return $username;
    }

    /***
     * @param string $title
     * @param string $subtitle
     * @param string $article
     * @param integer $userId
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
     * @param integer $id
     * @param string $title
     * @param string $subtitle
     * @param string $content
     * @return void
     */
    public function updatePost(int $id, string $title, string $subtitle, string $content): void
    {
        $sql = $this->db->getPdo()->prepare("UPDATE post SET title = :title, subtitle = :subtitle, content = :content WHERE id = :id");
        $sql->execute([
            'title' => $title,
            'subtitle' => $subtitle,
            'content' => $content,
            'id' => $id,
        ]);
    }

    /***
     * @param integer $id
     * @return void
     */
    public function deletePost(int $id): void
    {
        $sql = $this->db->getPdo()->prepare("DELETE FROM post WHERE id = :id");
        $sql->execute([
            'id' => $id,
        ]);
    }
}
