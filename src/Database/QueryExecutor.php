<?php

namespace App\Database;

use Exception;
use PDOException;
use PDOStatement;

class QueryExecutor
{
    protected static function executeQuery(string $query, ?string $errorMessage = null, ?array $placeholders = null): PDOStatement
    {
        $connection = Connection::getInstance();
        $statement = $connection->getConnection()->prepare($query);
        try {
            is_null($placeholders) ?
                $statement->execute()
                :
                $statement->execute($placeholders);
            return $statement;
        } catch (PDOException $e) {
            $message = $errorMessage ?? "Failed query";
            throw new Exception("$message: {$e->getMessage()}", (int) $e->getCode());
        } finally {
            $connection->closeConnection();
        }
    }
}
