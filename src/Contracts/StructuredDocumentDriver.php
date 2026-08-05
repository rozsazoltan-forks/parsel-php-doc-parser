<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Contracts;

use Shipfastlabs\Parsel\Data\Document;
use Shipfastlabs\Parsel\ParseRequest;

interface StructuredDocumentDriver extends Driver
{
    public function document(ParseRequest $request): Document;

    public function json(ParseRequest $request): string;
}
