<?php

namespace Model\SQL;

use App\Model\SQL\SqlConnector;
use PDOException;
use PHPUnit\Framework\TestCase;

class SqlConnectorTest extends TestCase
{
    private SqlConnector $sqlConnector;
    protected function setUp(): void
    {
        parent::setUp();
        $this->sqlConnector = new SqlConnector();
    }

    public function testConnectionFailed(): void {
        $_ENV['DATABASE'] = 'invalid-database';

        $this->expectException(PDOException::class);

        $this->sqlConnector->executeSelectQuery('SELECT * FROM users;', []);
        $this->sqlConnector->closeConnection();
    }

    public function testExecuteSelectQueryFailed() : void
    {
        $this->expectException(PDOException::class);
        $this->sqlConnector->executeSelectQuery('invalid-query', []);
    }

    public function testExecuteInsertQueryFailed() : void
    {
        $this->expectException(PDOException::class);
        $this->sqlConnector->executeInsertQuery('invalid-query', []);
    }

    public function testExecuteDeleteQueryFailed() : void
    {
        $this->expectException(PDOException::class);
        $this->sqlConnector->executeDeleteQuery('invalid-query', []);
    }

    public function tearDown(): void
    {
        $this->sqlConnector->closeConnection();
        unset($_ENV['DATABASE']);
    }
}