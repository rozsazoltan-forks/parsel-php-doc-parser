<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

use Generator;
use Shipfastlabs\Parsel\Data\Page;
use Shipfastlabs\Parsel\ParseRequest;

interface LazyPageDriver extends Driver
{
    /**
     * @return Generator<int, Page>
     */
    public function pages(ParseRequest $request): Generator;
}
