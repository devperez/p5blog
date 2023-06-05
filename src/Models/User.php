<?php

namespace David\Blogpro\Models;

use David\Blogpro\Database\DBConnection;
use David\Blogpro\Session\Session;
use PDOStatement;

/**
 * The user model
 */
class User extends Model
{
    public function __construct(private readonly DBConnection $db)
    {
    }

    /**
     * Fetches all the emails from the user table
     *
     * @return array
     */
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

    /**
     * Creates a new user in the database
     *
     * @param string $username The name of the user
     * @param string $email The email of the user
     * @param string $password The password of the user
     * @return pdostatement The user newly created
     */
    public function create(string $username, string $email, string $password): PDOStatement
    {
        $user = $this->db->getPdo()->prepare("INSERT INTO user(username, email, password) VALUES(?, ?, ?)");
        $user->execute([$username, $email, $password]);
        return $user;
    }

    /**
     * Selects a user in the user table
     *
     * @param string $email The email of the user
     * @param string $password The password of the user
     * @return array|bool Returns the user if found and false if not found
     */
    public function getOne(string $email, string $password): array|bool
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $user->execute([$email, $password]);
        $user = $user->fetch();
        if (!$user) {
            $session = new Session();
            $session = $session->set('errors', ['errors' => 'Votre adresse email  ou votre mot de passe n\'est pas valide']);
            return false;
        }
        return $user;
    }

    /**
     * Fetches a user thanks to his id
     *
     * @param integer $userId The id of the user
     * @return array Returns an array of the user with his details
     */
    public function getById(int $userId): array
    {
        $user = $this->db->getPdo()->prepare("SELECT * FROM user WHERE id = ?");
        $user->execute([$userId]);
        $user = $user->fetch();
        return $user;
    }
}
