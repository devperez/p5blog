<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDO;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        $req = $this->db->getPDO()->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $req->fetchAll();
    }

    public function findById(int $id): Model
    {
        $req = $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $req->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        $req->execute([$id]);
        return $req->fetch();
    }
}
