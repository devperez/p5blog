<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\User;
use PDOStatement;

class UserRepository extends AbstractRepository
{
    public function create(string $username, string $email, string $password): PDOStatement
    {
        $user = new User($this->db);
        $user = $user->create($username, $email, $password);
        return $user;
    }

    public function signin(string $email, string $password): array
    {
        $user = new User($this->db);
        $user = $user->getOne($email, $password);
        return $user;
    }

    public function getOne(int $id): array
    {
        $user = new User($this->db);
        $user = $user->getById($id);
        return $user;
    }

    public function getCommentAuthors(int $usersId): array
    {
        $user = new User($this->db);
        $users = $user->getUsersByCommentId($usersId);
        //var_dump($users);
        return $users;
    }
}
