<?php

namespace AntonioKadid\WAPPKitCore\Database\MySQL\Connections;

use AntonioKadid\WAPPKitCore\Database\Exceptions\MySQLException;
use AntonioKadid\WAPPKitCore\Database\MySQL\IMySQLConnection;
use mysqli;
use mysqli_stmt;

/**
 * Class MySQLiConnection.
 *
 * @package AntonioKadid\WAPPKitCore\Database\MySQL\Connections
 */
class MySQLiConnection implements IMySQLConnection
{
    /** @var mysqli */
    private $mysqli;

    /**
     * MySQLiConnection constructor.
     *
     * @param string $host
     * @param int    $port
     * @param string $dbName
     * @param string $username
     * @param string $password
     * @param string $encoding
     *
     * @throws MySQLException
     */
    public function __construct(
        string $host,
        int $port,
        string $dbName,
        string $username,
        string $password,
        string $encoding = 'UTF8'
    ) {
        $this->mysqli = new mysqli($host, $username, $password, $dbName, $port);
        if ($this->mysqli->connect_errno !== 0) {
            throw new MySQLException($this->mysqli->connect_error, '', [], $this->msqli->connect_errno);
        }

        if ($this->mysqli->set_charset($encoding) !== true) {
            throw new MySQLException('Cannot set character set.');
        }

        if ($this->mysqli->autocommit(false) !== true) {
            throw new MySQLException('Cannot disable auto-commit.');
        }

        if ($this->mysqli->begin_transaction() !== true) {
            throw new MySQLException('Cannot initiate transaction.');
        }
    }

    public function __destruct()
    {
        $this->rollback();
    }

    /**
     * {@inheritdoc}
     */
    public function commit(): bool
    {
        if ($this->mysqli == null) {
            throw new MySQLException('Database connection not initialized.');
        }

        if ($this->mysqli->ping() !== true) {
            throw new MySQLException('Database connection not active.');
        }

        if ($this->mysqli->commit() !== true) {
            throw new MySQLException($this->mysqli->error, '', [], $this->msqli->errno);
        }

        $this->mysqli->close();
        $this->mysqli = null;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sql, array $params = []): int
    {
        if ($this->mysqli == null) {
            throw new MySQLException('Database connection not initialized.');
        }

        if ($this->mysqli->ping() !== true) {
            throw new MySQLException('Database connection not active.');
        }

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new MySQLException($this->mysqli->error, $sql, $params, $this->msqli->errno);
        }

        if ($this->bindParameters($statement, $params) !== true) {
            throw new MySQLException($statement->error, $sql, $params, $statement->errno);
        }

        if ($statement->execute() !== true) {
            throw new MySQLException($statement->error, $sql, $params, $statement->errno);
        }

        return $statement->affected_rows;
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $sql, array $params = []): array
    {
        if ($this->mysqli == null) {
            throw new MySQLException('Database connection not initialized.');
        }

        if ($this->mysqli->ping() !== true) {
            throw new MySQLException('Database connection not active.');
        }

        $statement = $this->mysqli->prepare($sql);
        if ($statement === false) {
            throw new MySQLException($this->mysqli->error, $sql, $params, $this->msqli->errno);
        }

        if ($this->bindParameters($statement, $params) !== true) {
            throw new MySQLException($statement->error, $sql, $params, $statement->errno);
        }

        if ($statement->execute() !== true) {
            throw new MySQLException($statement->error, $sql, $params, $statement->errno);
        }

        $preparedResult = $statement->get_result();
        if ($preparedResult === false) {
            throw new MySQLException($statement->error, $sql, $params, $statement->errno);
        }

        $result = [];
        while (($record = $preparedResult->fetch_assoc()) != null) {
            $result[] = $record;
        }

        $preparedResult->free();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function rollback(): bool
    {
        if ($this->mysqli == null) {
            return false;
        }

        if ($this->mysqli->ping() !== true) {
            return false;
        }

        $result = $this->mysqli->rollback();

        $this->mysqli->close();
        $this->mysqli = null;

        return $result;
    }

    /**
     * @param mysqli_stmt $stmt
     * @param array       $params
     *
     * @return bool
     */
    private function bindParameters(mysqli_stmt $stmt, array $params): bool
    {
        if (empty($params)) {
            return true;
        }

        $type = '';
        foreach ($params as $value) {
            if (is_string($value) || $value == null) {
                $type .= 's';
            } elseif (is_int($value) || is_bool($value)) {
                $type .= 'i';
            } elseif (is_double($value)) {
                $type .= 'd';
            } else {
                $type .= 'b';
            }
        }

        return $stmt->bind_param($type, ...$params);
    }
}
