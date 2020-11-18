<?php

namespace AntonioKadid\WAPPKitCore\Localization;

const DEFAULT_DOMAIN = 'default';

/**
 * @param string $text
 * @param string $domain
 *
 * @return null|string
 */
function __(string $text, string $domain = DEFAULT_DOMAIN)
{
    $activeLocale = Locale::active();
    if ($activeLocale == null) {
        return $text;
    }

    $domain = TranslationDomain::get($domain);
    if ($domain == null) {
        return $text;
    }

    $translations = $domain->getTranslations($activeLocale->getLocale());
    if ($translations == null) {
        return $text;
    }

    $result = $translations->getString($text, '');

    return !empty($result) ? $result : $text;
}
