<?php

declare(strict_types=1);

use Shipfastlabs\Parsel;
use Shipfastlabs\Parsel\Options\LiteParseOptions;

require __DIR__.'/../vendor/autoload.php';

$document = $argv[1] ?? __DIR__.'/docs/sample.docx';

if (! file_exists($document)) {
    fwrite(STDERR, "Usage: php examples/parse-docx.php /path/to/document.docx\n");

    exit(1);
}

echo "== Word document text (LiteParse) ==\n";
echo Parsel::file($document)->withProviderOptions(LiteParseOptions::make()->withoutOcr())->text()."\n\n";

echo "== Word document metadata (LiteParse) ==\n";
$parsed = Parsel::file($document)->withProviderOptions(LiteParseOptions::make()->withoutOcr())->parse();
printf("pages=%d, characters=%d\n", $parsed->pageCount(), strlen($parsed->text));

echo "\n== Word document markdown (AnyDoc) ==\n";
echo Parsel::driver('anydoc')->file($document)->markdown()."\n";
