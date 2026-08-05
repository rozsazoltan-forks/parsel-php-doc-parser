<?php

declare(strict_types=1);

use Shipfastlabs\Parsel\Exceptions\BinaryNotFoundException;
use Shipfastlabs\Parsel\Support\BinaryResolver;
use Tests\Doubles\FakeExecutableFinder;

it('returns an explicit path before anything else', function (): void {
    expect(new BinaryResolver(new FakeExecutableFinder('/found/lit'))->resolve('/explicit/lit'))
        ->toBe('/explicit/lit');
});

it('reads the environment variable when no explicit path is given', function (): void {
    putenv('PARSEL_LITEPARSE_BINARY=/env/lit');

    expect(new BinaryResolver(new FakeExecutableFinder('/found/lit'))->resolve())->toBe('/env/lit');

    putenv('PARSEL_LITEPARSE_BINARY');
});

it('keeps the legacy liteparse environment variable as a fallback', function (): void {
    putenv('PARSEL_LIT_BINARY=/legacy/lit');

    expect(new BinaryResolver(new FakeExecutableFinder('/found/lit'))->resolve())->toBe('/legacy/lit');
});

it('resolves a provider-specific binary and environment variable', function (): void {
    putenv('PARSEL_ANYDOC_BINARY=/env/anydoc');

    expect(new BinaryResolver(new FakeExecutableFinder, 'anydoc', 'PARSEL_ANYDOC_BINARY')->resolve())->toBe('/env/anydoc');
});

it('falls back to a PATH lookup', function (): void {
    expect(new BinaryResolver(new FakeExecutableFinder('/path/lit'))->resolve())->toBe('/path/lit');
});

it('throws when the binary cannot be resolved anywhere', function (): void {
    new BinaryResolver(new FakeExecutableFinder)->resolve();
})->throws(BinaryNotFoundException::class);

it('throws when an empty string is passed as the explicit path', function (): void {
    new BinaryResolver(new FakeExecutableFinder)->resolve('');
})->throws(BinaryNotFoundException::class);
