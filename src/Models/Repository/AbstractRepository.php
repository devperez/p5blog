<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Database\DBConnection;

abstract class AbstractRepository
{
    public function __construct(protected readonly DBConnection $db = new DBConnection())
    {
    }


}