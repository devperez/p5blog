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

    public function signin($email, $password)
    {
        $user = new User($this->db);
        $user = $user->getOne($email, $password);
        return $user;
    }
}
