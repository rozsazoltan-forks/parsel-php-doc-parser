<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

use Shipfastlabs\Parsel\ParseRequest;

interface ScreenshotDriver extends Driver
{
    /**
     * @return list<string>
     */
    public function screenshots(ParseRequest $request, string $directory): array;
}
