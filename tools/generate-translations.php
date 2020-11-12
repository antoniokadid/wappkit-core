<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AntonioKadid\WAPPKitCore\Localization\LocaleGenerator;
use AntonioKadid\WAPPKitCore\Localization\StringCollector;

if ($argc < 3) {
    echo "Invalid parameter count.\n";
    exit(1);
}

$inputDirectory = $argv[1];
if (empty($inputDirectory)) {
    $inputDirectory = realpath('');
}

$outputDirectory = $argv[2];
if (empty($outputDirectory)) {
    $outputDirectory = realpath('');
}

if ($inputDirectory === false) {
    echo "Invalid input directory.\n";
    exit(1);
}

if ($outputDirectory === false) {
    echo "Invalid output directory.\n";
    exit(1);
}

$locales = [];
if ($argc === 4) {
    $locales = explode(',', $argv[3]);
}

$collector = new StringCollector($inputDirectory);
$strings   = $collector->collect();

if (empty($strings)) {
    exit(0);
}

$generator = new LocaleGenerator($outputDirectory, $locales, $strings);
$generator->generate();
