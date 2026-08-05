<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Support;

use Shipfastlabs\Parsel\Contracts\ExecutableFinder;
use Shipfastlabs\Parsel\Exceptions\BinaryNotFoundException;

final readonly class BinaryResolver
{
    public function __construct(
        private ExecutableFinder $finder = new SymfonyExecutableFinder,
        private string $name = 'lit',
        private string $envVar = 'PARSEL_LITEPARSE_BINARY',
    ) {}

    public function resolve(?string $explicit = null): string
    {
        if ($explicit !== null && $explicit !== '') {
            return $explicit;
        }

        $fromEnv = getenv($this->envVar);

        if ((! is_string($fromEnv) || $fromEnv === '') && $this->name === 'lit') {
            $fromEnv = getenv('PARSEL_LIT_BINARY');
        }

        if (is_string($fromEnv) && $fromEnv !== '') {
            return $fromEnv;
        }

        $found = $this->finder->find($this->name);

        if ($found !== null) {
            return $found;
        }

        throw BinaryNotFoundException::onPath($this->name, $this->envVar);
    }
}
