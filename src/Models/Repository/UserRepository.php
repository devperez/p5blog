<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\User;
use Error;

class UserRepository extends AbstractRepository
{
    public function create($username, $email, $password)
    {
        $user = new User($this->db);
        $user = $user->create($username, $email, $password);
        return $user;
    }

    public function signin()
    {
        try {
            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = htmlspecialchars($_POST['email']);
                $password = sha1($_POST['password']);


                $user = new User($this->db);
                $user = $user->getOne($email, $password);
                if ($user) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    return $user;
                } else {
                    throw new Error("Ce compte n'existe pas.");
                }
            } else {
                throw new Error("Tous les champs doivent être complétés.");
            }
        } catch (Error $e) {
            echo "<p class='error'>";
            echo 'Erreur : ' . $e->getMessage();
            echo "</p>";
        }
    }
}
