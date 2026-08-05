<?php

declare(strict_types=1);

namespace Shipfastlabs\Parsel\Enums;

enum ImageMode: string
{
    case Off = 'off';
    case Placeholder = 'placeholder';
    case Embed = 'embed';
}
