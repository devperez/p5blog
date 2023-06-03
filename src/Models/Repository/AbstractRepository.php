<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Database\DBConnection;

/**
 * Abstract class for the repositories
 */
abstract class AbstractRepository
{
    /**
     * Connection to the database
     *
     * @var DBConnection
     */

    /**
     * The class constructor
     *
     * @param DBConnection $db The connection to the database
     */
    public function __construct(protected readonly DBConnection $db = new DBConnection())
    {
    }
}
