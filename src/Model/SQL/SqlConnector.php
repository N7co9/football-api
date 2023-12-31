<?php

namespace App\Model\SQL;

use PDO;
use PDOException;

class SqlConnector
{
    private ?object $pdo = null;

    public function __construct()
    {
    }

    private function connect(): void
    {
        if ($this->pdo === null) {

            $dbName = $_ENV['DATABASE'] ?? 'football';

            $dbHost = "localhost:3336";
            $dbUser = "root";
            $dbPass = "nexus123";

            $this->pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function executeSelectQuery(string $query, array $params): array
    {
        $this->connect();
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function executeInsertQuery(string $query, array $params): string
    {
        $this->connect();
         $stmt = $this->pdo->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $this->pdo->lastInsertId();
    }

    public function executeDeleteQuery(string $query, array $params): string
    {
        $this->connect();
         $stmt = $this->pdo->prepare($query);

            // Bind parameters manually
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }

            // Execute the query
            $stmt->execute();

            // Return the last inserted ID
            return $this->pdo->lastInsertId();
    }

    public function closeConnection(): void
    {
        $this->pdo = null;
    }
}