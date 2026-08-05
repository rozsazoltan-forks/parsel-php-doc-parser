<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Options;

use Shipfastlabs\Parsel\Contracts\ProviderOptions;

final class AnyDocOptions implements ProviderOptions
{
    /** @var array<string, mixed> */
    private array $options = [];

    /** @var array<string, string|int|bool> */
    private array $extra = [];

    public static function make(): self
    {
        return new self;
    }

    public function provider(): string
    {
        return 'anydoc';
    }

    public function format(string $format): self
    {
        $this->options['format'] = strtolower(ltrim($format, '.'));

        return $this;
    }

    public function withBinary(string $path): self
    {
        $this->options['binary'] = $path;

        return $this;
    }

    public function option(string $name, string|int|bool $value = true): self
    {
        $this->extra[$name] = $value;

        return $this;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->extra === [] ? $this->options : [...$this->options, 'extra' => $this->extra];
    }
}
