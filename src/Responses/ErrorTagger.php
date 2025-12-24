<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception\Responses;

use Throwable;
use Vaened\Laravception\ErrorTag;
use Vaened\Laravception\Exceptions\Codeable;
use Vaened\Laravception\Exceptions\Parametrizable;
use Vaened\Laravception\Exceptions\TranslatableException;

final readonly class ErrorTagger
{
    public function classify(Throwable $exception): array
    {
        $tags = [];

        if ($exception instanceof Codeable) {
            $tags[] = ErrorTag::Coded;
        }

        if ($exception instanceof TranslatableException) {
            $tags[] = ErrorTag::Translated;
        }

        if ($exception instanceof Parametrizable) {
            $tags[] = ErrorTag::Parametrized;
        }

        return $tags;
    }
}
