<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\User;

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
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);

            $user = new User($this->db);
            $user = $user->getOne($email, $password);
            return $user;
        }
    }
}
