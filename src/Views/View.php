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
    private $description;
    /** @var string[] */
    private $keywords = [];
    /** @var string */
    private $title;
    /** @var bool instructs the search engine crawler to index or not to index a page. */
    private $robotIndex = true;
    /** @var bool instructs the search engine crawler to follow or not to follow any links on a page. */
    private $robotFollow = true;

    /**
     * @param string $title
     *
     * @return View
     */
    public function setTitle(string $title): View
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return View
     */
    public function setDescription(string $description): View
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $keyword
     *
     * @return View
     */
    public function addKeyword(string $keyword): View
    {
        if (!in_array($keyword, $this->keywords)) {
            array_push($this->keywords, $keyword);
        }

        return $this;
    }

    /**
     * @return View
     */
    public function disableSearchEngineIndexing(): View
    {
        $this->robotIndex = false;

        return $this;
    }

    /**
     * @return View
     */
    public function enableSearchEngineIndexing(): View
    {
        $this->robotIndex = true;

        return $this;
    }

    /**
     * @return View
     */
    public function enableSearchEngineLinkFollow(): View
    {
        $this->robotFollow = true;

        return $this;
    }

    /**
     * @return View
     */
    public function disableSearchEngineLinkFollow(): View
    {
        $this->robotFollow = false;

        return $this;
    }
}
