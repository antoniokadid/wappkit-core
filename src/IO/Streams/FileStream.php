<?php

namespace AntonioKadid\WAPPKitCore\IO\Streams;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;

/**
 * Class FileStream.
 *
 * @package AntonioKadid\WAPPKitCore\IO\Streams
 */
class FileStream
{
    /** @var resource */
    private $resource;

    /**
     * FileStream constructor.
     *
     * @param string $filename
     * @param string $mode
     *
     * @throws IOException
     */
    public function __construct(string $filename, string $mode)
    {
        $result = fopen($filename, $mode);
        if ($result === false) {
            throw new IOException(sprintf('Unable to open "%s".', $filename));
        }

        $this->resource = $result;
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * @return bool
     */
    public function atEnd(): bool
    {
        if (!is_resource($this->resource)) {
            return true;
        }

        return feof($this->resource);
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        if (!is_resource($this->resource)) {
            return true;
        }

        return fclose($this->resource);
    }

    /**
     * Reads remainder of a stream into a string.
     *
     * @param null|int $maxLength The maximum bytes to read. Defaults to -1 (read all the remaining buffer).
     * @param null|int $offset    Seek to the specified offset before reading.
     *                            If this number is negative, no seeking will occur and reading will start
     *                            from the current position.
     *
     * @throws IOException
     *
     * @return string
     */
    public function getContents(int $maxLength = -1, int $offset = -1): string
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = stream_get_contents($this->resource, $maxLength, $offset);
        if ($result === false) {
            throw new IOException('Unable to read from resource.');
        }

        return $result;
    }

    /**
     * Returns the current position of read/write pointer.
     *
     * @throws IOException
     *
     * @return int
     */
    public function getCurrentPosition(): int
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = ftell($this->resource);
        if ($result === false) {
            throw new IOException('Unable to retrieve current position for resource.');
        }

        return $result;
    }

    /**
     * Gets a line.
     * Reading ends when $length bytes have been read, when the string specified by
     * $ending is found (which is not included in the return value), or on EOF (whichever comes first).
     *
     * @param int         $length the number of bytes to read from the handle
     * @param null|string $ending an optional string delimiter
     *
     * @throws IOException
     *
     * @return string
     */
    public function getLine(int $length, string $ending = null): string
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = stream_get_line($this->resource, $length, $ending);
        if ($result === false) {
            throw new IOException('Unable to read from resource.');
        }

        return $result;
    }

    /**
     * Retrieves header/meta data.
     * The stream must be created by fopen(), fsockopen() and pfsockopen().
     *
     * @throws IOException
     *
     * @return array
     */
    public function getMetaData(): array
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        return stream_get_meta_data($this->resource);
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Reads up to $length bytes.
     *
     * @param int $length
     *
     * @throws IOException
     *
     * @return string
     */
    public function read(int $length): string
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = fread($this->resource, $length);
        if ($result === false) {
            throw new IOException('Unable to read from resource.');
        }

        return $result;
    }

    /**
     * Set position equal to $offset bytes.
     *
     * @param int $offset
     *
     * @throws IOException
     */
    public function seekFromBeginning(int $offset): void
    {
        $this->seek($offset, SEEK_SET);
    }

    /**
     * Set position to current location plus $offset.
     *
     * @param int $offset
     *
     * @throws IOException
     */
    public function seekFromCurrentPosition(int $offset): void
    {
        $this->seek($offset, SEEK_CUR);
    }

    /**
     * Set position to end-of-file plus $offset.
     *
     * @param int $offset
     *
     * @throws IOException
     */
    public function seekFromEnd(int $offset): void
    {
        $this->seek($offset, SEEK_END);
    }

    /**
     * Writes the contents of $string.
     *
     * @param string   $string the string that is to be written
     * @param null|int $length if the length argument is given, writing will stop after length bytes
     *                         have been written or the end of string is reached, whichever comes first
     *
     * @throws IOException
     *
     * @return int returns the number of bytes written
     */
    public function write(string $string, ?int $length = null): int
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = ($length == null) ? fwrite($this->resource, $string) : fwrite($this->resource, $string, $length);
        if ($result === false) {
            throw new IOException('Unable to write to resource.');
        }

        return $result;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @throws IOException
     */
    private function seek(int $offset, int $whence = SEEK_SET): void
    {
        if (!is_resource($this->resource)) {
            throw new IOException('Invalid resource.');
        }

        $result = fseek($this->resource, $offset, $whence);
        if ($result !== 0) {
            throw new IOException('Unable to seek.');
        }
    }
}
