<?php

declare(strict_types=1);

use Shipfastlabs\Parsel;
use Shipfastlabs\Parsel\Options\LiteParseOptions;

require __DIR__.'/../vendor/autoload.php';

$spreadsheet = $argv[1] ?? __DIR__.'/docs/sample.xlsx';

if (! file_exists($spreadsheet)) {
    fwrite(STDERR, "Usage: php examples/parse-spreadsheet.php /path/to/spreadsheet.xlsx\n");

    exit(1);
}

echo "== Spreadsheet text (LiteParse) ==\n";
echo Parsel::file($spreadsheet)->text()."\n\n";

echo "== Spreadsheet as array (LiteParse) ==\n";
$array = Parsel::file($spreadsheet)->withProviderOptions(LiteParseOptions::make()->withoutOcr())->toArray();
$items = array_sum(array_map(static fn (array $page): int => count($page['items']), $array['pages']));

printf("pages=%d, characters=%d, items=%d\n", count($array['pages']), strlen($array['text']), $items);

echo "\n== Spreadsheet markdown (AnyDoc) ==\n";
echo Parsel::driver('anydoc')->file($spreadsheet)->markdown()."\n";
