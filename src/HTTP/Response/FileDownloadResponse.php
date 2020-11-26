<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Response;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class FileDownloadResponse.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Response
 */
class FileDownloadResponse extends Response
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
     * {@inheritdoc}
     */
    protected function body()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    protected function headers(): ?Headers
    {
        return new Headers([
            'Content-Description'       => 'File Transfer',
            'Content-Type'              => "{$this->contentType}; charset=UTF-8",
            'Content-Disposition'       => "attachment; filename={$this->name}",
            'Content-Transfer-Encoding' => 'binary',
            'Expires'                   => '0',
            'Cache-Control'             => 'private, max-age=0, must-revalidate',
            'Pragma'                    => 'public',
            'Content-Length'            => $this->size
        ]);
    }
}
