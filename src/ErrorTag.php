<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Throwable;
use Vaened\Laravception\Exceptions\Codeable;
use Vaened\Laravception\Exceptions\Parametrizable;
use Vaened\Laravception\Exceptions\TranslatableException;

enum ErrorTag: string
{
    case Coded = 'coded';

    case Translated = 'translated';

    case Parametrized = 'parametrized';

    public function isCompatible(Throwable $throwable): bool
    {
        return match (true) {
            $this === self::Coded        => $throwable instanceof Codeable,
            $this === self::Translated   => $throwable instanceof TranslatableException,
            $this === self::Parametrized => $throwable instanceof Parametrizable,
            default                      => false,
        };
    }
}
