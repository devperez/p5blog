<?php

namespace David\Blogpro\Database;

use PDO;
use SensitiveParameter;

class DBConnection
{
    private $pdo;

    public function __construct(
        #[SensitiveParameter]
        private readonly string $dbname,
        private readonly string $host,
        private readonly string $username,
        private readonly string $password
    ) {
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
}
