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

    public function getAllEmails(): array
    {
        $req = $this->db->getPdo()->query("SELECT email FROM user");
        $mails = $req->fetchAll();
        $emails = [];
        foreach ($mails as $mail) {
            array_push($emails, $mail['email']);
        }
        return $emails;
    }

    public function create(string $username, string $email, string $password): PDOStatement
    {
        $user = $this->db->getPdo()->prepare("INSERT INTO user(username, email, password) VALUES(?, ?, ?)");
        $user->execute([$username, $email, $password]);
        return $user;
    }

    public function getOne(string $email, string $password): array|bool
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $user->execute([$email, $password]);
        $user = $user->fetch();
        if (!$user) {
            $session = new Session();
            $session = $session->set('errors', ['errors' => 'Votre adresse email  ou votre mot de passe n\'est pas valide']);
            return false;
        } else {
            return $user;
        }
    }

    public function getById(int $id): array
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $user->execute([$id]);
        $user = $user->fetch();
        return $user;
    }

    public function getUsersByCommentId(int $usersId): array
    {
        $req = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $req->execute([$usersId]);
        return $users = $req->fetchAll();
    }
}
