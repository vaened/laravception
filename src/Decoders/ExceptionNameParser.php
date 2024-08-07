<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception\Decoders;

use Throwable;

interface ExceptionNameParser
{
    public function parse(Throwable $throwable): string;
}
