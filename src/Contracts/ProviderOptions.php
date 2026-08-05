<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

interface ProviderOptions
{
    public function provider(): string;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
