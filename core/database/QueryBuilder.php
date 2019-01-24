<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insert a record into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
        } catch (\Exception $e) {
            //
        }
    }

    /**
     * Show a single record from a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function get($table, $parameters)
    {

        $statement = $this->pdo->prepare("SELECT * FROM {$table} WHERE `id` = {$parameters['id']}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Delete a single record from a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
    public function delete($table, $parameters)
    {
        $statement = $this->pdo->prepare("DELETE FROM {$table} WHERE `id` = {$parameters['id']}");

        try {
            $statement->execute($parameters);
        } catch (\Exception $e) {
            //
        }
    }
}
