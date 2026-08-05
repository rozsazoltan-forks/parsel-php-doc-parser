<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Exceptions;

final class DriverNotFoundException extends ParselException
{
    public static function named(string $name): self
    {
        return new self(sprintf('Parsel driver [%s] is not configured.', $name));
    }
}
