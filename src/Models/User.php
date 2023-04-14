<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use PDOStatement;

class User extends Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    public function create($username, $email, $password): PDOStatement
    {
        $user = $this->db->getPDO()->prepare("INSERT INTO user(username, email, password) VALUES(?, ?, ?)");
        $user->execute([$username, $email, $password]);
        return $user;
    }

    public function getOne($email, $password): array
    {
        $user = $this->db->getPDO()->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $user->execute([$email, $password]);
        $user = $user->fetch();
        return $user;
    }
}
