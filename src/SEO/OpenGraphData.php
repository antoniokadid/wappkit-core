<?php

namespace AntonioKadid\WAPPKitCore\SEO;

/**
 * Class OpenGraphData
 *
 * @package AntonioKadid\WAPPKitCore\SEO
 */
class OpenGraphData
{
    /** @var string */
    public $title;

    /** @var string */
    public $type = 'website';

    /** @var string */
    public $url;

    /** @var string */
    public $image;

    /** @var string */
    public $description;

    /** @var string[] */
    public $images = [];
}