<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Drivers;

use Shipfastlabs\Parsel\Contracts\Driver;
use Shipfastlabs\Parsel\Exceptions\InvalidProviderOptionsException;
use Shipfastlabs\Parsel\ParseRequest;
use Shipfastlabs\Parsel\Support\BinaryResolver;
use Shipfastlabs\Parsel\Support\CliProcess;

final readonly class AnyDocDriver implements Driver
{
    private const array OPTION_KEYS = ['format', 'binary', 'extra'];

    public function __construct(
        private CliProcess $process = new CliProcess,
        private BinaryResolver $resolver = new BinaryResolver(name: 'anydoc', envVar: 'PARSEL_ANYDOC_BINARY'),
        private ?string $configuredBinary = null,
    ) {}

    public function name(): string
    {
        return 'anydoc';
    }

    public function validateOptions(array $options): void
    {
        $unknown = array_values(array_diff(array_keys($options), self::OPTION_KEYS));

        if ($unknown !== []) {
            throw InvalidProviderOptionsException::unknown($this->name(), $unknown);
        }
    }

    public function markdown(ParseRequest $request): string
    {
        $options = $request->options;
        $explicit = $options['binary'] ?? null;
        $binary = $this->resolver->resolve(is_string($explicit) ? $explicit : $this->configuredBinary);

        $result = $this->process->run(
            $request->source,
            function (string $file) use ($binary, $options): array {
                $command = $this->command($binary, $file);
                $format = $options['format'] ?? null;

                if (is_string($format)) {
                    $command[] = '--format';
                    $command[] = $format;
                }

                $extra = $options['extra'] ?? [];

                if (is_array($extra)) {
                    foreach ($extra as $name => $value) {
                        if (! is_string($name)) {
                            continue;
                        }

                        if ($value === false) {
                            continue;
                        }

                        if (! is_string($value) && ! is_int($value) && $value !== true) {
                            continue;
                        }

                        $command[] = '--'.$name;

                        if ($value !== true) {
                            $command[] = (string) $value;
                        }
                    }
                }

                return $command;
            },
            $request->timeout,
            $this->name(),
        );

        return trim($result->stdout);
    }

    /** @return list<string> */
    private function command(string ...$parts): array
    {
        return array_values($parts);
    }
}
