<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;
use ReflectionClass;

/**
 * @template T
 */
abstract class Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    /**
     * @return T[]
     *
     */
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

    public function getAuthorName($id)
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM `post` INNER JOIN user ON post.user_id = ?");
        $user->execute([$id]);
        return $user->fetch();
    }

    public function create($title, $subtitle, $article, $userId)
    {
        $sql = $this->db->getPdo()->prepare("INSERT INTO post ('title', 'subtitle','content', 'user_id') VALUES (:title, :subtitle, :article, :userId)");
        $sql->bindParam(':title', $title);
        $sql->bindParam(':subtitle', $subtitle);
        $sql->bindParam(':content', $article);
        $sql->bindParam(':user_id', $userId);
        $sql->execute();
    }
}
