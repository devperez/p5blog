<?php

namespace David\Blogpro\Database;

use PDO;
use SensitiveParameter;

class DBConnection
{
    private $pdo;
    private $dbname;
    private $host;
    private $username;
    private $password;

    public function __construct(
        // #[SensitiveParameter] //thing to check
    ) {
        $this->dbname = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    public function getPDO(): PDO
    {
        //first, check if a pdo instance already exists.
        //If not, create a new instance with error mode on.
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                "mysql:dbname={$this->dbname};host={$this->host}",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        }
        return $this->pdo;
    }

    public function sql($sql, $parameters = null)
    {
        if ($parameters) {
            $result = $this->getPDO()->prepare($sql);

            $result->execute($parameters);

            return $result;
        } else {
            $result = $this->getPDO()->query($sql);

            return $result;
        }
    }
}
