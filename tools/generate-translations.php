<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AntonioKadid\WAPPKitCore\Localization\LocaleCleaner;
use AntonioKadid\WAPPKitCore\Localization\LocaleGenerator;
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
$clean           = array_key_exists('--clean', $parameters) === true;

$collector = new StringCollector($inputDirectory);
$strings   = $collector->collect();

if (empty($strings)) {
    exit(0);
}

$generator = new LocaleGenerator($outputDirectory, $locales, $strings, $clean);
$generator->generate();
