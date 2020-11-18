<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AntonioKadid\WAPPKitCore\Localization\TranslationGenerator;
use AntonioKadid\WAPPKitCore\Localization\StringCollector;

array_shift($argv);

$parameters = array_combine(
    array_map(
        function (string $value) {
            $result = preg_split('/=/', $value, 2);
            if ($result === false) {
                return '';
            }

            return $result[0];
        },
        $argv
    ),
    array_map(
        function ($value) {
            $result = preg_split('/=/', $value, 2);
            if ($result === false || count($result) === 1) {
                return '';
            }

            return $result[1];
        },
        $argv
    )
);

$inputDirectory  = realpath(array_key_exists('--input', $parameters) ? $parameters['--input'] : '');
$outputDirectory = realpath(array_key_exists('--output', $parameters) ? $parameters['--output'] : '');
$locales         = array_key_exists('--locales', $parameters) ? explode(',', $parameters['--locales']) : [];
$cleanStrings           = array_key_exists('--clean-strings', $parameters) === true;
$cleanDomains           = array_key_exists('--clean-domains', $parameters) === true;
$cleanLocales           = array_key_exists('--clean-locales', $parameters) === true;

$clean = 0;
if ($cleanStrings) {
    $clean += TranslationGenerator::FLAG_CLEAN_STRINGS;
}

if ($cleanDomains) {
    $clean += TranslationGenerator::FLAG_CLEAN_DOMAINS;
}

if ($cleanLocales) {
    $clean += TranslationGenerator::FLAG_CLEAN_LOCALES;
}

$collector = new StringCollector();
$strings   = $collector->collectFromDirectory($inputDirectory);

$generator = new TranslationGenerator($outputDirectory, $locales, $strings, $clean);
$generator->generate();
