<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Throwable;
use Vaened\Laravception\ErrorTag;

use function Lambdish\Phunctional\filter;

final readonly class ErrorTagger
{
    public function classify(Throwable $exception): array
    {
        return filter(static fn(ErrorTag $tag) => $tag->isCompatible($exception), ErrorTag::cases());
    }
}
