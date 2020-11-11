<?php

namespace AntonioKadid\WAPPKitCore\Audio\MP3\ID3v23\Frames;

use AntonioKadid\WAPPKitCore\Audio\MP3\ID3v23\Frame;
use AntonioKadid\WAPPKitCore\Audio\MP3\ID3v23\IFrame;
use AntonioKadid\WAPPKitCore\Exceptions\IOException;

/**
 * Class CommentFrame.
 *
 * @package AntonioKadid\WAPPKitCore\Audio\MP3\ID3v23\Frames
 */
class CommentFrame extends Frame implements IFrame
{
    /**
     * @throws IOException
     *
     * @return array
     */
    public function extract(): array
    {
        $encoding    = bin2hex($this->read(1));
        $language    = $this->read(3);
        $description = $this->readFromContent($encoding, $encoding == self::ENCODING_ISO ? '00' : '0000');
        $comment     = $this->readFromContent($encoding);

        return [
            'name'        => $this->name,
            'encoding'    => $encoding,
            'language'    => $language,
            'description' => $description,
            'comment'     => $comment
        ];
    }
}
