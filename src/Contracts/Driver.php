<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

use Shipfastlabs\Parsel\ParseRequest;

interface Driver
{
    public function name(): string;

    /**
     * @param  array<string, mixed>  $options
     */
    public function validateOptions(array $options): void;

    public function markdown(ParseRequest $request): string;
}
