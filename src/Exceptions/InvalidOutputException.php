<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Exceptions;

final class InvalidOutputException extends ParselException
{
    public static function emptyOutput(string $driver = 'parser'): self
    {
        return new self(sprintf('%s returned empty output.', $driver));
    }

    public static function malformedJson(string $detail, string $driver = 'parser'): self
    {
        return new self(sprintf('%s returned malformed JSON: %s', $driver, $detail));
    }
}
