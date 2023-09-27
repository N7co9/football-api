<?php

namespace App\Model\SQL;

use PDO;
use PDOException;

class SqlConnector
{

    private object $pdo;

    public function __construct()
    {
        try {
            $dbHost = "localhost:3336";
            $dbName = "football";
            $dbUser = "root";
            $dbPass = "nexus123";

            $this->pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function executeSelectQuery(string $query, array $params) : array
    {
        try {
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function executeInsertQuery(string $query, array $params): string
    {
        try {
            $stmt = $this->pdo->prepare($query);

            // Bind parameters manually
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }

            // Execute the query
            $stmt->execute();

            // Return the last inserted ID
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
}