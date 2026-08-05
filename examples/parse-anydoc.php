<?php

declare(strict_types=1);

use Shipfastlabs\Parsel;
use Shipfastlabs\Parsel\Options\AnyDocOptions;

require __DIR__.'/../vendor/autoload.php';

$document = $argv[1] ?? __DIR__.'/docs/sample.docx';

if (! file_exists($document)) {
    fwrite(STDERR, "Usage: php examples/parse-anydoc.php /path/to/document.docx\n");

    exit(1);
}

echo Parsel::driver('anydoc')
    ->file($document)
    ->withProviderOptions(AnyDocOptions::make())
    ->markdown();
