<?php
/**
 * @author enea dhack <contact@vaened.dev>
 * @link https://vaened.dev DevFolio
 */

declare(strict_types=1);

namespace Vaened\Laravception;

enum ErrorTag: string
{
    case Coded = 'coded';

    case Translated = 'translated';

    case Parametrized = 'parametrized';
}
