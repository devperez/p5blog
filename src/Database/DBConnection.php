<?php

namespace David\Blogpro\Database;

use PDO;

/**
 * This class handles the connection to the database
 */
class DBConnection
{
    /**
     * PDO connection to the database
     *
     * @var PDO|null
     */
    private $pdo;

    /**
     * The name of the database
     *
     * @var string
     */
    private $dbname;

    /**
     * The database host
     *
     * @var string
     */
    private $host;

    /**
     * The user name to connect to the database
     *
     * @var string
     */
    private $username;

    /**
     * The password to connect to the database
     *
     * @var string
     */
    private $password;

    /**
     * DBConnection class constructor
     */
    public function __construct()
    {
        /**
         * Link PDO variables to the environment variables
         */
        $this->dbname = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    /**
     * Using database variables to establish a connection
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        // first, check if a pdo instance already exists.
        // If not, create a new instance with error mode on.
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                "mysql:dbname={$this->dbname};host={$this->host}",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        }
        return $this->pdo;
    }
}
