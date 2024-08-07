<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\Laravception;

use Throwable;

interface ExceptionStatusCodeMapping
{
    public function statusCodeFor(Throwable $throwable): int;
}
