<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

use Shipfastlabs\Parsel\ParseRequest;

interface TextDriver extends Driver
{
    public function text(ParseRequest $request): string;
}
