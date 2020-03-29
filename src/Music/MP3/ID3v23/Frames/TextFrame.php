<?php

namespace AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frames;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;
use AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frame;
use AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\IFrame;

/**
 * Class TextFrame
 *
 * @package AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frames
 */
class TextFrame extends Frame implements IFrame
{
    /***
     * @return array
     *
     * @throws IOException
     */
    public function extract(): array
    {
        $encoding = bin2hex($this->read(1));
        $text = $this->readFromContent($encoding);

        return [
            'id' => $this->_id,
            'name' => $this->_name,
            'encoding' => $encoding,
            'text' => $text
        ];
    }
}