<?php

declare(strict_types=1);

use Shipfastlabs\Parsel;
use Shipfastlabs\Parsel\ParselManager;
use Shipfastlabs\Parsel\PendingParse;
use Shipfastlabs\Parsel\Support\FakeProcessRunner;

uses()
    ->beforeEach(function (): void {
        putenv('PARSEL_LIT_BINARY');
        putenv('PARSEL_LITEPARSE_BINARY');
        putenv('PARSEL_ANYDOC_BINARY');
        Parsel::flush();
    })
    ->afterEach(function (): void {
        putenv('PARSEL_LIT_BINARY');
        putenv('PARSEL_LITEPARSE_BINARY');
        putenv('PARSEL_ANYDOC_BINARY');
        Parsel::flush();
    })
    ->in('Unit');

function fixtureContents(string $name): string
{
    return (string) file_get_contents(fixture($name));
}

function fakeParse(FakeProcessRunner $runner, string $binary = 'lit'): PendingParse
{
    return new ParselManager(process: $runner, binaries: ['liteparse' => $binary])
        ->file(fixture('sample.pdf'))
        ->withProviderOptions([]);
}
