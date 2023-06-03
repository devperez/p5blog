<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\User;
use PDOStatement;

/**
 * Repository class for the users
 */
class UserRepository extends AbstractRepository
{
    /**
     * Creates a new user in the database
     *
     * @param string $username The name of the user
     * @param string $email The email of the user
     * @param string $password The password of the user
     * @return boolean|pdostatement Returns false if the user is not created and a PDOStatement if he is
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

    /**
     * Checks the username and the password of a user before connecting him
     *
     * @param string $email The email of the user
     * @param string $password The password of the user
     * @return array|boolean Returns array if user is found of false if he is not found in the database
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

    /**
     * Selects one user by taking its id as a parameter
     *
     * @param integer $userId The id of the user
     *
     * @return array Returns an array with the user's details
     */
    public function getOne(int $userId): array
    {
        $user = new User($this->db);
        $user = $user->getById($userId);
        return $user;
    }

    /**
     * Fetches the authors of the comments using the user's id
     *
     * @param integer $usersId The id of the user
     * @return array Returns an array with the user's details
     */
    public function getCommentAuthors(int $usersId): array
    {
        $user = new User($this->db);
        $users = $user->getUsersByCommentId($usersId);
        return $users;
    }
}
