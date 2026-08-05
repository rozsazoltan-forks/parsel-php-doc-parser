<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Exceptions;

use Shipfastlabs\Parsel\Support\ProcessResult;

final class ParseFailedException extends ParselException
{
    /**
     * @param  list<string>  $command
     */
    private function __construct(
        string $message,
        public readonly int $exitCode,
        public readonly string $stderr,
        public readonly array $command,
    ) {
        parent::__construct($message);
    }

    public static function fromResult(ProcessResult $result, string $driver = 'parser'): self
    {
        $detail = $result->stderr === '' ? '(no error output)' : $result->stderr;

        return new self(
            sprintf('%s exited with code %d: %s', $driver, $result->exitCode, $detail),
            $result->exitCode,
            $result->stderr,
            $result->command,
        );
    }
}
