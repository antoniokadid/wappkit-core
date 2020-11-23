<?php

namespace AntonioKadid\WAPPKitCore\DAL\Firebird;

use AntonioKadid\WAPPKitCore\DAL\DatabaseConnectionInterface;
use AntonioKadid\WAPPKitCore\DAL\Exceptions\DatabaseException;

/**
 * Class FirebirdConnection.
 *
 * @package AntonioKadid\WAPPKitCore\DAL\Firebird
 */
class FirebirdConnection implements DatabaseConnectionInterface
{
    private $connection;

    private $transaction;

    public function __construct(
        string $host,
        int $port,
        string $dbName,
        string $username,
        string $password,
        string $encoding = 'UTF-8'
    ) {
        $connection = @ibase_connect("{$host}/{$port}:{$dbName}", $username, $password, $encoding);
        if ($connection === false) {
            throw new DatabaseException(sprintf('Unable to connect to %s', $dbName));
        }

        $this->connection = $connection;

        $transaction = @ibase_trans(IBASE_DEFAULT, $this->connection);
        if ($transaction === false) {
            throw new DatabaseException(sprintf('Unable to start transaction for %s', $dbName));
        }

        $this->transaction = $transaction;
    }

    public function __destruct()
    {
        $this->rollback();

        if (is_resource($this->connection)) {
            @ibase_close($this->connection);
        }
    }

    public function blob($value)
    {
        $result = @ibase_blob_create($this->transaction);
        if ($result === false) {
            throw new DatabaseException('Unable to create blob.');
        }

        @ibase_blob_add($result, $value);

        $blobRef = @ibase_blob_close($result);
        if ($blobRef === false) {
            @ibase_blob_cancel($result);

            throw new DatabaseException('Unable to create blob.');
        }

        return $blobRef;
    }

    public function commit(): bool
    {
        if (!is_resource($this->transaction)) {
            return false;
        }

        $result = @ibase_commit($this->transaction);
        if ($result === false) {
            return false;
        }

        $this->transaction = null;

        return true;
    }

    public function execute(string $sql, array $params = []): int
    {
        $query = @ibase_prepare($this->connection, $this->transaction, $sql);
        if ($query === false) {
            throw new DatabaseException('Unable to prepare query.', $sql, $params);
        }

        if (!is_array($params)) {
            $params = [];
        }

        array_unshift($params, $query);

        $result = @call_user_func_array('ibase_execute', $params);
        if ($result === false) {
            throw new DatabaseException('Unable to execute query.', $sql, $params);
        }

        return $result !== false;
    }

    /**
     * @param mixed $generator
     * @param int   $increament
     *
     * @return int
     */
    public function genId($generator, $increament = 1): int
    {
        return intval(ibase_gen_id($generator, $increament, $this->transaction));
    }

    public function query(string $sql, array $params = []): array
    {
        $query = @ibase_prepare($this->connection, $this->transaction, $sql);
        if ($query === false) {
            throw new DatabaseException('Unable to prepare query.', $sql, $params);
        }

        if (!is_array($params)) {
            $params = [];
        }

        array_unshift($params, $query);

        $result = @call_user_func_array('ibase_execute', $params);
        if ($result === false) {
            throw new DatabaseException('Unable to execute query.', $sql, $params);
        }

        $records = [];
        while (($row = @ibase_fetch_assoc($result, IBASE_TEXT)) !== false) {
            $records[] = $row;
        }

        @ibase_free_result($result);

        return $records;
    }

    public function rollback(): bool
    {
        if (!is_resource($this->transaction)) {
            return false;
        }

        @ibase_rollback($this->transaction);
        $this->transaction = null;

        return true;
    }
}
