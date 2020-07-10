<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class FileDownloadResponse
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
class FileDownloadResponse extends GenericResponse
{
    /** @var string */
    public $contentType;
    /** @var mixed */
    public $data;
    /** @var string */
    public $name;
    /** @var int */
    public $size;

    /**
     * @inheritDoc
     */
    protected function responseHeaders(): ?Headers
    {
        return new Headers([
            'Content-Description' => 'File Transfer',
            'Content-Type' => "{$this->contentType}; charset=UTF-8",
            'Content-Disposition' => "attachment; filename={$this->name}",
            'Content-Transfer-Encoding' => 'binary',
            'Expires' => '0',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
            'Content-Length' => $this->size
        ]);
    }

    /**
     * @inheritDoc
     */
    protected function responseBody()
    {
        return $this->data;
    }
}