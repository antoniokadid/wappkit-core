<?php

namespace AntonioKadid\WAPPKitCore\Views;

use AntonioKadid\WAPPKitCore\HTTP\Response\HTMLResponse;

/**
 * Class View.
 *
 * @package AntonioKadid\WAPPKitCore\Views
 */
abstract class View extends HTMLResponse
{
    /** @var string */
    public $description;
    /** @var string */
    public $title;
}
