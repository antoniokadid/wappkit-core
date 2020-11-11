<?php

namespace AntonioKadid\WAPPKitCore\SEO;

/**
 * Interface ISearchEngineItem.
 *
 * @package AntonioKadid\WAPPKitCore\SEO
 */
interface ISearchEngineItem
{
    /**
     * Get open graph data from underlined object.
     *
     * @return OpenGraphData
     */
    public function getOpenGraphData(): OpenGraphData;

    /**
     * Get SEO data from underlined object.
     *
     * @return SeoData
     */
    public function getSeoData(): SeoData;
}
