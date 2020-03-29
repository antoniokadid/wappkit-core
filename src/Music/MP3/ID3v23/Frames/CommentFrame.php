<?php

namespace AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frames;

use AntonioKadid\WAPPKitCore\Exceptions\IOException;
use AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frame;
use AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\IFrame;

/**
 * Class CommentFrame
 *
 * @package AntonioKadid\WAPPKitCore\Music\MP3\ID3v23\Frames
 */
class CommentFrame extends Frame implements IFrame
{
    /**
     * @return array
     *
     * @throws IOException
     */
    public function extract(): array
    {
        $encoding = bin2hex($this->read(1));
        $language = $this->read(3);
        $description = $this->readFromContent($encoding, $encoding == self::ENCODING_ISO ? '00' : '0000');
        $comment = $this->readFromContent($encoding);

        return [
            'name' => $this->_name,
            'encoding' => $encoding,
            'language' => $language,
            'description' => $description,
            'comment' => $comment
        ];
    }
}