<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\User;
use PDOStatement;

class UserRepository extends AbstractRepository
{
    /***
     * @param string $username the name of the user
     * @param string $email the email of the user
     * @param string $password the password of the user
     * @return boolean or pdostatement
     */
    public function create(string $username, string $email, string $password): bool|PDOStatement
    {
        $mails = new User($this->db);
        $mails = $mails->getAllEmails();

        if (in_array($email, $mails) === true) {
            return $user = false;
        }
        $user = new User($this->db);
        $user = $user->create($username, $email, $password);
        return $user;
    }

    /***
     * @param string $email
     * @param string $password
     * @return array or boolean if no user found
     */
    public function signin(string $email, string $password): array|bool
    {
        $user = new User($this->db);
        $user = $user->getOne($email, $password);
        if ($user) {
            return $user;
        }
        return false;
    }

    /***
     * This function selects one user by taking its id as a parameter
     *
     * @param integer $userId the id of the user
     *
     * @return array
     */
    public function getOne(int $userId): array
    {
        $user = new User($this->db);
        $user = $user->getById($userId);
        return $user;
    }

    /***
     * @param integer $usersId the ids of the users
     * @return array
     */
    public function getCommentAuthors(int $usersId): array
    {
        $user = new User($this->db);
        $users = $user->getUsersByCommentId($usersId);
        return $users;
    }
}
