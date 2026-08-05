<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Exceptions;

final class BinaryNotFoundException extends ParselException
{
    public static function onPath(string $name, string $envVar): self
    {
        return new self(sprintf(
            'Could not locate the "%s" binary. Configure it through the driver provider options, '
            .'export %s, or make sure "%s" is on your PATH.',
            $name,
            $envVar,
            $name,
        ));
    }
}
