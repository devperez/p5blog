<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use David\Blogpro\Session\Session;
use PDOStatement;

class User extends Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    public function create($username, $email, $password): PDOStatement
    {
        $user = $this->db->getPdo()->prepare("INSERT INTO user(username, email, password) VALUES(?, ?, ?)");
        $user->execute([$username, $email, $password]);
        return $user;
    }

    public function getOne($email, $password): array
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $user->execute([$email, $password]);
        $user = $user->fetch();
        if (!$user) {
            $session = new Session();
            $session = $session->start('errors', ['errors' => 'Votre adresse email  ou votre mot de passe n\'est pas valide']);
        } else {
            return $user;
        }
    }

    public function getById($id)
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $user->execute([$id]);
        $user = $user->fetch();
        return $user;
    }

    public function getUsersByCommentId($usersId)
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $req->execute([$usersId]);
        return $users = $req->fetchAll();
    }
}
