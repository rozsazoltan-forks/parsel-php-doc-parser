<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Exceptions;

final class UnsupportedCapabilityException extends ParselException
{
    public static function forDriver(string $driver, string $capability): self
    {
        return new self(sprintf('The [%s] driver does not support [%s].', $driver, $capability));
    }
}
