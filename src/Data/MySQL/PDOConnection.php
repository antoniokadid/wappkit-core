<?php

namespace AntonioKadid\WAPPKitCore\Data\MySQL;

use AntonioKadid\WAPPKitCore\Data\DatabaseConnectionInterface;
use AntonioKadid\WAPPKitCore\Data\Exceptions\DatabaseException;
use PDO;
use PDOException;

/**
 * Class PDOConnection.
 *
 * @package AntonioKadid\WAPPKitCore\Database\MySQL
 */
class PDOConnection implements DatabaseConnectionInterface
{
    /** @var PDO */
    private $pdo;

    /**
     * PDOConnection constructor.
     *
     * @param string $host
     * @param int    $port
     * @param string $dbName
     * @param string $username
     * @param string $password
     * @param string $encoding
     *
     * @throws DatabaseException
     */
    public function __construct(
        string $host,
        int $port,
        string $dbName,
        string $username,
        string $password,
        string $encoding = 'utf8'
    ) {
        $dsn     = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $host, $port, $dbName, $encoding);
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_CASE               => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
            PDO::ATTR_AUTOCOMMIT         => false
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->pdo->beginTransaction();
        } catch (PDOException $pdoEx) {
            throw new DatabaseException($pdoEx->getMessage(), '', [], $pdoEx->getCode(), $pdoEx);
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
        if ($this->pdo == null) {
            throw new DatabaseException('Database connection not initialized.');
        }

        if ($this->pdo->inTransaction() !== true) {
            throw new DatabaseException('Not in transaction.');
        }

        if (!$this->pdo->commit()) {
            throw new DatabaseException($this->pdo->errorInfo()[2], '', [], $this->po->errorInfo()[1]);
        }

        $this->pdo = null;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sql, array $params = []): int
    {
        if ($this->pdo == null) {
            throw new DatabaseException('Database connection not initialized.', $sql, $params);
        }

        if ($this->pdo->inTransaction() !== true) {
            throw new DatabaseException('Not in transaction.', $sql, $params);
        }

        $statement = $this->pdo->prepare($sql);
        if ($statement === false) {
            throw new DatabaseException($this->pdo->errorInfo()[2], $sql, $params, $this->po->errorInfo()[1]);
        }

        $result = $statement->execute($params);
        if ($result === false) {
            throw new DatabaseException($statement->errorInfo()[2], $sql, $params, $statement->errorInfo()[1]);
        }

        return $statement->rowCount();
    }

    /**
     * {@inheritdoc}
     */
    public function query(string $sql, array $params = []): array
    {
        if ($this->pdo == null) {
            throw new DatabaseException('Database connection not initialized.', $sql, $params);
        }

        if ($this->pdo->inTransaction() !== true) {
            throw new DatabaseException('Not in transaction.', $sql, $params);
        }

        $statement = $this->pdo->prepare($sql);
        if ($statement === false) {
            throw new DatabaseException($this->pdo->errorInfo()[2], $sql, $params, $this->pdo->errorInfo()[1]);
        }

        $result = $statement->execute($params);
        if ($result === false) {
            throw new DatabaseException($statement->errorInfo()[2], $sql, $params, $statement->errorInfo()[1]);
        }

        $records = $statement->fetchAll();
        if ($records === false) {
            throw new DatabaseException($statement->errorInfo()[2], $sql, $params, $statement->errorInfo()[1]);
        }

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    public function rollback(): bool
    {
        if ($this->pdo == null) {
            return false;
        }

        if ($this->pdo->inTransaction() !== true) {
            return false;
        }

        $result = $this->pdo->rollBack();

        $this->pdo = null;

        return $result;
    }
}
